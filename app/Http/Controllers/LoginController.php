<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function checkloginform(Request $request)
    {
        if ($request->isMethod('POST')) 
        {

            $email = $request->email;
            $password = $request->password;
            if(Auth::attempt(['email' => $email, 'password' => $password]))
            {
                return redirect('user/dashboard');
            }else
            {
                return redirect('/login')->withErrors(['msg' => 'Invalid Login credentials']);
            }
        }
    }
}
