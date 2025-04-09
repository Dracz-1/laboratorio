<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
        })->name('dashboard');
    });


    Route::middleware(['auth'])->group(function () {
        Route::get('/sala', function () {
            if (Auth::id() == 3) return redirect()->route('dashboard');
            return view('sala');
        })->name('sala');
    
        Route::get('/equipamento', function () {
            if (Auth::id() == 3) return redirect()->route('dashboard');
            return view('crudequipamentos');
        })->name('crudequipamentos');
    
        Route::get('/responsaveis', function () {
            if (Auth::id() == 3) return redirect()->route('dashboard');
            return view('responsavel');
        })->name('crudresponsavel');
    
        Route::get('/edit_users', function () {
            if (Auth::id() == 3) return redirect()->route('dashboard');
            return view('user');
        })->name('cruduser');
    });
    


Route::middleware(['auth'])->group(function () {

    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/processar-imagens', function () {
    $output = null;
    $resultCode = null;

    // Caminho para o script Python
    $pythonScript = base_path('blobToImg.py');
    $command = "python $pythonScript"; // ou apenas python se for o caso

    // Executa o comando e captura a saída
    exec($command, $output, $resultCode);

    // Verifica se o script foi executado com sucesso
    if ($resultCode === 0) {
        return response()->json([
            'status' => 'sucesso',
            'mensagem' => 'Imagens processadas e base de dados atualizada.',
            'output' => $output
        ]);
    } else {
        return response()->json([
            'status' => 'erro',
            'mensagem' => 'Erro ao processar as imagens.',
            'output' => $output
        ]);
    }
});

require __DIR__.'/auth.php';
