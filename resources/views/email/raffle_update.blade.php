<body>

<div style="width:800px; margin: 0 auto" align="center">

    <div style="color: black; font-family:Arial; font-size:30px;">Seu Bilhete da Rifa Coletiva Online</div>
    <hr>
    <img src="{{asset('img/portal/raffles/'.$number->img)}}" style="width: 800px">
    <br>
    <br>
    <br>
    <div>Caso não consiga visualizar a imagem do seu bilhete, <a href="{{route('raffle.number.hash', ['hash' => $number->hash])}}">clique aqui!</a> </div>

</div>


