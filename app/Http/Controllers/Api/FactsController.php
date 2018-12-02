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
            'title' => $request->name,
            'is_published' => $request->is_published
        ]);

        return new FactResource($item);
    }

    public function show(Fact $item)
    {
        return new FactResource($item);
    }

    public function update(Request $request, Fact $item)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), '400');
        }

        $item->update($request->only(['title', 'is_published']));

        return new FactResource($item);
    }

    public function destroy(Fact $item)
    {
        $item->delete();

        return response()->json(null, 204);
    }
}
