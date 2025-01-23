<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware("role.admin");
    }

    public function index()
    {
        $category = Category::count();
        $product = Product::count();
        $order = Order::count();
        $orderSuccess = Order::where('status', 'success')->count();
        $orderPending = Order::where('status', 'pending')->count();
        $orderCancel = Order::where('status', 'cancel')->count();
        $user = User::count();
        $revenue = Order::where('status', 'success')->sum('total_price');

        return $this->httpOkResponse("Success get data dashboard", compact(
            'category',
            'product',
            'order',
            'orderSuccess',
            'orderPending',
            'orderCancel',
            'user',
            'revenue'
        ));
    }
}
