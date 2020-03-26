<div class="form-group">
    <label for="name">Nome de máquina da lista</label>
    <input type="text" class="form-control" name="name" value="{{ $lista->name ?? old('name')  }}" required >
</div>

<div class="form-group">
    <label for="url_mailman">URL de administração do Mailman</label>
    <input type="text" class="form-control" name="url_mailman" value="{{ $lista->url_mailman ?? old('url_mailman')  }}" required >
</div>

<div class="form-group">
    <label for="description">Descrição da Lista</label>
    <input type="text" class="form-control" name="description" value="{{ $lista->description ?? old('description')  }}" required >
</div>

<div class="form-group">
    <label for="pass">Senha de administração da Lista</label>
    <input type="text" class="form-control" name="pass" value="{{ $lista->pass ?? old('pass')  }}" required >
</div>

<div class="form-group">
    <label for="emails_allowed">Emails permitidos</label>
    <textarea id="emails_allowed" class="form-control" name="emails_allowed">{{ $lista->emails_allowed ?? old('emails_allowed')  }}</textarea>
</div>

<div class="form-group">
    <label for="replicado_query">Replicado Query (sem ;)</label>
    <textarea id="replicado_query" class="form-control" name="replicado_query">{{ $lista->replicado_query ?? old('replicado_query')  }}</textarea>
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Enviar">
</div>


