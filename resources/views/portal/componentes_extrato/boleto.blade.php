<div class="col">
    <div class="collapse" id="area_boleto">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-12" style="font-size: 16px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Vencimento</th>
                                <th class="text-center">Valor</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parcelas as $parcela)
                            <?php
                        //dd($parcelas);
                        //dd($pagamentos);
                            $actionParc = '';
                            $sumpg = 0;
                            $tptype = '';
                            //dd($parcelas);
                            if(isset($pagamentos[$parcela['id']]) ){

                                $parc = $pagamentos[$parcela['id']];
                                $sumpg = $parc->valor_pago;
                                if(isset($parc->typepaind_type)){
                                    $tptype = $parc->typepaind_type;
                                    $credit_parcels = isset($parc->typepaind->installments)?$parc->typepaind->installments:'';
                                    $credit_link_pdf = isset($parc->typepaind->secure_url)?$parc->typepaind->secure_url:'';
                                }else{
                                    $tptype = null;
                                }

                            }

                            $dt_venc = (strtotime($parcela['dt_vencimento']));
                            //$dt_venc_boleto = strtotime(date('Y-m-d'));
                            $dt_venc_boleto = strtotime('+0 day', strtotime(date('Y-m-d')));
                            //$dt_venc = strtotime('+0 day', strtotime(date('2020-06-20')));
                            
                            //print_r(date("Y-m-d",$dt_venc));
                            //echo '<br>';
                            //print_r(date("Y-m-d",$dt_venc_boleto));
                            $dt_calc = $dt_venc - $dt_venc_boleto;
                            //echo '<br>';
                            //echo date("Y-m-d",$dt_calc);
                            //echo '<br>';
                            //dd($dt_calc);

                            //echo date('Y-m-d', strtotime($parcela['dt_vencimento']));
                            //dd($tptype);
                            //dd($parcela['valor']);  
                            if($sumpg >= $parcela['valor'] ){
                                
                                if($tptype == ''){
                                    $actionParc = '<span class="label label-success">PAGO</span>';
                                }elseif($tptype == 'App\PagamentosBoleto'){
                                    $actionParc = '<span class="label label-success">PAGO</span>';
                                }elseif($tptype == 'App\PagamentosCartao'){
                                    $credit_parcels = ($credit_parcels <= 0) ? 1 : $credit_parcels;
                                    $actionParc = '<span style="height: 30px; " class="label label-success">PAGO</span> <a target="_blank" href="'.$credit_link_pdf.'.pdf"> <img style="height: 60px;" src="'.asset('img/pay_credit_X'.$credit_parcels.'.png').'"></a>';
                                }


                            }elseif($sumpg <= 0 ){
                                

                                //dd($parc);
                                //var_dump($parc->typepaind_type);
                                if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) <= $dateLimit->format('Y-m-d')){
                                    if(date('Y-m-d', strtotime($parcela['dt_vencimento'])) < date('Y-m-d')){
                                        //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                        $actionParc = '<a href_javascript="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-danger boleto-imprimir" target="_blank">Vencida</a>';
                                    }
                                    elseif( isset($parc->typepaind_type) && $parc->typepaind_type == 'App\PagamentosCartao'){
                                        
    //comentado para testes
                                    // if($pgto['status'] == 'Recusado'){
                                    //     $actionParc = '<a  class="label label-danger" target="_blank"> Cartão '.$pgto['status'].' </a>';
                                    // }else{
                                    //     $actionParc = '<a  class="label label-warning" target="_blank"> Cartão '.$pgto['status'].' </a>';
                                    //     $disable_cc_pgto = true;
                                    // }
                                            
                                }elseif( $dt_calc <= 345600 && $dt_calc >= 0 ){
                                    
                                    
                                    //dd($dateLimit->format('Y-m-d'));
                                    //$date = date("Y-m-d");
                                    //dd((strtotime('-10 day',strtotime($parcela['dt_vencimento'])) - strtotime('+10 day', strtotime(date('Y-m-d')))));
                                    //$mod_date = strtotime($date."+ 4 days");
                                    //echo date("Y-m-d",$mod_date) . "\n";exit;
                                        //$dt_limite = strtotime('+4 day', strtotime(date('Y-m-d')));
                                        /*$dt_venc = (strtotime($parcela['dt_vencimento']));
                                        $dt_venc_boleto = strtotime('+4 day', strtotime(date('Y-m-d')));
                                    echo date("Y-m-d",$x);
                                    echo '<br>';
                                    echo date("Y-m-d",$y);
                                    echo '<br>';
                                    echo $x-$y;
                                    //echo date('Y-m-d', strtotime($parcela['dt_vencimento'])) -date('Y-m-d');
                                    exit;
*/
                                        $actionParc = '<a href_javascript="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-warning boleto-imprimir" target="_blank">Imprimir</a>';
                                        
                                        //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                    }elseif(date('Y-m-d', strtotime($parcela['dt_vencimento'])) < date('Y-m-d')){
                                        //$actionParc = '<span class="label label-warning" title="Seu boleto estará disponível 5 dias antes do vencimento" target="_blank">Emitindo seu boleto...</span>';
                                        $actionParc = '<a href_javascript="'.route('portal.formando.boleto',['parcela' => $parcela['id']]).'" class="label label-danger boleto-imprimir" target="_blank">Vencida</a>';
                                    }else{
                                        
                                        $actionParc = '<span onclick="aviso_vencimento()" class="label label-primary a-vencer-click" title="Seu boleto estará disponível 30 dias antes do vencimento" style="cursor: pointer ;">A Vencer</span>';
                                    }
                                }else{
                                        
                                        $actionParc = '<span onclick="aviso_vencimento()" class="label label-primary a-vencer-click" title="Seu boleto estará disponível 30 dias antes do vencimento" style="cursor: pointer ;">A Vencer</span>';
                                    }
                            }


                            ?>
                            <tr>
                                <td class="text-center">{{$parcela['numero_parcela']}}</td>
                                <td class="text-center">
                                    {{date('d/m/Y', strtotime($parcela['dt_vencimento']))}}</td>
                                <td class="text-center">{{number_format($parcela['valor'],2, ",", ".")}}
                                </td>
                                <td class="text-center"> {!! $actionParc !!} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>