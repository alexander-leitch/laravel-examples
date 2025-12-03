<?php

use App\Http\Controllers\CacheDemoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QueueDemoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('home');
});

// Queue Demo Routes
Route::get('/queue-demo', [QueueDemoController::class, 'index'])->name('queue-demo');
Route::post('/queue-demo/dispatch', [QueueDemoController::class, 'dispatch'])->name('queue-demo.dispatch');
Route::get('/queue-demo/jobs', [QueueDemoController::class, 'getJobs'])->name('queue-demo.jobs');

// Cache Demo Routes
Route::get('/cache-demo', [CacheDemoController::class, 'index'])->name('cache-demo');
Route::get('/cache-demo/data', [CacheDemoController::class, 'getData'])->name('cache-demo.data');
Route::post('/cache-demo/clear', [CacheDemoController::class, 'clearCache'])->name('cache-demo.clear');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


