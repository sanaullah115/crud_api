<?php

use App\Http\Controllers\ModalUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/create', function () {
    return view('create');
});


Route::get('/edit', function () {
    return view('edit');
});



//route ModalUserController kly hy practic

//ye modal ka kam hy practics ki hy 
Route::get('/create-modalwith-form', function () {
    $users = \App\Models\User::all();
    return view('create-modalwith-form', compact('users'));
});
Route::post('/users/store', [ModalUserController::class, 'store'])->name('users.store');
Route::put('/users/{id}', [ModalUserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [ModalUserController::class, 'destroy'])->name('users.destroy');

Route::post('/storeuser', [ModalUserController::class, 'storeuser'])->name('storeuser');
//ye modal ka kam hy practics ki hy 

