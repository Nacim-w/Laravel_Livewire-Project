<?php


use App\Http\Livewire\Role\RoleIndex;
use App\Http\Livewire\Users\UserIndex;
use App\Http\Livewire\Chauffeur\ChauffeurIndex;
use App\Http\Livewire\Vehicule\VehiculeIndex;
use App\Http\Livewire\Route\RouteIndex;
use App\Http\Livewire\Employee\EmployeeIndex;



use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::middleware(['auth:sanctum', 'verified','acc'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/users', UserIndex::class)->name('users.index');
    Route::get('/roles', RoleIndex::class)->name('roles.index');
    Route::get('/chauffeurs', ChauffeurIndex::class)->name('chauffeurs.index');
    Route::get('/vehicules', VehiculeIndex::class)->name('vehicules.index');
    Route::get('/routes', RouteIndex::class)->name('routes.index');
    Route::get('/employees', EmployeeIndex::class)->name('employees.index');





});
