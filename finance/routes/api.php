<?php

use App\Http\Controllers\SalaryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/import-pdf', [TransactionController::class, 'importPdf']);
Route::post('/analyze', [TransactionController::class, 'analyze']);

Route::post('/salary', [SalaryController::class, 'salary']);
