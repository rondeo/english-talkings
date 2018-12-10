<?php

namespace App\Http\Controllers\Api;

use App\Fact;
use App\Http\Resources\FactResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FactsController extends Controller
{
    public function index()
    {
        return FactResource::collection(Fact::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), '400');
        }

        $item = Fact::create([
            'title' => $request->input('title'),
            'is_published' => $request->input('is_published')
        ]);

        return new FactResource($item);
    }

    public function show(Fact $item)
    {
        return new FactResource($item);
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), '400');
        }

        $item = Fact::where('id', $id)->first();
        $item->title = $request->input('title');
        $item->is_published = $request->input('is_published');
        $item->save();

        return new FactResource($item);
    }

    public function destroy(int $id)
    {
        Fact::destroy(['id' => $id]);

        return response()->json(null, 204);
    }
}
