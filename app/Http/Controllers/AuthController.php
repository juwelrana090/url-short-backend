<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function index()
    {
        // return view('auth.login');
        echo "Hello User";
    }

    public function register()
    {
        return view('auth.register');
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->guard('web')->attempt($credentials)) {
            return Redirect::route('admin.index')->with('success', 'Login successfully');
        }
        return Redirect::route('login')->with('error', 'Login details are not valid');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //dd($request->all());

        $this->validate($request, [
            'full_name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $nowdate = date('d, F, Y g:i A');

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'date_at' => $nowdate,
        ]);

        return Redirect::route('login')->with('success', 'User registion successfuly...');
    }


    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }



    public function password()
    {
        return view('auth.password');
    }

    public function forgot(Request $request)
    {
        $this->validate($request, [
            'email' => ['required'],
        ]);

        $user = User::where('email', "=", $request->email)->first();

        function genPassword($length = 10)
        {
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' .
                '0123456789!@#$%';
            $str = '';
            $max = strlen($chars) - 1;

            for ($i = 0; $i < $length; $i++)
                $str .= $chars[mt_rand(0, $max)];

            return $str;
        }

        $full_name = $user->full_name;
        $email = $user->email;
        $password = 'admin@123'; // genPassword();

        if (!empty($user)) {

            $user = User::where('id', $user->id)->update([
                'password' => bcrypt($password),
            ]);

            $details = [
                'full_name' => $full_name,
                'email' => $email,
                'password' => $password,
            ];

            \Mail::to($email)->send(new \App\Mail\passwordForgot($details));

            echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Successfully reset new password please check your email (' . $request->email . ') inbox or spam box</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';


        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">(' . $request->email . ') This email address <strong>Account does not exist !!!</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }

    public function logout()
    {
        auth()->guard('web')->logout();
        Session::flush();
        return redirect()->route('login')->with('success', 'You have logged out!');
    }
}
