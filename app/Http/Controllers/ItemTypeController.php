<?php

namespace App\Http\Controllers;

use App\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemTypeController extends Controller
{
    public function index(){
        $types = ItemType::all();
        return view('types.item_types', ['all_types' => $types]);
    }

    public function add(){
        return view('types.add_item_type');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('item.add')->withErrors($validator)->withInput();
        }
        $category = new ItemType();
        $name = $request->input('name');
        $category->name = $name;
        if ($category->save()) {
            return redirect()->route('items.list');
        } else {
            $error = [
                'error' => 'An error occurred while saving!',
            ];
            return redirect()->route('item.add')->withErrors($error)->withInput();
        }
    }

    public function delete($id){
        $type = ItemType::findorfail($id);
        $type->delete();
        return redirect()->route('items.list');
    }

    public function edit($id){
        $type = ItemType::findorfail($id);
        return view('types.edit_item_type', ['type' => $type]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->route('item.edit', ['id' => $id])->withErrors($validator)->withInput();
        }

        $type = ItemType::findorfail($id);
        $type->name = $request->input('name');

        if ($type->save()) {
            return redirect()->route('items.list');
        } else {
            $error = [
                'error' => 'An error occurred while saving!',
            ];
            return redirect()->route('item.edit', ['id' => $id])->withErrors($error)->withInput();
        }
    }
}
