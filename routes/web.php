<?php

use App\Http\Controllers\PhotosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumsController;


Route::get('/', [AlbumsController::class, "index"]);
Route::get('/albums', [AlbumsController::class, "index"])->name("albums.index");
Route::get('/albums/create', [AlbumsController::class, "create"]);
Route::post('/albums/store', [AlbumsController::class, "store"])->name("albums.store");
Route::get('/albums/{id}', [AlbumsController::class, "show"]);
Route::get('/albums/{album}/edit', [AlbumsController::class, "edit"])->name("albums.edit");
Route::put('/albums/{album}', [AlbumsController::class, "update"])->name("albums.update");
Route::get('/albums/{album}/delete', [AlbumsController::class, 'showDeleteConfirmation'])->name('albums.delete.confirmation');
Route::delete('/albums/{album}/delete', [AlbumsController::class, 'deleteConfirmed'])->name('albums.delete.confirmed');

Route::get('/photos/create/{album_id}', [PhotosController::class, 'create'])->name('photo.Create');
Route::post('/photos/store', [PhotosController::class, 'store'])->name("photos.store");
Route::get('/photos/{id}', [PhotosController::class, 'show']);
Route::delete('/photos/{id}', [PhotosController::class, 'destroy'])->name("photos.destroy");