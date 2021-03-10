<nav class="left-menu" left-menu>
    <div class="logo-container">
        <a href="index.html" class="logo">
            <img src="{{ asset('assets/common/img/murano.PNG') }}" alt="SIFORME LOGO">
            <img class="logo-inverse" src="../assets/common/img/logo-inverse.png" alt="Clean UI Admin Template" />
        </a>
    </div>
    <div class="left-menu-inner scroll-pane jspScrollable" tabindex="0"
         style="overflow: hidden; padding: 0px; width: 239px;">

        <ul class="left-menu-list left-menu-list-root list-unstyled">
            @php
            $rota_menu = Route::getCurrentRoute()->getName();
            $css_active = "class=\"left-menu-list-active\"";
            @endphp
            <li @if($rota_menu == 'portal.extrato'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('portal.extrato')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- --></i>
                    Extrato
                </a>
            </li>
            <li @if($rota_menu == 'portal.informativos' || $rota_menu == 'portal.informativos.show'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('portal.informativos')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- --></i>
                    Informativos
                </a>
            </li>
            <li @if($rota_menu == 'portal.chamados' || $rota_menu == 'portal.chamados.show'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('portal.chamados')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- --></i>
                    Atendimento
                </a>
            </li>

            <li @if($rota_menu == 'portal.albuns' or $rota_menu == 'portal.albuns.comprar' or $rota_menu == 'portal.albuns.comprado'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('portal.albuns')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"> </i>
                    Álbum de Formatura
                </a>
            </li>


            <li @if($rota_menu == 'portal.comprasextras'){!! $css_active !!}@endif>
                <a class="left-menu-link" href="{{route('portal.comprasextras')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"></i>
                    Compras Extras
                </a>
            </li>
            @if( auth()->user()->userable->contract_id == 7 )
            <li @if($rota_menu == 'portal.gifts'){!! $css_active !!}@endif>
                <a class="left-menu-link" href="{{route('portal.gifts')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"></i>
                    Lojinha da Turma
                </a>
            </li>
            @endif()

            @if( auth()->user()->userable->contract_id == 7 )
            <li @if($rota_menu == 'portal.raffle-select'){!! $css_active !!}@endif>
                <a class="left-menu-link" href="{{route('portal.raffle-select')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"></i>
                    Rifa Online
                </a>
            </li>
            @endif

            @if( auth()->user()->userable->contract_id == 7 )
                <li @if($rota_menu == 'portal.survey.index'){!! $css_active !!}@endif>
                    <a class="left-menu-link" href="{{route('portal.survey.index')}}">
                        <i class="left-menu-link-icon icmn-arrow-right2"></i>
                        Enquete
                    </a>
                </li>
            @endif

            @if( auth()->user()->userable->contract_id == 7 )
            <li @if($rota_menu == 'portal.photos'){!! $css_active !!}@endif>
                <a class="left-menu-link" href="{{route('portal.photos')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"></i>
                    Fotos Telão
                </a>
            </li>
            @endif

            <li @if($rota_menu == 'portal.comissao'){!! $css_active !!}@endif>
                <a class="left-menu-link" href="{{route('portal.comissao')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"></i>
                    Comissão de Formatura
                </a>
            </li>

            @if( auth()->user()->userable->contract_id == 1 )
            <li @if($rota_menu == 'portal.identity'){!! $css_active !!}@endif>
                <a class="left-menu-link" href="{{route('portal.identity')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"></i>
                    Identificação
                </a>
            </li>
            @endif


            <!--
            <li @if($rota_menu == 'portal.perfil'){!! $css_active  !!}@endif>
                <a class="left-menu-link" href="{{route('portal.perfil')}}">
                    <i class="left-menu-link-icon icmn-arrow-right2"><!-- </i>
                    Meus Dados
                </a>
            </li>-->
        </ul>

    </div>
</nav>
