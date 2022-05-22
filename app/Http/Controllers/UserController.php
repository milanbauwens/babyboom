<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function show(){
        $user = auth()->user();

        return view('pages.settings', [
            'user' => $user
        ]);
    }

    private function deleteUser(){
        $user = User::find(\auth()->user()->id);

        Auth::logout();

        if ($user->delete()) {

             return Redirect::route('landing')->with('global', 'Your account has been deleted!');
        }
    }
}
