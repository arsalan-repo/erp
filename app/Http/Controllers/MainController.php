<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class MainController extends Controller
{
    public function home()
    {
//    	 $role = Role::create(['name' => 'admin']);
//    	 $role = Role::create(['name' => 'distributor']);
//    	 $role = Role::create(['name' => 'warehouse_manager']);
//    	 $role = Role::create(['name' => 'client']);

        $session = Auth::user()->name;
//         $user = Auth::user();
//         $user->assignRole('admin');
        return view('index', ['session' => $session]);
    }
}
