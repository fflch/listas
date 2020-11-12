<div class="form-group">
    <label for="nome">Nome da Consulta</label>
    <input type="text" class="form-control" name="nome" value="{{ $consulta->nome ?? old('nome')  }}" required >
</div>

<div class="form-group">
    <label for="replicado_query">Consulta (Query) - sem ";"</label>
    <textarea id="replicado_query" class="form-control" name="replicado_query" rows="7">{{ $consulta->replicado_query ?? old('replicado_query')  }}</textarea>
</div>
<br>
<div class="form-group">
    <input type="submit" class="btn btn-primary" value="Enviar">
</div>


