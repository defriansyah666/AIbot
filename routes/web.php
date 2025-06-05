<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Master Data Routes (Admin only)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/master-data', function () {
            return view('master-data.index');
        })->name('master-data.index');
        
        Route::get('/users', function () {
            return view('users.index');
        })->name('users.index');
        
        Route::get('/activity-log', function () {
            return view('activity-log.index');
        })->name('activity-log.index');
    });
    
    // Production Routes (All authenticated users)
    Route::get('/injection', function () {
        return view('production.injection');
    })->name('injection.index');
    
    Route::get('/assembling', function () {
        return view('production.assembling');
    })->name('assembling.index');
    
    Route::get('/delivery', function () {
        return view('production.delivery');
    })->name('delivery.index');
    
    // Inventory Routes
    Route::get('/stock-wip', function () {
        return view('inventory.stock-wip');
    })->name('stock-wip.index');
    
    Route::get('/stock-fg', function () {
        return view('inventory.stock-fg');
    })->name('stock-fg.index');
    
    Route::get('/material-usage', function () {
        return view('inventory.material-usage');
    })->name('material-usage.index');
    
    // Reports Routes
    Route::get('/reports/production', function () {
        return view('reports.production');
    })->name('reports.production');
    
    Route::get('/reports/assembly', function () {
        return view('reports.assembly');
    })->name('reports.assembly');
});

