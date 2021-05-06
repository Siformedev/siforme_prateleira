<?php

namespace App\Http\Controllers;

use App\AuditAndLog;
use App\Chamado;
use App\ConfigApp;
use App\Contract;
use App\Event;
use App\FormandoProdutosEServicos;
use App\FormandoProdutosParcelas;
use App\Forming;
use App\GiftRequests;
use App\Helpers\FileHelper;
use App\ParcelasPagamentos;
use App\ProdutosEServicosTermo;
use App\Services\GiftRequestServices;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComissaoController extends Controller
{

    public function painel()
    {

        $contract = Contract::find(auth()->user()->userable->contract_id);
        $formingArray['total'] = 0;
        $formingArray['pendentes'] = 0;
        $formingArray['inadimplentes'] = 0;
        $formingArray['adimplentes'] = 0;

        $dataAdesao = [];
        $dataAdesaoGrafico = [];
        /** @var Forming $formings */
        $formings = $contract->formings->where('status', 1);
        $cursos = [];
        $dateSignature = Carbon::parse($contract->signature_date);
        $daysDifSignature = $dateSignature->diffInDays(Carbon::today());


        foreach ($formings as $forming){

            @$cursos[$forming->course->name] += 1;

            if($daysDifSignature <= 30){
                @$dataAdesao[date('d/m/Y', strtotime($forming->dt_adesao))]+= 1;
            }else{
                @$dataAdesao[date('m/Y', strtotime($forming->dt_adesao))]+= 1;
            }

            $product = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('category_id', 1)->first();
            //dd($forming->id);
            if( isset($product->id) ){
                $parcels_all = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->where('formandos_id', $forming->id)->get();
            }else{
                $parcels_all = FormandoProdutosParcelas::where('formandos_produtos_id', $product['id'])->where('formandos_id', $forming->id)->get();
            }
            
            $valor_pago_all = 0;
            foreach ($parcels_all as $parcel_all){
                if(isset($parcel_all->pagamento)){
                    $valor_pago_all+= $parcel_all->pagamento->sum('valor_pago');
                }

            }

            if($valor_pago_all <= 0){
                $formingArray['pendentes']+= 1;
                $formingArray['total']+= 1;
            }else{

                $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->where('formandos_id', $forming->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
                $valor = $parcels->sum('valor');
                $valor_pago = 0;
                foreach ($parcels as $parcel){
                    if(isset($parcel->pagamento)){
                        $valor_pago+= $parcel->pagamento->sum('valor_pago');
                    }

                }

                $formingArray['total']+= 1;

                if ($valor_pago_all >= 0 and ($valor_pago_all >= $valor)){
                    $formingArray['adimplentes']+= 1;
                }elseif ($valor_pago_all >= 0 and ($valor_pago_all < $valor)){
                    $formingArray['inadimplentes']+= 1;
                }
            }

        }





        $i=1;
        foreach ($dataAdesao as $key => $data){
            @$dataAdesaoGrafico['key'].=  '"'.$key.'"';
            @$dataAdesaoGrafico['data'].=  '"'.$data.'"';
            if($i < count($dataAdesao)){
                @$dataAdesaoGrafico['key'].=  ",";
                @$dataAdesaoGrafico['data'].=  ",";
            }
            $i++;
        }

        $graf_courses_title = "[";
        $graf_courses_quant = "[";
        ksort($cursos);
        foreach ($cursos as $curso => $quant){
            $graf_courses_title.= "'{$curso}',";
            $graf_courses_quant.= "{$quant},";
        }
        $graf_courses_title.= "]";
        $graf_courses_quant.= "]";
        $graf_courses_title = str_replace(",]", "]", $graf_courses_title);
        $graf_courses_quant = str_replace(",]", "]", $graf_courses_quant);
        //dd($graf_courses_title, $graf_courses_quant);

        $meta['inalcancado'] = $contract->goal - $formingArray['total'];
        $meta['alcancado'] = $formingArray['total'];

        $formingNowDay = Forming::where('contract_id',  $contract->id)->where('dt_adesao', '=', date('Y-m-d'))->get();


        return view('comissao.painel', compact('formingArray', 'dataAdesaoGrafico', 'meta', 'formingNowDay', 'contract', 'graf_courses_title', 'graf_courses_quant'));
    }

    public function formandos()
    {
        $contract = Contract::find(auth()->user()->userable->contract_id);
        $formings = $contract->formings->where('status', 1);
        //dd($formings);

        $formingStatus = [];
        $formingPerc = [];

       // dd($formings, $contract->formings);

        foreach ($formings as $forming){
            //dd($forming);
            $valor = 0;
            $valor_pago_all = 0;
            $product = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('category_id', 1)->first();

if( !isset($product->id) ){
dd($forming->id);
}

            $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
            $parcelsTotal = FormandoProdutosParcelas::where('formandos_id', $forming->id)->where('formandos_produtos_id', $product->id)->get();
            foreach ($parcelsTotal as $parcel_all){
                if(isset($parcel_all->pagamento)){
                    $valor_pago_all+= $parcel_all->pagamento->sum('valor_pago');
                }
            }
            $valorTotal = $parcelsTotal->sum('valor');
            $valor = $parcels->sum('valor');
            $valor_pago = 0;
            foreach ($parcels as $parcel){
                //dd($parcel->pagamento);
                if(isset($parcel->pagamento)){
                    $valor_pago+= $parcel->pagamento->sum('valor_pago');
                }
            }

            @$perc_pago = number_format((($valor_pago_all/ $valorTotal) * 100), 0);
            //dd($valorTotal, $valor_pago, $perc_pago);
            if(!$perc_pago or empty($perc_pago)){
                $perc_pago = 0;
            }
            $formingPerc[$forming->id] = (int)$perc_pago;

            if($valor_pago_all <= 0){
                $formingStatus[$forming->id] = 'Pendente';
                $formingLabel[$forming->id] = 'info';
            }elseif ($valor_pago_all >= 0 and ($valor_pago_all >= $valor)){
                $formingStatus[$forming->id] = 'Adimplente';
                $formingLabel[$forming->id] = 'success';
            }elseif ($valor_pago_all >= 0 and ($valor_pago_all < $valor)){
                $formingStatus[$forming->id] = 'Inadimplente';
                $formingLabel[$forming->id] = 'danger';
            }else{
                $formingStatus[$forming->id] = 'Pendente';
                $formingLabel[$forming->id] = 'info';
            }

        }

        return view('comissao.formandos', compact('contract', 'formingStatus', 'formingPerc', 'formings', 'formingLabel'));
    }

    public function registers()
    {
        $contract = Contract::find(auth()->user()->userable->contract_id);
        $registers = $contract->registers;

        /** @var Collection $count_registers */
        $count_registers_0 = $contract->registers;
        $count_registers_1 = $contract->registers;
        $count_registers_0 = $count_registers_0->where('checked', 0)->count();
        $count_registers_1 = $count_registers_1->where('checked', 1)->count();

        $cpfs = Forming::where('contract_id', auth()->user()->userable->contract_id)->get(['cpf'])->pluck(['cpf'])->toArray();

        return view('comissao.registers', compact('contract', 'registers', 'count_registers_0', 'count_registers_1', 'cpfs'));
    }

    public function formandosCanceled()
    {
        $contract = Contract::find(auth()->user()->userable->contract_id);
        $formings = $contract->formings->whereIn('status', [6,7]);
        //dd($formings);

        $formingStatus = [];
        $formingPerc = [];

        // dd($formings, $contract->formings);

        foreach ($formings as $forming){
            //dd($forming);
            $valor = 0;
            $parcels = FormandoProdutosParcelas::where('formandos_id', $forming->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
            $parcelsTotal = FormandoProdutosParcelas::where('formandos_id', $forming->id)->get();
            $valorTotal = $parcelsTotal->sum('valor');
            $valor = $parcels->sum('valor');
            $valor_pago = 0;
            foreach ($parcels as $parcel){
                if(isset($parcel->pagamento)){
                    $valor_pago+= $parcel->pagamento->sum('valor_pago');
                }
            }

            @$perc_pago = number_format((($valor_pago/ $valorTotal) * 100), 2, '.', '');
            //dd($valorTotal, $valor_pago, $perc_pago);
            if(!$perc_pago or empty($perc_pago)){
                $perc_pago = 0;
            }
            $formingPerc[$forming->id] = (int)$perc_pago;

            if($valor_pago <= 0){
                $formingStatus[$forming->id] = 'Pendente';
            }elseif ($valor_pago >= 0 and ($valor_pago >= $valor)){
                $formingStatus[$forming->id] = 'Adimplente';
            }elseif ($valor_pago >= 0 and ($valor_pago < $valor)){
                $formingStatus[$forming->id] = 'Inadimplente';
            }else{
                $formingStatus[$forming->id] = 'Pendente';
            }

        }

        return view('comissao.formandos_canceled', compact('contract', 'formingStatus', 'formingPerc', 'formings'));
    }

    public function formandosShow(Forming $forming)
    {
        $contract = Contract::find(auth()->user()->userable->contract_id);
        if($forming->contract_id != $contract->id){
            return redirect()->route('erro.404');
            //die('Sem permissão');
        }

        $products = [];
        $prods = $forming->products->where('status', 1);
        foreach ($prods as $product){

            $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
            $parcelsTotal = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->get();
            $valorTotal = $parcelsTotal->sum('valor');
            $valor = 0;
            $valor_pago = 0;
            foreach ($parcelsTotal as $parcel){
                if(isset($parcel->pagamento)){
                    $valor_pago+= $parcel->pagamento->sum('valor_pago');
                }
                $date = date("Y-m-d", strtotime($parcel->dt_vencimento));
                if($date > date("Y-m-d")){
                    continue;
                }
                $valor+= $parcel->valor;
            }
            @$perc_pago = number_format((($valor_pago/ $valorTotal) * 100), 0);
            //dd($valorTotal, $valor_pago, $perc_pago);
            $products['perc'][$product->id] = $perc_pago;

            if($valor_pago <= 0){
                $products[$product->id] = 'Pendente';
                $formingLabel[$product->id] = 'info';
            }elseif ($valor_pago >= 0 and ($valor_pago >= $valor)){
                $products[$product->id] = 'Adimplente';
                $formingLabel[$product->id] = 'success';
            }elseif ($valor_pago >= 0 and ($valor_pago < $valor)){
                $products[$product->id] = 'Inadimplente';
                $formingLabel[$product->id] = 'danger';
            }else{
                $products[$product->id] = 'Pendente';
                $formingLabel[$product->id] = 'info';
            }

        }

        //Cancelados
        $products_cancel = [];
        $prods_cancel = $forming->products->where('status', 7);
        foreach ($prods_cancel as $product_cancel){

            $parcels_cancel = FormandoProdutosParcelas::where('formandos_produtos_id', $product_cancel->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
            $parcelsTotal_cancel = FormandoProdutosParcelas::where('formandos_produtos_id', $product_cancel->id)->get();
            $valorTotal_cancel = $parcelsTotal_cancel->sum('valor');
            $valor_cancel = 0;
            $valor_pago_cancel = 0;
            foreach ($parcelsTotal_cancel as $parcel_cancel){
                if(isset($parcel_cancel->pagamento)){
                    $valor_pago_cancel+= $parcel_cancel->pagamento->sum('valor_pago');
                }
                $date_cancel = date("Y-m-d", strtotime($parcel_cancel->dt_vencimento));
                if($date_cancel > date("Y-m-d")){
                    continue;
                }
                $valor_cancel+= $parcel_cancel->valor;
            }
            @$perc_pago_cancel = number_format((($valor_pago_cancel/ $valorTotal_cancel) * 100), 0);
            //dd($valorTotal, $valor_pago, $perc_pago);
            $products_cancel['perc'][$product->id] = $perc_pago_cancel;

            if($valor_pago_cancel <= 0){
                $products_cancel[$product->id] = 'Pendente';
                $formingLabel_cancel[$product->id] = 'info';
            }elseif ($valor_pago_cancel >= 0 and ($valor_pago_cancel >= $valor)){
                $products_cancel[$product->id] = 'Adimplente';
                $formingLabel_cancel[$product->id] = 'success';
            }elseif ($valor_pago_cancel >= 0 and ($valor_pago < $valor)){
                $products_cancel[$product->id] = 'Inadimplente';
                $formingLabel_cancel[$product->id] = 'danger';
            }else{
                $products_cancel[$product->id] = 'Pendente';
                $formingLabel_cancel[$product->id] = 'info';
            }

        }
       //dd($products_cancel);

        return view('comissao.formando_show', compact('forming', 'products', 'formingLabel', 'prods', 'products_cancel', 'formingLabel_cancel', 'prods_cancel'));
    }

    public function formandosShowItem(FormandoProdutosEServicos $prod)
    {
        $contract = auth()->user()->userable->contract_id;
        $forming = Forming::find($prod->forming_id);
        if($forming->contract_id != $contract){die('acesso negado!');}

        $parcelas = FormandoProdutosParcelas::where('formandos_produtos_id', $prod['id'])->get()->toArray();
        $produtos = $prod->get()->toArray();
        $termo = ProdutosEServicosTermo::where('id', $prod['termo_id'])->get()->toArray()[0];
        $termo = str_replace('[[=valor]]', number_format($prod->valorFinal(), 2, ',', '.'), $termo);

        $date = Carbon::now();
        $dateLimit = Carbon::now();
        $dateLimit->addDays(15);

        $pagamentos = [];
        foreach ($parcelas as $parcela){
            $ret = ParcelasPagamentos::where('parcela_id', $parcela['id'])->where('deleted', 0)->first();
            if($ret){
                $pagamentos[$parcela['id']] = $ret;
            }

        }

        return view('comissao.formando_show_item', compact('prod','parcelas', 'termo', 'pagamentos', 'dateLimit'));
    }

    public function orcamento()
    {
        return view('comissao.orcamento');
    }

    public function orcamentoItem()
    {
        return view('comissao.orcamento_item');
    }

    public function contrato(Request $request)
    {
        $contract = Contract::find(auth()->user()->userable->contract_id);
        if($request->get('downcontract') == 'ok'){
            $path = storage_path().'/app/public/'.$contract->filepath;
            FileHelper::forcarDownload($path);
        }
        return view('comissao.contrato');
    }

    public function chamados()
    {
        $formando_id = \auth()->user()->userable->id;
        $chamados_abertos = Chamado::where('forming_id', '=', $formando_id)->where('status', '=', 1)->where('setor_chamado', '=', 2)->get()->toArray();
        $chamados_finalizados = Chamado::where('forming_id', '=', $formando_id)->where('status', '=', 2)->get()->toArray();
        return view('comissao.chamados', compact('chamados_abertos', 'chamados_finalizados'));
    }

    public function chamadosAbrir()
    {

        return view('comissao.chamado_abrir');
    }

    public function chamadosStore(Request $request)
    {
        $this->validate($request, [
            "setor_chamado" => "required",
            "assunto_chamado" => "required|not_in:0",
            "titulo" => "required",
            'descricao' => 'required'
        ]);

        $dt_now = Carbon::now();
        var_dump($dt_now);
        $dt_now->addDays(2);
        if($dt_now->dayOfWeek == 6){
            $dt_now->addDays(2);
        }elseif ($dt_now->dayOfWeek == 0){
            $dt_now->addDays(1);
        }
        $dataDb = $request->all();
        $dataDb['data_limite'] = $dt_now->format('Y-m-d');
        $dataDb['forming_id'] = \auth()->user()->userable->id;
        $dataDb['status'] = 1;
        Chamado::create($dataDb);
        return redirect()->route('comissao.chamados');
    }

    public function chamadosShow(Chamado $chamado)
    {
        return view('comissao.chamados_show', compact('chamado'));
    }

    public function chamadosConversasStore(Request $request, Chamado $chamado)
    {
        $dataDb = $request->all();
        $dataDb['user_id'] = \auth()->user()->id;
        $chamado->conversas()->create($dataDb);
        return redirect()->route('comissao.chamados.show', ['chamado' => $chamado->id]);

    }

    public function vendasExtras(Request $request)
    {
        $name = $request->get('name');
        $contract = Contract::find(auth()->user()->userable->contract_id);
        $productsGroup = FormandoProdutosEServicos::where('contract_id', $contract->id)->where('status', 1)->where('category_id', 6)->groupBy('name')->pluck('name');
        if(empty($name) || $name === 'all'){
            $vendas = FormandoProdutosEServicos::where('contract_id', $contract->id)->where('status', 1)->where('category_id', 6)->get();
        }else{
            $vendas = FormandoProdutosEServicos::where('contract_id', $contract->id)->where('status', 1)->where('category_id', 6)->where('name', 'LIKE', "%{$name}%")->get();
        }

        return view('comissao.extrassales', compact('vendas', 'productsGroup', 'name'));
    }

    public function event($event)
    {
        $contract = Contract::find(auth()->user()->userable->contract_id);
        $event = Event::where('id', $event)->where('contract_id', $contract->id)->where('status', 1)->first();
        if($event->count()<=0){
            die();
        }

        $formings = Forming::where('contract_id', $contract->id)->where('status', 1)->get(); //TODO: Resolver caso formando cancele não aparece mais na lista de presença

        return view('comissao.event', compact('formings', 'contract', 'event'));

    }

    public function lojinhaVendas()
    {
        $contract = Contract::find(auth()->user()->userable->contract_id);
        $vendas = GiftRequests::where('contract_id', $contract->id)->orderBy('created_at', 'desc')->get();
        $vendasTratadas = [];

        $totals['sold'] = 0;
        $totals['to_receive'] = 0;
        $totals['receiving'] = 0;
        $totals['count'] = $vendas->count();

        foreach ($vendas as $venda){
            $vendaTemp = GiftRequestServices::calculateInfos($venda);

            $totals['sold']+= ($vendaTemp['total'] - $vendaTemp['rate']);
            if($vendaTemp['receiving']){
                $totals['receiving']+= ($vendaTemp['total'] - $vendaTemp['rate']);
            }else{
                $totals['to_receive']+= ($vendaTemp['total'] - $vendaTemp['rate']);

            }

            $vendasTratadas[] = $vendaTemp;
        }

        return view('comissao.lojinha_vendas', compact( 'totals', 'vendasTratadas'));
    }

    public function lojinhaVendasTotal()
    {
        $contract = Contract::find(auth()->user()->userable->contract_id);
        $vendas = GiftRequests::where('contract_id', $contract->id)->orderBy('created_at', 'desc')->get();
        $vendasTratadas = [];

        $totals['sold'] = 0;
        $totals['to_receive'] = 0;
        $totals['receiving'] = 0;
        $totals['count'] = $vendas->count();

        foreach ($vendas as $venda){

            $vendaTemp = GiftRequestServices::calculateInfos($venda);

            $totals['sold']+= ($vendaTemp['total'] - $vendaTemp['rate']);
            if($vendaTemp['receiving']){
                $totals['receiving']+= ($vendaTemp['total'] - $vendaTemp['rate']);
            }else{
                $totals['to_receive']+= ($vendaTemp['total'] - $vendaTemp['rate']);

            }

            $vendasTratadas[] = $vendaTemp;
        }

        return view('comissao.lojinha_vendas_total', compact( 'totals', 'vendasTratadas'));
    }

    public function lojinhaVendaDetalhes($id){
        $contract = Contract::find(auth()->user()->userable->contract_id);
        $requestId = $id;
        $infos = [];
        $request = GiftRequests::where('id', $requestId)->where('status', '>=', 1)->where('contract_id', $contract->id)->first();

        $dataStatusHistoricArray = [];
        foreach($request->statusHistoric()->orderBy('created_at', 'desc')->get() as $re){
            $dataStatusHistoric = [
                'date' => date("d/m/Y H:i", strtotime($re->created_at)),
                'status' => ConfigApp::GiftRequetsStatus()[$re->status],
                'user' =>  $re->user->name,
            ];

            $dataStatusHistoricArray[] = $dataStatusHistoric;
        }
        $infos = GiftRequestServices::calculateInfos($request);

        return view('comissao.lojinha_venda_detalhes', compact('request', 'infos', 'dataStatusHistoricArray'));
    }

    public function lojinhaPedidoImprimir($id){

        $contract = Contract::find(auth()->user()->userable->contract_id);
        $requestId = $id;
        $request = GiftRequests::where('id', $requestId)->where('status', '>=', 1)->where('contract_id', $contract->id)->first();
        $infos = GiftRequestServices::calculateInfos($request);
        $liquido = $request->total - $infos['rate'];
        $recebido = ($infos['receiving'] == true ? "SIM" : "NÃO");
        $status = ConfigApp::GiftRequetsStatus()[$request->status];

        $html = '<html><head><meta charset="utf-8"><title>Imprimir Pedido</title></head>';
        $html.= '<body style="font-family: Arial, Helvetica, sans-serif;">';
        $html.= '<table border="0" cellspacing="0" cellpadding="3" width="100%">';
        $html.= '<tbody>';
        $html.= '<tr>';
        $html.= "<td style='font-size: 24px; text-transform: uppercase'> Pedido Número: {$request->id} </td>";
        $html.= "<td style='font-size: 20px; text-transform: capitalize; text-align: right'> Formando: {$request->forming->nome} {$request->forming->sobrenome} </td>";
        $html.= '</tr>';

        $html.= '<tr>';
        $html.= "<td colspan='2'> <hr> </td>";
        $html.= '</tr>';

        $html.= '<tr>';
        $html.= "
            <td style='border-right: 1px solid #b3b3b3'> 
            Data: ".date("d/m/Y H:i", strtotime($request->created_at))."<br>
            Forma de pagamneto: Cartão de Crédito<br>
            Parcelas: 1<br>
            Status: {$status}
            </td>";
        $html.= "
            <td style='text-align: right'> 
            Total: R$ ".number_format($request->total,2,",", ".")."<br>
            Taxa: R$ ".number_format($infos['rate'],2,",", ".")."<br>
            Liquido: R$ ".number_format($liquido,2,",", ".")."<br>
            Recebido?: {$recebido}<br>
            Data Recebimento: ".date("d/m/Y", strtotime($infos['receiving_date']))."<br>
            </td>";
        $html.= '</tr>';

        $html.= '<tr>';
        $html.= "<td colspan='2'> <hr> </td>";
        $html.= '</tr>';

        $html.= '</tbody>';
        $html.= '</table>';

        //Produtos
        $html.= '<table border="0" cellspacing="0" cellpadding="3" width="100%">';

        $html.= '<thead>';
        $html.= '<tr>';
        $html.= '<th>Foto</th>';
        $html.= '<th>Nome</th>';
        $html.= '<th>Valor</th>';
        $html.= '<th>Quantidade</th>';
        $html.= '<th>Tamanho</th>';
        $html.= '<th>Modelo</th>';
        $html.= '</tr>';
        $html.= '</thead>';
        $html.= '<tbody style="border: 1px solid #b3b3b3">';
        foreach ($request->gifts as $gift){

            $html.= '<tr>';
            $html.= "<td> <img src='".asset('img/portal/gifts/'.$gift->photo)."' style=\"width: 70px; height: 70px;\"> </td>";
            $html.= "<td> {$gift->name} </td>";
            $html.= "<td> ".number_format($gift->price, 2, ",",".")." </td>";
            $html.= "<td style='text-align: center'> {$gift->amount} </td>";
            $html.= "<td> {$gift->size} </td>";
            $html.= "<td> {$gift->model} </td>";
            $html.= '</tr>';

        }

        $html.= '</tbody>';
        $html.= '</table>';

        $html.= '</body>';
        $html.= '</html>';

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();

    }

}
