<?php

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

Route::post('/hola-mundo', function() {
	return 'hola-mundo!! soy erick';
});

/*
Route::get('contacto/{nombre?}/{edad?}', function($nombre = "Erick", $edad=45) {
	return view('contacto', array(
		"nombre" => $nombre,
		"edad" 	 => $edad
	));
})-> where([
	"nombre" => '[A-Za-z]+',
	"edad"	=> '[0-9]+'
]);
*/

Route::get('contacto/{nombre?}/{edad?}', function($nombre = "Erick", $edad=45){

	return view('contacto.contacto')
					->with('nombre',$nombre)
					->with('edad',$edad);
})-> where([
	"nombre" => '[A-Za-z]+',
	"edad"	=> '[0-9]+'
]);

