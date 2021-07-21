<?php
$time = time();
?>
<?php /* session()->get('sucesso') != "" ? '<script>var success="true";</script>' : ""; */ ?>
<script src="{{ asset('assets/common/js/Comun.js')}}?v=<?= $time; ?>"></script>
<script src="{{ asset('assets/common/js/app.js') }}?v=<?= $time; ?>"></script>
<script>
var comun = new Comun();
<?php if (session()->has('sucesso')) { ?>
    comun.mostraMensagemSucesso();
<?php } ?>
</script>
