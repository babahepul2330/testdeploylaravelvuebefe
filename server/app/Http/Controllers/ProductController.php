<?php

namespace App\Http\Controllers;

use App\Helpers\CloudinaryHelper;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show'],
        ]);

        $this->middleware("role.admin", [
            "except" => ["index", "show"],
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $qlimit = $request->query('limit', '');
        $qSearch = $request->query('search', '');
        $products = Product::search($qSearch)
            ->latest()
            ->paginate($qlimit ?? 15)
            ->withQueryString()
            ->onEachSide(1);

        return $this->httpOkResponse("Success get all product", compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "description" => "required|string",
            "image" => "required|image|max:2048",
            "stock" => "required|integer|min:0",
            "category_id" => "required|exists:categories,id"
        ]);

        $cloudinaryResponse = CloudinaryHelper::store($request->file("image"));

        $product = Product::create(array_merge($validated, [
            "image" => $cloudinaryResponse->getSecurePath(),
            'image_public_id' => $cloudinaryResponse->getPublicId()
        ]));

        return $this->httpOkResponse("Produuct created", compact("product"), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->httpOkResponse("Success get produdct", compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "price" => "required|numeric|min:0",
            "description" => "required|string",
            "image" => "sometimes|image|max:2048",
            "stock" => "required|integer|min:0",
            "category_id" => "required|exists:categories,id"
        ]);

        if ($request->hasFile('image')) {
            $cloudinaryResponse = CloudinaryHelper::update($request->file('image'), $product->image_public_id);

            $validated["image"] = $cloudinaryResponse->getSecurePath();
            $validated["image_public_id"] = $cloudinaryResponse->getPublicId();
        }

        $product->update($validated);

        return $this->httpOkResponse("Product updated", compact("product"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->httpOkResponse("Product deleted");
    }
}
