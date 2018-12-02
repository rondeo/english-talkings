<?php

namespace App\Http\Controllers;

use App\Events\Newcomers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class NewcomersController extends Controller
{
    public function add(Request $request) {
        $user = Auth::user();
        $user->nickname = $request->input('nickname');
        $user->sex = $request->input('sex');
        $user->goal = $request->input('goal');
        $user->age = $request->input('age');
        $user->country_id = $request->input('country');
        $user->language_id = $request->input('talking');
        $user->language_level_id = $request->input('level');
        $user->skype = $request->input('skype');
        $user->save();
    }

    public function index() {
        $newcomers = User::whereNotNull('skype')->get();
        return response()->json($newcomers);
    }

    public function delete($userId)
    {
       // User::destroy($userId);
    }
}
