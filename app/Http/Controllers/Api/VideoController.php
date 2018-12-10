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
            'title' => $request->input('title'),
            'url' => $request->input('url'),
            'is_published' => $request->input('is_published')
        ]);

        return new VideoResource($item);
    }

    public function show(Video $item)
    {
        return new VideoResource($item);
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'url' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), '400');
        }

        $item = Video::where('id', $id)->first();
        $item->title = $request->input('title');
        $item->url = $request->input('url');
        $item->is_published = $request->input('is_published');
        $item->save();

        return new VideoResource($item);
    }

    public function destroy(int $id)
    {
        Video::destroy(['id' => $id]);

        return response()->json(null, 204);
    }
}
