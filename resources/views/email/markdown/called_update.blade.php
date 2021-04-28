@component('mail::message')
# Agradecemos pelo seu contato!

Seu chamado de número {{$called->id}} foi respondido!

Resposta: {{$msg}}

Clique no botão abaixo para acessar:
@component('mail::button', ['url' => route('portal.chamados.show', ['chamdo' => $called->id])])
Acessar
@endcomponent

Obrigado,<br>
Agência Pingo No I
@endcomponent