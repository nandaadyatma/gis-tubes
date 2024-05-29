<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (!session()->has('token')){
        return redirect()->route('login');
    }

    return view('home',[
        "title" => "Home",
        "name" => ""
    ]);
})->name('home');

Route::get('/laravel', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about',[
        "title" => "About",
        "name" => "Nanda Arya",
    ]);
});


Route::get('/posts', function () {
    return view('posts', [
        "title" => "Posts",
    ]);
});


Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('login', [AuthController::class, 'login']);

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');

Route::post('register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/createNewRoad', [RoadController::class, 'createNewRoad'])->name('createNewRoad');

// Route::get('/detail', [RoadController::class, 'detail'])->name('detail');

Route::get('/detail', function () {
    return view('about', [
        "title" => "Detail",
    ]);
});


Route::get('/test', function () {
    return view('test',[
        "title" => "About",
        "name" => "Nanda Arya",
    ]);
});

