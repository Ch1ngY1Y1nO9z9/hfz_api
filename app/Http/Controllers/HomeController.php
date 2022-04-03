<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function resetPassword() {
        return view('auth.passwords.reset');
    }

    public function reset(Request $request) {

        $check_old_password = $request->OldPassword;

        if(!Hash::check($check_old_password, Auth::user()->password)) {
            return redirect()->back()->with('OldPasswordFailed','密碼錯誤');
        }

        $new_password = $request->password;
        $check_new_password = $request->password_confirmation;

        if($new_password != $check_new_password) {
            return redirect()->back()->with('PasswordConfirmationFailed','新密碼錯誤');
        }

        $user = Auth::user();

        $user->password = Hash::make($new_password);

        $user->save();

        Auth::logout();

        return redirect('/login')->with('success','更新成功');

    }

    public function clearCache() {
        Session::put('cleared',date('Y/m/d'));
        Artisan::call('cache:clear');

        return redirect()->back();
    }
}
