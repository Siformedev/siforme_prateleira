<nav class="left-menu" left-menu="">
    <div class="logo-container">
        <a href="index.html" class="logo">
            <img src="{{ asset('assets/common/img/logo.png') }}" alt="{{env('APP_NAME')}} LOGO">
            <img class="logo-inverse" src="{{ asset('assets/common/img/logo-inverse.png') }}" alt="Clean UI Admin Template">
        </a>
    </div>
    <div class="left-menu-inner scroll-pane jspScrollable" tabindex="0"
         style="overflow: hidden; padding: 0px; width: 239px;">

        @if(isset($fases[1]) or isset($fases[2]) or isset($fases[3]) or isset($fases[4]))
            <div class="step-block step-success" onclick="window.location = '{{ route('adesao.contrato') }}'" style="cursor: pointer">
                <span class="step-digit"><i class="fa fa-check" aria-hidden="true"></i></span>
                <div class="step-desc">
                    <span class="step-title">Contrato</span>
                    <p>Concluido</p>
                </div>
            </div>
        @else
            <div class="step-block step-success">
                <span class="step-digit">1</span>
                <div class="step-desc">
                    <span class="step-title">Contrato</span>
                    <p>Em andamento</p>
                </div>
            </div>
        @endif

        @if(isset($fases[1]))
        <div class="step-block step-info" onclick="window.location = '{{ route('adesao.dados') }}'" style="cursor: pointer">
            <span class="step-digit">2</span>
            <div class="step-desc">
                <span class="step-title">Dados</span>
                <p>Em andamento</p>
            </div>
        </div>
        @elseif(isset($fases[2]) or isset($fases[3]) or isset($fases[4]) or isset($fases[5]))
            <div class="step-block step-success" onclick="window.location = '{{ route('adesao.dados') }}'" style="cursor: pointer">
                <span class="step-digit"><i class="fa fa-check" aria-hidden="true"></i></span>
                <div class="step-desc">
                    <span class="step-title">Dados</span>
                    <p>Concluido</p>
                </div>
            </div>
        @else
            <div class="step-block step-default">
                <span class="step-digit">2</span>
                <div class="step-desc">
                    <span class="step-title">Dados</span>
                    <p>Aguardando</p>
                </div>
            </div>
        @endif


        @if(isset($fases[2]))
            <div class="step-block step-info" onclick="window.location = '{{ route('adesao.confirma') }}'" style="cursor: pointer">
                <span class="step-digit">3</span>
                <div class="step-desc">
                    <span class="step-title">Confirmação</span>
                    <p>Em andamento</p>
                </div>
            </div>
        @elseif(isset($fases[3]) or isset($fases[4]) or isset($fases[5]))
            <div class="step-block step-success">
                <span class="step-digit"><i class="fa fa-check" aria-hidden="true"></i></span>
                <div class="step-desc">
                    <span class="step-title">Confirmação</span>
                    <p>Concluido</p>
                </div>
            </div>
        @else
            <div class="step-block step-default">
                <span class="step-digit">3</span>
                <div class="step-desc">
                    <span class="step-title">Confirmação</span>
                    <p>Aguardando</p>
                </div>
            </div>
        @endif

        @if(isset($fases[3]))
            <div class="step-block step-info" onclick="window.location = '{{ route('adesao.pagamento') }}'" style="cursor: pointer">
                <span class="step-digit">4</span>
                <div class="step-desc">
                    <span class="step-title">Pagamento</span>
                    <p>Em andamento</p>
                </div>
            </div>
        @elseif(isset($fases[4]) or isset($fases[5]))
            <div class="step-block step-success">
                <span class="step-digit"><i class="fa fa-check" aria-hidden="true"></i></span>
                <div class="step-desc">
                    <span class="step-title">Pagamento</span>
                    <p>Concluido</p>
                </div>
            </div>
        @else
            <div class="step-block step-default">
                <span class="step-digit">4</span>
                <div class="step-desc">
                    <span class="step-title">Pagamento</span>
                    <p>Aguardando</p>
                </div>
            </div>
        @endif

        @if(isset($fases[4]))
            <div class="step-block step-success">
                <span class="step-digit"><i class="fa fa-check" aria-hidden="true"></i></span>
                <div class="step-desc">
                    <span class="step-title">Concluido</span>
                    <p>Concluido</p>
                </div>
            </div>
        @else
            <div class="step-block step-default">
                <span class="step-digit">5</span>
                <div class="step-desc">
                    <span class="step-title">Concluido</span>
                    <p>Aguardando</p>
                </div>
            </div>
        @endif

    </div>
</nav>