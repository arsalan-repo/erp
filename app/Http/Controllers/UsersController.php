<?php

namespace App\Http\Controllers;

use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::with('metas')->get();
        return view('users.users', ['users' => $user]);
    }

    public function add()
    {
        return view('users.add_user');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'phone' => 'required|max:15',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
            'region' => 'required|max:255',
            'city' => 'required|max:255',
            'role' => 'required|max:255',
            'address' => 'required|max:1000',
            'additional_info' => 'max:1000',
        ]);

        if ($validator->fails()) {
            return redirect('user/add')->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = $request->input('password');
        $user->password = Hash::make($password);
        if ($user->save()) {
            $user_meta = new UserMeta();
            $data = [
                ['user_id' => $user->id, 'key' => 'phone', 'value' => $request->input('phone')],
                ['user_id' => $user->id, 'key' => 'region', 'value' => $request->input('region')],
                ['user_id' => $user->id, 'key' => 'city', 'value' => $request->input('city')],
                ['user_id' => $user->id, 'key' => 'address', 'value' => $request->input('address')],
                ['user_id' => $user->id, 'key' => 'additional_info', 'value' => $request->input('additional_info')],
            ];

            $user->assignRole($request->input('role'));

            if (UserMeta::insert($data)) {
                return redirect()->route('users.list');
            }
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.list');
    }

    public function edit($id)
    {
        $user = User::with('metas')->get()->where('id', '=', $id);
        return view('users.edit_user', ['user' => $user]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'phone' => 'required|max:15',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
            'region' => 'required|max:255',
            'city' => 'required|max:255',
            'role' => 'required|max:255',
            'address' => 'required|max:1000',
            'additional_info' => 'max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.update', ['id' => $id])->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = $request->input('password');
        $user->password = Hash::make($password);

        if ($user->save()) {

            $data = [
                ['user_id' => $user->id, 'key' => 'phone', 'value' => $request->input('phone')],
                ['user_id' => $user->id, 'key' => 'region', 'value' => $request->input('region')],
                ['user_id' => $user->id, 'key' => 'city', 'value' => $request->input('city')],
                ['user_id' => $user->id, 'key' => 'address', 'value' => $request->input('address')],
                ['user_id' => $user->id, 'key' => 'additional_info', 'value' => $request->input('additional_info')],
            ];

            $user->removeRole($user->role_name);
            $user->assignRole($request->input('role'));

            foreach ($data as $k => $v) {
                UserMeta::updateOrInsert(['user_id' => $v['user_id'], 'key' => $v['key']], $v);
            }

            return redirect()->route('users.list');
        }
    }
}
