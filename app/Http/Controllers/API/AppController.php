<?php

namespace App\Http\Controllers\API;

use App\Chamado;
use App\ChamadoConversa;
use App\ConfigApp;
use App\Course;
use App\Event;
use App\EventCheckin;
use App\FormandoProdutosEServicos;
use App\FormandoProdutosParcelas;
use App\Forming;
use App\Helpers\ConvertData;
use App\Http\Controllers\Controller;
use App\Informativo;
use App\PagamentosBoleto;
use App\ProductAndService;
use App\ProductAndServiceDiscounts;
use App\ProductAndServiceValues;
use App\ProdutosEServicosTermo;
use App\Register;
use App\Ticket;
use App\TokenApiLogin;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AppController extends Controller
{

    /*public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $json = ['error' => 1, 'msg' => '', 'data' => ''];


        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $user = Auth::user();
            $forming = Forming::where('id', $user->userable_id)->get(['id', 'nome', 'sobrenome', 'date_nascimento', 'img', 'contract_id'])->first();
            if($forming->img == 'assets/common/img/avatar.png' or $forming->img == ''){
                $forming->img = '/assets/common/img/avatar.png';
            }
            $json['data'] = ['forming' => $forming];

            $products = FormandoProdutosEServicos::where('forming_id', $forming->id)->orderBy('created_at')->get(['id', 'name', 'description', 'img', 'termo_id']);
            foreach ($products as $index => $product){
                $json['data']['forming']['products'][$index] = $product;

                $termo = ProdutosEServicosTermo::find($product->termo_id);
                $termo->conteudo = $termo->conteudoLimpo();
                $json['data']['forming']['products'][$index]['termo'] = $termo;

                $parcelas = FormandoProdutosParcelas::where(['formandos_produtos_id' => $product->id])->get();
                $pagamentos = [];

                foreach ($parcelas as $index2 => $parcela){

                    $parcelaArray['dt_vencimento'] = $parcela->dt_vencimento;
                    $parcelaArray['numero_parcela'] = $parcela->numero_parcela;
                    $parcelaArray['valor'] = $parcela->valor;





                    $pagamento = $parcela->pagamento()->where(['deleted' => 0])->first();
                    if($pagamento){
                        $boleto = PagamentosBoleto::where(['parcela_pagamento_id' => $pagamento->id, 'deleted' => 0])->first();
                        if($boleto){
                            $parcelaArray['status'] = $boleto->status;
                            $parcelaArray['secure_url'] = $boleto->secure_url;
                            $parcelaArray['digitable_line'] = $boleto->digitable_line;
                        }
                    }else{
                        $parcelaArray['status'] = "null";
                        $parcelaArray['secure_url'] = "null";
                        $parcelaArray['digitable_line'] = "null";
                    }




                    //dd($pagamentos, $boleto);
                    foreach ($pagamentos as $index3 => $pagamento){

                        $parcelaArray['pagamentos'] =  $boleto->toArray();
                        //dd($parcelaArray['pagamentos']);
                    }


                    $json['data']['forming']['products'][$index]['boletos'][$index2] = $parcelaArray;
                    unset($parcelaArray);

                }

            }

            $infos = Informativo::where('contract_id', $forming->contract_id)->orderBy('updated_at', 'desc')->get()->toArray();
            $json['data']['forming']['infos'] = $infos;

            $dtNow = Carbon::now();

            $selectToken = TokenApiLogin::where('user_id', $user->id)->where('status', 1)->where('expiration', '>', $dtNow->format("Y-m-d H:i:s"))->first();
            if(!$selectToken){
                $token = md5(date('Ymd').$user->id.date('Hisu'));
                $expired_at = Carbon::now()->addDays(7);
                $createToken = [
                    'user_id' =>  $user->id,
                    'token' =>  $token,
                    'expiration' =>  $expired_at->format("Y-m-d H:i:s"),
                    'status' =>  1,
                ];

                $tokenCreated = TokenApiLogin::create($createToken);
                $json['data']['forming']['token'] = $tokenCreated->token;
            }else{
                $json['data']['forming']['token'] = $selectToken->token;
            }

            $json['data']['forming']['atends'] = [];

            $chamados = Chamado::where('forming_id', $user->userable_id);
            $atendsArray = [];
            foreach ($chamados->get() as $chamado){
                $chamado->conversas;
                $tempArray = $chamado->toArray();
                $idAssunto = $tempArray['assunto_chamado'];
                $tempArray['assunto_chamado'] = ConfigApp::AssuntosChamados()[$idAssunto];
                $atendsArray[] = $tempArray;

            }

            $json['data']['forming']['atends'] = $atendsArray;




            $json['error'] = 0;
            $json['msg'] = 'Login efetuado com sucesso!';

        }else{
            $json['msg'] = 'Usuário ou senha incorreto!';
        }

        return $json;

//        $userLogin = User::where('email', $email)->where('password', $password)->get();
//        dd($userLogin);
//
//        echo($email);
//        echo("<br>");
//        echo($password);
        //$formandos = Forming::where('cpf', $cpf)->where('date_nascimento', $dtnascimento)->first();

//        if($formandos){
//
//            $retorno = [
//                'error' => false,
//                'message' => 'Formando Localizado',
//                'data' => [
//                    'Id' => $formandos->id,
//                    'Name' => $formandos->nome.' '.$formandos->sobrenome,
//                    'Email' => $formandos->email,
//                    'PhoneNumber' => $formandos->telefone_celular,
//                    'Address' => $formandos->logradouro.', '.$formandos->numero.' '.$formandos->complemento.' - '.$formandos->bairro.' - '.$formandos->cidade.' - '.$formandos->estado,
//                    'CPF' => $formandos->cpf,
//                    'CEP' => $formandos->cep
//                ]
//            ];
//
//        }else{
//
//            $retorno = [
//                'error' => true,
//                'message' => 'Credencial inválida'
//            ];
//
//        }
//
//        return $retorno;
    }*/

    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $json = ['error' => 1, 'msg' => '', 'data' => ''];


        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $user = Auth::user();
            $forming = Forming::where('id', $user->userable_id)->get(['id', 'nome', 'sobrenome', 'date_nascimento', 'img', 'contract_id', 'valid'])->first();
            if($forming->img == 'assets/common/img/avatar.png' or $forming->img == ''){
                $forming->img = 'assets/common/img/avatar.png';
            }
            $forming->img = $this->stringImg($forming->img);
            $json['data'] = ['forming' => $forming];

            $dtNow = Carbon::now();

            $selectToken = TokenApiLogin::where('user_id', $user->id)->where('status', 1)->where('expiration', '>', $dtNow->format("Y-m-d H:i:s"))->first();
            if(!$selectToken){
                $token = md5(date('Ymd').$user->id.date('Hisu'));
                $expired_at = Carbon::now()->addDays(7);
                $createToken = [
                    'user_id' =>  $user->id,
                    'token' =>  $token,
                    'expiration' =>  $expired_at->format("Y-m-d H:i:s"),
                    'status' =>  1,
                ];

                $tokenCreated = TokenApiLogin::create($createToken);
                $json['token'] = $tokenCreated->token;
            }else{
                $json['token'] = $selectToken->token;
            }

            $json['error'] = 0;
            $json['msg'] = 'Login efetuado com sucesso!';

        }else{
            $json['msg'] = 'Usuário ou senha incorreto!';
        }

        return $json;

    }

    public function atendimento(Request $request)
    {
        $ssunto = $request->get('assunto');
        $token = $request->get('token');
        $title = $request->get('title');
        $description = $request->get('description');
        $assuntosIds = ConfigApp::AssuntosChamados();

        $dtNow = Carbon::now();
        $userToken = TokenApiLogin::where('token', $token)->where('status', 1)->where('expiration', '>', $dtNow->format("Y-m-d H:i:s"))->first();
        $user = User::find($userToken->user_id);


        foreach ($assuntosIds as $key => $value){
            if($ssunto == $value){
                $ssunto = $key;
            }else{
                $ssunto = 6;
            }
        }

        $dt_now = Carbon::now();
        $dt_now->addDays(2);
        if($dt_now->dayOfWeek == 6){
            $dt_now->addDays(2);
        }elseif ($dt_now->dayOfWeek == 0){
            $dt_now->addDays(1);
        }

        $data = [
            'forming_id' => $user->userable_id,
            'setor_chamado' => 1,
            'assunto_chamado' => $ssunto,
            'titulo' => $title,
            'descricao' => $description,
            'data_limite' => $dt_now->format('Y-m-d'),
            'status' => 1,
        ];

        $createAtend = Chamado::create($data)->toArray();
        $idAssunto = $createAtend['assunto_chamado'];
        $createAtend['assunto_chamado'] = $assuntosIds[$idAssunto];
        if($createAtend){
            return $createAtend;
        }else{
            return ['error' => 1];
        }

    }

    public function atendNovaMsg(Request $request)
    {
        $id = $request->get('id');
        $token = $request->get('token');
        $msg = $request->get('msg');



        $assuntosIds = ConfigApp::AssuntosChamados();

        $dtNow = Carbon::now();
        $userToken = TokenApiLogin::where('token', $token)->where('status', 1)->where('expiration', '>', $dtNow->format("Y-m-d H:i:s"))->first();
        if(!$userToken){
            return ['error' => 1];
        }
        $user = User::find($userToken->user_id);
        if(!$user){
            return ['error' => 2];
        }


        $createAtend = Chamado::find($id)->toArray();

        $data = [
            'chamado_id' => $id,
            'user_id' => $user->id,
            'texto' => $msg
        ];

        $createNova = ChamadoConversa::create($data);

        return $createNova;

    }

    public function getProducts(Request $request)
    {

        $token = $request->get('token');

        $dtNow = Carbon::now();
        $userToken = TokenApiLogin::where('token', $token)->where('status', 1)->where('expiration', '>', $dtNow->format("Y-m-d H:i:s"))->first();
        $user = User::find($userToken->user_id);

        $prods = FormandoProdutosEServicos::where('forming_id', $user->userable_id)->get();
        return $prods;



    }

    public function getProductParcels(FormandoProdutosEServicos $prod, $token)
    {

        $json = [];
        $termo = ProdutosEServicosTermo::find($prod->termo_id);
        $termo->conteudo = $termo->conteudoLimpo();
        $termo->conteudo = explode("\n", $termo->conteudo);
        $json['termo'] = $termo->conteudo;

        $dtNow = Carbon::now();
        $userToken = TokenApiLogin::where('token', $token)->where('status', 1)->where('expiration', '>', $dtNow->format("Y-m-d H:i:s"))->first();
        $user = User::find($userToken->user_id);

        $parcelas = FormandoProdutosParcelas::where(['formandos_produtos_id' => $prod->id])->get();

        if($parcelas->count() <= 0){
            return [];
        }

        $pagamentos = [];

        foreach ($parcelas as $index2 => $parcela){

            $parcelaArray['dt_vencimento'] = $parcela->dt_vencimento;
            $parcelaArray['numero_parcela'] = $parcela->numero_parcela;
            $parcelaArray['valor'] = $parcela->valor;





            $pagamento = $parcela->pagamento()->where(['deleted' => 0])->first();
            if($pagamento){
                $boleto = PagamentosBoleto::where(['parcela_pagamento_id' => $pagamento->id, 'deleted' => 0])->first();
                if($boleto){
                    $parcelaArray['status'] = $boleto->status;
                    $parcelaArray['secure_url'] = $boleto->secure_url;
                    $parcelaArray['digitable_line'] = $boleto->digitable_line;
                }
            }else{
                $parcelaArray['status'] = "null";
                $parcelaArray['secure_url'] = "null";
                $parcelaArray['digitable_line'] = "null";
            }




            //dd($pagamentos, $boleto);
            foreach ($pagamentos as $index3 => $pagamento){

                $parcelaArray['pagamentos'] =  $boleto->toArray();
                //dd($parcelaArray['pagamentos']);
            }


            $json['boletos'][$index2] = $parcelaArray;
            unset($parcelaArray);

        }

        return $json;
    }

    public function getExtrasProducts(Request $request)
    {

        $token = $request->get('_token');

        if(empty($token)){
            return ['error' => 'No token'];
        }

        $dtNow = Carbon::now();
        $userToken = TokenApiLogin::where('token', $token)->where('status', 1)->where('expiration', '>', $dtNow->format("Y-m-d H:i:s"))->first();


        if(!$userToken){
            return ['error' => 'No token valid'];
        }

        $user = User::find($userToken->user_id);

        $products = ProductAndService::where('contract_id', $user->userable->contract_id)->where('category_id', 6)->get();

        foreach ($products as $p){

            $product[$p['id']] = $p;

            $values = ProductAndServiceValues::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s'))
                ->where('date_end', '>', date('Y-m-d H:i:s'))
                ->get()->first()->toArray();

            ;

            $product[$p['id']]['values'] = $values;
            //$product[$p['id']]['termo'] = ProdutosEServicosTermo::where('id', '=', $p['termo_id'])->get()->toArray()[0];
            //$product[$p['id']]['termo'] = str_replace('[[=valor]]', number_format($product[$p['id']]['values']['value'], 2, ',', '.'), $product[$p['id']]['termo']);

//            $discounts = ProductAndServiceDiscounts::where('products_and_services_id', $p['id'])
//                ->where('date_start', '<=', date('Y-m-d H:i:s'))
//                ->where('date_end', '>', date('Y-m-d H:i:s'))
//                ->get()->toArray();

//            foreach ($discounts as $d){
//                $product[$p['id']]['discounts'][$d['maximum_parcels']] = $d;
//            }

            $product[$p['id']]['max_parcels'] = ConvertData::calculaParcelasMeses(date('Y-m-d', strtotime($product[$p['id']]['values']['date_start'])), $product[$p['id']]['values']['maximum_parcels']);
            foreach ($product[$p['id']]['max_parcels'] as $maxp){
                $product[$p['id']]['max_parcels'] = $maxp['parcelas'];
            }
            $product[$p['id']]['value'] = $product[$p['id']]['values']['value'];
            unset($product[$p['id']]['values']);
            unset($product[$p['id']]['maximum_parcels']);
            unset($product[$p['id']]['category_id']);
            unset($product[$p['id']]['reset_igpm']);
            unset($product[$p['id']]['date_start']);
            unset($product[$p['id']]['date_end']);
            unset($product[$p['id']]['created_at']);
            unset($product[$p['id']]['updated_at']);
            unset($product[$p['id']]['stock']);
            unset($product[$p['id']]['contract_id']);
            //$product[$p['id']]['discounts'] = $discounts;

        }

        return $products;



    }

    public function checkRegister(Register $register)
    {

        if($register->checked == 0){
            $register->checked = 1;
            $register->save();
        }elseif($register->checked == 1){
            $register->checked = 0;
            $register->save();
        }
        return ['checked' => $register->checked];

    }

    public function valid(Request $request)
    {
        $valid = $request->get('v');
        $forming = Forming::where('valid', $valid)->get(['nome', 'sobrenome', 'img', 'curso_id', 'rg'])->first()->toArray();

        $curso = Course::find($forming['curso_id'])->first()->name;
        $forming['img'] = $this->stringImg($forming['img']);
        $forming['curso'] = $curso;


        return $forming;

    }

    private function stringImg($img){
        if(starts_with($img, '/')){
            return str_after($img, '/');
        }
        return $img;
    }

    public function ckeckinTicket(Request $request)
    {
        $token = $request->get('_token');
        $code = $request->get('code');
        $event = $request->get('event');
        if($token != '704e3d808f5e1a348739d4321229309b'){
            die('Access denied!');
        }
        $ticket = Ticket::where('code', $code)->where('event_id', $event)->where('status', 1)->first();
        if(!$ticket){
            $return =  [
                'error' => 1,
                'msg' => 'ingresso não localizado!'
            ];
        }elseif($ticket->checkin == 1){
            $return =  [
                'error' => 2,
                'msg' => 'ingresso já utilizado'
            ];
        }elseif($ticket->checkin == 0){

            $ticket->checkin = 1;
            $ticket->checkin_datetime = date("Y-m-d H:i:s");
            $ticket->save();
            $return =  [
                'error' => 0,
                'msg' => 'Ingresso validado com sucesso'
            ];

        }else{
            $return =  [
                'error' => 3,
                'msg' => 'Undefined (254)'
            ];;
        }

        $ticket = Ticket::where('event_id', $event)->where('status', 1)->get();
        $return['checked'] =  $ticket->where('checkin', 1)->count();
        $return['total'] =  $ticket->count();
        return  $return;

    }

    public function EventCheckin(Event $event, Forming $forming)
    {
        $checkin = EventCheckin::where('event_id', $event->id)->where('contract_id', $forming->contract_id)->where('forming_id', $forming->id)->get();

        if($checkin->count()<=0){
            $checked = EventCheckin::create([
                'event_id' => $event->id,
                'contract_id' => $forming->contract_id,
                'forming_id' => $forming->id
            ]);
            $return =  [
                'checked' => 1,
                'datetime' => date("d/m/Y H:i", strtotime($checked->created_at)),
                'name' => $forming->nome,
            ];
        }else{
            $return =  [
                'checked' => 1,
                'datetime' => date("d/m/Y H:i", strtotime($checkin->first()->created_at)),
                'name' => $forming->nome,
            ];
        }
        $checkeds = EventCheckin::where('event_id', $event->id)->where('contract_id', $forming->contract_id)->count();
        $return['total_checkeds'] = $checkeds;
        return $return;
    }

    public function EventCheckinQR(Request $request)
    {

        $token = $request->get('_token');
        $valid = $request->get('valid');
        $event = $request->get('event');
        if($token != 'klajhfds89fdf9dsbfdsbf98fgd9s'){
            die('Access denied!');
        }

        $forming = Forming::where('valid', $valid)->first();
        $event = Event::where("id", $event)->where('contract_id', $forming->contract_id)->first();
        if(!$forming or !$event){
            return [
                'error' => 1
            ];
        }
        $checkin = EventCheckin::where('event_id', $event->id)->where('contract_id', $forming->contract_id)->where('forming_id', $forming->id)->first();

        if($checkin){
            $return =  [
                'error' => 2
            ];
        }else{
            $checked = EventCheckin::create([
                'event_id' => $event->id,
                'contract_id' => $forming->contract_id,
                'forming_id' => $forming->id
            ]);
            if($checked){
                $return =  [
                    'error' => 0,
                ];
            }else{
                $return =  [
                    'error' => 3,
                ];
            }

        }

        return $return;
    }

}
