<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SendResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use config\constants;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Session\Session;
use Laravel\Fortify\Actions\ConfirmPassword;

class ForgotpasswordController extends Controller
{
  public function __construct()
  {
    $this->getAlert();
  }
  /**

   * Show  from forgot.
   *
   * @return \Illuminate\View\View
   */
  public function showForgetPasswordForm()
  {
    return view('login.forgotpassword');
  }
  /**
   * Handle an authentication attempt.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function submitForgetPasswordForm(Request $request)
  {
    $email = $request->email;
    $user = User::where('email', '=', $email)
      ->where('users.flag_delete', config('constants.FLAG_DELETE'))
      ->first();
    if (!is_null($user)) {
      $val_token = $request->_token;
      $lifetime = time() + 3600;
      $token = Cookie::queue(Cookie::make('token', $val_token, $lifetime));
      return redirect()->route('send-data')->with('email', $request->email);
    }
  }

  /**
   * send mail reset password
   *
   * @return view
   */
  public function sendData()
  {
    $token = Cookie::get('token');
    $email = session()->get('email');
    $data = [
      'email' => $email,
      'token' => $token
    ];
    SendResetPassword::dispatch($data);
    return redirect()->route('forget.password.get')->with('thongbao', ' Mật khẩu đã được gửi vào email của bạn !');
  }
  /**
   * authentication requires reset password
   *
   * @param string $email
   * @param string $token
   *
   * @return view
   */
  public function getRecoverPassword($email)
  {
    $user = User::where('email', '=', $email)
      ->where('users.flag_delete', config('constants.FLAG_DELETE'))
      ->first();
    if (!is_null($user)) {
      return view('login.recover_password', ['email' => $email]);
    } else {
      echo "Incorrect information!";
    }
  }

  /**
   * update password
   *
   * @param Request $request
   *
   * @return view
   */
  public function updatePassword(Request $request)
  {
    $password = $request->password;
    $confirm_password = $request->confirm_password;
    DB::beginTransaction();
    try {
      if ($password == $confirm_password) {
        $user = User::where('email', '=', $request->email);
        $user->update([
          'password' => bcrypt($password)
        ]);
        $cookie = Cookie::forget('token');
      } else {
        return redirect()->back()->with('error', 'Incorrect information');
      }
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
    }
    return redirect()->route('user.get.login');
  }
}
