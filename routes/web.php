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
//
//Route::get('/coisa', function () {
//    return view('teste');
//});

Auth::routes();

Route::get('/getdatatables', 'HomeController@getDataDatatables')->name('datatables.data');;
Route::get('/', 'HomeController@home')->name('home');
Route::get('/home', 'HomeController@home')->name('home');
Route::get('/cadastrar-usuario','HomeController@cadastrarUser');
Route::post('/registrar-usuario','UserController@store');

Route::get('/listar-usuarios','HomeController@listarUsers');
Route::get('/detalhes-usuario/{id}','UserController@show')->name('detalhes.usuario');
Route::delete('/excluir-usuario/{id}','UserController@destroy')->name('excluir.usuario');
Route::post('/atualizar-usuario/{id}','UserController@update')->name('atualizar.usuario');

Route::get('/adicionar-consultor','ConsultorController@create');
Route::post('/registrar-consultor','ConsultorController@salvarconsultor')->name('registrar.consultor');
Route::get('/detalhes-consultor/{id}','ConsultorController@show')->name('detalhes.consultor');
Route::post('/atualizar-consultor/{id}','ConsultorController@update')->name('atualizar.consultor');
Route::delete('/excluir-consultor/{id}','ConsultorController@destroy')->name('excluir.consultor');

Route::get('/gerenciar-gestores','GestorController@home');
Route::post('/registrar-gestor','GestorController@salvargestor')->name('registrar.gestor');
Route::get('/detalhes-gestor/{id}','GestorController@show')->name('detalhes.gestor');
Route::post('/atualizar-gestor/{id}','GestorController@update')->name('atualizar.gestor');

Route::get('/atividades','AtividadesController@index')->name('home.atividade');
Route::post('/registrar-atividade','AtividadesController@salvarAtividade')->name('registrar.atividade');
Route::get('/detalhes-atividade/{id}','AtividadesController@show')->name('detalhes.atividade');
Route::post('/atualizar-atividade/{id}','AtividadesController@update')->name('atualizar.atividade');
Route::delete('/excluir-atividade/{id}','AtividadesController@destroy')->name('excluir.atividade');

Route::get('/clientes','ClienteController@index')->name('home.atividade');
Route::post('/registrar-cliente','ClienteController@salvarCliente')->name('registrar.cliente');
Route::get('/detalhes-cliente/{id}','ClienteController@show')->name('detalhes.cliente');
Route::post('/atualizar-cliente/{id}','ClienteController@update')->name('atualizar.cliente');

Route::get('/projetos','ProjetoController@index')->name('home.projeto');
Route::post('/registrar-projeto','ProjetoController@salvarProjeto')->name('registrar.projeto');
Route::get('/detalhes-projeto/{id}','ProjetoController@show')->name('detalhes.projeto');
Route::post('/atualizar-projeto/{id}','ProjetoController@update')->name('atualizar.projeto');
Route::delete('/excluir-projeto/{id}','ProjetoController@destroy')->name('excluir.projeto');

Route::get('/planos','PlanoController@index')->name('home.plano');
Route::post('/registrar-plano','PlanoController@salvarPlano')->name('registrar.plano');
Route::get('/detalhes-plano/{id}','PlanoController@Atividades')->name('home.plano.detalhes');
Route::post('/registrar-tarifa/{id}','PlanoController@defineTarifa')->name('home.plano.tarifa');
Route::post('/registrar-atividade/{id}','PlanoController@adicionarAtividade')->name('add.plano.tarifa');
Route::delete('/excluir-atividade/{id}','PlanoController@destroyAtividade')->name('excluir.atividade');


Route::post('/registrar-envolvido','planoEnvolvidosController@addUserEnvolvido')->name('registrar.Envolvido');
Route::get('/editar-atividade/{id}','planoEnvolvidosController@getDetPlanDetail')->name('registrar.Envolvido');
Route::post('/excluir-envolvido','planoEnvolvidosController@deleteEnvolvido')->name('/excluir.envolvido');


// chamar view orçamento
Route::get('/orcamento/{id}','OrcamentoController@show')->name('home.orcamentos');
Route::get('/orcamento-pesquisa','OrcamentoController@index')->name('home.orcamento');
Route::post('/Registrar-orcamento','OrcamentoController@criaorc')->name('home.orcamentocria');




Route::get('/escopo-orcamento','orcamentoescopoController@index')->name('home.escopo');
Route::post('/Registrar-escopo','orcamentoescopoController@salvar')->name('registrar.escopo');
Route::post('/tras-escopo','orcamentoescopoController@trasItem')->name('tras.escopo');

Route::post('/Edita-escopo','orcamentoescopoController@edita')->name('edita.escopo');
Route::post('/Deleta-escopo','orcamentoescopoController@deleta')->name('deleta.escopo');
//home detalhe do orcamento
Route::get('/orcamento-detalhe/{id}','OrcamentoDetalheController@index')->name('home.detalhe.orcamento');
Route::post('/orcamento-detalhe','OrcamentoDetalheController@salvar')->name('salvar.detalhe.orcamento');


Route::get('/registro-horas','RegistroHorasController@index')->name('home.horas');
Route::post('/registro-horas','RegistroHorasController@salvar')->name('salvar.horas');
Route::post('/orcamento-detalhe-final','orcamentoescopoController@salvarFinal')->name('registrar.escopo.final');