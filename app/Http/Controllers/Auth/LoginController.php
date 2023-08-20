<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request) {
        $request->validate([
            'userUniqueId' => 'required'
        ]);

        // $userUniqueId = $request->input('userUniqueId');
        // $password = $request->input('password');

        // if(Auth::attempt(['userUniqueId' => $userUniqueId, 'password'=>$password])) {

        //     $user = User::where('userUniqueId', $userUniqueId)->first();

        //     Auth::login($user);

        //     return redirect('home');

        // }else{
        //     return back()->withErrors(['Invalid Credentials']);
        // }


        $userUniqueId = $request->userUniqueId;    
        $user = User::where('userUniqueId', $userUniqueId)->first();    
        if ($user) {    
            Auth::login($user);    
            return redirect('home');    
        } else { 
          
            return back()->withErrors(['Invalid Credentials']);   
        } 




    }

    public function logout() {
        Auth::logout();
        return redirect('login');
    }

    public function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (User::where("userUniqueId", "=", $code)->first());
  
        return $code;
    }
}
