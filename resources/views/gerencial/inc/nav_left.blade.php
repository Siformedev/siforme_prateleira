<nav class="left-menu">
    <div class="logo-container" style="background: #f1f1f1">
        <a>
            <img src="{{ asset('assets/common/img/murano.PNG') }}" class="width-150" alt="{{env('APP_NAME')}} LOGO">
        </a>
    </div>
    <div class="left-menu-inner scroll-pane jspScrollable" tabindex="0"
         style="overflow: hidden; padding: 0px; width: 239px;">

        <ul class="left-menu-list left-menu-list-root list-unstyled">
            @php
            $rota_menu = Route::getCurrentRoute()->getName();
            $css_active = "class=\"left-menu-list-active\"";
            @endphp
            <li class="left-menu-list-submenu">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon icmn-files-empty2"><!-- --></i>
                    Contratos
                </a>
                <ul class="left-menu-list list-unstyled" style="display: none;">
                    <li>
                        <a class="left-menu-link" href="{{route('gerencial.contrato.create')}}">
                            Cadastrar
                        </a>
                    </li>
                    <li>
                        <a class="left-menu-link" href="{{route('gerencial.contratos')}}">
                            Consultar
                        </a>
                    </li>
                    <li>
                        <a class="left-menu-link" href="{{route('gerencial.cursos.index')}}">
                            Gerenciar Cursos
                        </a>
                    </li>
                </ul>
            </li>
            <li class="left-menu-list-submenu">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon icmn-user"><!-- --></i>
                    Formandos
                </a>
                <ul class="left-menu-list list-unstyled" style="display: none;">
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="javascript: alert('Em desenvolvimento!');">--}}
{{--                            Cadastrar--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li>
                        <a class="left-menu-link" href="{{route('gerencial.formandos')}}">
                            Consultar
                        </a>
                    </li>
                </ul>
            </li>
            @if(auth()->user()->id == 684 || auth()->user()->id == 685)
            <li class="left-menu-list-submenu">
                <a class="left-menu-link" href="javascript: void(0);">
                    <i class="left-menu-link-icon icmn-users"><!-- --></i>
                    Usuarios
                </a>
                <ul class="left-menu-list list-unstyled" style="display: none;">
                    <li>
                        <a class="left-menu-link" href="{{route('gerencial.collaborator.create')}}">
                            Novo
                        </a>
                    </li>
                    <li>
                        <a class="left-menu-link" href="{{route('gerencial.collaborator.index')}}">
                            Gerenciar
                        </a>
                    </li>
                </ul>
            </li>
            @endif()
{{--            <li class="left-menu-list-submenu">--}}
{{--                <a class="left-menu-link" href="javascript: void(0);">--}}
{{--                    <i class="left-menu-link-icon icmn-price-tag"><!-- --></i>--}}
{{--                    Produtos--}}
{{--                </a>--}}
{{--                <ul class="left-menu-list list-unstyled" style="display: none;">--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-login.html">--}}
{{--                            Cadastrar--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Consultar--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Categorias--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="left-menu-list-submenu">--}}
{{--                <a class="left-menu-link" href="javascript: void(0);">--}}
{{--                    <i class="left-menu-link-icon icmn-coin-dollar"><!-- --></i>--}}
{{--                    Orçamentos--}}
{{--                </a>--}}
{{--                <ul class="left-menu-list list-unstyled" style="display: none;">--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-login.html">--}}
{{--                            Cadastrar--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Consultar--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Produtos--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Categorias--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Tipos de Evento--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
            <li class="left-menu-list-submenu">
                <a class="left-menu-link" href="{{route('gerencial.calleds')}}">
                    <i class="left-menu-link-icon icmn-phone-incoming"><!-- --></i>
                    Chamados
                </a>
            </li>
{{--            <li class="left-menu-list-submenu">--}}
{{--                <a class="left-menu-link" href="javascript: void(0);">--}}
{{--                    <i class="left-menu-link-icon icmn-stats-bars"><!-- --></i>--}}
{{--                    Relatórios--}}
{{--                </a>--}}
{{--                <ul class="left-menu-list list-unstyled" style="display: none;">--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-login.html">--}}
{{--                            Por Contratos--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Por Formandos--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Por Produtos--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Por Categorias--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="left-menu-list-submenu">--}}
{{--                <a class="left-menu-link" href="javascript: void(0);">--}}
{{--                    <i class="left-menu-link-icon icmn-medal"><!-- --></i>--}}
{{--                    Fechamento de Turma--}}
{{--                </a>--}}
{{--                <ul class="left-menu-list list-unstyled" style="display: none;">--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-login.html">--}}
{{--                            Retirada de Convites--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Lista de Valsa--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Lista Havainas--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Lista de Fornecedores--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class="left-menu-list-submenu">--}}
{{--                <a class="left-menu-link" href="javascript: void(0);">--}}
{{--                    <i class="left-menu-link-icon icmn-medal"><!-- --></i>--}}
{{--                    Gerar Contrato--}}
{{--                </a>--}}
{{--                <ul class="left-menu-list list-unstyled" style="display: none;">--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-login.html">--}}
{{--                            PDF--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a class="left-menu-link" href="pages-register.html">--}}
{{--                            Anexos--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
        </ul>

    </div>
</nav>
