<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware("role.admin", [
            "only" => ["index"],
        ]);

        $this->middleware("verify", [
            "only" => ["store", "update"],
        ]);

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.environment');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $qSearch = $request->query('search', '');
        $orders = Order::search($qSearch)
            ->latest()
            ->paginate(15)
            ->withQueryString()
            ->onEachSide(1);

        return $this->httpOkResponse("Success get all order", compact('orders'));
    }

    /**
     * Display a listing of the resource.
     */
    public function myOrder(Request $request)
    {
        $orders = auth()->user()->orders()->with('product', 'product.category')->latest()->get();
        return $this->httpOkResponse("Success get all order", compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "first_name" => "required|string|max:255",
            "last_name" => "required|string|max:255",
            "address" => "required|string",
            "product_id" => "required|exists:products,id",
            "quantity" => "required|integer|gt:0",
        ]);

        $product = Product::where('id', $validated['product_id'])->first();
        $paymentOrderId = uniqid();
        $totalPrice = $product->price * $validated['quantity'];

        if ($validated["quantity"] > $product->stock) {
            return $this->httpErrorResponse("Product out of stock", 400);
        }

        $order = auth()->user()->orders()->create(array_merge($validated, [
            "order_id" => $paymentOrderId,
            "price" => $product->price,
            "total_price" => $totalPrice,
            "status" => "pending",
        ]));

        $payloadPayment = [
            "transaction_details" => [
                "order_id" => $paymentOrderId,
                "gross_amount" => $totalPrice,
            ],
            "item_details" => [
                [
                    'id' => $order->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $validated['quantity'],
                ]
            ],
            "customer_details" => [
                'first_name' => $validated["first_name"],
                'last_name' => $validated["last_name"],
                'email' => auth()->user()->email,
                'shipping_address' => $validated["address"],
            ],
        ];

        try {
            $response = \Midtrans\Snap::getSnapToken($payloadPayment);

            return $this->httpOkResponse("Order created", [
                "snap_token" => $response,
                "order" => $order,
            ], 201);
        } catch (Exception $e) {
            return $this->httpErrorResponse($e->getMessage() ?? "Order fail", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('product', 'product.category');
        return $this->httpOkResponse("Success get order", compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $paymentOrderId)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:success,fail,pending,cancel',
        ]);

        $order = Order::where('order_id', $paymentOrderId)->first();
        $order->update($validated);

        if ($validated["status"] === "success") {
            $product = Product::findOrFail($order->product_id);
            $product->update([
                "stock" => $product->stock - $order->quantity
            ]);
        }

        return $this->httpOkResponse("Order updated", compact('order'));
    }

    /**
     * Delete the specified resource in storage.
     */
    public function destroy(Request $request, Order $order)
    {
        $order->delete();
        return $this->httpOkResponse("Order canceled");
    }
}
