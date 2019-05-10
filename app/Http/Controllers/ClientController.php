<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('distributor')->get();
        return view('clients.clients', ['clients' => $clients]);
    }

    public function add()
    {
        $roles = Role::all();
        $users = User::with('roles')->get(['id', 'name']);
        $distributors = $users->reject(function ($user, $key) {
            return $user->hasRole(['admin', 'warehouse_manager']);
        });
        return view('clients.add_client', ['distributors' => $distributors]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'distributor_id' => 'required',
            'phone' => 'required|max:255',
            'whatsapp_number' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
            'code' => 'required|max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'region' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('clients.add_client')->withErrors($validator)->withInput();
        }
        $client = new Client();

        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $password = $request->input('password');
        $client->password = md5($password);
        $client->phone = $request->input('phone');
        $client->whatsapp_number = $request->input('whatsapp_number');
        $client->distributor_id = $request->input('distributor_id');
        $client->city = $request->input('city');
        $client->region = $request->input('region');
        $client->address = $request->input('address');
        $client->code = $request->input('code');

        if ($client->save()) {
            return redirect('clients');
        } else {
            $error = [
                'error' => 'An error occurred while saving!',
            ];
            return redirect('clients.add_client')->withErrors($error)->withInput();
        }
    }

    public function delete($id)
    {
        $client = Client::findorfail($id);
        $client->delete();
        return redirect()->route('clients.list');
    }

    public function edit($id)
    {
        $client = Client::find($id);
        $roles = Role::all();
        $users = User::with('roles')->get(['id', 'name']);
        $distributors = $users->reject(function ($user, $key) {
            return $user->hasRole(['admin', 'warehouse_manager']);
        });
        return view('clients.edit_client', ['client' => $client, 'distributors' => $distributors]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'distributor_id' => 'required',
            'phone' => 'required|max:255',
            'whatsapp_number' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255',
            'code' => 'required|max:255',
            'address' => 'required|max:255',
            'city' => 'required|max:255',
            'region' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('client.edit', [$id])->withErrors($validator)->withInput();
        }

        $client = Client::findorfail($id);

        $client->name = $request->input('name');
        $password = $request->input('password');
        $client->password = md5($password);
        $client->email = $request->input('email');
        $client->phone = $request->input('phone');
        $client->whatsapp_number = $request->input('whatsapp_number');
        $client->distributor_id = $request->input('distributor_id');
        $client->city = $request->input('city');
        $client->region = $request->input('region');
        $client->address = $request->input('address');
        $client->code = $request->input('code');

        if ($client->save()) {
            return redirect('clients');
        } else {
            $error = [
                'error' => 'An error occurred while saving!',
            ];
            return redirect()->route('client.edit', [$id])->withErrors($error)->withInput();
        }
    }

}
