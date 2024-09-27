<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Services\VerificationService;

class AuthController extends Controller
{
    public function __construct(
        private VerificationService $verificationService
    ) {
    }

    /*
     *  Sign in
     */
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
                'password' => 'required',
                'remember' => 'required|boolean'
            ],
            ['email.exists' => 'No account with such email exists!']
        );

        if (!Auth::attempt($request->only(['email', 'password']), $request->remember)) {
            return redirect()->back()->withErrors([
                'password' => 'Invalid credential!'
            ]);
        }

        $request->session()->regenerate();

        // return redirect()->back()->with('message', 'Login successful!');
        // Redirect based on user type
        $user = Auth::user();
        if ($user->usertype === 'admin') {
            return Inertia::location('/admin/dashboard');
        }

        if ($user->usertype === 'super_admin') {
            return redirect('/super_admin/dashboard')->with('message', 'Login successful!');
        }

        return redirect()->back()->with('message', 'Login successful!');
    }

    public function register(Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required',
                'password' => 'required',
                'password_confirm' => 'required|same:password',
                'otp' => 'required'
            ],
            ['email.unique' => 'An account already exists with such email!']
        );

        $res = $this->verificationService->verifyOtp($request->otp, $request->email);

        if (!$res['status']) {
            return redirect()->back()->withErrors([
                'otp' => $res['message']
            ]);
        }

        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'avatar' => fake()->imageUrl(320, 320, 'people', true),
            'email_verified' => true
        ]);

        // TODO: Account created event - Send welcome email

        Auth::login($user);

        return redirect()->back()->with('message', 'Registration successful!');
    }

    public function emailOTP(Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'password' => 'required',
                'password_confirm' => 'required|same:password',
            ],
            [
                'phone.required' => 'Phone required',
                'email.required' => 'Email required',
                'fullname.required' => 'Fullname required',
                'password.required' => 'Password required',
                'password_confirm.required' => 'Confirm password'
            ]
        );

        $otp = $this->verificationService->createOtp($request->email);

        Mail::to($request->email)->queue(new \App\Mail\EmailVerification($otp));

        return redirect()->back()->with('message', 'OTP has been sent!');
    }

    public function passwordOTP(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email'
            ]
        );

        $otp = $this->verificationService->createOtp($request->email);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors([
                'email' => 'No account exists with such email!'
            ]);
        }

        Mail::to($user->email)->queue(new \App\Mail\PasswordReset($user, $otp));

        return redirect()->back();
        // ->with('message', 'OTP has been sent!');
    }
    


    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required',
            'password_confirm' => 'required|same:password'

        ]);

        
        $res = $this->verificationService->verifyOtp($request->otp, $request->email);
        
        if (!$res['status']) {
            return redirect()->back()->withErrors([
                'otp' => $res['message']
            ]);
        }
        
        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with('message', 'Password has been reset!');
        //fix return redirect with laracast

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Inertia::location('/');
    }
}
