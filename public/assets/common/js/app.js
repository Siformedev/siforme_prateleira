class App {

    constructor() {
        this.locationJs = "/assets/js/";
        this.loadScripts();
        this.applyMasks();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
    applyMasks() {
        $(".moeda").maskMoney({"thousands":""});
    }
    loadScripts() {
        var object = this;
        /*if (typeof Jss !== "undefined") {
            $(Jss).each(function (indice, elemento) {
                $.getScript(object.locationJs + elemento + ".js?v="+Date.now())
                        .done(function (script, textStatus) {
                        }).fail(function (jqxhr, settings, exception) {
                    alert("Houve um erro na requisição do script [" + object.locationJs + elemento + ".js]");
                });
            });
        }*/
    }

    showMessage(message) {
        alert(message);
    }

    mostraoverlay(mensagem) {
        $('#msgoverlay').html(mensagem);
        $(document).find('#overlaymaster,#suboverlay').removeClass('d-none');
        $('#suboverlay').addClass('d-flex align-items-center');
    }

    escondeoverlay() {
        $('#msgoverlay').html("");
        $('#suboverlay').removeClass('d-flex align-items-center');
        $('#overlaymaster,#suboverlay').addClass('d-none');
    }
    mostraModal(id) {
        $(id).modal('show');
    }
    escondeModal(id) {
        $(id).modal('hide');
    }

}

var app = new App();
