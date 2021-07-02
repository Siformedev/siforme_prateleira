'use strict';
class Comun {

    constructor() {
        this.pathResources = '/assets/common/js/scripts/';
        this.loadScripts();
        this.aplicaMascaras();
    }

    loadScripts() {
        var object=this;
        if (typeof Jss !== "undefined") {
            $(Jss).each(function (indice, elemento) {
                $.getScript(object.pathResources + elemento + ".js")
                        .done(function (script, textStatus) {
                        }).fail(function (jqxhr, settings, exception) {
                    alert("Houve um erro na requisição do script [" + elemento + ".js]");
                });
            });
        }
    }

    print(element) {
        var WindowPrint;
        WindowPrint = window.open('', '', 'width=1200,height=800');
        WindowPrint.document.write(`
                            <html>
                                <head>
                                <style type="text/css">
                                @media print {
                                   tr:nth-child(even) td {
                                       background-color: #dfe4ed !important;
                                        -webkit-print-color-adjust: exact;
                                   }
                                }
                                </style>
                                </head>
                                <body onload="window.print()">
                                ` + $(element)[0].outerHTML + `
                                </body>
                            </html>
                            `);
        WindowPrint.document.close();
        WindowPrint.focus();
    }

    datatable(reference, display = 25) {
        $(reference).DataTable({
            responsive: false,
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

    aplicaMascaras() {
        $(".moeda").maskMoney({decimal: ".", thousands: ""});
    }

    mostraMensagemSucesso(message) {
        swal("Sucesso", (typeof message !== "undefined" ? message : "Ação realizada com sucesso !"), "success");
    }
}
