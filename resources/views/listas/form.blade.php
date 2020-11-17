<div class="form-group">
    <label for="description">Título da Lista</label>
    <input type="text" class="form-control" name="description" value="{{ $lista->description ?? old('description')  }}" required >
</div>

<div class="form-group">
    <label for="replicado_query">Consultas</label>
    <select multiple="" name="replicado_query[]" class="form-control" id="replicado_query">
        @foreach($lista->consultaOptions() as $consulta)
                @if(old('replicado_query') == '')
                    <option value="{{ $consulta->id }}" @foreach($lista->consultas()->get() as $replicado_query) {{ ($consulta->id == $replicado_query->id) ? 'selected' : ''}} @endforeach>
                        {{ $consulta->nome }} | {{ $consulta->replicado_query }}
                    </option>                
                @else
                    <option value="{{ $consulta->id }}" {{ (Request()->nome == $consulta->nome) ? 'selected' : ''}}>
                        {{ $consulta->nome }} | {{ $consulta->replicado_query }}
                    </option>   
                @endif
        @endforeach
    </select>
</div>

<div class="card">
    <div class="card-header">Configurações Opcionais para lista Mailmam</div>
        <div class="card-body">

            <div class="form-group">
                <label for="name">Nome de máquina da lista no mailmam</label>
                <input type="text" class="form-control" name="name" value="{{ $lista->name ?? old('name')  }}" >
            </div>

            <div class="form-group">
                <label for="url_mailman">URL de administração do Mailman</label>
                <input type="text" class="form-control" name="url_mailman" value="{{ $lista->url_mailman ?? old('url_mailman')  }}" >
            </div>

            <div class="form-group">
                <label for="pass">Senha de administração</label>
                <input type="text" class="form-control" name="pass" value="{{ $lista->pass ?? old('pass')  }}" >
            </div>

            <div class="form-group">
                <label for="emails_allowed">Emails permitidos</label>
                <textarea id="emails_allowed" class="form-control" name="emails_allowed">{{ $lista->emails_allowed ?? old('emails_allowed')  }}</textarea>
            </div>

            <div class="form-group">
                <label for="emails_adicionais">Emails adicionais</label>
                <textarea id="emails_adicionais" class="form-control" name="emails_adicionais">{{ $lista->emails_adicionais ?? old('emails_adicionais')  }}</textarea>
            </div>

</div>
</div>
<br>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Enviar">
</div>


