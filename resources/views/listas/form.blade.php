<div class="form-group">
    <label for="description">Título da Lista</label>
    <input type="text" class="form-control" name="description" value="{{ $lista->description ?? old('description')  }}" required >
</div>

<div class="form-group">
    <label for="replicado_query">Replicado Query (sem ;)</label>
    <textarea id="replicado_query" class="form-control" name="replicado_query" rows="7">{{ $lista->replicado_query ?? old('replicado_query')  }}</textarea>
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

</div>
</div>
<br>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Enviar">
</div>


