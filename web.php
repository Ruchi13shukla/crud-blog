<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ProductController::class,'index'])->name('products.index');
Route::get('products/create', [ProductController::class,'create'])
        ->name('products.create');

Route::post('products/store', [ProductController::class,'store'])
        ->name('products.store');

Route::get('products/{id}/edit', [ProductController::class,'edit'])
        ->name('products.edit');

Route::put('products/{id}/update', [ProductController::class,'update']);
   
Route::get('products/{id}/delete', [ProductController::class,'destroy']);

// Route::delete('products/{id}/delete', [ProductController::class,'destroy']);
   
Route::get('products/{id}/show', [ProductController::class,'show']);
Route::get('/load-more-employees', [ProductController::class, 'loadMore']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
