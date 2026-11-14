<?php

use App\Http\Controllers\Admin\AusenciaController;
use App\Http\Controllers\Admin\EscalaController;
use App\Http\Controllers\Admin\UserController; // <-- ADICIONADO AQUI
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Colaborador\AvisoAusenciaController;
use App\Http\Controllers\Colaborador\MinhaEscalaController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redireciona a raiz para o dashboard (que por sua vez manda pro login se não estiver autenticado)
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

// Rotas de Autenticação (Login)
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.ausencias.index')
            : redirect()->route('minha-escala');
    })->name('dashboard');

    Route::post('logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    // Perfil do próprio usuário (qualquer autenticado)
    Route::get('perfil', [PerfilController::class, 'edit'])
        ->name('perfil.edit');

    Route::post('perfil/foto', [PerfilController::class, 'updateFoto'])
        ->name('perfil.foto.update');

    Route::middleware(['role:porteiro|recepcionista'])->group(function () {
        Route::get('minha-escala', [MinhaEscalaController::class, 'index'])
            ->name('minha-escala');

        Route::get('minha-escala/{alocacao}/ausencia', [AvisoAusenciaController::class, 'create'])
            ->name('ausencia.create');

        Route::post('minha-escala/{alocacao}/ausencia', [AvisoAusenciaController::class, 'store'])
            ->name('ausencia.store');
    });

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('ausencias', [AusenciaController::class, 'index'])
            ->name('ausencias.index');

        Route::get('ausencias/{aviso}', [AusenciaController::class, 'show'])
            ->name('ausencias.show');

        Route::post('ausencias/{aviso}/alocar', [AusenciaController::class, 'alocar'])
            ->name('ausencias.alocar');

        Route::post('ausencias/{aviso}/rejeitar', [AusenciaController::class, 'rejeitar'])
            ->name('ausencias.rejeitar');

        Route::get('escalas', [EscalaController::class, 'index'])
            ->name('escalas.index');

        // --- ROTAS DE GERENCIAMENTO DE USUÁRIOS (ADICIONADAS AQUI) ---
        Route::get('usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
        Route::post('usuarios', [UserController::class, 'store'])->name('usuarios.store');
        Route::get('usuarios/{user}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
        Route::put('usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
        Route::patch('usuarios/{user}/toggle', [UserController::class, 'toggle'])->name('usuarios.toggle');
        // -------------------------------------------------------------

        // Admin troca a foto de qualquer usuário
        Route::post('usuarios/{user}/foto', [PerfilController::class, 'updateFotoAdmin'])
            ->name('usuarios.foto.update');
    });
});