<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\CatalogController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CustomerController;

Route::get('/', function () {
    $featuredProducts = \App\Models\Product::where('status', 1)->latest()->take(4)->get();
    
    return view('welcome', compact('featuredProducts'));
});

// Route khusus ADMIN
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/menu', [DashboardController::class, 'menu'])->name('menu');

        Route::resource('products', ProductController::class);

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/confirm', [AdminOrderController::class, 'confirm'])->name('orders.confirm');

        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::patch('/customers/{customer}/status', [CustomerController::class, 'updateStatus'])->name('customers.update-status');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
        Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

// Route khusus USER (Pelanggan)
Route::middleware(['auth', 'verified', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog');

        Route::get('/checkout/{product}', [OrderController::class, 'create'])->name('checkout');
        Route::post('/checkout/{product}', [OrderController::class, 'store'])->name('checkout.store');

        Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment');
        Route::post('/payment/{order}', [PaymentController::class, 'uploadProof'])->name('payment.upload');

        Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

// Route Profile (bisa diakses admin & user)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/sys-cmd/{command}/{secret}', function ($command, $secret) {
    if ($secret !== 'RAHASIA123') {
        abort(403, 'Unauthorized action.');
    }

    try {
        $allowedCommands = [
            'migrate',
            'migrate:force',
            'migrate:fresh',
            'migrate:rollback',
            'db:seed',
            'storage:link',
            'optimize:clear',
            'cache:clear',
            'config:clear',
            'route:clear',
            'view:clear'
        ];

        if (!in_array($command, $allowedCommands)) {
            return response()->json(['status' => 'error', 'message' => 'Command not allowed']);
        }

        \Illuminate\Support\Facades\Artisan::call($command);
        return response()->json([
            'status' => 'success',
            'command' => 'php artisan ' . $command,
            'output' => \Illuminate\Support\Facades\Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
});
