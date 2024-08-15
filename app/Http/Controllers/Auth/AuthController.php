<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register(){
        return view('auth.register');
    }

    public function registerSave(Request $request)
    {
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8'
        ])->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'siswa' ,  // Set default type as admin
           // Set default value for is_approved
        ]);

        return redirect()->route('login');
    }

    public function login(){
        return view('auth.login');
    }

    public function loginAction(Request $request)
    {
        Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        $request->session()->regenerate();

        // if (!auth()->user()->is_approved) {
        //     Auth::logout();
        //     return redirect()->route('login')->withErrors(['email' => 'Akun Anda belum disetujui oleh admin.']);
        // }

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.home');
        } else if (auth()->user()->role === 'guru'){
            return redirect()->route('guru.home');
        } else{
            return redirect()->route('siswa.home');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }

}
