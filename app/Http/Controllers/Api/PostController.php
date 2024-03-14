<?php

namespace App\Http\Controllers\Api;

use App\Exports\PostExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostStoreRequest;
use App\Http\Requests\Api\PostUpdateRequest;
use App\Http\Resources\Api\PostCollection;
use App\Http\Resources\Api\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    public function index(Request $request): PostCollection
    {
        $posts = Post::with(['user', 'categories'])->paginate($request->input('per_page', 15));

        return new PostCollection($posts);
    }

    public function store(PostStoreRequest $request): PostResource
    {
        $post = Post::create($request->validated());

        $post->categories()->attach($request->categories);
        $post->user()->associate($request->user_id);

        return new PostResource($post);
    }

    public function show(Request $request, Post $post): PostResource
    {
        return new PostResource($post->load(['user', 'categories']));
    }

    public function update(PostUpdateRequest $request, Post $post): PostResource
    {
        $post->update($request->validated());
        $request->categories ? $post->categories()->sync($request->categories) : null;

        return new PostResource($post);
    }

    public function destroy(Request $request, Post $post): Response
    {
        $post->delete();

        return response()->noContent();
    }

    public function export(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new PostExport(), 'posts.xlsx');
    }
}
