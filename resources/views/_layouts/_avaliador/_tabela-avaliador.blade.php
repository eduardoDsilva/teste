<table class="centered responsive-table highlight bordered">

    <thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Usuário</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($avaliadores as $avaliador)
        <tr>
            <td>{{$avaliador->id}}</td>
            <td>{{$avaliador->user->name}}</td>
            <td>{{$avaliador->user->username}}</td>
            <td>
                <a class="modal-trigger tooltipped" data-position="top" data-delay="50"
                   data-tooltip="Editar" href="{{ route("admin.avaliador.edit", $avaliador->id) }}"><i
                            class="small material-icons">edit</i></a>
                <a data-target="modal1" class="modal-trigger tooltipped" data-position="top" data-delay="50"
                   data-tooltip="Deletar" href="#modal1" data-id="{{$avaliador->id}}"
                   data-name="{{$avaliador->name}}" data-tipo="avaliador"> <i class="small material-icons">delete</i></a>
                <a class="tooltipped" data-position="top" data-delay="50" data-tooltip="Visualizar"
                   href="{{ route("admin.avaliador.show", $avaliador->id) }}"> <i
                            class="small material-icons">library_books</i></a>
                <a class="tooltipped" data-position="top" data-delay="50" data-tooltip="Projetos" href="">
                    <i class="small material-icons">view_agenda</i></a>
            </td>
        </tr>
    @empty
        <tr>
            <td>Nenhum registro encontrado</td>
            <td>Nenhum registro encontrado</td>
            <td>Nenhum registro encontrado</td>
            <td>Nenhum registro encontrado</td>
        </tr>
    @endforelse
    </tbody>
</table>
{{$avaliadores->links()}}