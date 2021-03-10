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

        <section class="panel col-md-5">
            <div class="panel-heading">

                <div class="row">

                    <div class="col-lg-8 col-md-7 col-sm-7">
                        <h3>Saldo a Pagar com Cartão de Crédito</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12" style="font-size: 16px;">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-center" scope="row">Total</th>
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

        @if($saldo_pagar > 0)
        <section class="panel col-md-7">
            <div class="panel-body">
                <form id="payment-form"
                    action="{{route('portal.extrato.produto.paycredit.process', ['prod' => $prod['id']])}}"
                    method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-nome">Nome no cartão</label>
                            <input type="text" pattern="[A-Z a-z]{1,32}" name="nome_cc" class="form-control cc-nome"
                                title="Nome como esta no cartão, tudo em caixa alta" placeholder="" required="">
                            <small class="text-muted">Nome completo, como mostrado no cartão.</small>
                            <div class="invalid-feedback">
                                O nome que está no cartão é obrigatório.
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="cc-numero">Data de Nascimento</label>
                            <input type="text" name="data_nasc" class="form-control cc-data_nasc" placeholder=""
                                required="" data-mask="00/00/0000" maxlength="11">
                            <small class="text-muted">Dado do titular do Cartão</small>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cc-numero">CPF do Titular do cartão</label>
                            <input type="text" data-mask="000.000.000-00" pattern="\d{3}\.?\d{3}\.?\d{3}-?\d{2}"
                                title="Digite um CPF no formato: xxx.xxx.xxx-xx" name="cpf_tit"
                                class="form-control cc-cpf" placeholder="" required="">
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-numero">Número do cartão de crédito</label>
                            <input type="text" class="form-control cc-numero" placeholder="" required="">
                            <div class="invalid-feedback">
                                O número do cartão de crédito é obrigatório.
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="cc-expiracao">Data de expiração</label>
                            <input type="text" class="form-control cc-expiracao" data-mask="00/0000" maxlength="7"
                                placeholder="" required="">
                            <div class="invalid-feedback">
                                Data de expiração é obrigatória.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cc-cvv">CVV</label>
                            <input type="text" class="form-control cc-cvv" placeholder="" required="">
                            <div class="invalid-feedback">
                                Código de segurança é obrigatório.
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label class="form-control-label">Selecione a quantidade de
                                parcelas:</label>
                            <select name="pay-parcels" class="form-control">
                                @if(false)
                                @for($i=1;$i<=$parce_max;$i++) <?php $valor_f =  $saldo_pagar/$i; ?> <option
                                    value="{{$i}}">{{$i}}X de R$ {{number_format($valor_f, 2, ",", ".")}}</option>
                                    @endfor
                                    @else
                                    <option> Aguardando número do Cartão </option>
                                    @endif
                            </select>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit" id="btn-pagar">
                            PAGAR
                        </button>
                    </div>
                    <input type="hidden" name="token" id="token">
                    <input type="hidden" name="hash" id="hash">
                    <input type="hidden" name="prod" value="{{$prod['id']}}">
                    <input type="hidden" name="saldo" value="{{$saldo_pagar}}">

                    @foreach($sum_pags as $p)
                    <input type="hidden" name="parcels[]" value="{{$p}}">
                    @endforeach

                    {!! csrf_field() !!}
                </form>
            </div>
        </section>


        @endif
    </div>

</section>
<script src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

<script>
    let cc = {};
    $('.invalid-feedback').hide();
    $(".cc-expiracao").mask("99/9999",{placeholder:"MM/AAAA"});
    $(".cc-data_nasc").mask("99/99/9999",{placeholder:"DD/MM/AAAA"});
    $(".cc-cpf").mask("999.999.999-99",{placeholder:"xxx.xxx.xxx-xx"});
    PagSeguroDirectPayment.setSessionId('{{$id_sessao}}');        
    PagSeguroDirectPayment.onSenderHashReady(function(response){
    if(response.status == 'error') {
        //console.log(response.message);
        //return false;
    }
    //hash = response.senderHash; //Hash estará disponível nesta variável.
    $('#hash').val(response.senderHash);
    });

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
</script>

@endsection