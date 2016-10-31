<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

//para utilizarlos en la activacion de la cuenta por email
use Illuminate\Http\Request;
use App\ActivationService;
use Mail;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Para la activacion por correo de la cuenta
     */
    protected $activationService;
    
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     * 
     * ActivationService $activationService se agrego para activacion por email
     * @return void
     */
    public function __construct(ActivationService $activationService)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->activationService = $activationService;//para activacion por email
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
//            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
//            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }




    /**
     * Sobrescribiendo metodo de la clase
     * \vendor\laravel\framework\src\Illuminate\Foundation\Auth\RegistersUsers.php
     * para la activacion de la cuenta por email
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        $this->activationService->sendActivationMail($user);

        return redirect('/login')->with('status', 'Le hemos enviado un código de activación. Revice su email.');
    }

    /**
     * If method authenticated exists in the AuthController
     * probar este metodo
     *  Para bloquear al usuario si no esta activo todavia, y si es necesario, reenviarle un correo.
     */
    public function authenticated(Request $request, $user)
    {
        if (!$user->activated) {
//            $this->activationService->sendActivationMail($user);
            auth()->logout();
            return back()->with('warning', 'Es necesario que Ud confirme su cuenta.Le hemos enviado un codigo de activación, por favor verifique su email.');
        }
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Metodo que activa al usuario
     */

    public function activateUser($token)
    {
        if ($user = $this->activationService->activateUser($token)) {
            auth()->login($user);
            return redirect($this->redirectPath());
        }
        abort(404);
    }
    
}
