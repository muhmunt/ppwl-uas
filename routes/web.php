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

    // Admin routes (with /admin prefix)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Categories routes (admin only)
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
        
        // Menus routes (admin only)
        Route::get('menus', [\App\Http\Controllers\MenuController::class, 'index'])->name('menus.index');
        Route::get('menus/create', [\App\Http\Controllers\MenuController::class, 'create'])->name('menus.create');
        Route::post('menus', [\App\Http\Controllers\MenuController::class, 'store'])->name('menus.store');
        Route::get('menus/{menu}', [\App\Http\Controllers\MenuController::class, 'show'])->name('menus.show');
        Route::get('menus/{menu}/edit', [\App\Http\Controllers\MenuController::class, 'edit'])->name('menus.edit');
        Route::put('menus/{menu}', [\App\Http\Controllers\MenuController::class, 'update'])->name('menus.update');
        Route::delete('menus/{menu}', [\App\Http\Controllers\MenuController::class, 'destroy'])->name('menus.destroy');
        Route::post('menus/{menu}/toggle-availability', [\App\Http\Controllers\MenuController::class, 'toggleAvailability'])->name('menus.toggle-availability');
        
        // Orders routes (admin can also access)
        Route::resource('orders', \App\Http\Controllers\OrderController::class);
        Route::post('orders/{order}/update-status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('orders/{order}/print', [\App\Http\Controllers\OrderController::class, 'print'])->name('orders.print');
        
        // Reports routes (admin only)
        Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    });
    
    // Categories routes without prefix (for backward compatibility)
    Route::middleware(['admin'])->resource('categories', \App\Http\Controllers\CategoryController::class);
    
    // Menus routes (read-only for kasir - without prefix)
    Route::middleware(['kasir'])->get('menus', [\App\Http\Controllers\MenuController::class, 'index'])->name('menus.index');
    Route::middleware(['kasir'])->get('menus/{menu}', [\App\Http\Controllers\MenuController::class, 'show'])->name('menus.show');
    
    // Orders routes (accessible by kasir - without prefix)
    Route::middleware(['kasir'])->resource('orders', \App\Http\Controllers\OrderController::class);
    Route::middleware(['kasir'])->post('orders/{order}/update-status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::middleware(['kasir'])->get('orders/{order}/print', [\App\Http\Controllers\OrderController::class, 'print'])->name('orders.print');
    
    // Reports routes without prefix (for backward compatibility)
    Route::middleware(['admin'])->get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

    // Kasir routes (with /kasir prefix)
    Route::middleware(['kasir'])->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/dashboard', [KasirDashboardController::class, 'index'])->name('dashboard');
    });

    // Profile routes (accessible by all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';