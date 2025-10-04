<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

            try {
                
            } catch (\Throwable $th) {
                
            }
            echo 'OK!';
    }
    public function logout(){
        echo "Logout";
    }
}
