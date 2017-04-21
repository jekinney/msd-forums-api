<?php
use App\Attachment;
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

Route::get('download/{name}',function() use($name) {
	$file = Attachment::where('name', $name)->first();
    Response::download($file->full_path, $file->name);
});
