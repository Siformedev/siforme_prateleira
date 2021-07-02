$(document).ready(function () {
    var id;
    $(document).on('click', '.editparcela', function () {
        id = $(this).data('identity');
        $.ajax({
            method: "POST",
            url: "/gerencial/formando/getparcela/" + id,
            data: {},
            dataType: "json",
            success: function (data) {
                $("#id").val(data.parcela.id);
                $("#valor").val(data.parcela.valor);
                $("#datavencimento").val(data.parcela.dt_vencimento);
                app.mostraModal('#modalparcelas');
            }
        });
    });
    $(document).on('click', '#btnsave', function () {
        $.ajax({
            method: "POST",
            url: "/gerencial/formando/editparcela/" + id,
            data: $('#formulario').serialize()+'&prodid='+prod.id+"&formandosid="+prod.forming_id+"&contratoid="+prod.contract_id,
            dataType: "json",
            success: function (data) {
                app.escondeModal('#modalparcelas');
                window.location.reload();
            }
        });
    });
    $(document).on('click', '.removeparcela', function () {
        id = $(this).data('identity');
        if (confirm('Tem certeza que deseja excluir o registro ?')) {
            $.ajax({
                method: "POST",
                url: "/gerencial/formando/removeparcela/" + id,
                data: {},
                dataType: "json",
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
    $(document).on('click', '#btnaddparcela', function () {
        id = 0;
        app.mostraModal('#modalparcelas');
    });
});

