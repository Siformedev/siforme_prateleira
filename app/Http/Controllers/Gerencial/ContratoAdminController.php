<?php

namespace App\Http\Controllers\Gerencial;

use App\Contract;
use App\FormandoProdutosEServicos;
use App\FormandoProdutosParcelas;
use App\Forming;
use App\ProductAndService;
use App\ProductAndServiceValues;
use App\ProdutosEServicosTermo;
use App\Services\ProdutosService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ContratoAdminController extends Controller
{
    public function panel(Contract $contract)
    {
        return view('gerencial.contrato.admin.panel', ['contract' => $contract]);
    }

    public function dashboard($contract)
    {

        $contract = Contract::find($contract);
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


        foreach ($formings as $forming) {

            @$cursos[$forming->course->name] += 1;


            if ($daysDifSignature <= 30) {
                @$dataAdesao[date('d/m/Y', strtotime($forming->dt_adesao))] += 1;
            } else {
                @$dataAdesao[date('m/Y', strtotime($forming->dt_adesao))] += 1;
            }



            $parcels_all = FormandoProdutosParcelas::where('formandos_id', $forming->id)->get();
            $valor_pago_all = 0;
            foreach ($parcels_all as $parcel_all) {
                if (isset($parcel_all->pagamento)) {
                    $valor_pago_all += $parcel_all->pagamento->sum('valor_pago');
                }
            }

            if ($valor_pago_all <= 0) {
                $formingArray['pendentes'] += 1;
                $formingArray['total'] += 1;
            } else {

                $parcels = FormandoProdutosParcelas::where('formandos_id', $forming->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
                $valor = $parcels->sum('valor');
                $valor_pago = 0;
                foreach ($parcels as $parcel) {
                    if (isset($parcel->pagamento)) {
                        $valor_pago += $parcel->pagamento->sum('valor_pago');
                    }
                }

                $formingArray['total'] += 1;

                if ($valor_pago_all >= 0 and ($valor_pago_all >= $valor)) {
                    $formingArray['adimplentes'] += 1;
                } elseif ($valor_pago_all >= 0 and ($valor_pago_all < $valor)) {
                    $formingArray['inadimplentes'] += 1;
                }
            }
        }

        $i = 1;
        foreach ($dataAdesao as $key => $data) {
            @$dataAdesaoGrafico['key'] .=  '"' . $key . '"';
            @$dataAdesaoGrafico['data'] .=  '"' . $data . '"';
            if ($i < count($dataAdesao)) {
                @$dataAdesaoGrafico['key'] .=  ",";
                @$dataAdesaoGrafico['data'] .=  ",";
            }
            $i++;
        }

        $graf_courses_title = "[";
        $graf_courses_quant = "[";
        ksort($cursos);
        foreach ($cursos as $curso => $quant) {
            $graf_courses_title .= "'{$curso}',";
            $graf_courses_quant .= "{$quant},";
        }
        $graf_courses_title .= "]";
        $graf_courses_quant .= "]";
        $graf_courses_title = str_replace(",]", "]", $graf_courses_title);
        $graf_courses_quant = str_replace(",]", "]", $graf_courses_quant);
        //dd($graf_courses_title, $graf_courses_quant);

        $meta['inalcancado'] = $contract->goal - $formingArray['total'];
        $meta['alcancado'] = $formingArray['total'];

        $formingNowDay = Forming::where('contract_id',  $contract->id)->where('dt_adesao', '=', date('Y-m-d'))->get();


        return view('gerencial.contrato.admin.dashboard', compact('formingArray', 'dataAdesaoGrafico', 'meta', 'formingNowDay', 'contract', 'graf_courses_title', 'graf_courses_quant'));
    }

    public function formings(Contract $contract)
    {

        $formings = $contract->formings->where('status', 1);
        //dd($formings);

        $formingStatus = [];
        $formingPerc = [];

        // dd($formings, $contract->formings);

        foreach ($formings as $forming) {
            //dd($forming);
            $valor = 0;
            $valor_pago_all = 0;
            $parcels = FormandoProdutosParcelas::where('formandos_id', $forming->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
            $parcelsTotal = FormandoProdutosParcelas::where('formandos_id', $forming->id)->get();
            foreach ($parcelsTotal as $parcel_all) {
                if (isset($parcel_all->pagamento)) {
                    $valor_pago_all += $parcel_all->pagamento->sum('valor_pago');
                }
            }
            $valorTotal = $parcelsTotal->sum('valor');
            $valor = $parcels->sum('valor');
            $valor_pago = 0;
            foreach ($parcels as $parcel) {
                //dd($parcel->pagamento);
                if (isset($parcel->pagamento)) {
                    $valor_pago += $parcel->pagamento->sum('valor_pago');
                }
            }

            @$perc_pago = number_format((($valor_pago_all / $valorTotal) * 100), 0);
            //dd($valorTotal, $valor_pago, $perc_pago);
            if (!$perc_pago or empty($perc_pago)) {
                $perc_pago = 0;
            }
            $formingPerc[$forming->id] = (int) $perc_pago;

            if ($valor_pago_all <= 0) {
                $formingStatus[$forming->id] = 'Pendente';
                $formingLabel[$forming->id] = 'info';
            } elseif ($valor_pago_all >= 0 and ($valor_pago_all >= $valor)) {
                $formingStatus[$forming->id] = 'Adimplente';
                $formingLabel[$forming->id] = 'success';
            } elseif ($valor_pago_all >= 0 and ($valor_pago_all < $valor)) {
                $formingStatus[$forming->id] = 'Inadimplente';
                $formingLabel[$forming->id] = 'danger';
            } else {
                $formingStatus[$forming->id] = 'Pendente';
                $formingLabel[$forming->id] = 'info';
            }
        }

        return view('gerencial.formandos', compact('contract', 'formingStatus', 'formingPerc', 'formings', 'formingLabel'));
    }

    public function prod(Contract $contract, Request $request)
    {
        $active = $request->get('active');
        if (isset($active) && $active > 0) {
            $prod = ProductAndService::find($active);
            $prod->status = 1;
        }

        $inactive = $request->get('inactive');
        if (isset($inactive) && $inactive > 0) {
            $prod = ProductAndService::find($inactive);
            $prod->status = 0;
        }

        $produtos = ProductAndService::where('contract_id', $contract->id)->get();
        $categorias = \App\CategoriasProdutosEServicos::all()->toArray();
        foreach ($categorias as $categoria) {
            $categoriaArray[$categoria['id']] = $categoria['name'];
        }
        //dd($categoriaArray);
        return view('gerencial.contrato.admin.prod', ['contract' => $contract, 'produtos' => $produtos, 'categorias' => $categoriaArray]);
    }

    public function prodEdit(Request $request, $prod)
    {

        $productValues = ProdutosService::veriricaValoresEDescontosAtuais($prod);
        //dd($request->session());
        $prod = ProductAndService::find($prod);
        $categorias = \App\CategoriasProdutosEServicos::all()->toArray();

        $parcels = ProductAndServiceValues::where('products_and_services_id', $prod->id)->orderBy('date_start')->get();
        foreach ($categorias as $categoria) {
            $categoriaArray[$categoria['id']] = $categoria['name'];
        }
        //dd($categoriaArray);
        return view('gerencial.contrato.admin.prod_edit', compact('prod', 'categoriaArray', 'parcels', 'productValues'));
    }

    public function prodRemove(Request $request, $prod){
        dd($prod);
    }

    public function prodEditPost(Request $request, $prod)
    {
        /*atualiza a descricao*/
        $params['description'] = $request->get('description');
        $produto = ProductAndService::find($prod);
        $produto->update($params);

        if ($request->has('date_start')) {

            $date_start = $request->get('date_start');
            $date_end = $request->get('date_end');
            $maximum_parcels = $request->get('max_parcels');
            $value = $request->get('value');
            $date_end = $request->get('date_end');
            $date_start = Str::replaceFirst('T', ' ', $date_start);
            $date_end = Str::replaceFirst('T', ' ', $date_end);
            // dd($date_start, $date_end);
            $date_start = Carbon::createFromFormat('Y-m-d H:i', $date_start)->toDateTimeString();
            $date_end = Carbon::createFromFormat('Y-m-d H:i', $date_end)->toDateTimeString();

            //$prod = ProductAndService::find($prod);
            //$categorias = \App\CategoriasProdutosEServicos::all()->toArray();

            $parcels = ProductAndServiceValues::where('products_and_services_id', $prod)
                ->where('date_start', '<=', $date_start)
                ->where('date_end', '>=', $date_end)
                ->get();

            if ($parcels->count() > 0) {
                session()->flash('parcel_error', 1);
                session()->flash('parcel_msg', 'Já existe parcelas para este período!');
                return redirect()->route('gerencial.contrato.admin.prod.edit', ['prod' => $prod]);
            }
            /*era create, eu mudei para update, precisa validar*/
            ProductAndServiceValues::update([
                'products_and_services_id' => $prod,
                'maximum_parcels' => $maximum_parcels,
                'value' => $value,
                'date_start' => $date_start,
                'date_end' => $date_end,
            ]);

            session()->flash('parcel_ok', 1);
            session()->flash('parcel_msg', 'Parcela criada com sucesso!');
        }

        return redirect()->route('gerencial.contrato.admin.prod.edit', ['prod' => $prod]);
    }

    public function prodEditParcelDel(Request $request, $prod, $parcel)
    {

        $parcel = ProductAndServiceValues::where('products_and_services_id', $prod)->where('id', $parcel)->first();
        $parcel->delete();

        session()->flash('parcel_ok', 1);
        session()->flash('parcel_msg', 'Parcela excluída com sucesso!');
        return redirect()->route('gerencial.contrato.admin.prod.edit', ['prod' => $prod]);
    }

    public function prodCreate(Contract $contract)
    {
        $produtos = ProductAndService::where('contract_id', $contract->id)->get();
        $categorias = \App\CategoriasProdutosEServicos::all()->toArray();
        foreach ($categorias as $categoria) {
            $categoriaArray[$categoria['id']] = $categoria['name'];
        }
        $termos = ProdutosEServicosTermo::all()->toArray();
        foreach ($termos as $termo) {
            $termoArray[$termo['id']] = $termo['titulo'];
        }
        //dd($categoriaArray);
        return view('gerencial.contrato.admin.prod_create', ['contract' => $contract, 'produtos' => $produtos, 'categorias' => $categoriaArray, 'termos' => $termoArray]);
    }

    public function prodStore(Request $request, Contract $contract)
    {
        $this->validate($request, [
            "name" => "required",
            "description" => "required",
            "img" => "required",
            "value" => "required",
            "maximum_parcels" => "required",
            "category_id" => "required",
            "reset_igpm" => "required",
            "termo_id" => "required",
            "date_start" => "required",
            "date_end" => "required",
            "limit_per_purchase" => "required",
            "limit_per_form" => "required",
            "stock" => "required",
        ]);
        $image = Input::file('img');
        if ($image) {
            $dirname = 'assets/uploads/produtos/';
            $filename  = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path($dirname . $filename);
            $image = Image::make($image->getRealPath())->resize(200, 200)->save($path);
            $dirimage = $dirname . $image->basename;
        }
        $data = $request->all();
        $data['contract_id'] = $contract->id;
        $data['img'] = $dirimage;
        $data['value'] = str_replace(",", ".", $data['value']);
        unset($data['_token']);
        $prod = ProductAndService::create($data);

        ProductAndServiceValues::create([
            'products_and_services_id' => $prod->id,
            'maximum_parcels' => $data['maximum_parcels'],
            'value' => $data['value'],
            'date_start' => $data['date_start'],
            'date_end' => $data['date_end'],
        ]);

        $request->session()->flash('message', 'O Produto ' . $prod->name . ' foi cadastrado com sucesso!');
        return redirect()->route('gerencial.contrato.admin.prod', ['contract' => $contract->id]);
    }

    public function finance(Request $request, Contract $contract)
    {
        $total = [];
        $total['parcela'] = 0;
        $total['pago'] = 0;
        $total_forming['parcela'] = 0;
        $total_forming['pago'] = 0;

        $formings_data = [];

        $formings = Forming::where('contract_id', $contract->id)->get();
        foreach ($formings as $forming) {
            $formings_data[$forming->id]['nome'] = $forming->nome . ' ' . $forming->sobrenome;

            $products = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('category_id', '<>', 2)->get();
            foreach ($products as $product) {

                $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->get();
                if ($parcels) {
                    foreach ($parcels as $parcel) {
                        $total['parcela'] += $parcel->valor;
                        $total_forming['parcela'] += $parcel->valor;
                        if (isset($parcel->pagamento)) {
                            foreach ($parcel->pagamento as $pagamentos) {

                                //Pagamento por tipo
                                if (!isset($formings_data[$forming->id]['pgs'][$pagamentos->typepaind_type])) {
                                    $formings_data[$forming->id]['pgs'][$pagamentos->typepaind_type] = $pagamentos->valor_pago;
                                } else {
                                    $formings_data[$forming->id]['pgs'][$pagamentos->typepaind_type] += $pagamentos->valor_pago;
                                }

                                //taxa
                                if ($pagamentos->valor_pago > 0) {
                                    if (!isset($formings_data[$forming->id]['taxa'])) {
                                        $formings_data[$forming->id]['taxa'] = 2.49;
                                    } else {
                                        $formings_data[$forming->id]['taxa'] += 2.49;
                                    }
                                }
                                $total['pago'] += $pagamentos->valor_pago;
                                $total_forming['pago'] += $pagamentos->valor_pago;
                            }
                        }
                    }
                }
            }
            $formings_data[$forming->id]['parcela'] = $total_forming['parcela'];
            $formings_data[$forming->id]['pago'] = $total_forming['pago'];
            $total_forming['parcela'] = 0;
            $total_forming['pago'] = 0;

        
        }

        return view('gerencial.contrato.admin.finance', compact('formings_data', 'contract', 'total'));
    }

    public function finance2(Request $request, Contract $contract)
    {
        

        $total = [];
        $total['parcela'] = 0;
        $total['pago'] = 0;
        $total_forming['parcela'] = 0;
        $total_forming['pago'] = 0;

        $formings_data = [];

        $formings = Forming::where('contract_id', $contract->id)->get();
        foreach ($formings as $forming) {
            $formings_data[$forming->id]['nome'] = $forming->nome . ' ' . $forming->sobrenome;

            $products = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('category_id', '=', 1)->get();


            foreach ($products as $product) {

                $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->get();
                if ($parcels) {
                    foreach ($parcels as $parcel) {
                        $total['parcela'] += $parcel->valor;
                        $total_forming['parcela'] += $parcel->valor;
                        if (isset($parcel->pagamento)) {
                            foreach ($parcel->pagamento as $pagamentos) {


                                @$formings_data[$forming->id]['pgs'][$pagamentos->typepaind_type] += $pagamentos->valor_pago;


                                if ($pagamentos->valor_pago > 0) {

                                    if ($pagamentos->typepaind_type) {
                                        if ($pagamentos->typepaind_type == 'App\PagamentosBoleto') {
                                            @$formings_data[$forming->id]['taxa'] += 2.49;
                                        } elseif ($pagamentos->typepaind_type == 'App\PagamentosCartao') {
                                            @$formings_data[$forming->id]['taxa'] += $pagamentos->typepaind->taxes_paid;
                                        }
                                    }
                                }

                                $total_forming['pago'] += $pagamentos->valor_pago;
                                $total['pago'] += $pagamentos->valor_pago;
                            }
                        }
                    }
                }
            }

            $formings_data[$forming->id]['parcela'] = $total_forming['parcela'];
            $formings_data[$forming->id]['pago'] = $total_forming['pago'];
            $total_forming['parcela'] = 0;
            $total_forming['pago'] = 0;
        }

        // dd($formings_data);

        return view('gerencial.contrato.admin.finance', compact('formings_data', 'contract', 'total'));
    }

    public function financeAccumulatedMonthToMonth(Request $request, Contract $contract)
    {
        $vencs = [];
        $total = [];
        $total['parcela'] = 0;
        $total['pago'] = 0;
        $total_forming['parcela'] = 0;
        $total_forming['pago'] = 0;

        $formings_data = [];

        $formings = Forming::where('contract_id', $contract->id)->get();
        foreach ($formings as $forming) {
            $formings_data[$forming->id]['nome'] = $forming->nome . ' ' . $forming->sobrenome;

            $products = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('category_id', '=', 1)->get();
            foreach ($products as $product) {

                $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->get();
                if ($parcels) {
                    foreach ($parcels as $parcel) {
                        $total['parcela'] += $parcel->valor;
                        $total_forming['parcela'] += $parcel->valor;
                        if (isset($parcel->pagamento)) {
                            foreach ($parcel->pagamento as $pagamentos) {


                                @$formings_data[$forming->id]['pgs'][$pagamentos->typepaind_type] += $pagamentos->valor_pago;


                                if ($pagamentos->valor_pago > 0) {

                                    @$date_month = date("m/Y", strtotime($pagamentos->typepaind->due_date));
                                    if ($pagamentos->typepaind_type) {
                                        if ($pagamentos->typepaind_type == 'App\PagamentosBoleto') {
                                            @$vencs[$date_month] += ($pagamentos->valor_pago - 2.49);
                                        } elseif ($pagamentos->typepaind_type == 'App\PagamentosCartao') {
                                            @$vencs[$date_month] += ($pagamentos->valor_pago - $pagamentos->typepaind->taxes_paid);
                                        }
                                    }
                                }

                                $total_forming['pago'] += $pagamentos->valor_pago;
                                $total['pago'] += $pagamentos->valor_pago;
                            }
                        }
                    }
                }
            }
            $formings_data[$forming->id]['parcela'] = $total_forming['parcela'];
            $formings_data[$forming->id]['pago'] = $total_forming['pago'];
            $total_forming['parcela'] = 0;
            $total_forming['pago'] = 0;
        }
        echo "<table border='1'>";
        foreach ($vencs as $key => $venc) {
            echo "<tr>";
            echo "<td>" . $key . "</td>";
            echo "<td>" . $venc . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        //return view('gerencial.contrato.admin.finance', compact('formings_data', 'contract', 'total'));
        //@$vencs[$pagamentos->typepaind->due_date]+= ($pagamentos->valor_pago - 2.49);

    }

    public function config_tipo_pagamento(Contract $contract){
        return view('gerencial.contrato.admin.tipo_pagamento', compact('contract'));
    }

    public function store_tipo_pagamento(Request $request){

      
        $contract = Contract::find($request->contrato);
        $contract->tipo_pagamento = $request->tipo_pagamento;
        $contract->save();

        return view('gerencial.contrato.admin.panel', ['contract' => $contract]);   
     }
}
