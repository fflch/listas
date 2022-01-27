@component('mail::message')
# Desinscrição

Olá, recebemos a solicitação da sua desinscração nas listas de e-mail da FFLCH. <br>
Para seguir com o processo clique no botão abaixo ou acesse a url <a href="{{$unsubscribe_link}}">{{$unsubscribe_link}}</a>.


@component('mail::button', ['url' => $unsubscribe_link])
Desinscrever-se
@endcomponent

@endcomponent
