<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Redirect to role-based dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'kasir') {
            return redirect()->route('kasir.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Admin routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Categories routes
        Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    });
    
    // Categories routes (accessible by admin only)
    Route::middleware(['admin'])->resource('categories', \App\Http\Controllers\CategoryController::class);
    
    // Menus routes (accessible by admin only)
    Route::middleware(['admin'])->resource('menus', \App\Http\Controllers\MenuController::class);
    Route::middleware(['admin'])->post('menus/{menu}/toggle-availability', [\App\Http\Controllers\MenuController::class, 'toggleAvailability'])->name('menus.toggle-availability');
    
    // Orders routes (accessible by kasir and admin)
    Route::resource('orders', \App\Http\Controllers\OrderController::class);
    Route::post('orders/{order}/update-status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders/{order}/print', [\App\Http\Controllers\OrderController::class, 'print'])->name('orders.print');

    // Kasir routes
    Route::middleware(['kasir'])->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('dashboard');
        // Other kasir routes will be added here
    });

    // Profile routes (accessible by all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
