<?php
/**
 * Created by PhpStorm.
 * User: leonardozaneladias
 * Date: 17/05/17
 * Time: 17:11
 */

namespace App\Services;


use App\ConfigApp;
use App\Contract;
use App\FormandoProdutosEServicos;
use App\FormandoProdutosEServicosCateriasTipos;
use App\FormandoProdutosParcelas;
use App\Forming;
use App\Helpers\ConvertData;
use App\Helpers\DateHelper;
use App\ProductAndService;
use App\ProductAndServiceDiscounts;
use App\ProductAndServiceValues;
use App\ProdutosEServicosTermo;
use Carbon\Carbon;

class ProdutosService
{
    public function cadastraProduto($ids, $diaPagamento, $data_inicio, $codFormando, $contrato, $quant = 1)
    {

        $dia = $diaPagamento;
        $data_inicio_ad = $data_inicio;
        $products = ProductAndService::whereIn('id', array_keys($ids))->get()->toArray();
        //dd($ids);



        foreach ($products as $p) {

            $product[$p['id']] = $p;

            $values = ProductAndServiceValues::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s', strtotime($data_inicio_ad)))
                ->where('date_end', '>', date('Y-m-d H:i:s', strtotime($data_inicio_ad)))
                ->get()->first()->toArray();

            $product[$p['id']]['values'] = $values;

            $discounts = ProductAndServiceDiscounts::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s', strtotime($data_inicio_ad)))
                ->where('date_end', '>', date('Y-m-d H:i:s', strtotime($data_inicio_ad)))
                ->get()->toArray();

            foreach ($discounts as $d) {
                $product[$p['id']]['discounts'][$d['maximum_parcels']] = $d;
            }
            @ksort($product[$p['id']]['discounts']);

            $date_inicio = date('Y-m-d', strtotime($product[$p['id']]['values']['date_start']));
            $maximum_parcls = $product[$p['id']]['values']['maximum_parcels'];

            $max_parls = ConvertData::geraParcelasProdutos($date_inicio, $maximum_parcls ,$dia);
            $valor = $product[$p['id']]['values']['value'];
            if($p["id"] == 31) {
                
                if ($quant >= 8) {
                    $max_parls = 10;
                } elseif ($quant >= 4) {
                    $max_parls = 6;
                } else {
                    $max_parls = 3;
                }

            }

            for($i=1; $i<= $max_parls; $i++){

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
                $vlfor = number_format($vl_parcela, 2, '.', '');
                $disc_label = ($disc > 0 ? "C/ {$disc}% de desconto" : "");
                $product[$p['id']]['parcels'][$i] = ['valorCheio' => $valor,'valorTotal' => $valorProd, 'valorParcela' => $vlfor, 'discount' => $disc];
                //$product[$p['id']]['parcels'][$i] = "{$i}X de R$ {$vlfor} = R$ " . $valorProd . " {$disc_label} ";
            }


            $parcelas = $ids[$p['id']];

            $dataDB = [
                'forming_id' => $codFormando,
                'contract_id' => $contrato['id'],
                'name' => $p['name'],
                'description' => $p['description'],
                'img' => $p['img'],
                'value' => $valor,
                'discounts' => $product[$p['id']]['parcels'][$parcelas]['discount'],
                'parcels' => $parcelas,
                'payday' => (int)$dia,
                'termo_id' => $p['termo_id'],
                'amount' => $quant,
                'category_id' => $p['category_id'],
                'reset_igpm' => $p['reset_igpm'],
                'original_id' => $p['id'],
                'events_ids' => $p['events_ids'],
            ];
            //dd($dataDB);
            $codFormandoProduto = FormandoProdutosEServicos::create($dataDB);

            $ano_mes = date('Y-m')  ;
            if(date('Y-m-d', strtotime("+0 days")) > date('Y-m-d', strtotime("{$ano_mes}-{$dia}"))){
                $addMes = 1;
            }else{
                $addMes = 0;
            }

            $dt = Carbon::now();
            $dtVenc = Carbon::createFromDate($dt->year, $dt->month, $dia);
            $dtVenc = Carbon::parse($dtVenc)->addMonth($addMes);

            $vlTotal = $product[$p['id']]['parcels'][$parcelas]['valorTotal'];
            $vlTotal = $vlTotal * $quant;
            $vlParcela = $product[$p['id']]['parcels'][$parcelas]['valorParcela'];
            $vlParcela = $vlParcela * $quant;
            $result = $vlTotal - ($vlParcela * $parcelas);
            $result = number_format($result, 2, ".", "");
            //dd($result);

            for ($i=1; $i<=$parcelas; $i++){

                if($i == $parcelas){
                    $vlParcela += $result;
                }
                $dtVencX = Carbon::parse($dtVenc)->addMonth(($i-1));

                if(
                    ($dtVencX->format("m-d") == "03-01" || $dtVencX->format("m-d") == "03-02" || $dtVencX->format("m-d") == "03-03")
                    && $dia > 28){

                    $dtVencX = Carbon::createFromDate($dtVencX->year, ($dtVencX->month - 1), $dtVencX->addMonth(-1)->endOfMonth()->format("d"));

                }

                $dataDB2 = [
                    'formandos_produtos_id' => $codFormandoProduto->id,
                    'formandos_id' => $codFormando,
                    'contrato_id' => $contrato['id'],
                    'numero_parcela' => $i,
                    'dt_vencimento' => $dtVencX->toDateTimeString(),
                    'valor' => number_format($vlParcela,2, '.', ''),
                    'status' => 0,
                ];
                FormandoProdutosParcelas::create($dataDB2);

            }


            //Insert DB
        }
        return $codFormandoProduto;

    }

    public static function verificarEstoque(ProductAndService $produto)
    {
        $vendas = 0;
        $total_convites = 0;
        $total_mesas = 0;

        $estoque = FormandoProdutosEServicos::where('original_id', $produto->id)->where('status', 1)->get();
        foreach ($estoque as $e){
            $vendas += $e->amount;
            $id = $e->id;

//            if($e->name == 'Formatura Pacote C/ 1 Mesa e 10 Convites'
//            or $e->name == 'Formatura Pacote C/ 1 Mesa e 10 Convites. [Desconto Especial 400]'
//            or $e->name == 'Formatura Pacote C/ 1 Mesa e 10 Convites [Desconto Especial 400]'){
//                FormandoProdutosEServicosCateriasTipos::create(['fps_id' => $id, 'category_id' => 1, 'quantity' => 10]);
//                FormandoProdutosEServicosCateriasTipos::create(['fps_id' => $id, 'category_id' => 2, 'quantity' => 10]);
//            }else{
//                FormandoProdutosEServicosCateriasTipos::create(['fps_id' => $id, 'category_id' => 1, 'quantity' => 1]);
//            }

            foreach ($e->categorias_tipos as $cats){

                if($cats->category_id == 1){
                    $total_convites += ($cats->quantity * $e->amount);
                }elseif($cats->category_id == 2){
                    $total_mesas += ($cats->quantity * $e->amount);
                }

            }

        }
        return ['vendas' => $vendas, 'convites' => $total_convites,  'mesas' => ($total_mesas/10)];

    }

    public static function verificarEstoquePorFormando(ProductAndService $produto, Forming $forming)
    {
        $vendas = 0;
        $total_convites = 0;
        $total_mesas = 0;

        $estoque = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('original_id', $produto->id)->where('status', 1)->get();
        foreach ($estoque as $e){
            $vendas += $e->amount;
            $id = $e->id;

//            if($e->name == 'Formatura Pacote C/ 1 Mesa e 10 Convites'
//            or $e->name == 'Formatura Pacote C/ 1 Mesa e 10 Convites. [Desconto Especial 400]'
//            or $e->name == 'Formatura Pacote C/ 1 Mesa e 10 Convites [Desconto Especial 400]'){
//                FormandoProdutosEServicosCateriasTipos::create(['fps_id' => $id, 'category_id' => 1, 'quantity' => 10]);
//                FormandoProdutosEServicosCateriasTipos::create(['fps_id' => $id, 'category_id' => 2, 'quantity' => 10]);
//            }else{
//                FormandoProdutosEServicosCateriasTipos::create(['fps_id' => $id, 'category_id' => 1, 'quantity' => 1]);
//            }

            foreach ($e->categorias_tipos as $cats){

                if($cats->category_id == 1){
                    $total_convites += ($cats->quantity * $e->amount);
                }elseif($cats->category_id == 2){
                    $total_mesas += ($cats->quantity * $e->amount);
                }

            }

        }
        return ['vendas' => $vendas, 'convites' => $total_convites,  'mesas' => ($total_mesas/10)];

    }

    public static function veriricaValoresEDescontosAtuais($prod){

        $date_inicio = date('Y-m-d H:i:s');
        $products = ProductAndService::where('id', $prod)->get()->toArray();
        foreach ($products as $p){

            $product[$p['id']] = $p;

            $values = ProductAndServiceValues::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s', strtotime($date_inicio)))
                ->where('date_end', '>', date('Y-m-d H:i:s', strtotime($date_inicio)))
                ->get();

            if($values->count() <= 0){
                return false;
            }
            $values = ProductAndServiceValues::where('products_and_services_id', $p['id'])
                ->where('date_start', '<=', date('Y-m-d H:i:s', strtotime($date_inicio)))
                ->where('date_end', '>', date('Y-m-d H:i:s', strtotime($date_inicio)))
                ->first()->toArray();

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
            if($max_parcel_discount >= $parcel_temp_max){
                $valor_termo = $product[$p['id']]['values']['value'] - ($product[$p['id']]['values']['value'] * ($max_parcel_porc/100));
            }

            $product[$p['id']]['termo'] = ProdutosEServicosTermo::where('id', $p['termo_id'])->get()->toArray()[0];
            $product[$p['id']]['termo'] = str_replace('[[=valor]]', number_format($valor_termo, 2, ',', '.'), $product[$p['id']]['termo']);

            //$product[$p['id']]['discounts'] = $discounts;
            return $product;


        }

    }

}
