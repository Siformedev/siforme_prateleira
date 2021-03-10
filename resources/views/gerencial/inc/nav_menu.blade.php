<nav class="top-menu" style="background: #f1f1f1">
    <div class="menu-icon-container hidden-md-up">
        <div class="animate-menu-button left-menu-toggle">
            <div><!-- --></div>
        </div>
    </div>
    <div class="menu">
        <div class="menu-user-block">
            <div class="dropdown dropdown-avatar">
                <a href="javascript: void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="avatar" href="javascript:void(0);">
                        <img src="" alt="IMG Perfil" class="img_crop_perfil">
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="" role="menu">
                    <!--<a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon icmn-user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header">Home</div>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon icmn-circle-right"></i> System Dashboard</a>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon icmn-circle-right"></i> User Boards</a>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon icmn-circle-right"></i> Issue Navigator (35 New)</a>
                    <div class="dropdown-divider"></div>-->
                    <a class="dropdown-item" href="{{route('portal.perfil')}}"><i class="dropdown-icon icmn-exit"></i> Meus dados</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="dropdown-icon icmn-exit"></i> Logout</a>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header">Portal</div>
                    <a class="dropdown-item" href="{{route('portal.home')}}"><span class="label label-success"><i class="dropdown-icon icmn-previous"></i> Voltar para o Portal</span></a>


                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                </ul>
            </div>
        </div>
        <div class="menu-info-block">
            <div class="center-block text-center">
                <img class="height-50 logo-mobile" src="{{ asset('assets/common/img/logo.png') }}" alt="{{env('APP_NAME')}} LOGO">
                <span class="text-logo-mobile">GERENCIAL</span>
            </div>
        </div>
    </div>
</nav>