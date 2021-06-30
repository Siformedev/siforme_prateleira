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

use Illuminate\Support\Facades\Auth;


Route::group(['prefix'=>'/','middleware' => 'web'], function (){
    //return redirect()->route('site.home');
    /*SITE*/
    Route::get('', ['uses' => 'SiteController@home', 'as' => 'site.home']);
    Route::get('',['uses' => 'PortalController@home', 'as' => 'home']);
    Route::post('/contato', ['uses' => 'SiteController@contato', 'as' => 'site.contato']);
    Route::get('/simulacao', ['uses' => 'SiteController@simulacao', 'as' => 'site.simulacao']);
    Route::post('/simulacao', ['uses' => 'SiteController@simulacaoStore', 'as' => 'site.simulacao.store']);

    Route::get('/autorizacao', function()
    {
        include public_path().'/auth_pseg.php';
    });

    Route::get('/retorno', function()
    {
        include public_path().'/retorno_auth_pseg.php';
    });
});



/*TESTE*/
Route::get('teste/t1', ['uses' => 'TesteController@t1', 'as' => 'teste.t1']);
Route::get('test/slack', ['uses' => 'TesteController@testSlack', 'as' => 'test.slack']);

Route::get('adesao/ncontrato', ['uses' => 'nContratoController@index', 'as' => 'adesao.ncontrato']);
Route::post('adesao/ncontrato', ['uses' => 'nContratoController@consultContract', 'as' => 'adesao.consulta']);

Route::get('adesao/contrato', ['uses' => 'adesaoController@contrato', 'as' => 'adesao.contrato']);
Route::post('adesao/vcontrato', ['uses' => 'adesaoController@validContrato', 'as' => 'adesao.validcontrato']);
Route::get('adesao/dados', ['uses' => 'adesaoController@dados', 'as' => 'adesao.dados']);
Route::post('adesao/vdados', ['uses' => 'adesaoController@validDados', 'as' => 'adesao.validdados']);

Route::get('adesao/verro', ['uses' => 'adesaoController@erroFormandoJaCadastrado', 'as' => 'adesao.formandojacadastrado']);

Route::get('adesao/confirma', ['uses' => 'adesaoController@confirma', 'as' => 'adesao.confirma']);
Route::post('adesao/vconfirma', ['uses' => 'adesaoController@validConfirma', 'as' => 'adesao.vconfirma']);
Route::get('adesao/pagamento', ['uses' => 'adesaoController@pagamento', 'as' => 'adesao.pagamento']);
Route::get('adesao/pagamento/{dia}', ['uses' => 'adesaoController@pagamento', 'as' => 'adesao.pagamento.dia']);
Route::post('adesao/vpagamento', ['uses' => 'adesaoController@validPagamento', 'as' => 'adesao.vpagamento']);
Route::get('adesao/concluido', ['uses' => 'adesaoController@concluido', 'as' => 'adesao.concluido']);

Route::group(['prefix'=>'portal','as' => 'portal.', 'middleware' => 'auth'], function (){

    Route::get('consultaAtivaBoleto',['uses'=>'PortalController@consultaAtivaBoleto']);
    Route::get('consultaTransacao/{invoice_id}',['uses'=>'PortalController@consultaTransacao']);


    Route::get('home', ['uses' => 'PortalController@home', 'as' => 'home']);
    Route::get('extrato', ['uses' => 'PortalController@extrato', 'as' => 'extrato']);
    Route::get('extrato/prod/{prod}', ['uses' => 'PortalController@extratoProduto', 'as' => 'extrato.produto']);
    Route::get('extrato/prod-pay-credit/{prod}', ['uses' => 'PortalController@extratoProdutoPayCredit', 'as' => 'extrato.produto.paycredit']);
    Route::get('extrato/payment/{prod}', ['uses' => 'PortalController@extratoProdutoPayCredit2', 'as' => 'extrato.produto.payment']);
    Route::post('extrato/prod-pay-credit-process/{prod}', ['uses' => 'PortalController@extratoProdutoPayCreditProcess', 'as' => 'extrato.produto.paycredit.process']);

    // Enquetes
    Route::get('polls', ['uses' => 'Portal\PollController@index', 'as' => 'polls.index']);
    Route::get('poll/{poll}', ['uses' => 'Portal\PollController@show', 'as' => 'poll.show']);
    Route::get('poll/{poll}/result', ['uses' => 'Portal\PollController@result', 'as' => 'poll.result']);

    Route::get('perfil', ['uses' => 'PortalController@perfil', 'as' => 'perfil']);
    Route::get('chamados', ['uses' => 'PortalController@chamados', 'as' => 'chamados']);
    Route::get('chamados/abrir', ['uses' => 'PortalController@chamadosAbrir', 'as' => 'chamados.abrir']);
    Route::post('chamados/abrir', ['uses' => 'PortalController@chamadosStore', 'as' => 'chamados.store']);
    Route::get('chamados/show/{chamado}', ['uses' => 'PortalController@chamadosShow', 'as' => 'chamados.show']);
    Route::post('chamados/show/{chamado}', ['uses' => 'PortalController@chamadosConversasStore', 'as' => 'chamados.conversas.store']);

    Route::get('informativos', ['uses' => 'PortalController@informativos', 'as' => 'informativos']);
    Route::get('informativos/show/{informativo}', ['uses' => 'PortalController@informativosShow', 'as' => 'informativos.show']);

    Route::get('comissao', ['uses' => 'PortalController@comissao', 'as' => 'comissao']);

    Route::get('comprasextras', ['uses' => 'PortalController@comprasExtras', 'as' => 'comprasextras']);
    Route::get('comprasextras/{produto}/{quantidade}/{dia_pagamento}/{tppg}', ['uses' => 'PortalController@comprasExtrasComprar', 'as' => 'comprasextras.comprar']);
    Route::post('comprasextras/store', ['uses' => 'PortalController@comprasExtrasStore', 'as' => 'comprasextras.store']);

    Route::get('gifts', ['uses' => 'PortalController@gifts', 'as' => 'gifts']);
    Route::get('giftscheckout', ['uses' => 'PortalController@giftscheckout', 'as' => 'gifts.checkout']);
    Route::get('giftdetails', ['uses' => 'PortalController@giftdetails', 'as' => 'gift.details']);
    Route::post('giftspaysession', ['uses' => 'PortalController@giftspaysession', 'as' => 'gifts.pay.session']);
    Route::get('giftspayment', ['uses' => 'PortalController@giftspayment', 'as' => 'gifts.payment']);
    Route::post('giftspaycreditprocess', ['uses' => 'PortalController@giftsPayCreditProcess', 'as' => 'gifts.payment.creditprocess']);
    Route::get('giftrequests', ['uses' => 'PortalController@giftRequests', 'as' => 'gift.requests']);
    Route::get('giftrequest/{id}', ['uses' => 'PortalController@giftRequest', 'as' => 'gift.request']);

    Route::get('albuns', ['uses' => 'PortalController@albuns', 'as' => 'albuns']);
    Route::get('albuns/{produto}/{quantidade}/{dia_pagamento}', ['uses' => 'PortalController@albunsComprar', 'as' => 'albuns.comprar']);
    Route::post('albuns/store', ['uses' => 'PortalController@albunsStore', 'as' => 'albuns.store']);

    Route::post('perfil/update', ['uses' => 'PortalController@perfilUpdate', 'as' => 'formando.update']);
    Route::get('boleto/{parcela}/{hash_pseg?}', ['uses' => 'PortalController@boleto', 'as' => 'formando.boleto']);

    Route::get('termo/pdf/{product}', ['uses' => 'PortalController@termoPdf', 'as' => 'termo.pdf']);
    //Route::get('mmvantagem', ['uses' => 'PortalController@mmvantagem', 'as' => 'mmvantagem']);

    Route::get('raffle/{raffle}', ['uses' => 'PortalController@raffle', 'as' => 'raffle']);
    Route::get('raffle-select', ['uses' => 'PortalController@raffleSelect', 'as' => 'raffle-select']);
    Route::get('raffle/number/{number}/update', ['uses' => 'PortalController@raffleNumberUpdate', 'as' => 'raffle.number.update']);
    Route::post('raffle/number/{number}/update', ['uses' => 'PortalController@raffleNumberUpStore', 'as' => 'raffle.number.upstore']);
    Route::get('raffle/number/{number}/view', ['uses' => 'PortalController@raffleNumberView', 'as' => 'raffle.number.view']);
    Route::get('raffle/number/{number}/print', ['uses' => 'PortalController@raffleNumberPrint', 'as' => 'raffle.number.print']);

    Route::get('ticket/{ticket}', ['uses' => 'PortalController@ticketSave', 'as' => 'ticket.save']);

    Route::get('photos/', ['uses' => 'Portal\UploadImageController@index', 'as' => 'photos']);
    Route::post('photos/', ['uses' => 'Portal\UploadImageController@upload', 'as' => 'photos.upload']);

    Route::get('surveys', ['uses' => 'PortalController@surveys', 'as' => 'survey.index']);
    Route::get('survey/{survey}', ['uses' => 'PortalController@surveyShow', 'as' => 'survey.show']);
    Route::post('survey/{survey}', ['uses' => 'PortalController@surveyAnswerStore', 'as' => 'survey.answer.store']);

    Route::get('identify', ['uses' => 'PortalController@identify', 'as' => 'identity']);

});

Route::get('raffle/number/{hash}', ['uses' => 'PortalController@raffleNumberHash', 'as' => 'raffle.number.hash']);

Route::group(['prefix'=>'comissao','as' => 'comissao.', 'middleware' => ['auth', 'checkcomissao']], function (){

    Route::get('painel', ['uses' => 'ComissaoController@painel', 'as' => 'painel']);

    Route::get('formandos', ['uses' => 'ComissaoController@formandos', 'as' => 'formandos']);
    Route::get('formandos/canceled', ['uses' => 'ComissaoController@formandosCanceled', 'as' => 'formandos.canceled']);
    Route::get('formandos/{forming}', ['uses' => 'ComissaoController@formandosShow', 'as' => 'formandos.show']);
    Route::get('formandos/extrato/{prod}', ['uses' => 'ComissaoController@formandosShowItem', 'as' => 'formandos.show.item']);

    Route::get('extrasales', ['uses' => 'ComissaoController@vendasExtras', 'as' => 'extrasales']);

    Route::get('orcamento', ['uses' => 'ComissaoController@orcamento', 'as' => 'orcamento']);
    Route::get('orcamento/1', ['uses' => 'ComissaoController@orcamentoItem', 'as' => 'orcamento.item']);

    Route::get('contrato', ['uses' => 'ComissaoController@contrato', 'as' => 'contrato']);
    Route::post('contrato', ['uses' => 'ComissaoController@contrato', 'as' => 'contrato']);

    Route::get('registers', ['uses' => 'ComissaoController@registers', 'as' => 'registers']);


    Route::get('chamados', ['uses' => 'ComissaoController@chamados', 'as' => 'chamados']);
    Route::get('chamados/abrir', ['uses' => 'ComissaoController@chamadosAbrir', 'as' => 'chamados.abrir']);
    Route::post('chamados/abrir', ['uses' => 'ComissaoController@chamadosStore', 'as' => 'chamados.store']);
    Route::get('chamados/show/{chamado}', ['uses' => 'ComissaoController@chamadosShow', 'as' => 'chamados.show']);
    Route::post('chamados/show/{chamado}', ['uses' => 'ComissaoController@chamadosConversasStore', 'as' => 'chamados.conversas.store']);

    Route::get('event/{event}', ['uses' => 'ComissaoController@event', 'as' => 'event']);

    Route::get('lojinha/vendas', ['uses' => 'ComissaoController@lojinhaVendas', 'as' => 'lojinha.vendas']);
    Route::get('lojinha/vendastotal', ['uses' => 'ComissaoController@lojinhaVendasTotal', 'as' => 'lojinha.vendastotal']);
    Route::get('lojinha/venda/{id}', ['uses' => 'ComissaoController@lojinhaVendaDetalhes', 'as' => 'lojinha.venda.detalhes']);
    Route::get('lojinha/venda/print/{id}', ['uses' => 'ComissaoController@lojinhaPedidoImprimir', 'as' => 'lojinha.venda.print']);
});

Route::group(['prefix'=>'gerencial','as' => 'gerencial.', 'middleware' => ['auth', 'checkcollaborator']], function (){

    

    Route::get('collaborator/create', ['uses' => 'Gerencial\CollaboratorController@create', 'as' => 'collaborator.create']);
    Route::post('collaborator/store', ['uses' => 'Gerencial\CollaboratorController@store', 'as' => 'collaborator.store']);
    Route::get('collaborator', ['uses' => 'Gerencial\CollaboratorController@index', 'as' => 'collaborator.index']);
    Route::get('collaborator/edit/{collaborator}', ['uses' => 'Gerencial\CollaboratorController@edit', 'as' => 'collaborator.edit']);
    Route::post('collaborator/update/{collaborator}', ['uses' => 'Gerencial\CollaboratorController@update', 'as' => 'collaborator.update']);

    //Formandos
    Route::get('formandos', ['uses' => 'Gerencial\FormandoAdminController@index', 'as' => 'formandos']);
    Route::get('formando/{forming}', ['uses' => 'Gerencial\FormandoAdminController@show', 'as' => 'formando.show']);
    Route::get('formando/extrato/{prod}', ['uses' => 'Gerencial\FormandoAdminController@showItem', 'as' => 'formando.show.item']);
    Route::get('formando/login/{forming}', ['uses' => 'Gerencial\FormandoAdminController@forceLogin', 'as' => 'formando.login']);



    Route::get('contratos', ['uses' => 'Gerencial\ContratoController@index', 'as' => 'contratos']);
    Route::get('contrato/create', ['uses' => 'Gerencial\ContratoController@create', 'as' => 'contrato.create']);
    Route::get('contrato/{contract}/edit', ['uses' => 'Gerencial\ContratoController@edit', 'as' => 'contrato.edit']);
    Route::post('contrato/store', ['uses' => 'Gerencial\ContratoController@store', 'as' => 'contrato.store']);
    Route::post('contrato/{contract}/update', ['uses' => 'Gerencial\ContratoController@update', 'as' => 'contrato.update']);
    Route::get('cursos',  ['uses' =>'CursosController@index','as'=>'cursos.index']);
    Route::post('cursos/store',  ['uses' =>'CursosController@store','as'=>'cursos.store']);
    Route::post('cursos/delete/{id}',  ['uses' =>'CursosController@delete','as'=>'cursos.delete']);

    //expenses
    Route::get('contrato/{contract}/expenses', ['uses' => 'Gerencial\Contrato\ContratoExpensesController@index', 'as' => 'contrato.expenses']);
    Route::get('contrato/{contract}/expenses/create', ['uses' => 'Gerencial\Contrato\ContratoExpensesController@create', 'as' => 'contrato.expenses.create']);
    Route::post('contrato/{contract}/expenses/store', ['uses' => 'Gerencial\Contrato\ContratoExpensesController@store', 'as' => 'contrato.expenses.store']);
    Route::get('contrato/{contract}/expenses/{expenses}/edit', ['uses' => 'Gerencial\Contrato\ContratoExpensesController@edit', 'as' => 'contrato.expenses.edit']);
    Route::post('contrato/{contract}/expenses/{expenses}/update', ['uses' => 'Gerencial\Contrato\ContratoExpensesController@update', 'as' => 'contrato.expenses.update']);
    Route::get('contrato/{contract}/expenses/{expenses}/remove', ['uses' => 'Gerencial\Contrato\ContratoExpensesController@remove', 'as' => 'contrato.expenses.remove']);

    Route::get('contrato/admin/{contract}', ['uses' => 'Gerencial\ContratoAdminController@panel', 'as' => 'contrato.admin.panel']);
    Route::get('contrato/admin/{contract}/dashboard', ['uses' => 'Gerencial\ContratoAdminController@dashboard', 'as' => 'contrato.admin.dashboard']);
    Route::get('contrato/admin/{contract}/formings', ['uses' => 'Gerencial\ContratoAdminController@formings', 'as' => 'contrato.admin.formings']);

    Route::get('contrato/admin/{contract}/prod', ['uses' => 'Gerencial\ContratoAdminController@prod', 'as' => 'contrato.admin.prod']);
    Route::get('contrato/admin/{contract}/prod/create', ['uses' => 'Gerencial\ContratoAdminController@prodCreate', 'as' => 'contrato.admin.prod.create']);
    Route::post('contrato/admin/{contract}/prod/store', ['uses' => 'Gerencial\ContratoAdminController@prodStore', 'as' => 'contrato.admin.prod.store']);
    Route::get('contrato/admin/prod/{prod}/edit', ['uses' => 'Gerencial\ContratoAdminController@prodEdit', 'as' => 'contrato.admin.prod.edit']);
    Route::post('contrato/admin/prod/{prod}/edit', ['uses' => 'Gerencial\ContratoAdminController@prodEditPost', 'as' => 'contrato.admin.prod.edit.post']);
    Route::get('contrato/admin/prod/{prod}/remove', ['uses' => 'Gerencial\ContratoAdminController@prodRemove', 'as' => 'contrato.admin.prod.remove']);
    Route::get('contrato/admin/prod/{prod}/edit/parcel/{parcel}/del', ['uses' => 'Gerencial\ContratoAdminController@prodEditParcelDel', 'as' => 'contrato.admin.prod.edit.parcel.delete']);

    Route::get('contrato/admin/{contract}/finance', ['uses' => 'Gerencial\ContratoAdminController@finance2', 'as' => 'contrato.admin.finance']);
    Route::get('contrato/admin/{contract}/finance-month', ['uses' => 'Gerencial\ContratoAdminController@financeAccumulatedMonthToMonth', 'as' => 'contrato.admin.finance.month']);
    Route::get('contrato/admin/{contract}/config_tipo_pagamento', ['uses' => 'Gerencial\ContratoAdminController@config_tipo_pagamento', 'as' => 'contrato.admin.config_tipo_pagamento']);
    Route::post('contrato/admin/store_tipo_pagamento', ['uses' => 'Gerencial\ContratoAdminController@store_tipo_pagamento', 'as' => 'contrato.admin.store_tipo_pagamento']);

    


    Route::get('orcamento/produtos', ['uses' => 'Gerencial\OrcamentoProdutoController@create', 'as' => 'orcamento.produto.create']);
    Route::get('orcamento/categorias', ['uses' => 'Gerencial\OrcamentoCategoriaController@create', 'as' => 'orcamento.categoria.create']);

    Route::get('calleds', ['uses' => 'Gerencial\CalledController@calleds', 'as' => 'calleds']);
    Route::get('calleds/show/{chamado}', ['uses' => 'Gerencial\CalledController@calledShow', 'as' => 'called.show']);
    Route::post('calleds/show/{chamado}', ['uses' => 'Gerencial\CalledController@calledConversationsStore', 'as' => 'called.conversations.store']);

});

Auth::routes();

Route::get('/home', function (){
    return redirect()->route('portal.home');
});

/*
 * Crop Image
 */
Route::post('crop/avatar', ['as' => 'crop.avatar', 'uses' => 'CropImageController@crop']);
Route::post('portal/perfil/fotoupdate', ['as' => 'perfil.fotoupdate', 'uses' => 'CropImageController@fotoupdate']);


/*
 * API
 */
Route::post('api/iugu/webhook', ['uses' => 'API\IuguController@webhook', 'as' => 'api.iugu.webhook']);
Route::get('api/sapi/consultaformando/{cpf}/{dtnascimento}', ['uses' => 'API\SapiController@consultaformando', 'as' => 'api.sapi.consultaformando']);
Route::get('api/iugu/consults/{date}', ['uses' => 'API\IuguController@consults', 'as' => 'api.iugu.consults']);


/*
 * /cad
 * Cadastro de formandos não aderidos
 */
Route::group(['prefix'=>'cad','as' => 'cad.'], function (){

    Route::get('', ['uses' => 'CadastroController@nContrato', 'as' => 'ncontrato']);

    Route::get('cpf', ['uses' => 'CadastroController@cpf', 'as' => 'cpf']);
    Route::post('cpf', ['uses' => 'CadastroController@cpfValid', 'as' => 'cpf.valid']);

    Route::get('{codturma}', ['uses' => 'CadastroController@contrato', 'as' => 'contrato']);
    Route::post('{codturma}', ['uses' => 'CadastroController@store', 'as' => 'store']);
    //Route::get('{codturma}', ['uses' => 'API\AppController@valid', 'as' => 'app.forming.valid']);

});


/*
 * API APPs
 */
Route::group(['prefix'=>'api','as' => 'api.'], function (){

    Route::post('app/login', ['uses' => 'API\AppController@login', 'as' => 'app.login']);
    Route::post('app/atends', ['uses' => 'API\AppController@atendimento', 'as' => 'app.atend']);
    Route::post('app/atends/newmsg', ['uses' => 'API\AppController@atendNovaMsg', 'as' => 'app.atend.newmsg']);

    Route::get('giftrequests/status', ['uses' => 'API\GiftRequestsController@statusUpdate', 'as' => 'giftrequests.status']);

    // API MOBILE
    Route::get('app/forming/valid', ['uses' => 'API\AppController@valid', 'as' => 'app.forming.valid']);
    Route::get('app/products', ['uses' => 'API\AppController@getProducts', 'as' => 'app.products']);
    Route::get('app/product/{prod}/{token}', ['uses' => 'API\AppController@getProductParcels', 'as' => 'app.product.parcels']);
    Route::get('app/extrasproducts', ['uses' => 'API\AppController@getExtrasProducts', 'as' => 'app.extrasproducts']);

    Route::get('app/register/{register}/checked', ['uses' => 'API\AppController@checkRegister', 'as' => 'app.register.check']);

    Route::get('app/event/checkin/{event}/{forming}', ['uses' => 'API\AppController@eventCheckin', 'as' => 'app.event.checkin']);

    Route::post('app/ckeckin/ticket', ['uses' => 'API\AppController@ckeckinTicket', 'as' => 'app.ckeckin.ckeckin']);
    Route::post('app/event/checkin/qr', ['uses' => 'API\AppController@EventCheckinQR', 'as' => 'app.ckeckin.ckeckin.qr']);

});


/*
 * WEBHOOK
 */
Route::group(['prefix'=>'webhook','as' => 'webhook.'], function (){

    Route::get('geraboletos', ['uses' => 'WebhookController@geraBoletos', 'as' => 'geraboletos']);
    Route::get('cancelaboletos', ['uses' => 'WebhookController@cancelaBoletos', 'as' => 'cancelaboletos']);
    Route::get('geraTickets', ['uses' => 'WebhookController@geraTickets', 'as' => 'geratickets']);
    Route::any('pseg', ['uses' => 'API\PsegController@webhook', 'as' => 'api.pseg.webhook']);

});


Route::get('/erro/404', function (){
    return view('erro.404');
})->name('erro.404');

