<?php

use Illuminate\Support\Facades\Route;

// ----- x ------ -------------------- ----- x ----- \\
// ----- x ------ Resumo de relatórios ----- x ----- \\
// ----- x ------ -------------------- ----- x ----- \\

Route::get('/home', 'HomeController@index');
// ----- x ------ ---- ----- x ----- \\
// ----- x ------ Auth ----- x ----- \\
// ----- x ------ ---- ----- x ----- \\
Auth::routes(['register' => false]);
Route::get('/', 'HomeController@index');
Route::get('/despesa', 'HomeController@despesa');
Route::get('/receita', 'HomeController@receita');
// ----- x ------ ------------------------------ ----- x ----- \\
// ----- x ------ Centros de Despesas e Receitas ----- x ----- \\
// ----- x ------ ------------------------------ ----- x ----- \\

// Lista de centros de despesas e receita (sources). Opções de editar, excluir, visualizar e criar
Route::get('/centros', 							'SourcesController@index')	->name('sources.index');
// Inserir novo centro
Route::post('/centros/criar', 					'SourcesController@store')	->name('sources.store');
// Formuláio de criação de novo centro
Route::get('/centros/criar', 					'SourcesController@create')	->name('sources.create');
// Formuláio de edição do centro {source}
Route::get('/centros/{source}/editar', 			'SourcesController@edit')	->name('sources.edit');
// Atualizar o centro {source}
Route::put('/centros/{source}/', 				'SourcesController@update')	->name('sources.update');
// Ver as despesas e receitas mensais (se houver) do centro {source}, no ano {year}, no mês {month}
Route::get('/centros/{source}/{year}/{month}', 	'SourcesController@show')	->name('sources.show');
// Apagar o centro {source}
Route::delete('/centros/{source}/', 			'SourcesController@destroy')->name('sources.delete');

// ----- x ------ ----------------- ----- x ----- \\
// ----- x ------ Tipos de Despesas ----- x ----- \\
// ----- x ------ ----------------- ----- x ----- \\

// Lista de tipos de despesas. Opções de editar, visualizar, excluir e criar
Route::get('/despesas/', 							'ExpensesController@index')	->name('expenses.index');
// Inserir novo tipo de despesa
Route::post('/despesas/criar', 					'ExpensesController@store')	->name('expenses.store');
// Formuláio de criação de novo tipo de despesa
Route::get('/despesas/criar', 					'ExpensesController@create')	->name('expenses.create');
// Formuláio de edição do tipo de despesa {expense}
Route::get('/despesas/{expense}/editar', 			'ExpensesController@edit')	->name('expenses.edit');
// Atualizar o tipo de despesa {expense}
Route::put('/despesas/{expense}/', 				'ExpensesController@update')	->name('expenses.update');
// Ver o valor mensal da despesa {expense}, no ano {year}, no mês {month}, para todos os centros de despesa
Route::get('/despesas/{expense}/{year}/{month}', 	'ExpensesController@show')	->name('expenses.show');
// Apagar o centro {expense}
Route::delete('/despesas/{expense}/', 			'ExpensesController@destroy')->name('expenses.delete');

// ----- x ------ ----------------- ----- x ----- \\
// ----- x ------ Tipos de Receitas ----- x ----- \\
// ----- x ------ ----------------- ----- x ----- \\

// Lista de tipos de receitas. Opções de editar, visualizar, excluir e criar
Route::get('/receitas/', 							'IncomesController@index')	->name('incomes.index');
// Inserir novo tipo de receita
Route::post('/receitas/criar', 					'IncomesController@store')	->name('incomes.store');
// Formuláio de criação de novo tipo de receita
Route::get('/receitas/criar', 					'IncomesController@create')	->name('incomes.create');
// Formuláio de edição do tipo de receita {expense}
Route::get('/receitas/{expense}/editar', 			'IncomesController@edit')	->name('incomes.edit');
// Atualizar o tipo de receita {expense}
Route::put('/receitas/{expense}/', 				'IncomesController@update')	->name('incomes.update');
// Ver o valor mensal da receita {expense}, no ano {year}, no mês {month}, para todos os centros de receita
Route::get('/receitas/{expense}/{year}/{month}', 	'IncomesController@show')	->name('incomes.show');
// Apagar o centro {expense}
Route::delete('/receitas/{expense}/', 			'IncomesController@destroy')->name('incomes.delete');

// ----- x ------ ---------- ----- x ----- \\
// ----- x ------ Relatórios ----- x ----- \\
// ----- x ------ ---------- ----- x ----- \\

// Todos