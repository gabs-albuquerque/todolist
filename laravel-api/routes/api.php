<?php

use Illuminate\Support\Facades\Route;

Route::get('tarefas', 'TarefaController@index');
Route::post('tarefas', 'TarefaController@store');
Route::put('tarefas/{id}', 'TarefaController@update');
Route::delete('tarefas/{id}', 'TarefaController@destroy');
