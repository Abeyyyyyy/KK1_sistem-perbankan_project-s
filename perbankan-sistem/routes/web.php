<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueryController;

Route::get('/', [QueryController::class, 'home'])->name('home');
Route::get('/query1', [QueryController::class, 'query1'])->name('query1');
Route::get('/query2', [QueryController::class, 'query2'])->name('query2');
Route::get('/query3', [QueryController::class, 'query3'])->name('query3');
Route::get('/query4', [QueryController::class, 'query4'])->name('query4');
Route::get('/query5', [QueryController::class, 'query5'])->name('query5');
Route::get('/query6', [QueryController::class, 'query6'])->name('query6');
Route::get('/query7', [QueryController::class, 'query7'])->name('query7');
Route::get('/query8', [QueryController::class, 'query8'])->name('query8');
Route::get('/query9', [QueryController::class, 'query9'])->name('query9');