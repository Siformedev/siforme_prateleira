<?php

namespace App\Http\Controllers\Gerencial;

use App\FormandoProdutosEServicos;
use App\FormandoProdutosParcelas;
use App\Forming;
use App\ParcelasPagamentos;
use App\ProdutosEServicosTermo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\PagamentosBoleto;
use App\Helpers\MainHelper;
use App\Contract;
class FormandoAdminController extends Controller {

    function __construct() {
        parent::__construct();
        $this->helper = new MainHelper();
    }

    private function exportExcellFile($formings) {

        $helper = new MainHelper();

        ob_start();

        echo "<table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Curso</th>
                            <th>Periodo</th>
                            <th >Data e Hora Adesão</th>
                            <th >% Pago</th>
                            <th ></th>
                            <th >Status</th>
                            <th >Adquiriu Album</th>
                        
                        </tr>
                    </thead>";

        foreach ($formings as $forming) {



            $valor = 0;
            $valor_pago_all = 0;
            $product = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('category_id', 1)->first();
            if (isset($product->id)) {
                $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
                $parcelsTotal = FormandoProdutosParcelas::where('formandos_id', $forming->id)->where('formandos_produtos_id', $product->id)->get();
                foreach ($parcelsTotal as $parcel_all) {
                    if (isset($parcel_all->pagamento)) {
                        $valor_pago_all += $parcel_all->pagamento->sum('valor_pago');
                    }
                }
                $valorTotal = $parcelsTotal->sum('valor');
                $valor = $parcels->sum('valor');
                $valor_pago = 0;
                foreach ($parcels as $parcel) {
                    if (isset($parcel->pagamento)) {
                        $valor_pago += $parcel->pagamento->sum('valor_pago');
                    }
                }
                @$perc_pago = number_format((($valor_pago_all / $valorTotal) * 100), 0);
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


            $albuns = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('category_id', '2')->get();
            if (isset(\App\ConfigApp::Periodos()[$forming->periodo_id])) {
                $periodo = \App\ConfigApp::Periodos()[$forming->periodo_id];
            } else {
                $periodo = '';
            }
            ?>
            <tr>
                <td><span class="font-size-16 font-weight-bold"><?= $forming->nome; ?> <?= $forming->sobrenome; ?></span></td>
                <td><?= \App\Course::find($forming->curso_id)['name']; ?></td>
                <td><?= $periodo; ?></td>
                <td><?= $helper->toMysqlDate($forming->created_at, false); ?></td>
                <td style="width: 20px;<?= isset($mostradetalhes) ? 'display:none;' : ''; ?>"> <?= isset($formingPerc[$forming->id]) ? $formingPerc[$forming->id] : ''; ?>%
                </td>
                <td style="width: 60px; <?= isset($mostradetalhes) ? 'display:none;' : ''; ?>">
                    <progress class="progress progress-success" value="<?= isset($formingPerc[$forming->id]) ? $formingPerc[$forming->id] : ''; ?>" max="100"><?= isset($formingPerc[$forming->id]) ? $formingPerc[$forming->id] : ''; ?>%</progress>
                </td>
                <td style="<?= isset($mostradetalhes) ? 'display:none;' : ''; ?>"><span class="label label-<?= isset($formingPerc[$forming->id]) ? $formingPerc[$forming->id] : ''; ?>"><?= isset($formingPerc[$forming->id]) ? $formingPerc[$forming->id] : ''; ?></span> </td>
                <td><?= (count($albuns) > 0) ? 'Sim' : 'Não'; ?></td>

            </tr>
            <?php
        }
        echo "</table>";
        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=relatorioformandos.xls");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        echo ob_get_clean();
    }

    function exportexcell() {
        $contract = Contract::find(auth()->user()->userable->contract_id);
        $formings = Forming::get();
        $formingStatus = [];
        $formingPerc = [];
        foreach ($formings as $forming) {
            $valor = 0;
            $valor_pago_all = 0;
            $product = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('category_id', 1)->first();
            if (isset($product->id)) {
                $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
                $parcelsTotal = FormandoProdutosParcelas::where('formandos_id', $forming->id)->where('formandos_produtos_id', $product->id)->get();
                foreach ($parcelsTotal as $parcel_all) {
                    if (isset($parcel_all->pagamento)) {
                        $valor_pago_all += $parcel_all->pagamento->sum('valor_pago');
                    }
                }
                $valorTotal = $parcelsTotal->sum('valor');
                $valor = $parcels->sum('valor');
                $valor_pago = 0;
                foreach ($parcels as $parcel) {
                    if (isset($parcel->pagamento)) {
                        $valor_pago += $parcel->pagamento->sum('valor_pago');
                    }
                }
                @$perc_pago = number_format((($valor_pago_all / $valorTotal) * 100), 0);
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
        }
        return $this->exportExcellFile($formings);
    }

    function printpapper() {
        $contract = Contract::find(auth()->user()->userable->contract_id);
        $formings = Forming::get();
        $formingStatus = [];
        $formingPerc = [];
        foreach ($formings as $forming) {
            $valor = 0;
            $valor_pago_all = 0;
            $product = FormandoProdutosEServicos::where('forming_id', $forming->id)->where('category_id', 1)->first();
            if (isset($product->id)) {
                $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
                $parcelsTotal = FormandoProdutosParcelas::where('formandos_id', $forming->id)->where('formandos_produtos_id', $product->id)->get();
                foreach ($parcelsTotal as $parcel_all) {
                    if (isset($parcel_all->pagamento)) {
                        $valor_pago_all += $parcel_all->pagamento->sum('valor_pago');
                    }
                }
                $valorTotal = $parcelsTotal->sum('valor');
                $valor = $parcels->sum('valor');
                $valor_pago = 0;
                foreach ($parcels as $parcel) {
                    if (isset($parcel->pagamento)) {
                        $valor_pago += $parcel->pagamento->sum('valor_pago');
                    }
                }
                @$perc_pago = number_format((($valor_pago_all / $valorTotal) * 100), 0);
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
        }
        return view('comissao.formandosprintpapper', compact('contract', 'formingStatus', 'formingPerc', 'formings', 'formingLabel'));
    }

    public function index(Request $request) {


        $search = $request->get('search');

        $query = new Forming();


        if (isset($search) && !empty($search)) {

            $query = $query->where(function($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%");
                $query->orWhere('sobrenome', 'like', "%{$search}%");
                $query->orWhere('cpf', 'like', "%{$search}%");
                $query->orWhere('email', 'like', "%{$search}%");
            });
        }

        $formings = $query->get();

        $formingStatus = [];
        $formingPerc = [];
        foreach ($formings as $forming) {
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
        return view('gerencial.formandos.index', @compact('contract', 'formingStatus', 'formingPerc', 'formings', 'formingLabel', 'search'));
    }

    public function atualizaParcelas() {
        $post = request()->post();
        foreach ($post['parcela'] as $key => $retorno) {
            
        }
    }

    /**
     * Recupera a busca da parcela baseado no id.
     * @author Rafael Dantas Fortes <contato@dantsym.com.br>
     * @version 1.0
     * @access public
     * @return object
     */
    public function getParcela($id) {
        return response()->json(['parcela' => FormandoProdutosParcelas::find($id)]);
    }

    /**
     * Edita o registro no banco de dados.
     * @author Rafael Dantas Fortes <contato@dantsym.com.br>
     * @version 1.0
     * @access public
     * @param $id O id da parcela editada.
     * @return object
     */
    public function editParcela($id) {
        $post = request()->all();
        if ($id != 0) {
            $parcela = FormandoProdutosParcelas::find($id);
        } else {
            $parcela = new FormandoProdutosParcelas();
            $parcela->formandos_produtos_id = $post['prodid'];
            $parcela->formandos_id = $post['formandosid'];
            $parcela->contrato_id = $post['contratoid'];
        }
        $parcela->valor = $post['valor'];
        $parcela->dt_vencimento = $post['datavencimento'];
        $parcela->save();
        return response()->json(['success' => true]);
    }

    /**
     * Exclui a parcela do banco de dados.
     * @author Rafael Dantas Fortes <contato@dantsym.com.br>
     * @version 1.0
     * @access public
     * @param $id O id da parcela removida.
     * @return object
     */
    public function removeParcela($idproduct) {


        $formando = Auth::user()->userable->id;
        $retorno = FormandoProdutosParcelas::find($idproduct);


        $parcelas = ParcelasPagamentos::where('parcela_id', $retorno->id)->get();
        foreach ($parcelas as $retorno2) {
            PagamentosBoleto::where('parcela_pagamento_id', $retorno2->id)->first()->delete();
            $retorno2->delete();
        }
        $retorno->delete();

        FormandoProdutosEServicos::where('id', $idproduct)->delete();
        //FormandoProdutosParcelas::find($id)->delete();
        return response()->json(['success' => true]);
    }

    public function show(Forming $forming) {

        $contract = $forming->contract->id;
        $products = [];
        $prods = $forming->products->where('status', 1);
        foreach ($prods as $product) {
            $parcels = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
            $parcelsTotal = FormandoProdutosParcelas::where('formandos_produtos_id', $product->id)->get();
            $valorTotal = $parcelsTotal->sum('valor');
            $valor = 0;
            $valor_pago = 0;
            foreach ($parcelsTotal as $parcel) {
                if (isset($parcel->pagamento)) {
                    $valor_pago += $parcel->pagamento->sum('valor_pago');
                }
                $date = date("Y-m-d", strtotime($parcel->dt_vencimento));
                if ($date > date("Y-m-d")) {
                    continue;
                }
                $valor += $parcel->valor;
            }
            @$perc_pago = number_format((($valor_pago / $valorTotal) * 100), 0);
            //dd($valorTotal, $valor_pago, $perc_pago);
            $products['perc'][$product->id] = $perc_pago;
            if ($valor_pago <= 0) {
                $products[$product->id] = 'Pendente';
                $formingLabel[$product->id] = 'info';
            } elseif ($valor_pago >= 0 and ($valor_pago >= $valor)) {
                $products[$product->id] = 'Adimplente';
                $formingLabel[$product->id] = 'success';
            } elseif ($valor_pago >= 0 and ($valor_pago < $valor)) {
                $products[$product->id] = 'Inadimplente';
                $formingLabel[$product->id] = 'danger';
            } else {
                $products[$product->id] = 'Pendente';
                $formingLabel[$product->id] = 'info';
            }
        }
        //Cancelados
        $products_cancel = [];
        $prods_cancel = $forming->products->where('status', 7);
        foreach ($prods_cancel as $product_cancel) {
            $parcels_cancel = FormandoProdutosParcelas::where('formandos_produtos_id', $product_cancel->id)->where('dt_vencimento', '<', date('Y-m-d'))->get();
            $parcelsTotal_cancel = FormandoProdutosParcelas::where('formandos_produtos_id', $product_cancel->id)->get();
            $valorTotal_cancel = $parcelsTotal_cancel->sum('valor');
            $valor_cancel = 0;
            $valor_pago_cancel = 0;
            foreach ($parcelsTotal_cancel as $parcel_cancel) {
                if (isset($parcel_cancel->pagamento)) {
                    $valor_pago_cancel += $parcel_cancel->pagamento->sum('valor_pago');
                }
                $date_cancel = date("Y-m-d", strtotime($parcel_cancel->dt_vencimento));
                if ($date_cancel > date("Y-m-d")) {
                    continue;
                }
                $valor_cancel += $parcel_cancel->valor;
            }
            @$perc_pago_cancel = number_format((($valor_pago_cancel / $valorTotal_cancel) * 100), 0);
            //dd($valorTotal, $valor_pago, $perc_pago);
            $products_cancel['perc'][$product->id] = $perc_pago_cancel;
            if ($valor_pago_cancel <= 0) {
                $products_cancel[$product->id] = 'Pendente';
                $formingLabel_cancel[$product->id] = 'info';
            } elseif ($valor_pago_cancel >= 0 and ($valor_pago_cancel >= $valor)) {
                $products_cancel[$product->id] = 'Adimplente';
                $formingLabel_cancel[$product->id] = 'success';
            } elseif ($valor_pago_cancel >= 0 and ($valor_pago < $valor)) {
                $products_cancel[$product->id] = 'Inadimplente';
                $formingLabel_cancel[$product->id] = 'danger';
            } else {
                $products_cancel[$product->id] = 'Pendente';
                $formingLabel_cancel[$product->id] = 'info';
            }
        }
        //dd($products_cancel);
        return view('gerencial.formandos.show', @compact('forming', 'products', 'formingLabel', 'prods', 'forming_cancel', 'products_cancel', 'formingLabel_cancel', 'prods_cancel'));
    }

    public function showItem(FormandoProdutosEServicos $prod) {

        $contract = auth()->user()->userable->contract_id;
        $forming = Forming::find($prod->forming_id);
        $parcelas = FormandoProdutosParcelas::leftJoin('parcelas_pagamentos', function($join) {
                            $join->on('parcelas_pagamentos.parcela_id', '=', 'formandos_produtos_parcelas.id');
                        })
                        ->leftJoin('pagamentos_boleto', function($join) {
                            $join->on('pagamentos_boleto.parcela_pagamento_id', '=', 'parcelas_pagamentos.id');
                        })
                        ->where('formandos_produtos_id', $prod['id'])->select("*", 'formandos_produtos_parcelas.id as idparcela')->get();
        $produtos = $prod->get()->toArray();
        $termo = ProdutosEServicosTermo::where('id', $prod['termo_id'])->get()->toArray()[0];
        $termo = str_replace('[[=valor]]', number_format($prod->valorFinal(), 2, ',', '.'), $termo);
        $date = Carbon::now();
        $dateLimit = Carbon::now();
        $dateLimit->addDays(15);
        $pagamentos = [];

        foreach ($parcelas as $parcela) {
            $id = $parcela['id'];
            $ret = ParcelasPagamentos::where('parcela_id', $id)->where('deleted', 0)->first();
            if ($ret) {
                $pagamentos[$id] = $ret;
            }
        }
        return view('gerencial.formandos.show_item', compact('prod', 'parcelas', 'termo', 'pagamentos', 'dateLimit', 'forming', 'contract', 'prod'));
    }

    public function forceLogin(Forming $forming) {
        Auth::loginUsingId($forming->user->id);
        return redirect()->route('portal.home');
    }

}
