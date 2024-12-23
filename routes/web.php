<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', 'ImovelMapController@index');

Auth::routes();

Route::get('/todos_imoveis', 'ImovelMapController@index')->name('mapa');

Route::get('/todos_imoveis', 'ImovelMapController@index')->name('imovel_map.index');

Route::put('imoveis/{id}', 'ImovelController@update')->name('imoveis.update');
Route::get('/imoveis/cpf/{cpf}', 'ImovelController@searchByCpf')->name('imoveis.searchByCpf');

Route::resource('imoveis', 'ImovelController');


