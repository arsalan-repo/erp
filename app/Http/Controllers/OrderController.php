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
        $order  = $request;
        $product = Product::find($request->product_id);
        return view('frontend.products.checkout', ['product' => $product,'order' => $order]);
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

        return view('order.order')->with('orders',$orders);
    }
    public function get_order($id){
        $order = Order::find($id);
        $quantity = OrderMeta::Where('order_id',$id)->where('key','qty')->first();
        $user = User::find($order->user_id);
        $color = OrderMeta::Where('order_id',$id)->where('key','color')->first();
        $billing= OrderMeta::Where('order_id',$id)->where('key','billing')->first();
        $shipping = OrderMeta::Where('order_id',$id)->where('key','shipping')->first();
        $additional  = OrderMeta::Where('order_id',$id)->where('key','additional_notes')->first();
        $product_id = OrderMeta::Where('order_id',$id)->where('key','product_id')->first();
        $product = Product::find($product_id->value);
//        dd($product_id->value);
        return view('order.vieworder',['user'=> $user,'order' => $order,'quantity' => $quantity,'color'=>$color,'billing'=>$billing,'shipping'=>$shipping,'addtional'=>$additional,'product'=> $product]);

    }

    public function delete($id)
    {
        $product = Product::findorfail($id);
        $product->delete();
        return redirect()->route('products.list');
    }

    public function edit($id)
    {
        $product = Product::findorfail($id);
        $product_categories = Product::findorfail($id)->categories;
        $product_type = Product::findorfail($id)->types;
        $product_color = Product::findorfail($id)->colors;
        $categories = array();
        $types = array();
        $colors = array();

        foreach ($product_categories as $key => $category) {
            $categories[$key] =  $category->category_id;
        }
        foreach ($product_type as $type)
        {
            $types[$key] = $type->type_id;
        }
        foreach ($product_color as $color)
        {
            $colors[$key] = $color->color_id;
        }
        $product['categories'] = $categories;
        $product['types'] = $types;
        $product['colors'] = $colors;
        // dd($product);
        $category = Category::all();
        $sub_category = ItemType::all();
        $code = Color::all();
        // dd($product);
        return view('products.edit_product', ['product' => $product, 'categories' => $category, 'sub_categories' => $sub_category, 'codes' => $code]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required|max:255',
            'type_id' => 'required|max:255',
            'code_id' => 'required|max:255',
            'qty' => 'required|max:255',
            'unit' => 'required|max:255',
            'image' => 'required|max:255',
            'description' => 'required|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.edit', ['id' => $id])->withErrors($validator)->withInput();
        }

        $product = Product::findorfail($id);

        $file = $request->file('image');
        $newfile = Storage::put('public/product', $file);
        // dd($newfile);

        $newfile = (explode("/",$newfile));
        $filename = $newfile[1].'/'.$newfile[2];
        // $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        // request()->image->move(public_path('images'), $imageName);

        $product->name = $request->input('name');
//        $product->category_id = $request->input('category_id');
//        $product->type_id = $request->input('type_id');
//        $product->code_id = $request->input('code_id');
        $product->qty = $request->input('qty');
        $product->unit = $request->input('unit');
        $product->description = $request->input('description');
        $product->image = $filename;

        if ($product->save()) {
            ProductCategory::where('product_id', $product->$id)->delete();
            $product_id = $products->id;
            $categories = $request->input('category_id');
            foreach ($categories as $cat) {
                $product_categories = new ProductCategory();
                $product_categories->product_id = $product_id;
                $product_categories->category_id = $cat;

                $product_categories->save();
            }

            $types = $request->input('type_id');
            ProductTypes::where('product_id', $product->$id)->delete();
            foreach ($types as $type){
                $product_types = new ProductTypes();
                $product_types->product_id = $product_id;
                $product_types->type_id = $type;

                $product_types->save();
            }

            $colors = $request->input('color_id');
            ProductColors::where('product_id', $product->$id)->delete();
            // ProductColors
            foreach ($colors as $color){
                $product_colors = new ProductColors();
                $product_colors->product_id = $product_id;
                $product_colors->color_id = $color;

                $product_colors->save();
            }
            return redirect()->route('products.list');
        } else {
            $error = [
                'error' => 'An error occurred while saving!',
            ];
            return redirect()->route('product.edit', ['id' => $id])->withErrors($error)->withInput();
        }

    }
}
