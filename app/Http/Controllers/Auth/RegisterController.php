<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{


    public function register() {
        return view('auth.register');
    }

    public function store(Request $request ) {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required|confirmed'
            ]
        );

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->userUniqueId = $this->generateUniqueCode();
        $user->save();
        Auth::login($user);

        return redirect('home');

    }


    //20-08-2023

    public function generateUniqueCode()
{
    do {
        $code = $this->generateRandomCode();
    } while ($this->codeExists($code) || !$this->isCodeValid($code));

    return $code;
}

private function generateRandomCode()
{
    return random_int(100000, 999999);
}

private function codeExists($code)
{
    return User::where("userUniqueId", "=", $code)->exists();
}

private function isCodeValid($code)
{
    return
        !$this->isPalindrome($code) &&
        $this->hasMaxRepeatedCharacters($code) &&
        $this->hasMaxSequenceLength($code) &&
        $this->hasMinUniqueCharacters($code);
}

private function isPalindrome($code)
{
    return $code == strrev($code);
}

private function hasMaxRepeatedCharacters($code)
{
    $charCount = array_count_values(str_split($code));
    return max($charCount) <= 1;
}

private function hasMaxSequenceLength($code)
{
    $sequences = preg_split('/(?<=\d)(?=\d)/', $code);
    return max(array_map('strlen', $sequences)) <= 1;
}

private function hasMinUniqueCharacters($code)
{
    return count(array_unique(str_split($code))) >= 1;
}


}