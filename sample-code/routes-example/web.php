<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GardenController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\PlantingRecordController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\YieldRecordController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Dashboard (ต้องล็อกอินและยืนยันอีเมล)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// กลุ่ม Route ที่ต้องล็อกอินก่อนถึงเข้าได้
Route::middleware('auth')->group(function () {

    // โปรไฟล์ผู้ใช้ (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // LINE Settings
    Route::get('/profile/line', [ProfileController::class, 'lineSettings'])->name('profile.line');
    Route::post('/profile/line/link', [ProfileController::class, 'linkLine'])->name('profile.line.link');
    Route::post('/profile/line/unlink', [ProfileController::class, 'unlinkLine'])->name('profile.line.unlink');
    Route::post('/profile/line/test', [ProfileController::class, 'testLine'])->name('profile.line.test');

    // ระบบจัดการแปลงเพาะปลูก
    Route::resource('gardens', GardenController::class);

    // ระบบจัดการข้อมูลพืช
    Route::resource('plants', PlantController::class);

    // ระบบบันทึกการปลูก
    Route::resource('planting-records', PlantingRecordController::class);

    // ระบบจัดการต้นทุน
    Route::resource('costs', CostController::class);

    // ระบบจัดการข้อมูลผู้ซื้อ
    Route::resource('buyers', BuyerController::class);

    // ระบบบันทึกผลผลิต
    Route::resource('yield-records', YieldRecordController::class);

    // Reports (รายงาน)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit-loss');
        Route::get('/harvest-summary', [ReportController::class, 'harvestSummary'])->name('harvest-summary');
        Route::get('/profit-loss/pdf', [ReportController::class, 'exportProfitLossPdf'])->name('profit-loss.pdf');
        Route::get('/harvest-summary/pdf', [ReportController::class, 'exportHarvestSummaryPdf'])->name('harvest-summary.pdf');
    });
});

// รวม route ของระบบ Auth
require __DIR__.'/auth.php';
