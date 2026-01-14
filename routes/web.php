<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UtilityController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas públicas sin autenticación
Route::get('/utilities', [UtilityController::class, 'index'])->name('utilities.index');

// IMPORTANTE: Usar resource routes correctamente
Route::resource('providers', ProviderController::class);
Route::resource('incomes', IncomeController::class);
Route::resource('expenses', ExpenseController::class);

// Para depuración: Rutas explícitas
Route::get('/providers/{id}/edit', [ProviderController::class, 'edit'])->name('providers.edit');
Route::put('/providers/{id}', [ProviderController::class, 'update'])->name('providers.update');