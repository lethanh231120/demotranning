<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use config\constants;

class AdminController extends Controller
{
    /**
     * Get login admin.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/admin');
        }
        return view("login.login");
    }
    /**
     * Show list user from admin.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = User::select('users.id', 'users.email', 'users.user_name', 'users.avatar', 'users.first_name', 'users.last_name', 'users.status', 'users.address', 'commune.name as commune_name', 'district.name as district_name', 'province.name as province_name')
            ->leftJoin('communes as commune', 'users.commune_id', '=', 'commune.id')
            ->leftJoin('districts as district', 'users.district_id', '=', 'district.id')
            ->leftJoin('provinces as province', 'users.province_id', '=', 'province.id')
            ->where('flag_delete', config('constants.FLAG_DELETE'))
            ->search()
            ->paginate(config('constants.PAGINATION_RECORDS'));
        return view('admin.category.index', compact('data'));
    }
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect('admin/');
        } else {
            return redirect()->back()->with(["msg" => "Bạn nhập sai thông tin tài khoản ! Vui lòng nhập lại"]);
        }
    }

    public function destroy()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
