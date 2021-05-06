<div class="col">
    <div class="collapse show" id="area_cc">
        <div class="card card-body">
            <div class="panel-body">
                <form id="payment-form"
                    action="{{route('portal.extrato.produto.paycredit.process', ['prod' => $prod['id']])}}"
                    method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-nome">Nome no cartão</label>
                            <input type="text" pattern="[A-Z a-z]{1,32}" name="nome_cc"
                                class="form-control cc-nome"
                                title="Nome como esta no cartão, tudo em caixa alta" placeholder=""
                                required="" value="Roberto da Silva Flor">
                            <small class="text-muted">Nome completo, como mostrado no cartão.</small>
                            <div class="invalid-feedback">
                                O nome que está no cartão é obrigatório.
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="cc-numero">Data de Nascimento</label>
                            <input type="text" name="data_nasc" class="form-control cc-data_nasc"
                                placeholder="" required="" data-mask="00/00/0000" maxlength="11" value="01/06/1984">
                            <small class="text-muted">Dado do titular do Cartão</small>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cc-numero">CPF do Titular do cartão</label>
                            <input type="text" data-mask="000.000.000-00"
                                pattern="\d{3}\.?\d{3}\.?\d{3}-?\d{2}"
                                title="Digite um CPF no formato: xxx.xxx.xxx-xx" name="cpf_tit"
                                class="form-control cc-cpf" placeholder="" required="" value='31411005864'>
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-numero">Número do cartão de crédito</label>
                            <input type="text" class="form-control cc-numero" placeholder=""
                                required="" value="4111111111111111">
                            <div class="invalid-feedback">
                                O número do cartão de crédito é obrigatório.
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label for="cc-expiracao">Data de expiração</label>
                            <input type="text" class="form-control cc-expiracao" data-mask="00/0000"
                                maxlength="7" placeholder="" required="" value="12/2030">
                            <div class="invalid-feedback">
                                Data de expiração é obrigatória.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cc-cvv">CVV</label>
                            <input type="text" class="form-control cc-cvv" placeholder="" required="" value="123">
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
                                @for($i=1;$i<=$parce_max;$i++) <?php $valor_f =  $saldo_pagar/$i; ?>
                                    <option value="{{$i}}">{{$i}}X de R$
                                    {{number_format($valor_f, 2, ",", ".")}}</option>
                                    @endfor
                                    @else
                                    <option> Aguardando número do Cartão </option>
                                    @endif
                            </select>
                        </div>
                        <button class="btn btn-primary" align="center" type="submit" id="btn-pagar">
                            Processar compra
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
        </div>
    </div>
</div>