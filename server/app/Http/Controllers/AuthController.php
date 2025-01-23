<?php

namespace App\Http\Controllers;

use App\Helpers\CloudinaryHelper;
use App\Mail\OtpCreated;
use App\Mail\AccountCreated;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['login', 'register'],
        ]);

        $this->middleware("verify")->only("updateProfile");
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email|max:255",
            "password" => "required|max:255",
        ]);

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->httpErrorResponse("Email or password is wrong", 401);
        }

        $user = User::with('role')->where('email', $request->email)->firstOrFail();

        return $this->httpOkResponse("Login success", [
            "user" => $user,
            "token" => $token,
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email|max:255",
            "password" => "required|min:8|max:255|confirmed",
        ]);

        $role = Role::where("name", "user")->first();

        $user = User::create(array_merge($request->only('name', 'email'), [
            "password" => Hash::make($request->password),
            "role_id" => $role->id,
        ]));

        $token = rand(111111, 999999);

        $user->token()->create([
            "token" => $token,
            "expired_at" => now()->addMinutes(5),
        ]);

        Mail::to($user->email)->queue(new AccountCreated($token));

        return $this->httpOkResponse("Registration success", [
            "user" => $user,
        ], 201);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return $this->httpOkResponse("Logout success");
    }

    public function me(Request $request)
    {
        return $this->httpOkResponse("Success get profile", [
            "user" => auth()->user()->load('role', 'profile'),
        ]);
    }

    public function generateToken(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email|max:255", // exists:users,id fungsi email???
        ]);

        $token = rand(111111, 999999);

        auth()->user()->token()->updateOrCreate([
            "user_id" => auth()->user()->id,
        ], [
            "token" => $token,
            "expired_at" => now()->addMinutes(5),
        ]);

        Mail::to($request->user()->email)->queue(new OtpCreated($token));

        return $this->httpOkResponse("Success regenerate OTP code", [
            "user" => $request->user(),
        ]);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            "otp" => "required|integer|digits:6",
        ]);

        $otp = $request->otp;
        $token = auth()->user()->token()->first();
        $tokenExpire = $token->expired_at ?? now();

        if ($token->token != $otp || now() > $tokenExpire) {
            return $this->httpErrorResponse("Invalid OTP code");
        }

        auth()->user()->update([
            "email_verified_at" => now(),
        ]);

        $token->delete();

        return $this->httpOkResponse("Success verify email", [
            "user" =>  auth()->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            "age" => "required|integer|gte:0",
            "biodata" => "required|string",
            "address" => "required|string|max:255",
            "image" => "sometimes|image|max:2048",
        ]);

        $profile = $request->user()->profile();

        if ($request->hasFile("image")) {
            if ($profile->first()?->image || $profile->first()?->image_public_id) {
                $cloudinaryResponse = CloudinaryHelper::update($request->file("image"), $profile->first()->image_public_id);
            } else {
                $cloudinaryResponse = CloudinaryHelper::store($request->file("image"));
            }

            $profile->updateOrCreate([
                "user_id" => $request->user()->id,
            ], array_merge($request->only([
                "age",
                "biodata",
                "address",
            ]), [
                "image" => $cloudinaryResponse->getSecurePath(),
                "image_public_id" => $cloudinaryResponse->getPublicId(),
            ]));
        }

        $profile->updateOrCreate([
            "user_id" => $request->user()->id,
        ], $request->only([
            "age",
            "biodata",
            "address",
        ]));

        return $this->httpOkResponse("Success update profile", [
            "user" => $request->user()->profile,
        ]);
    }
}
