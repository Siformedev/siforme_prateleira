@component('mail::message')
# Agradecemos pelo seu cadastro!

Seu pré-cadastrado foi efetuado com sucesso!

Clique no botão abaixo para efetuar sua adesão:
@component('mail::button', ['url' => 'https://agenciapni.com.br/fei2019.2', 'color' => '#ff9800'])
Adesão Online
@endcomponent

Ou copie e cole o link: agenciapni.com.br/fei2019.2

Obrigado,<br>
{{env("APP_NAME")}}
@endcomponent
