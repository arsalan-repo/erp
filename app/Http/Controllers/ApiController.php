<?php

namespace App\Http\Controllers;

use App\Category;
use App\Client;
use App\Color;
use App\ItemType;
use App\Product;
use Illuminate\Http\Request;
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

//        $client = Client::where('email', $request->get('email'))
//            ->where('password', $request->get('password'))
//            ->first();

        if(auth()->guard('auth')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
            return "success";
        }else{
            return "error";
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
