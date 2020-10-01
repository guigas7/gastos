<?php

use Illuminate\Support\Facades\Route;

// ----- x ------ ---- ----- x ----- \\
// ----- x ------ Auth ----- x ----- \\
// ----- x ------ ---- ----- x ----- \\

Auth::routes(['register' => false]);

Route::post('/month', 'HomeController@month')->name('home.month');

// ----- x ------ ------------------------------ ----- x ----- \\
// ----- x ------ Centros de Despesas e Receitas ----- x ----- \\
// ----- x ------ ------------------------------ ----- x ----- \\

// Lista de centros de despesas e receita (sources). Opções de editar, excluir, visualizar e criar
Route::get('/',                         'SourceController@index')   ->name('source.index');
// Inserir novo centro
Route::post('/criar',                   'SourceController@store')   ->name('source.store');
// Formulário de criação de novo centro
Route::get('/criar',                    'SourceController@create')  ->name('source.create');
// Formulário de edição do centro {source}
Route::get('/{source}/editar',          'SourceController@edit')    ->name('source.edit');
// Atualizar o centro {source}
Route::put('/{source}',                 'SourceController@update')  ->name('source.update');
// Ver as despesas e receitas mensais (se houver) do centro {source} no ano e mês selecionados
Route::get('/{source}',                 'SourceController@show')    ->name('source.show');
// Apagar o centro {source}
Route::delete('/{source}/',             'SourceController@destroy') ->name('source.delete');
// Mostra os relatórios do centro {source}
Route::get('/{source}/relatorios/',     'SourceController@report')  ->name('source.report');

// ----- x ------ -------------------------- ----- x ----- \\
// ----- x ------ Grupos de tipos de despesa ----- x ----- \\
// ----- x ------ -------------------------- ----- x ----- \\

// Lista de grupos, editar, excluir e criar novo
Route::get('/{source}/grupos',          'ExgroupController@index')  ->name('exgroup.index');
// Inserir novo grupo
Route::post('/{source}/criar',          'ExgroupController@store')  ->name('exgroup.store');
// Formulário de edição de grupo
Route::get('/{source}/{exgroup}/editar','ExgroupController@edit')   ->name('exgroup.edit');
// Atualizar o grupo
Route::put('/{source}/{exgroup}',       'ExgroupController@update') ->name('exgroup.update');
// Apagar o grupo
Route::delete('/{source}/{exgroup}',    'ExgroupController@destroy')->name('exgroup.delete');

// ----- x ------ ----------------- ----- x ----- \\
// ----- x ------ Tipos de Despesas ----- x ----- \\
// ----- x ------ ----------------- ----- x ----- \\

// Lista de tipos de despesas. Opções de editar, visualizar, excluir e criar
// Route::get('/despesas/', 							'ExtypeController@index')	->name('expense.index');
// Inserir novo tipo de despesa
Route::post('/despesas/criar', 					'ExtypeController@store')	->name('expense.store');
// // Formuláio de criação de novo tipo de despesa
// Route::get('/despesas/criar', 					'ExtypeController@create')	->name('expense.create');
// // Formuláio de edição do tipo de despesa {expense}
// Route::get('/despesas/{expense}/editar', 			'ExtypeController@edit')	->name('expense.edit');
// Atualizar o tipo de despesa {expense}
Route::put('/despesas/{expense}/', 				'ExtypeController@update')	->name('expense.update');
// // Ver o valor mensal da despesa {expense}, no ano {year}, no mês {month}, para todos os centros de despesa
// Route::get('/despesas/{expense}/{year}/{month}', 	'ExtypeController@show')	->name('expense.show');
// // Apagar o centro {expense}
// Route::delete('/despesas/{expense}/', 			'ExtypeController@destroy')->name('expense.delete');

// ----- x ------ ----------------- ----- x ----- \\
// ----- x ------ Tipos de Receitas ----- x ----- \\
// ----- x ------ ----------------- ----- x ----- \\

// // Lista de tipos de receitas. Opções de editar, visualizar, excluir e criar
// Route::get('/receitas/', 							'IntypeController@index')	->name('income.index');
// Inserir novo tipo de receita
Route::post('/receitas/criar', 					'IntypeController@store')	->name('income.store');
// // Formuláio de criação de novo tipo de receita
// Route::get('/receitas/criar', 					'IntypeController@create')	->name('income.create');
// // Formuláio de edição do tipo de receita {expense}
// Route::get('/receitas/{expense}/editar', 			'IntypeController@edit')	->name('income.edit');
// Atualizar o tipo de receita {expense}
Route::put('/receitas/{expense}/', 				'IntypeController@update')	->name('income.update');
// // Ver o valor mensal da receita {expense}, no ano {year}, no mês {month}, para todos os centros de receita
// Route::get('/receitas/{expense}/{year}/{month}', 	'IntypeController@show')	->name('income.show');
// // Apagar o centro {expense}
// Route::delete('/receitas/{expense}/', 			'IntypeController@destroy')->name('income.delete');

// ----- x ------ ---------- ----- x ----- \\
// ----- x ------ Relatórios ----- x ----- \\
// ----- x ------ ---------- ----- x ----- \\

// Todos

/*Route::get('/despesa/criar', function(){
    $sr = DB::table('sources')->get();
    $ed = DB::table('extype_source')->get();
    $me = DB::table('extypes')->get();
    return view('criar', compact('sr','ed', 'me'));
});

Route::get('/despesa/{pagina}', function($abr){
    $pagina = $abr;
    $sr = DB::table('sources')->get();
    $ed = DB::table('extype_source')->get();
    $me = DB::table('extypes')->get();
    return view('despesa/centros', compact('pagina','sr','ed', 'me'));
});

Route::get('/despesa/{pagina}/{esp}', function($abr, $rba){
    $pagina = $abr;
    $esp = $rba;
    $sr = DB::table('sources')->get();
    $ed = DB::table('extype_source')->get();
    $me = DB::table('extypes')->get();
    return view('despesa/especifica', compact('pagina','rba','sr','ed', 'me', 'esp'));
});

Route::get('/despesa/{pagina}/criar', function($abr){
    $pagina = $abr;
    $sr = DB::table('sources')->get();
    $ed = DB::table('extype_source')->get();
    $me = DB::table('extypes')->get();
    return view('despesa/criar', compact('pagina','sr','ed', 'me'));
});

Route::get('/despesa/{pagina}/{esp}/editar', function($abr, $rba){
    $pagina = $abr;
    $esp = $rba;
    $sr = DB::table('sources')->get();
    $ed = DB::table('extype_source')->get();
    $me = DB::table('extypes')->get();
    return view('despesa/editar', compact('pagina','rba','sr','ed', 'me', 'esp'));
});

Route::get('/receita/{pagina}', function($abr){
    $pagina = $abr;
    $sr = DB::table('sources')->get();
    $ed = DB::table('intype_source')->get();
    $me = DB::table('intypes')->get();
    return view('receita/centros', compact('pagina','sr','ed', 'me'));
});

Route::get('/receita/{pagina}/{esp}', function($abr, $rba){
    $pagina = $abr;
    $esp = $rba;
    $sr = DB::table('sources')->get();
    $ed = DB::table('intype_source')->get();
    $me = DB::table('intypes')->get();
    return view('receita/especifica', compact('pagina','rba','sr','ed', 'me', 'esp'));
});

Route::get('/receitas/{pagina}/criar', function($abr){
    $pagina = $abr;
    $sr = DB::table('sources')->get();
    $ed = DB::table('intype_source')->get();
    $me = DB::table('intypes')->get();
    return view('receita/criar', compact('pagina','rba','sr','ed', 'me'));
});

Route::get('/receitas/{pagina}/{esp}/editar', function($abr, $rba){
    $pagina = $abr;
    $esp = $rba;
    $sr = DB::table('sources')->get();
    $ed = DB::table('intype_source')->get();
    $me = DB::table('intypes')->get();
    return view('receita/editar', compact('pagina','rba','sr','ed', 'me', 'esp'));
});*/