<?php

use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\ExportacaoController;
use Illuminate\Support\Facades\Route;

// Página inicial para escolher o tipo de acesso
Route::get('/', [ChatGPTController::class, 'index'])->name('home');

// Rotas para funcionalidades específicas de usuários
Route::get('/verificar-objeto', [ExportacaoController::class, 'index'])->name('verificar-objeto');
Route::post('/verificar-objeto', [ExportacaoController::class, 'verificarObjeto']);
Route::post('/gerar-pdf', [ExportacaoController::class, 'gerarPDF'])->name('gerar-pdf');

// Rotas para funcionalidades de funcionários dos Correios
Route::get('/funcionario-correios', [ChatGPTController::class, 'correios'])->name('funcionario-correios');
Route::post('/processar-pdf', [ChatGPTController::class, 'processarPDF'])->name('processar-pdf');
Route::post('/processar-excel', [ChatGPTController::class, 'processarExcel'])->name('processar-excel');