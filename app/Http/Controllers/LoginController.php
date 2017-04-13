<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use View;
class LoginController extends Controller {

    public function login()
    {
        if (Auth::user())
        {
            $sessions['alert-warning'] = 'Anda sudah melakukan login dengan username ' . Auth::user()->username;
            View::share('sessions', $sessions);
        }

        return view('user.login');
    }

    public function doLogin(Request $request)
    {
        $input = Input::get();
        $attempt = Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ]);
        if ($attempt)
        {
            $request->session()->flash('alert-success', 'Anda telah berhasil login');

            return redirect()->intended('/');
        } else
        {
            $request->session()->flash('alert-danger', 'Username / Password anda salah!');

            return redirect()->intended('user/login');
        }

    }

    public function logout()
    {
        if(Auth::user()) Auth::logout();
        return redirect()->intended();
    }
}
