<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Redirect; 

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'string', 'in:male,female'],
            'address' => ['required', 'string'], // Validation rule for address
        ]);
    }

    protected function create(array $data)
    {
        // Set the default value for 'type' to 'user' if not provided
        $type = isset($data['type']) ? $data['type'] : 'user';

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'type' => $type, // Save the selected user type or default to 'user'
        ]);
    }

    protected function registered(Request $request, $user)
    {
        Auth::logout(); // Logout the newly registered user
        return Redirect::route('login')->with('success', 'Your account has been successfully created. Please login.');
    }
}
