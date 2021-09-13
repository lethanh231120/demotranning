<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use config\constants;

class LoginUserController extends Controller
{
    /**
     * Get login user.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view("login.login");
    }
    /**

     * Show  from index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('user.dashboard');
    }
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return redirect('/user');
        } else {
            return redirect()->back()->with(["msg" => "Bạn nhập sai thông tin tài khoản của user!"]);
        }
    }
}
