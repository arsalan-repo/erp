<?php

namespace App\Http\Controllers;

use App\Category;
use App\Color;
use App\ItemType;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with(['category', 'color', 'sub_category'])->get();
        return view('products.products', ['products' => $products]);
    }

    public function add(){
        $category = Category::all();
        $sub_category = ItemType::all();
        $code = Color::all();
        return view('products.add_product', ['categories' => $category, 'sub_categories' => $sub_category, 'codes' => $code]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required|max:255',
            'sub_category_id' => 'required|max:255',
            'code_id' => 'required|max:255',
            'qty' => 'required|max:255',
            'unit' => 'required|max:255',
            'image' => 'required|max:255',
            'description' => 'required|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.create')->withErrors($validator)->withInput();
        }

        $products = new Product();

        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);

        $products->name = $request->input('name');
        $products->category_id = $request->input('category_id');
        $products->sub_category_id = $request->input('sub_category_id');
        $products->code_id = $request->input('code_id');
        $products->qty = $request->input('qty');
        $products->unit = $request->input('unit');
        $products->image = $imageName;
        $products->description = $request->input('description');

        if($products->save()){
            return redirect()->route('products.list');
        }else{
            $error = [
                'error' => 'An error occurred while saving!',
            ];
            return redirect('product/add')->withErrors($error)->withInput();
        }
    }

    public function delete($id){
        $product = Product::findorfail($id);
        $product->delete();
        return redirect()->route('products.list');
    }

    public function edit($id){
        $product = Product::findorfail($id);
        $category = Category::all();
        $sub_category = ItemType::all();
        $code = Color::all();
        return view('products.edit_product', ['product' => $product, 'categories' => $category, 'sub_categories' => $sub_category, 'codes' => $code]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required|max:255',
            'sub_category_id' => 'required|max:255',
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

        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);

        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->sub_category_id = $request->input('sub_category_id');
        $product->code_id = $request->input('code_id');
        $product->qty = $request->input('qty');
        $product->unit = $request->input('unit');
        $product->description = $request->input('description');
        $product->image = $imageName;

        if($product->save()){
            return redirect()->route('products.list');
        }else{
            $error = [
                'error' => 'An error occurred while saving!',
            ];
            return redirect()->route('product.edit', ['id' => $id])->withErrors($error)->withInput();
        }

    }
}
