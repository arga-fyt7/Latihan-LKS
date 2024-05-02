<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index1()
    {
        return view('auth.sign-in', [
            "title" => "Sign In"
        ]);
    }
    public function index2()
    {
        return view('auth.login', [
            "title" => "LogIn"
        ]);
    }
    public function index3()
    {
        return view('auth.forgot-password', [
            "title" => "Forgot Password"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $credentials = $request->validate([
            'email-username' => 'required',
            'password' => 'required|min:8',
        ]);

        $user = User::where(function ($query) use ($credentials) {
            $query->where('email', $credentials['email-username'])
                ->orWhere('username', $credentials['email-username']);
        })->first();

        if ($user) {
            if ($user && Hash::check($credentials['password'], $user->password)) {
                Auth::login($user);
                return redirect()->intended('/dashboard');
            } else {
                return back()->withInput()->withErrors(['email-username' => 'Email atau password salah']);
            }
        } else {
            return redirect('/sign-in')->with(['unk'=> 'Tampaknya anda mencoba login dengan akun yang belum terdaftar?']);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'terms' => 'accepted',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Password reset link has been sent to your email.');
        } else {
            return back()->withErrors(['email' => 'Unable to send password reset link. Please try again later.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
