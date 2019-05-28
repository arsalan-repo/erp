<?php

namespace App\Http\Controllers;

use App\Category;
use App\Color;
use App\Order;
use App\OrderMeta;
use App\ItemType;
use App\Product;
use App\ProductCategory;
use App\ProductColors;
use App\ProductTypes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Auth;

class OrderController extends Controller
{
    public function index()
    {
        $products = Product::all();
//         dd($products);
        return view('products.products', ['products' => $products]);
    }

    public function add(Request $request)
    {
        $order = $request;
        $product = Product::find($request->product_id);
        return view('frontend.products.checkout', ['product' => $product, 'order' => $order]);
    }

    public function create(Request $request)
//    {
//      public function order(Request $request)
    {
//            dd($request);
//            $validator = Validator::make($request->all(), [
//                'product_id' => 'required',
//                'qty' => 'required',
//            ]);
//
//            if ($validator->fails()) {
//                return response()->json($validator->errors());
//            }

        $order = new Order();
        $order->user_id = Auth::user()->id;

        if ($order->save()) {
//                dd($order);
            $order_meta = new OrderMeta();
            $data = [
                ['order_id' => $order->id, 'key' => 'product_id', 'value' => $request->input('product_id')],
                ['order_id' => $order->id, 'key' => 'qty', 'value' => $request->input('qty')],
                ['order_id' => $order->id, 'key' => 'color', 'value' => $request->input('color')],
                ['order_id' => $order->id, 'key' => 'shipping', 'value' => $request->input('shipping')],
                ['order_id' => $order->id, 'key' => 'billing', 'value' => $request->input('billing')],
                ['order_id' => $order->id, 'key' => 'additional_notes', 'value' => $request->input('additional_notes')],
            ];

            if (OrderMeta::insert($data)) {
                return redirect(route('clients'));
            }
        }
    }

    public function get_all_orders()
    {

        $orders = Order::all();
//        dd($orders);

        return view('order.order')->with('orders', $orders);
    }

    public function get_order($id)
    {
        $order = Order::find($id);
        $quantity = OrderMeta::Where('order_id', $id)->where('key', 'qty')->first();
        $user = User::find($order->user_id);
        $color = OrderMeta::Where('order_id', $id)->where('key', 'color')->first();
        $billing = OrderMeta::Where('order_id', $id)->where('key', 'billing')->first();
        $shipping = OrderMeta::Where('order_id', $id)->where('key', 'shipping')->first();
        $additional = OrderMeta::Where('order_id', $id)->where('key', 'additional_notes')->first();
        $product_id = OrderMeta::Where('order_id', $id)->where('key', 'product_id')->first();
        $product = Product::find($product_id->value);
//        dd($product_id->value);
        return view('order.vieworder', ['user' => $user, 'order' => $order, 'quantity' => $quantity, 'color' => $color, 'billing' => $billing, 'shipping' => $shipping, 'addtional' => $additional, 'product' => $product]);

    }


    public function update(Request $request, $id)
    {

//        dd($id);
        $order = Order::findorfail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('order.list');
    }
//}

    }
//}
