<?php

use App\Http\Controllers\FinanceController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/import-pdf', [TransactionController::class, 'importPdf']);

Route::post('/analyze', [TransactionController::class, 'analyze']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/set-salary', [FinanceController::class, 'setSalary']);
    Route::post('/add-expense', [FinanceController::class, 'addExpense']);
    Route::post('/calculate', [FinanceController::class, 'calculate']);
    Route::post('/add-goal', [FinanceController::class, 'addGoal']);
});
