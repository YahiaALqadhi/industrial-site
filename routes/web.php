<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminInquiryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminTestEmailController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\SystemHealthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/products', [ProductCatalogController::class, 'index'])->name('products.index');
Route::get('/products/category/{slug}', [ProductCatalogController::class, 'category'])->name('products.category');
Route::get('/product/{slug}', [ProductCatalogController::class, 'product'])->name('products.show');

Route::get('/services', [PageController::class, 'services'])->name('services');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [InquiryController::class, 'contact'])
    ->middleware('throttle:10,1')
    ->name('contact.store');

Route::post('/inquiry/product/{slug}', [InquiryController::class, 'product'])
    ->middleware('throttle:10,1')
    ->name('inquiry.product');


Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')
    ->middleware(['auth', 'verified', 'ensureUserIsActive'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', AdminCategoryController::class);
        Route::resource('products', AdminProductController::class);
        Route::resource('services', AdminServiceController::class);

        Route::get('inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
        Route::get('inquiries/{inquiry}', [AdminInquiryController::class, 'show'])->name('inquiries.show');
        Route::patch('inquiries/{inquiry}/status', [AdminInquiryController::class, 'updateStatus'])->name('inquiries.updateStatus');
        Route::patch('inquiries/{inquiry}/reply', [AdminInquiryController::class, 'reply'])->name('inquiries.reply');
        Route::delete('inquiries/bulk-delete', [AdminInquiryController::class, 'bulkDelete'])->name('inquiries.bulkDelete');
        Route::delete('inquiries/{inquiry}', [AdminInquiryController::class, 'destroy'])->name('inquiries.destroy');

        Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::patch('settings', [AdminSettingController::class, 'update'])->name('settings.update');

        Route::resource('users', AdminUserController::class)->except(['show']);

        Route::get('test-email', [AdminTestEmailController::class, 'index'])->name('test-email.index');
        Route::post('test-email/send', [AdminTestEmailController::class, 'send'])->name('test-email.send');

        Route::get('system-health', [SystemHealthController::class, 'index'])->name('system-health.index');
        Route::post('system-health/test-mail', [SystemHealthController::class, 'testMail'])->name('system-health.test-mail');
        Route::post('system-health/clear-cache', [SystemHealthController::class, 'clearCache'])->name('system-health.clear-cache');
    });
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
require __DIR__.'/auth.php';