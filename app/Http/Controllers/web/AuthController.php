<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_field' => ['required'],
            'password' => ['required'],
        ], [
            'login_field.required' => 'Please enter Email or Phone Number.',
            'password.required' => 'Please enter password.',
        ]);

        $loginValue = $request->input('login_field');
        
        $fieldType = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $fieldType => $loginValue,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', "Welcome Admin {$user->name}!");
            }

            return redirect('/')
                ->with('success', "Hello {$user->name}, welcome to BK Cinema!");
        }


        return back()->withErrors([
            'login_field' => 'Login credentials or password is incorrect.',
        ])->withInput($request->only('login_field', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have successfully logged out.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => [
            'required', 
            'numeric', 
            'digits:10',
            'regex:/^(03|05|07|08|09)/',
            'unique:users,phone'
            ],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'name.required' => 'Full name cannot be empty.',
            'email.required' => 'Email cannot be empty.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'This email already exists in the system.',
            'phone.required' => 'Phone number cannot be empty.',
            'phone.unique' => 'This phone number has been used by another account.',
            'phone.numeric' => 'Phone number must be numeric format.',
            'phone.digits_between' => 'Phone number must be between 10 and 11 digits.',
            'password.required' => 'Password cannot be empty.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user', 
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in with your new account.');
    }
}