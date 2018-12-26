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

Route::get('/atividades','TipoAtividadesController@index')->name('home.atividade');
Route::post('/registrar-atividade','TipoAtividadesController@salvarAtividade')->name('registrar.atividade');
Route::get('/detalhes-atividade/{id}','TipoAtividadesController@show')->name('detalhes.atividade');
Route::post('/atualizar-atividade/{id}','TipoAtividadesController@update')->name('atualizar.atividade');
Route::delete('/excluir-atividade/{id}','TipoAtividadesController@destroy')->name('excluir.atividade');
Route::get('/grupo-atividades','TipoAtividadesController@grupoAtividade')->name('grupo.atividade');
Route::get('/grupo-atividades','TipoAtividadesController@grupoAtividade')->name('grupo.atividade');
Route::POST('/grupo-adicionar','TipoAtividadesController@grupoAdicionar')->name('registrar.atividade.grupo');
Route::get('/detalhes-grupo/{id}','TipoAtividadesController@detalhesGrupo')->name('detalhes.grupo');
Route::post('/atualizar-grupo-nome','TipoAtividadesController@atualizarBlocoTipo')->name('atualizar.grupo');
Route::delete('/excluir-grupo/{id}','TipoAtividadesController@deletarGrupo')->name('deletar.grupo');
Route::get('/gerenciar-grupo/{id}','TipoAtividadesController@adicionarTiposaoGrupo')->name('adicionar.tipos.grupo');
Route::post('/adicionar-tipodetalhe-grupo','TipoAtividadesController@adicionarAtividadeaoGrupo');



//orçamento-escopo

Route::get('/escopo-orcamento','OrcamentoController@index')->name('home.orcamento.escopo');
Route::get('/excluir-escopo/{id}','OrcamentoController@removerEscopo')->name('home.orcamento.escopo');

Route::post('/criar-escopo-orcamento','OrcamentoController@adicionarOrcamentoEscopo')->name('criar.orcamento.escopo');
Route::get('/configurar-orcamento/{id}','OrcamentoController@homeEditarOrcamento')->name('detalhes.orcamento.escopo');
Route::post('/adicionar-atividade-orcamento','OrcamentoController@adicionarAtividadeEscopoOrcamento')->name('adicionar.atividade.escopo');


Route::post('/adicionar-grupo-atividades-bloco','OrcamentoController@adicionarBlocoEscopo');

Route::post('/atualizar-atividade-orcamento/{id}','OrcamentoController@atualizarAtividadeEscopoOrcamento')->name('atualizar.atividade.escopo');
Route::post('/atualizar-orcamento-escopo/{id}','OrcamentoController@atualizarOrcamentoEscopo')->name('atualizar.atividade.escopo');

Route::delete('/excluir-detalhe-orcamento/{id}','OrcamentoController@RemoverAtividadeEscopoOrcamento')->name('remover.atividade.escopo');
Route::post('/criar-projeto/{id}','ProjetoController@criarProjeto')->name('criar.projeto');

Route::get('/projetos','ProjetoController@index')->name('home.projetos');

//Projeto Detalhe
Route::get('/detalhe-projeto/{id}','ProjetoController@projetoDetalhes')->name('home.projetos');

Route::post('/atualiza-projeto-header/{id}','ProjetoController@atualizarProjetoHeader')->name('atualizar.projeto.header');
Route::post('/adicionar-atividade-projeto-detalhe','ProjetoController@adicionarAtividadeProjetoDetalhe')->name('atualizar.projeto.header');
Route::post('/definir-responsavel','ProjetoController@atribuirUserAtividade')->name('definir.proprietario-projeto.detalhe');
Route::delete('/excluir-detalhe-projeto/{id}','ProjetoController@removerProjetoDetalhe')->name('remover.projeto.detalhe');
Route::put('/atualizar-detalhe-projeto','ProjetoController@atualizarProjetoDetalhe')->name('remover.projeto.detalhe');





//Fotos

Route::get('/fotos-projeto/{id}','FotosController@index')->name('home.fotos');
Route::post('/criar-foto/{id}','FotosController@Create')->name('create.fotos');
Route::post('/detalhes-foto/{id}','FotosController@DetalhesFoto')->name('detalhes.fotos');




// chamar view orçamento
Route::get('/orcamento/{id}','OrcamentoController@show')->name('home.orcamentos');
Route::get('/orcamento-pesquisa','OrcamentoController@index')->name('home.orcamento');
Route::post('/Registrar-orcamento','OrcamentoController@criaorc')->name('home.orcamentocria');

//metodo que adiciona um novo cliente
Route::post('/Registrar-cliente','OrcamentoController@criacli')->name('cadastrar.cliente');
//indexcliente
Route::get('/cliente','OrcamentoController@indexCli')->name('home.cliente');
Route::post('/cliente-edit','OrcamentoController@editcli')->name('edit.cliente');




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



Route::post('/aux','RegistroHorasController@horafim')->name('registrar.horasf');
//Registros de horas por atividade
Route::get('/horas/{id}','RegistroHorasController@resHorasDet')->name('detalhe.hora');
Route::post('/horas-excluir/{id}','RegistroHorasController@delDet')->name('excluir.horas');
Route::post('/horas-alterar','RegistroHorasController@alterRegistro')->name('alterar.horas');
Route::post('/pegar-horas-fim/{id}','RegistroHorasController@horasfim')->name('pegar.fim.horas');


//chamar view que mostra todas os registros de hora
Route::get('/todos-registros','RegistroHorasController@todosRegistros')->name('todos.registros');