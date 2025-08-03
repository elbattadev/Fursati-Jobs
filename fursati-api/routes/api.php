<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

Route::prefix('ar/api/job-seeker')->group(function () {
    Route::get('all-jobs', [JobController::class, 'index']);
    Route::get('job-details/{id}', [JobController::class, 'show']);
    Route::get('bookmarks', [JobController::class, 'bookmarked']);
});

Route::post('jobs/{id}/mark-favorite', [JobController::class, 'markFavorite']);
