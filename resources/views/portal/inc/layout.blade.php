@include('portal.inc.top')

@include('portal.inc.nav_left')

@include('portal.inc.nav_menu')

<body>

@yield('content')

@yield('scripts')
@include('sweetalert::alert')

</body>