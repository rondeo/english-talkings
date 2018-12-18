<?php

namespace App\Http\Controllers;

use App\Fact;
use App\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function index()
    {
        return Video::where('is_published', true)->get();
    }

    public function getLastVideos() {
        return Video::orderBy('created_at', 'DESC')->limit(3)->get();
    }
}
