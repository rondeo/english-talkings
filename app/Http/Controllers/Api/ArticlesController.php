<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
    public function index()
    {
        return ArticleResource::collection(Article::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'img' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), '400');
        }

        $item = Article::create([
            'title' => $request->title,
            'text' => $request->text,
            'img' => $request->img,
            'is_published' => $request->is_published
        ]);

        return new ArticleResource($item);
    }

    public function show(Article $item)
    {
        return new ArticleResource($item);
    }

    public function update(Request $request, Article $item)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'img' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), '400');
        }

        $item->update($request->only(['title', 'is_published', 'text', 'img']));

        return new ArticleResource($item);
    }

    public function destroy(Article $item)
    {
        $item->delete();

        return response()->json(null, 204);
    }
}
