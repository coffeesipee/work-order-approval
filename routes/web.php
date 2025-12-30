<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.admin.pages.dashboard');
});

Route::get('/documents/berita-acara/{damage}', [App\Http\Controllers\DocumentGeneratorController::class, 'generateBeritaAcara'])->name('documents.berita-acara');