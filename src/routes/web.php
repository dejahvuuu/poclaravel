<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropboxController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/dropbox/upload', [DropboxController::class, 'upload']);
Route::get('/dropbox/download', [DropboxController::class, 'download']);
Route::get('/dropbox/list-tree', [DropboxController::class, 'listTree']);
Route::get('/dropbox/count-files', [DropboxController::class, 'countFiles']);
Route::get('/dropbox/debug-list', [DropboxController::class, 'debugListContents']);

