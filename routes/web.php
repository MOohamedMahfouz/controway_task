<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Symfony\Component\CssSelector\Node\FunctionNode;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// require 'vendor/autoload.php';
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



Route::get('/',function() {
    return view('welcome');
});
// Route::post('/show-excel-file',function() {
//     return view('show_excel',[
//         'data' => []
//     ]);
// });


// Route::get('/show-excel-file/{fileName}', [ExcelController::class, 'showExcelFile'])->name('show-excel-file');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/import-products-mapping', [ProductController::class, 'importProductsWithMapping']);
    Route::post('/import-products', [ProductController::class, 'importProductsWithoutMapping']);
    Route::get('/map-excel', function(){
        return view('show_excel');
    })->name('map-excel');
});
require __DIR__.'/auth.php';



// admins routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [AdminController::class,'index'])->name('pending-users');
    Route::get('/accept-user/{id}',[AdminController::class,'approve'])->name('accept-user');
    Route::get('/delete-user/{id}',[AdminController::class,'delete'])->name('delete-user');
});





