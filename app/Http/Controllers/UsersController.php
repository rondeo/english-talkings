<?php

namespace App\Http\Controllers;

use App\Country;
use App\Language;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        $country = Country::find($user->country_id);
        $language = Language::find($user->language_id);
        $user->country = $country;
        $user->language = $language;
        return view('profile', compact('user'));
    }
}
