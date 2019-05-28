<?php

namespace App\Http\Controllers;

use App\Category;
use App\Client;
use App\Color;
use App\ItemType;
use App\Order;
use App\OrderMeta;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiController extends Controller
{

    public function client_authentication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $token = Str::random(60);
        $email = $request->input('email');
        $password = md5($request->input('password'));
        $client = Client::where('email', $email)->where('password', $password)->first();

        if (!empty($client)) {
            $client->api_token = $token;
            $client->save();

            return response()->json(['success' => true, 'token' => $token]);
        } else {
            return response()->json(['success' => false, 'error' => 'Invalid Credentials', 'password' => $password]);
        }
    }

    public function order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $order = new Order();
        $order->client_id = $request->input('client_id');

        if ($order->save()) {
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

            } else {
                return response()->json(['success' => false, 'error' => 'An error occurred']);
            }
        }
    }

    public function get_order(Request $request)
    {
        $order_id = $request->input('order_id');
        $client_id = $request->input('order_id');
        $order = Order::findorfail($order_id)->with('metas')->where('client_id', '=', $client_id)->get();
        if (!empty($order)) {
            return response()->json(['success' => true, 'order' => $order]);
        } else {
            return response()->json(['success' => false, 'order' => 'An error occurred']);
        }
    }

    public function get_all_orders(Request $request)
    {
        $client_id = $request->input('client_id');
        $orders = Order::with('metas')->where('client_id', '=', $client_id)->get();

        if (!empty($orders)) {
            return response()->json(['success' => true, 'order' => $orders]);
        } else {
            return response()->json(['success' => false, 'order' => 'An error Occurred']);
        }
    }

    public function category()
    {
        return Category::all();
    }

    public function color()
    {
        return Color::all();
    }

    public function subCategory()
    {
        return ItemType::all();
    }

    public function product()
    {
        return Product::all();
    }
}
