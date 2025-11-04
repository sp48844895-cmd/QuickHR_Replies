<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidateEmailController;

Route::get('/', function () {
    return redirect()->route('candidate.form');
});

Route::get('/candidate', [CandidateEmailController::class, 'index'])->name('candidate.form');
Route::post('/candidate/preview', [CandidateEmailController::class, 'preview'])->name('candidate.preview');
Route::post('/candidate/send', [CandidateEmailController::class, 'send'])->name('candidate.send');
