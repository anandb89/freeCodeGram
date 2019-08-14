<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        //If user is not logged in, it shouldnt even be touching this- execution of this statment leads to 500 error, to solve this a constructor is made above
        return auth()->user()->following()->toggle($user->profile);
    }
}
