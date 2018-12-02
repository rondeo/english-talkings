<?php

namespace App\Http\Controllers;

use App\LanguageLevel;
use Illuminate\Http\Request;

class LanguageLevelsController extends Controller
{
    public function index()
    {
        return LanguageLevel::orderBy('id')->get();
    }
}
