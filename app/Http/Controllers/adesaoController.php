<?php

namespace App\Http\Controllers;

use App\ConfigApp;
use App\Contract;
use App\Forming;
use App\Helpers\ConvertData;
use App\Helpers\DateHelper;
use App\ProductAndService;
use App\ProductAndServiceDiscounts;
use App\ProductAndServiceValues;
use App\ProdutosEServicosTermo;
use App\Services\FormandoServices;
use App\Services\ProdutosService;
use App\User;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class adesaoController extends Controller
{

    public function contrato(Request $request)
    {
        $session = $request->session()->get('contrato');
        $register = $request->session()->get('register');
        $date_inicio = $request->session()->get('date_inicio');
        if(!is_array($session)){
            \Session::flash('flash_message','Codigo não localizado');
            return redirect('adesao/ncontrato');
        }

        $contrato = Contract::where('code', $session['code'])->where('valid', $session['valid'])->get()->first();
        $mes = DateHelper::ConvertMonth($contrato->conclusion_month);
        $date_now = date("Y-m-d H:i:s");
        $products = ProductAndService::where('contract_id', $contrato->id)->where('date_start', '<=', $date_now)->where('date_end', '>', $date_now)->whereIn('category_id', ['1','2'])->get()->toArray();

        if(count($products) <= 0 || empty($products)){
            \Session::flash('flash_message','Nenhuma adesão localizada pra esse contrato!');
            return redirect('adesao/ncontrato');
        }

        if($contrato->id == 7){
            $formings = Forming::where('contract_id', $contrato->id)->where('status', 1)->get()->count();
            if($formings >= 430){
                \Session::flash('flash_message','Adesão encerrada ou limite excedido!');
                return redirect('adesao/ncontrato');
            }
        }
        //dd($products);
        foreach ($products as $p){

            $product[$p['id']] = $p;

            $values = ProductAndServiceValues::where('products_and_services_id', $p['id'])
                                                ->where('date_start', '<=', date('Y-m-d H:i:s', strtotime($date_inicio)))
                                                ->where('date_end', '>', date('Y-m-d H:i:s', strtotime($date_inicio)))
                                                ->get()->first()->toArray();

            $product[$p['id']]['values'] = $values;


            $discounts = ProductAndServiceDiscounts::where('products_and_services_id', $p['id'])
                                                        ->where('date_start', '<=', date('Y-m-d H:i:s', strtotime($date_inicio)))
                                                        ->where('date_end', '>', date('Y-m-d H:i:s', strtotime($date_inicio)))
                                                        ->get()->toArray();
            $max_parcel_discount = 0;
            foreach ($discounts as $d){
                $product[$p['id']]['discounts'][$d['maximum_parcels']] = $d;
                if($d['maximum_parcels'] > $max_parcel_discount){
                    $max_parcel_discount    =  $d['maximum_parcels'];
                    $max_parcel_porc        =  $d['value'];
                }
            }


            $product[$p['id']]['max_parcels'] = ConvertData::calculaParcelasMeses(date('Y-m-d', strtotime($product[$p['id']]['values']['date_start'])), $product[$p['id']]['values']['maximum_parcels']);
            $parcel_temp_max = 0;
            foreach($product[$p['id']]['max_parcels'] as $parcel_temp){
                if($parcel_temp['parcelas'] > $parcel_temp_max ){
                    $parcel_temp_max = $parcel_temp['parcelas'];
                }
            }

            $valor_termo = $product[$p['id']]['values']['value'];
            if($max_parcel_discount >= $parcel_temp_max && $parcel_temp_max > 0){
                $valor_termo = $product[$p['id']]['values']['value'] - ($product[$p['id']]['values']['value'] * ($max_parcel_porc/100));
            }

            $product[$p['id']]['termo'] = ProdutosEServicosTermo::where('id', $p['termo_id'])->get()->toArray()[0];
            $product[$p['id']]['termo'] = str_replace('[[=valor]]', number_format($valor_termo, 2, ',', '.'), $product[$p['id']]['termo']);

            //$product[$p['id']]['discounts'] = $discounts;


        }
        //dd($prods_values, $prods_discounts);

        //dd($product);
        $courses[0] = 'Selecione seu curso...';
        foreach ($contrato->courses()->orderBy('name')->get() as $c){
            $courses[$c['id']] = $c['name'];
        }

        $data = $request->session()->get('fase1');
        $fases = $request->session()->get('fases');
        $periodosString = explode(',', $contrato->periodos);
        $periodos = [];
        $periodos[0] = 'Selecione seu período...';
        foreach ($periodosString as $periodoString){
            $periodos[$periodoString] = ConfigApp::Periodos()[$periodoString];
        }

        return view('adesao.contrato', compact('contrato','mes', 'courses', 'data', 'periodos', 'fases', 'product', 'register'));
    }

    public function validContrato(Request $request)
    {

        $passAdesao = false;
        $this->validate($request, [
            'course' => 'numeric|min:1',
            'periodo' => 'numeric|min:1',
            'products_and_services' => 'required|array',
            'concorso' => 'same:on'
        ]);

        $products = $request->get('products_and_services');
        
        foreach ($products as $key => $product){
            $p = ProductAndService::find($product);
            /*if($p->category_id == 1) {
                $passAdesao = true;
                //dd($passAdesao);
            }*/

            $passAdesao = true;
        }
        //dd($passAdesao);
        if(!isset($passAdesao) or $passAdesao == false){
            $request->session()->flash('msgerro', 'Você deve escolher ao menos um pacote de formatura.');
            return redirect()->back();
        }

        $request->session()->put(['fase1' => $request->all()]);
        $request->session()->put(['fases' => ['1' => true]]);
        $request->session()->save();

        return redirect()->route('adesao.dados');
    }

    public function dados(Request $request)
    {

        $data = $request->session()->get('fase2');
        $fases = $request->session()->get('fases');
        $register = $request->session()->get('register');

        //Altura
        $i_altura = [];
        for ($i = 1.40; $i <= 2.10; $i+= 0.01){
            $i_altura["'".$i."'"] = str_replace(".",",",number_format($i, 2, ",", "."));
        }

        //Camiseta
        $camiseta = [
            'P' => 'P',
            'M' => 'M',
            'G' => 'G',
            'GG' => 'GG',
            'EG' => 'EG'
        ];

        //Calçado
        $calcado = ConfigApp::Calcados();
        //dd($data);
        return view('adesao.dados', compact('i_altura', 'camiseta', 'calcado', 'data', 'fases', 'register'));
    }

    public function validDados(Request $request)
    {
        $this->validate($request, [
          "nome" => "required",
          "sobrenome" => "required",
          "cpf" => "required",
          "sexo" => "required",
          "datanascimento" => "required",
          "rg" => "required",
          "cep" => "required",
          "email" => "required|email",
          "telefone-celular" => "required",
          "altura" => "required",
          "camiseta" => "required",
          "calcado" => "required"
        ]);

        $email = $request->get('email');
        $cpf = $request->get('cpf');
        $cpf = str_replace(".","", str_replace("-", "", $cpf));
        $session = $request->session()->get('contrato');

        $contrato = Contract::where('code', $session['code'])->where('valid', $session['valid'])->get()->first();
        $formingExists = Forming::where('contract_id', $contrato->id)->where('email', $email)->get();
        $formingExists2 = Forming::where('contract_id', $contrato->id)->where('cpf', $cpf)->get();

        if($formingExists->count() > 0 or $formingExists2->count() > 0){
            return redirect()->route('adesao.formandojacadastrado');
        }

        $request->session()->put(['fase2' => $request->all()]);
        $request->session()->put(['fases' => ['2' => true]]);
        $request->session()->save();

        return redirect()->route('adesao.confirma');

    }

    public function confirma(Request $request)
    {

        $session = $request->session()->get('contrato');
        $date_inicio = $request->session()->get('date_inicio');
        $fase1 = $request->session()->get('fase1');
        if (!is_array($session)) {
            \Session::flash('flash_message', 'Codigo não localizado');
            return redirect('adesao/ncontrato');
        }

        $contrato = Contract::where('code', $session['code'])->where('valid', $session['valid'])->get()->first();
        $products = ProductAndService::whereIn('id', $fase1['products_and_services'])->get()->toArray();

        foreach ($products as $p) {

            $product[$p['id']] = $p;

            $values = ProductAndServiceValues::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s', strtotime($date_inicio)))
                ->where('date_end', '>', date('Y-m-d H:i:s', strtotime($date_inicio)))
                ->get()->first()->toArray();

            $product[$p['id']]['values'] = $values;

            $discounts = ProductAndServiceDiscounts::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s', strtotime($date_inicio)))
                ->where('date_end', '>', date('Y-m-d H:i:s', strtotime($date_inicio)))
                ->get()->toArray();

            foreach ($discounts as $d) {
                $product[$p['id']]['discounts'][$d['maximum_parcels']] = $d;
            }

            $product[$p['id']]['max_parcels'] = ConvertData::calculaParcelasMeses(date('Y-m-d', strtotime($product[$p['id']]['values']['date_start'])), $product[$p['id']]['values']['maximum_parcels']);
        }



        $dataConfirma = $request->session()->get('fase2');
        $data = $request->session()->get('fase3');
        $fases = $request->session()->get('fases');
        return view('adesao.confirma', compact('fases', 'data', 'dataConfirma', 'fase1', 'product'));
    }

    public function validConfirma(Request $request)
    {
        $request->session()->put(['fases' => ['3' => true]]);
        $request->session()->save();
        return redirect()->route('adesao.pagamento');
    }

    public function pagamento(Request $request, $dia = null)
    {

        $dia_get = $dia;
        //$paytype = $request->get('paytype');
        $paytype = 1;
        $session = $request->session()->get('contrato');
        $data_inicio = $request->session()->get('date_inicio');
        $fase1 = $request->session()->get('fase1');
        $fases = $request->session()->get('fases');
        if (!is_array($session)) {
            \Session::flash('flash_message', 'Codigo não localizado');
            return redirect('adesao/ncontrato');
        }

        if( !($paytype) || ($paytype != 1 && $paytype != 2)){
            return view('adesao.pagamento-type', compact('fases', 'fase1', 'dia_get'));
        }

        $contrato = Contract::where('code', $session['code'])->where('valid', $session['valid'])->get()->first();
        $products = ProductAndService::whereIn('id', $fase1['products_and_services'])->get()->toArray();

        foreach ($products as $p) {

            $product[$p['id']] = $p;

            $values = ProductAndServiceValues::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s', strtotime($data_inicio)))
                ->where('date_end', '>', date('Y-m-d H:i:s', strtotime($data_inicio)))
                ->get()->first()->toArray();

            $product[$p['id']]['values'] = $values;
            //dd($product[$p['id']]['values']);

            $discounts = ProductAndServiceDiscounts::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s', strtotime($data_inicio)))
                ->where('date_end', '>', date('Y-m-d H:i:s', strtotime($data_inicio)))
                ->get()->toArray();

            foreach ($discounts as $d) {
                $product[$p['id']]['discounts'][$d['maximum_parcels']] = $d;
            }
            @ksort($product[$p['id']]['discounts']);

            //dd($product[$p['id']]['discounts']);

            $date_inicio = date('Y-m-d', strtotime($product[$p['id']]['values']['date_start']));
            $maximum_parcls = $product[$p['id']]['values']['maximum_parcels'];

            $product[$p['id']]['max_parcels'] = ConvertData::calculaParcelasMeses($date_inicio, $maximum_parcls);
            //dd($product[$p['id']]['max_parcels']);
            $max_parls = ConvertData::geraParcelasProdutos($date_inicio, $maximum_parcls ,$dia);
            $valor = $product[$p['id']]['values']['value'];

            for($i=1; $i<= $max_parls; $i++){

                if($paytype == 2 && $i>12){break;}

                $disc = 0;
                if(isset($product[$p['id']]['discounts']) and is_array($product[$p['id']]['discounts'])){

                    $discounts_array = $product[$p['id']]['discounts'];
                    //dd($discounts_array);
                    krsort($discounts_array);
                    //dd($discounts_array);
                    foreach ($discounts_array as $k => $v){
                        if($v['maximum_parcels'] >= $i){
                            $disc = $v['value'];
                        }
                    }
                }

                $valorProd = ($valor - ($valor * ($disc/100)));
                $vl_parcela = ($valorProd / $i);
                $vlfor = number_format($vl_parcela, 2, ',', '.');
                $disc_label = ($disc > 0 ? "C/ {$disc}% de desconto" : "");
                $product[$p['id']]['parcels'][$i] = "{$i}X de R$ {$vlfor} = R$ " . $valorProd . " {$disc_label} ";
            }

        }
        $dataConfirma = $request->session()->get('fase2');
        $data = $request->session()->get('fase3');
        $dia_pagamento = ConvertData::geraProximosParcelas();
        foreach ($dia_pagamento as $d){
            $dias_pagamento[$d['dia']] = "Todo dia " . $d['dia'] . " com a primeira para " . date('d/m/Y', strtotime($d['priPagamento']));
        }
        $pageview = ($paytype == 1) ? 'adesao.pagamento' : 'adesao.pagamento-credit';


        return view($pageview, compact('fases', 'data', 'dataConfirma', 'fase1', 'product', 'dias_pagamento', 'dia_get', 'paytype'));
    }

    public function validPagamento(Request $request)
    {
        $paytype = $request->get("paytype");
        $parcelas_prod = $request->get("parcelas_prod_");
        foreach ($parcelas_prod as $key => $value){
            if($value <= 0){
                \Session::flash('erro_parcelamento', 'Favor escolha um parcelamento');
                $this->validate($request, [
                    "parcelas_prod_" => "required|int|min:1"
                ]);

            }
        }
        if($paytype == 2){
            $this->validate($request, [
                "parcelas_prod_" => "required|array"
            ]);
        }else{
            $this->validate($request, [
                "dia_pagamento" => "required|min:1|max:30",
                "parcelas_prod_" => "required|array"
            ]);
        }

        $concluidoExe = $request->session()->get('concluido_exe');
        if($concluidoExe != true){

            $request->session()->put(['concluido_exe' => true]);

            $date_inicio = $request->session()->get('date_inicio');
            $session = $request->session()->get('contrato');
            $contrato = Contract::where($session)->select('id')->get()->first()->toArray();

            $parcelas = $request->get('parcelas_prod_');
            $dia = $request->get('dia_pagamento');
            foreach ($parcelas as $p){
                if($p == 0 || $p == '' || $p == null) {
                    return redirect()->route('adesao.pagamento.dia', $dia);
                }
            }


            $request->session()->put(['fases' => ['4' => true]]);
            $request->session()->save();

            $serviceFormando = new FormandoServices;

            $formando = $serviceFormando->cadastraFormando(array_merge($request->session()->get('fase2'), $request->session()->get('fase1')), $request->session()->get('fase1'));
            $senha = str_random(8);
            $user = User::create(['name' => $formando->nome.' '.$formando->sobrenome, 'email' => $formando->email, 'password' => bcrypt($senha), 'remember_token' => str_random(10)]);
            $user->userable()->associate($formando);
            $user->save();
            if(!$formando){

            }else{

                $serviceProdutos = new ProdutosService();
                $serviceProdutos->cadastraProduto($parcelas, $dia, $date_inicio, $formando->id, $contrato);
                $request->session()->put(['adesao_ok_id' => $formando->id]);

                $fromMail = 'naoresponda@arrecadeei.com.br';
                $fromName = 'Arrecadeei - Formatura do Futuro';
                $dataEmail = $formando->toArray();
                $dataEmail['senha'] = $senha;

                Mail::send('email.adesao-cadastrada', $dataEmail, function ($message) use ($fromName, $fromMail, $formando){

                    $message->to($formando->email, $formando->nome);
                    $message->from($fromMail, $fromName);
                    $message->subject('Cadastro Concluido!');
                    //$message->attach(public_path('contrato_GABRIEL_BICALHO.pdf'));

                });

            }

        }
        return redirect()->route('adesao.concluido');

    }

    public function concluido(Request $request)
    {
        $fases = $request->session()->get('fases');
        $formandoId = $request->session()->get('adesao_ok_id');
        $formando = Forming::find((int) $formandoId);
        return view('adesao.concluido', compact('formando', 'fases'));
    }

    public function erroFormandoJaCadastrado(){

        return view('adesao.erro_adesaodupla');

    }

}
