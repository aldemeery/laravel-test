<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;

Route::middleware('auth:api')->group(function () {
    Route::apiResource('posts', PostController::class)->only('index', 'store', 'show');
    Route::apiResource('posts/{post}/comments', CommentController::class)->only('store');
    Route::get('notifications', NotificationController::class);
});
