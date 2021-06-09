$(function () {
    $(".a-vencer-click").click(function (e) {
        alert("Seu boleto estará disponível 30 dias antes do vencimento");
    });
    $(".boleto-imprimir").click(function (e) {
        let url = "";
        url = $(this).attr('href_javascript');
        if (url.length < 50) {
            url += '/' + hash;
            location.replace(url);
        }
    });
});
PagSeguroDirectPayment.setSessionId('{{$id_sessao}}');
PagSeguroDirectPayment.onSenderHashReady(function (response) {
    if (response.status == 'error') {
        alert('Ocorreu um erro, por favor atualize a página');
        console.log(response.message);
        return false;
    }
    hash = response.senderHash;
});