<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }
    public function loginSubmit(Request $request){
        $request->validate(
            //rules
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            //error mensages
            [
                'text_username.required' => 'O username é obrigatório',
                'text_username.email' => 'O username não possui um email válido',
                'text_password.required' => 'A senha é obrigatório',
                'text_password.min' => 'O número de dígitos mínimos é :min',
                'text_password.max' => 'O número de dígitos máximo é :max',


            ],
        );
            $username = $request -> input('text_username');
            $password = $request -> input('text_password');

            //check if user exists
            $user = User::where('username', $username)
                        ->where('deleted_at', NULL)
                        ->first();



                if(!$user){
                    return redirect()
                    ->back()
                    ->withInput()
                    ->with('loginError', 'Password ou username incorretos');
                }
                //check if password is correct
                if(!password_verify($password, $user->password)){
                    return redirect()
                    ->back()
                    ->withInput()
                    ->with('loginError', 'Password ou username incorretos');
                }
                //update last login
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();

                // login user
                session([
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username
                    ]
                ]);
                //redirect to home
                return redirect()->to('/');

            //get all users
            //$users = User::all()->toArray();
            //using as a object instance of the model's class
            //$userModel = new User();
            //$users = $userModel->all()->toArray();
            //echo '<pre>';
            //print_r($users);

    }
    public function logout(){
        //logout from the application
        session()->forget('user');
        return redirect()->to('/login');
    }
}
