<div class="col-sm">
    <table class="table table-striped">
    <thead>
        <tr> 
        <th><h3>Últimos emails enviados</h3></th>
        </tr>
    </thead>

    <tbody>
        @foreach($titles as $title)
        <tr>
            <td>{{$title}}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
</div>