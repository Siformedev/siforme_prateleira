$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function mostraoverlay(mensagem) {
    $('#msgoverlay').html(mensagem);
    $(document).find('#overlaymaster,#suboverlay').removeClass('hidden');
    $('#suboverlay').addClass('d-flex align-items-center');
    $('#suboverlay').css({'display': 'flex'});
}
function escondeoverlay() {
    $('#msgoverlay').html("");
    $('#suboverlay').removeClass('d-flex align-items-center');
    $('#overlaymaster,#suboverlay').addClass('hidden');
}
function escondeOverlay() {
    return escondeoverlay();
}
function mostraOverlay(mensagem) {
    return mostraoverlay(mensagem);
}
function mostraMensagem(mensagem) {
    $("#bodymodalmessages").html(mensagem);
    $("#modalmessages").modal("show");
}
$(document).on('click', ".deletebutton", function (e) {
    e.preventDefault();
    var href = $(this).attr('href');
    swal({
        title: "Confirmação",
        text: "Tem certeza que deseja excluir ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, exclua !",
        cancelButtonText: "Não, foi engano !",
        closeOnConfirm: false,
        closeOnCancel: false
    },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = (href);
                } else {
                    swal("Cancelado", "A ação foi cancelada", "error");
                }
            });
});
if (typeof success != "undefined") {
    swal({
        title: "Sucesso",
        text: "Ação realizada com sucesso !",
        type: "success",
    });
}
if (typeof Jss !== "undefined") {
    /*$(Jss).each(function (indice, elemento) {
        $.getScript('/assets/common/js/scripts/' + elemento + ".js")
                .done(function (script, textStatus) {
                }).fail(function (jqxhr, settings, exception) {
            alert("Houve um erro na requisição do script [" +  elemento + ".js]");
        });
    });*/
}
