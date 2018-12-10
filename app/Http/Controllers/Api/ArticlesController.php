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
            'text' => 'string',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), '400');
        }

        $image = $request->file('img');
        $name = '';

        if ($image) {
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/uploads/');
            $image->move($destinationPath, $name);
        }

        $item = Article::create([
            'title' => $request->input('title'),
            'text' => $request->input('text'),
            'img' => ($image) ? 'images/uploads/' . $name : '',
            'is_published' => $request->input('is_published')
        ]);

        $item->tags()->attach($request->input('tags'));

        return new ArticleResource($item);
    }

    public function show(Article $item)
    {
        return new ArticleResource($item);
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,string|max:2048',
            'text' => 'string',
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), '400');
        }

        $image = $request->file('img');
        $name = '';
        if ($image) {
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/uploads/');
            $image->move($destinationPath, $name);
        }

        $item = Article::where('id', $id)->first();
        $item->tags()->detach();

        $item->title = $request->input('title');
        $item->text = $request->input('text');
        $item->img = ($image) ? 'images/uploads/' . $name : '';
        $item->is_published = $request->input('is_published');

        $item->tags()->attach($request->input('tags'));

        $item->save();

        return new ArticleResource($item);
    }

    public function destroy(int $id)
    {
        Article::destroy(['id' => $id]);

        return response()->json(null, 204);
    }
}
