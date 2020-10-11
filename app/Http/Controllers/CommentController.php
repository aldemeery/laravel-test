<?php

namespace App\Http\Controllers;

use App\Events\ModeratedModelCreated;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateCommentRequest $request
     * @param \App\Models\Post  $post
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCommentRequest $request, Post $post): JsonResponse
    {
        $comment = auth()->user()->comments()->make($request->validated());
        $post->comments()->save($comment);
        $comment->refresh();

        event(new ModeratedModelCreated($comment));

        return response()->json(['message' => 'Success.'], 202);
    }
}
