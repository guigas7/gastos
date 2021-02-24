<?php

use Illuminate\Support\Facades\Route;

// ----- x ------ ---- ----- x ----- \\
// ----- x ------ Auth ----- x ----- \\
// ----- x ------ ---- ----- x ----- \\

Auth::routes(['register' => false]);
//Auth::routes();

Route::post('/month', 'HomeController@month')->name('home.month');

// ----- x ------ ------- ----- x ----- \\
// ----- x ------ Records ----- x ----- \\
// ----- x ------ ------- ----- x ----- \\

// Atualizar o valor de {record}
Route::put('/valores/{record}',                'RecordController@update')  ->name('record.update');
// Apagar {record}
Route::delete('/valores/{record}',             'RecordController@destroy') ->name('record.destroy');

// ----- x ------ ----------------- ----- x ----- \\
// ----- x ------ Tipos de Despesas ----- x ----- \\
// ----- x ------ ----------------- ----- x ----- \\


// Inserir um novo registro em {ExpenseType}
Route::post('/despesas/{expenseType}',         		'ExpenseTypeController@record') ->name('expense.record');
// Formulário de edição do tipo de despesa {expenseType}
Route::get('/despesas/{expenseType}/editar',        'ExpenseTypeController@edit')   ->name('expense.edit');
// Atualizar o tipo de despesa {expense}
Route::put('/despesas/{expenseType}',               'ExpenseTypeController@update') ->name('expense.update');
// Deletar o tipo de despesa {expense}
Route::delete('/despesas/{expenseType}',            'ExpenseTypeController@destroy')->name('expense.delete');

// Retorna imagem do comprovante do pagamento $payment
Route::get('/pagamentos/{source}/{expenseType}/{payment}',      'PaymentController@show')   ->name('payment.show');
// Inserir imagens de comprovantes no pagamento de id = {paymentId}
Route::post('/pagamentos/{expenseType}',                        'PaymentController@store')  ->name('payment.store');
// Delete $payment and it's file, if it has one
Route::delete('/pagamentos/{source}/{expenseType}/{payment}',   'PaymentController@destroy') ->name('payment.destroy');


// ----- x ------ ----------------- ----- x ----- \\
// ----- x ------ Tipos de Receitas ----- x ----- \\
// ----- x ------ ----------------- ----- x ----- \\

// Inserir um novo registro em {ExpenseType}
Route::post('/receitas/{incomeType}',          		'IncomeTypeController@record') ->name('expense.record');
// Formulário de edição do tipo de receira {incomeType}
Route::get('/receitas/{incomeType}/editar',         'IncomeTypeController@edit')   ->name('income.edit');
// Atualizar o tipo de receita {income}
Route::put('/receitas/{incomeType}',                'IncomeTypeController@update') ->name('income.update');
// Deletar o tipo de receita {income}
Route::delete('/receitas/{incomeType}',             'IncomeTypeController@destroy')->name('income.delete');

// ----- x ------ ------------------ ----- x ----- \\
// ----- x ------ Grupos de Despesas ----- x ----- \\
// ----- x ------ ------------------ ----- x ----- \\

// Remover a despesa extype do grupo exgroup
Route::delete('/grupo/despesa/{expenseType}',	'ExgroupTypeController@destroy')	->name('exgroupType.delete');
// Atualizar o grupo
Route::put('/grupo/{expenseGroup}',     		'ExpenseGroupController@update') 	->name('exgroup.update');
// Apagar o grupo
Route::delete('/grupo/{expenseGroup}',    		'ExpenseGroupController@destroy')	->name('exgroup.delete');
// Inserir novo grupo
Route::post('/grupo/{source}/criar',          	'ExpenseGroupController@store')  	->name('exgroup.store');

// ----- x ------ -------- ----- x ----- \\
// ----- x ------ Gráficos ----- x ----- \\
// ----- x ------ -------- ----- x ----- \\



// ----- x ------ ------------------------------ ----- x ----- \\
// ----- x ------ Centros de Despesas e Receitas ----- x ----- \\
// ----- x ------ ------------------------------ ----- x ----- \\

// Lista de centros de despesas e receita (sources). Opções de editar, excluir, visualizar e criar
Route::get('/',                             'SourceController@index')   	->name('source.index');
// Inserir novo centro
Route::post('/criar',                       'SourceController@store')   	->name('source.store');
// Formulário de criação de novo centro
Route::get('/criar',                        'SourceController@create')  	->name('source.create');
// Formulário de edição do centro {source}
Route::get('/{source}/editar',              'SourceController@edit')    	->name('source.edit');
// Atualizar o centro {source}
Route::put('/{source}',                     'SourceController@update')  	->name('source.update');
// Ver as despesas mensais do centro {source}
Route::get('/{source}/despesas',            'SourceController@despesas')    ->name('source.despesas');
// Ver as receitas mensais (se houver) do centro {source} e opções de edição do centro
Route::get('/{source}/receitas',            'SourceController@receitas')    ->name('source.receitas');
// Apagar o centro {source}
Route::delete('/{source}',                  'SourceController@destroy') 	->name('source.delete');
// Mostra os relatórios do centro {source}
Route::get('/{source}/relatorio/geral',     'SourceController@report')  	->name('source.report');
// Lista de grupos, editar, excluir e criar novo
Route::get('/{source}/grupos',              'ExpenseGroupController@index')	->name('exgroup.index');
// Inserir novo tipo de despesa em {source}
Route::post('/{source}/despesas',           'ExpenseTypeController@store')  ->name('expense.store');
// Inserir novo tipo de receita em {source}
Route::post('{source}/receitas',            'IncomeTypeController@store')   ->name('income.store');
// Permite comparar 
Route::get('/{source}/relatorio/analise',   'SourceController@analyze')     ->name('source.analyze');

// ----- x ------ ---- ----- x ----- \\
// ----- x ------ APIs ----- x ----- \\
// ----- x ------ ---- ----- x ----- \\

// Retorna o centro {source}
Route::get('/api/{source}',                 'SourceController@source')    	        ->name('source.api');
// Retorna o centro {source}
Route::get('/api/{expenseType}',            'expenseTypeController@expenseType')    ->name('expense.api');
// Retorna o centro {source}
Route::get('/api/{expenseGroup}',           'SourceController@expenseGroup')        ->name('exgroup.api');
// Retorna o centro {source}
Route::get('/api/{source}/records',         'SourceController@records')             ->name('source.records.api');
// Retorna o centro {source}
Route::get('/api/{expenseType}/records',    'SourceController@records')             ->name('expense.records.api');
// Retorna o centro {source}
Route::get('/api/{expenseGroup}/records',   'SourceController@records')             ->name('exgroup.records.api');
