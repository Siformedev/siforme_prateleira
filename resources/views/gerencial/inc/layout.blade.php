@include('gerencial.inc.top')

@include('gerencial.inc.nav_left')

@include('gerencial.inc.nav_menu')

<body>

@yield('content')
@include('gerencial.inc.footer')
</body>

@yield('script')
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
@include('gerencial.inc.footer')
</html>