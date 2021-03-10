<nav class="left-menu">
    <div class="logo-container" style="background: #f1f1f1">
        <a>
            <img src="{{ asset('assets/common/img/logo.png') }}" class="width-150" alt="{{env('APP_NAME')}} LOGO">
        </a>
    </div>
    <div class="left-menu-inner scroll-pane jspScrollable" tabindex="0"
         style="overflow: hidden; padding: 0px; width: 239px;">

        <ul class="left-menu-list left-menu-list-root list-unstyled">
            @php
            $rota_menu = Route::getCurrentRoute()->getName();
            $css_active = "class=\"left-menu-list-active\"";
            @endphp
            <li @if($rota_menu == 'comissao.painel'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('comissao.painel')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- --></i>
                    Painel
                </a>
            </li>
            <li @if($rota_menu == 'comissao.formandos'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('comissao.formandos')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- --></i>
                    Formandos
                </a>
            </li>

            <li @if($rota_menu == 'comissao.formandos.canceled'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('comissao.formandos.canceled')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- --></i>
                    Cancelamentos
                </a>
            </li>
            <li @if($rota_menu == 'comissao.extrasales'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('comissao.extrasales')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- --></i>
                    Vendas Extras
                </a>
            </li>
            <li @if($rota_menu == 'comissao.registers'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('comissao.registers')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- --></i>
                    Registros
                </a>
            </li>
            <!--
            <li @if($rota_menu == 'comissao.orcamento'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('comissao.orcamento')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- </i>
                    Orçamento
                </a>
            </li>
            -->
            <li @if($rota_menu == 'comissao.lojinha.vendas'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('comissao.lojinha.vendas')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- --></i>
                    Lojinha da Turma
                </a>
            </li>

            <li @if($rota_menu == 'comissao.contrato'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('comissao.contrato')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- --></i>
                    Contrato
                </a>
            </li>

            <!--
            <li @if($rota_menu == 'comissao.chamados'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('comissao.chamados')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- </i>
                    Chamados
                </a>
            </li>
            -->
        </ul>

    </div>
</nav>
