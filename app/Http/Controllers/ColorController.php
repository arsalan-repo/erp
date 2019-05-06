<?php

namespace App\Http\Controllers;

use App\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    public function index(){
        $colors = DB::table('colors')->get();
        return view('colors.colors', ['colors' => $colors]);
    }

    public function add(){
        return view('colors.add_color');
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'code' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return redirect('color/add')->withErrors($validator)->withInput();
        }

        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);

        $color = new Color();
        $color->name = $request->input('name');
        $color->code = $request->input('code');
        $color->image = $imageName;
        if($color->save()){
            return redirect('colors');
        }else{
            $error = [
                'error' => 'An error occurred while saving!',
            ];
            return redirect('color/add')->withErrors($error)->withInput();
        }
    }

    public function edit($id){
        $color = Color::find($id);
        return view('colors.edit_color', ['color' => $color]);
    }

    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'code' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return redirect()->route('color.edit', [$id])->withErrors($validator)->withInput();
        }

        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);

        $color = Color::find($id);
        $color->name = $request->input('name');
        $color->code = $request->input('code');
        $color->image = $imageName;
        if($color->save()){
            return redirect('colors');
        }else{
            $error = [
                'error' => 'An error occurred while saving!',
            ];
            return redirect()->route('color.edit', [$id])->withErrors($error)->withInput();
        }
    }

    public function delete($id){
        $color = Color::find($id);
        $color->delete();
        return redirect()->route('color.list');
    }
}
