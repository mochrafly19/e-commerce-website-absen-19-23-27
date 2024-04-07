<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
  
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
  
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request): RedirectResponse
    {   
        $input = $request->validate([
            'email' => ['required', 'email', Rule::exists('users')],
            'password' => 'required',
        ]);
     
        if(auth()->attempt($input))
        {
            $user = auth()->user();
            switch ($user->type) {
                case 'admin':
                    return redirect()->route('admin.home');
                    break;
                case 'manager':
                    return redirect()->route('manager.home');
                    break;
                default:
                    return redirect()->route('home');
                    break;
            }
        }else{
            return redirect()->route('login')
                ->with('error','Email address and password are incorrect.');
        }
    }
}
