<?php

use Illuminate\Support\Facades\Route;
use Modules\Grade\Http\Controllers\MarkController;
use Modules\Grade\Http\Controllers\TermController;
use Modules\Grade\Http\Controllers\GradeController;
use Modules\Grade\Http\Controllers\DistributionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('exam')->group(function () {
    Route::resource('term', TermController::class);
    Route::get('mark/{session}/{term}/{branch}/{class}/{section}/{subject}', [MarkController::class, 'studentMark'])->name('student-mark');
    Route::post('mark-distribution-entry/{session}/{term}/{branch}/{class}/{section}/{subject}', [MarkController::class, 'studentMarkEntry'])->name('mark-distribution-entry');
    Route::resource('/mark', MarkController::class);
    Route::resource('/distribution', DistributionController::class);
    Route::resource('/grade', GradeController::class);
});