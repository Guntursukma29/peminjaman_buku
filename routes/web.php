<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\BorrowingController;

Auth::routes();

// Route::get('/', function () {
//     return view('admin.index');
// })->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('books', BookController::class)->only(['index', 'store', 'update','destroy']);
Route::resource('members', MemberController::class);

Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');  // List all borrowings
Route::get('borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');  // Show form to create a new borrowing
Route::post('borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');  // Store a new borrowing
Route::get('borrowings/{borrowing}/edit', [BorrowingController::class, 'edit'])->name('borrowings.edit');  // Show form to edit a borrowing
Route::put('borrowings/{borrowing}', [BorrowingController::class, 'update'])->name('borrowings.update');  // Update a borrowing
Route::delete('borrowings/{borrowing}', [BorrowingController::class, 'destroy'])->name('borrowings.destroy');  // Delete a borrowing
Route::put('/borrowings/{id}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');