<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DatabaseSetupController;

// Rute beranda yang langsung mengirimkan ke tampilan reviews.index with default member ID 1
Route::get('/', function () {
    // Redirect ke route reviews.index dengan member_id=1
    return redirect('/reviews?member_id=1');
});

// Database Setup Routes
Route::prefix('db-setup')->group(function () {
    Route::get('/setup', [DatabaseSetupController::class, 'setupDatabase']);
    Route::get('/status', [DatabaseSetupController::class, 'checkStatus']);
});

// Frontend routes for Reviews
Route::prefix('reviews')->group(function () {
    Route::get('/', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/form', [ReviewController::class, 'showReviewForm'])->name('reviews.form');
    Route::get('/history', [ReviewController::class, 'showReviewHistory'])->name('reviews.history');
});

// Tambahkan route khusus untuk halaman utama
Route::get('/home', function() {
    return redirect()->route('reviews.index');
});

// API routes to proxy to the Nameko service
Route::prefix('api')->group(function () {
    Route::apiResource('reviews', \App\Http\Controllers\Api\ReviewRatingController::class)->only(['index', 'store']);
    
    // Custom routes for reviews
    Route::put('reviews/{id}', [\App\Http\Controllers\Api\ReviewRatingController::class, 'updateReview']);
    Route::delete('reviews/{id}', [\App\Http\Controllers\Api\ReviewRatingController::class, 'deleteReview']);
    
    // Rating routes
    Route::put('ratings/{id}', [\App\Http\Controllers\Api\ReviewRatingController::class, 'updateRating']);
    Route::delete('ratings/{id}', [\App\Http\Controllers\Api\ReviewRatingController::class, 'deleteRating']);
    
    // Order, member, and menu routes
    Route::get('orders/{orderId}/reviews', [\App\Http\Controllers\Api\ReviewRatingController::class, 'getOrderReviews']);
    Route::get('members/{memberId}/reviews', [\App\Http\Controllers\Api\ReviewRatingController::class, 'getMemberReviews']);
    Route::get('members/{memberId}/reviews/direct', [\App\Http\Controllers\Api\ReviewRatingController::class, 'getMemberReviewsDirect']);
    Route::get('members/{memberId}/ratings/direct', [\App\Http\Controllers\Api\ReviewRatingController::class, 'getMemberRatingsDirect']);
    Route::get('members/{memberId}', [\App\Http\Controllers\Api\ReviewRatingController::class, 'getMemberDetails']);
    Route::get('menus', [\App\Http\Controllers\Api\ReviewRatingController::class, 'getAllMenus']);
    Route::get('menus/{menuId}/rating-stats', [\App\Http\Controllers\Api\ReviewRatingController::class, 'getMenuRatingStats']);
    Route::get('mock/orders/{memberId}', [\App\Http\Controllers\Api\ReviewRatingController::class, 'getMemberOrders']);
});
