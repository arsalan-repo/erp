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
        $session = Auth::user()->name;
        return view('index', ['session' => $session]);
    }
}
