class Comun {

    constructor() {
        this.pathResources = '/assets/common/js/scripts/';
        this.loadScripts();
    }
    loadScripts() {
        if (typeof Jss !== "undefined") {
            $(Jss).each(function (indice, elemento) {
                $.getScript(this.pathResources + elemento + ".js")
                        .done(function (script, textStatus) {
                        }).fail(function (jqxhr, settings, exception) {
                    alert("Houve um erro na requisição do script [" + elemento + ".js]");
                });
            });
        }
    }
    datatable(reference, display = 25) {
        $(reference).DataTable({
            responsive: true,
            "oLanguage": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "iDisplayLength": display,
            paging: true
        });
    }
}
