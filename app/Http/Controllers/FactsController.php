<?php

namespace App\Http\Controllers;

use App\Fact;
use Illuminate\Http\Request;

class FactsController extends Controller
{
    public function index()
    {
        return Fact::where('is_published', true)->first();
    }
}
