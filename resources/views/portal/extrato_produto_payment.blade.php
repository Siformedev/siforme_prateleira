@extends('portal.inc.layout')

@section('content')
<section class="page-content">
    <div class="page-content-inner">

        <section class="panel">
            <div class="panel-heading" style="padding: 10px 20px;">

                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-3"><a class="btn btn-default"
                            href="{{route('portal.extrato.produto', ['prod' => $prod['id']])}}">Voltar</a>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-9">
                        <h3>{{$prod['name']}}</h3>
                    </div>
                </div>
            </div>
        </section>

        @if(Session::has('process_message'))
        <div class="alert alert-danger">{{Session::get('process_message')}}! Código:
            LR-{{Session::get('process_lr')}}</div>
        @endif

        @if(Session::has('process_success_msg'))
        <div class="alert alert-warning">Pagamento {{Session::get('process_success_msg')}}!</div>
        @endif

        <section class="panel col-md-12">
            <div class="panel-heading">

                <div class="row">

                    <div class="col-md-12">
                        <h3>Saldo a Pagar</h3>
                        
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12" style="font-size: 16px;">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-
                                    " scope="row">Total</th>
                                    <td>R$ {{number_format($prod->valorFinal(), 2, ",", ".")}}</td>
                                </tr>
                                <tr>
                                    <th class="text-center" scope="row">Valor Pago</th>
                                    <td>R$ {{number_format($valor_pago_p, 2, ",", ".")}}</td>
                                </tr>
                                <tr>
                                    <th class="text-center" scope="row">Saldo</th>
                                    <td>R$ {{number_format($saldo_pagar, 2, ",", ".")}}</td>
                                </tr>
                                @if($saldo_pagar <= 0) <tr class="text-center">
                                    <td colspan="2">
                                        <img src="{{ asset("img/icon_pago.png") }}" class="img-responsive"
                                            style="max-height: 100px;">
                                        <hr>
                                        <h2 style="color: #00ad21">Parabéns Tudo Pago!</h2>
                                    </td>
                                    </tr>
                                    @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel col-md-12">
            <p class="" align="center">
                   
                    @if ($tipo_pagamento == 'cb')
                    <a class="btn btn-success col-md-auto btn-block-xs-only" data-toggle="collapse" href="#area_cc"
                    role="button" aria-expanded="true" aria-controls="area_cc"><u>Cartão de Crédito</u></a>
                
                    <button class="btn btn-success col-md-auto btn-block-xs-only" type="button" data-toggle="collapse"
                    data-target="#area_boleto" aria-expanded="true" aria-controls="area_boleto"><u>Boleto
                        Bancário</u></button>
                    @endif

                    @if($tipo_pagamento == 'b')
                   
                    <button class="btn btn-success col-md-auto btn-block-xs-only" type="button" data-toggle="collapse"
                    data-target="#area_boleto" aria-expanded="true" aria-controls="area_boleto"><u>Boleto
                        Bancário</u></button>
                    @endif

                    @if($tipo_pagamento == 'c')
                    <a class="btn btn-success col-md-auto btn-block-xs-only" data-toggle="collapse" href="#area_cc"
                    role="button" aria-expanded="true" aria-controls="area_cc"><u>Cartão de Crédito</u></a>
                    
                    @endif
                   
            </p>
            
            <div class="row">
                
                @if ($tipo_pagamento == 'cb')
                    @include('portal.componentes_extrato.cartao')
                    @include('portal.componentes_extrato.boleto')
                @endif

                @if ($tipo_pagamento == 'c')
                    @include('portal.componentes_extrato.cartao')
                @endif

                @if ($tipo_pagamento == 'b')
                    @include('portal.componentes_extrato.boleto')
                @endif

            </div>
        </section>

        @if($saldo_pagar > 0)
        <section class="panel col-md-7">

        </section>


        @endif
    </div>

    {!! Form::hidden('hash', '', ['id'=>'hash']) !!}

</section>

{{-- <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script> --}}

<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

<script>
    let cc = {};
    $('.invalid-feedback').hide();
    $(".cc-expiracao").mask("99/9999",{placeholder:"MM/AAAA"});
    $(".cc-data_nasc").mask("99/99/9999",{placeholder:"DD/MM/AAAA"});
    $(".cc-cpf").mask("999.999.999-99",{placeholder:"xxx.xxx.xxx-xx"});
    
    PagSeguroDirectPayment.setSessionId('{{$id_sessao}}');   
        
    // PagSeguroDirectPayment.onSenderHashReady(function(response){
    
    // if(response.status == 'error') {
    //     console.log(response.message);
    //     return false;
    // }
    // // hash = response.senderHash; //Hash estará disponível nesta variável.
    //  $('#hash').val(response.senderHash);  
   
    //  });

$('.cc-numero').keyup(function(){    
    pagseguroValidateCard(this.value, false);
});
$('.cc-numero').focusout(function(){
    pagseguroValidateCard(this.value, true);
});
$('.cc-expiracao').focusout(function(){
    if(pagseguroValidateExp(this.value)){
        $(this).unbind('focusout');
    };
});

$( "#payment-form" ).submit(function( event ) {  
  event.preventDefault();
  
  cc.nome = $('.cc-nome').val();
  cc.num = $('.cc-numero').val();  
  cc.cvv = $('.cc-cvv').val();
  
  tokenCC().then(token_success).catch(error_handler);
  /*if(cc.token){
    $(this).unbind().submit();
  }*/
});

function bandeira_error(r){
 console.log("failed with status", r);
}

function token_success(r){
    //console.log(r)
    $('#token').val(r.card.token);
    $( "#payment-form" ).unbind().submit();    
}

function error_handler(r){
    //error_string = "";
    //console.log(r)
    cc.token=false;
    if (r.hasOwnProperty('errors')) {

    Object.keys(r.errors).forEach(function(prop) {
        alert(r.errors[prop]);
    });
    }else{
        console.log(r)
    }
    
    //alert(error_string);
}
function tokenCC(){
    
var promiseObj = new Promise(function(fullfill, reject){
   PagSeguroDirectPayment.createCardToken({
   cardNumber: cc.num.replace(/\s/g, ''), // Número do cartão de crédito
   brand: cc.brand, // Bandeira do cartão
   cvv: cc.cvv, // CVV do cartão
   expirationMonth: cc.mes, // Mês da expiração do cartão
   expirationYear: cc.ano, // Ano da expiração do cartão, é necessário os 4 dígitos.
   success: function(response) {
        // Retorna o cartão tokenizado.
        fullfill(response);
   },
   error: function(response) {
		    // Callback para chamadas que falharam.
            reject(response)      
   },
   complete: function(response) {
        // Callback para todas chamadas.
   }
});
});
return promiseObj;       
}

function getBrand(cc){    
    
    var promiseObj = new Promise(function(fullfill, reject){
    PagSeguroDirectPayment.getBrand({
    cardBin: cc.num.substr(0, 6),
    success: function(response) {
      fullfill(response);
    },
    error: function(response) {
      
    },
    complete: function(response) {
        reject(response)
    }      
  });
});  
  return promiseObj;       
}

function pagseguroValidateExp(element){
    
    str = element.split('/');
    if(element.length < 7 || str[0] > 12 || str[0] < 1 || str[1] < 2020){
        alert("Verifique se a data de vencimento esta correta");
        
        return false
    }
    cc.mes = str[0];
    cc.ano = str[1];
}

function pagseguroValidateCard (element, bypassLengthTest) {

        $('input[name=pagseguro\\[creditCardToken\\]]').val('');
        var cardNum = element.replace(/[^\d.]/g, '');
        var card_invalid = 'Validamos os primeiros 6 números do seu cartão de crédito e está inválido. Por favor esvazie o campo e tente digitar de novo.';

        if (cardNum.length == 6 || (bypassLengthTest && cardNum.length >= 6)) {
            PagSeguroDirectPayment.getBrand({
            cardBin: cardNum.substr(0, 6),
            success: function(response) {
                if (typeof response.brand.name != 'undefined') {

                    $('input[name=pagseguro\\[brand\\]]').val(response.brand.name);
                    cc.brand = response.brand.name;
                    PagSeguroDirectPayment.getInstallments({
                        amount: {{$saldo_pagar}},
                        maxInstallmentNoInterest: 6,
                        brand: response.brand.name,
                        success: function(response1) {
                            //$('select[name=pagseguro\\[installments\\]]').html('');
                            $('select[name=pay-parcels]').html('');
                            
                            $.each(response1.installments[response.brand.name], function(key, value){
                                if(value.quantity <= 6){
                                    $('select[name=pay-parcels]').append('<option value="'+value.quantity+'x'+value.installmentAmount.toFixed(2)+'">'+value.quantity+' vezes  '+value.installmentAmount.toFixed(2).replace('.', ',')+' (Total: '+value.totalAmount.toFixed(2).replace('.', ',')+') - ' + response.brand.name.toUpperCase() + '</option>');
                                }
                                
                            });
                            //$('.pagseguro-installments').show();
                            //$('.pagseguro-installments-info').hide();
                        },
                        error: function(){
                            alert(card_invalid);
                            $(this).unbind('focusout');
                            return false;
                        }
                    });

                }else{
                    alert(card_invalid);
                    $(this).unbind('focusout');
                    return false;
                }
            },
            error: function(response) {
                alert(card_invalid);
                $(this).unbind('focusout');
                return false;
            }});
        }
    }
    //start opened
    $('#area_cc').collapse('show')
    $('.panel').on('shown.bs.collapse', function (e) {
    
    if(e.target.id == "area_boleto"){
        $('#area_cc').collapse('hide')
    }else{
        $('#area_boleto').collapse('hide')
        
    }
})
</script>

<script type="text/javascript">


                PagSeguroDirectPayment.onSenderHashReady(function(response){
                    $('#hash').val(response.senderHash); 
                });




   $(function(){
            $(".a-vencer-click").click(function (e) {
                //alert("Seu boleto estará disponível 30 dias antes do vencimento");
                swal({ title: "Aviso", text: "Seu boleto estará disponível 4 dias antes do vencimento", type: "warning" });
            });
            

            $(".boleto-imprimir").click(function (e) {
                
                let url = "";
                url = $(this).attr('href_javascript');

                url += '/'+$('#hash').val();
                    //this.href = url;
                    console.log(url)
                    location.replace(url);


                if(url.length < 50){
                    // hash = $('#hash').val();
                    url += '/'+$('#hash').val();
                    //this.href = url;
                    console.log(url)
                    location.replace(url);
                }                
            });
    });
   

    
function aviso_vencimento(){
    swal({ title: "Aviso", text: "Para todos os boletos gerados, a data de vencimento do mesmo será gerado em D+4", type: "warning" });
}
</script>

<style>
    @media (max-width: 575.98px) {
        .btn-block-xs-only {
            display: block;
            width: 100%;
            margin-bottom: 1em;
        }
    }
</style>

@endsection