<div class="card">
    <div class="card-header">Mailman</div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>name</b>: {{ $lista->name }}</li>

            @can('admin')
            <li class="list-group-item"><b>url_mailman</b>: {{ $lista->url_mailman }}</li>
            <li class="list-group-item"><b>url completa</b>: <a href="{{ $lista->url_mailman }}/{{ $lista->name }}" target="_blank">{{ $lista->url_mailman }}/{{ $lista->name }}</a></li>
            <li class="list-group-item"><b>pass</b>: {{ $lista->pass }}</li>
            @endcan('admin')

            <li class="list-group-item"><b>emails permitidos</b>: {{ $lista->emails_allowed }}</li>
            <li class="list-group-item"><b>emails adicionais</b>: {{ $lista->emails_adicionais }}</li>
            <li class="list-group-item"><b>fonte externa (API)</b>: {{ $lista->url_externa }} ({{$lista->token}})</li>
            <li class="list-group-item"><b>consultas</b>:
                <ul>
                    @foreach($lista->consultas()->get() as $consulta)
                        <li><a href="/consultas/{{ $consulta->id }}">{{ $consulta->nome }}</a></li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
</div>

<br>
<div class="card">
    <div class="card-header">Estatística da Sincronização</div>
    <div class="card-body">
        <ul class="list-group list-group-flush">

            <li class="list-group-item"><b>Data da última sincronização</b>: 
                {{ $lista->stat_mailman_date }}</li>
        
            <li class="list-group-item"><b>Emails que deveriam estar na lista no Mailman</b>:
                {{ $lista->stat_mailman_updated }}</li>

            <li class="list-group-item"><b>Emails de fato no Mailman</b>:
                {{ $lista->stat_mailman_after }}</li>

        </ul>
    </div>
</div>