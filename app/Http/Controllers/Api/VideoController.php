<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\VideoResource;
use App\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function index()
    {
        return VideoResource::collection(Video::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'url' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), '400');
        }

        $item = Video::create([
            'title' => $request->name,
            'is_published' => $request->is_published,
            'url' => $request->url,
        ]);

        return new VideoResource($item);
    }

    public function show(Video $item)
    {
        return new VideoResource($item);
    }

    public function update(Request $request, Video $item)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'url' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), '400');
        }

        $item->update($request->only(['title', 'url', 'is_published']));

        return new VideoResource($item);
    }

    public function destroy(Video $item)
    {
        $item->delete();

        return response()->json(null, 204);
    }
}
