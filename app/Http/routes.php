<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	$notes = Storage::disk('local')->get('my-apps/notes/notes.txt');
	return View::make('my-apps.note')->with('notes', $notes);
});
Route::post('/save', function (Request $request) {
	$notes = $request->input('notes');
	Storage::disk('local')->put('my-apps/notes/notes.txt', $notes);
	return response()->json(['success' => true], 200);
});