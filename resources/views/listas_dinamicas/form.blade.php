<div class="form-group">
    <label for="description">Título da Lista</label>
    <input type="text" class="form-control" name="description" value="{{ $listaDinamica->description ?? old('description')  }}" required >
</div>

<div class="card">
    <div class="card-header">Configurações do Mailmam</div>
        <div class="card-body">

            <div class="form-group">
                <label for="name">Nome de máquina da lista no mailmam</label>
                <input type="text" class="form-control" name="name" value="{{ $listaDinamica->name ?? old('name')  }}" >
            </div>

            <div class="form-group">
                <label for="url_mailman">URL de administração do Mailman</label>
                <input type="text" class="form-control" name="url_mailman" value="{{ $listaDinamica->url_mailman ?? old('url_mailman')  }}" >
            </div>

            <div class="form-group">
                <label for="pass">Senha de administração</label>
                <input type="text" class="form-control" name="pass" value="{{ $listaDinamica->pass ?? old('pass')  }}" >
            </div>

            <div class="form-group">
                <label for="emails_allowed">Emails permitidos</label>
                <textarea id="emails_allowed" class="form-control" name="emails_allowed">{{ $listaDinamica->emails_allowed ?? old('emails_allowed')  }}</textarea>
            </div>

</div>
</div>
<br>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Enviar">
</div>


