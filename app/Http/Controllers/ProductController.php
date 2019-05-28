<?php

namespace App\Http\Controllers;

use App\Category;
use App\Color;
use App\ItemType;
use App\Product;
use App\ProductCategory;
use App\ProductColors;
use App\ProductTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
//         dd($products);
        return view('products.products', ['products' => $products]);
    }

    public function add()
    {
        $category = Category::all();
        $sub_category = ItemType::all();
        $code = Color::all();
        return view('products.add_product', ['categories' => $category, 'sub_categories' => $sub_category, 'codes' => $code]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required|max:255',
            'type_id' => 'required|max:255',
            'color_id' => 'required|max:255',
            'qty' => 'required|max:255',
            'unit' => 'required|max:255',
            'image' => 'required|max:255',
            'description' => 'required|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.add')->withErrors($validator)->withInput();
        }

        $products = new Product();

        $file = $request->file('image');
        $newfile = Storage::put('public/product', $file);
        // dd($newfile);

        $newfile = (explode("/",$newfile));
        $filename = $newfile[1].'/'.$newfile[2];
        // $imageName = time() . '.' . request()->image->getClientOriginalExtension();
        // request()->image->move(public_path('images'), $imageName);

        $products->name = $request->input('name');
        $products->qty = $request->input('qty');
        $products->unit = $request->input('unit');
        $products->image = $filename;
        $products->description = $request->input('description');
        $products->save();
        if ($products->save()) {
            // dd($products);
            $product_id = $products->id;
            $categories = $request->input('category_id');
            foreach ($categories as $cat) {
                $product_categories = new ProductCategory();
                $product_categories->product_id = $product_id;
                $product_categories->category_id = $cat;

                $product_categories->save();
            }

            $types = $request->input('type_id');
            foreach ($types as $type){
                $product_types = new ProductTypes();
                $product_types->product_id = $product_id;
                $product_types->type_id = $type;

                $product_types->save();
            }

            $colors = $request->input('color_id');
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
            return redirect('product/add')->withErrors($error)->withInput();
        }
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
