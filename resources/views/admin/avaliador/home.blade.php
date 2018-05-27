@extends('layout.site')

@section('titulo','Motic Admin')

@section('conteudo')

    @if(Session::get('mensagem'))
        <div class="center-align">
            <div class="chip green">
                {{Session::get('mensagem')}}
                <i class="close material-icons">close</i>
            </div>
        </div>
        {{Session::forget('mensagem')}}
    @endif

    <a class="btn green" href="{{url()->previous()}}">Voltar</a>

    <div class="section no-pad-bot" id="index-banner">
        <div class="container">
            <br><br>
            <h1 class="header center orange-text">Avaliadores</h1>
            <div class="row center">
                <h5 class="header col s12 light">Esses são os avaliadores cadastrados no sistema!</h5>
            </div>
            <br>
        </div>
    </div>

    <div class="container">
        <div class="col s12 m4 l8">

            <table>
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>
                </thead>
                @forelse ($avaliadores as $avaliador)
                    <tbody>
                    <tr>
                        <td>{{$avaliador->user->name}}</td>
                        <td>{{$avaliador->user->username}}</td>
                        <td>{{$avaliador->user->email}}</td>
                        <td>{{$avaliador->user->telefone}}</td>
                        <td>{{$avaliador->user->endereco->rua}}</td>
                        <td>
                            <a class="modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Editar"  href="{{ url("/admin/avaliador/update/".$avaliador->id."/editar") }}"><i class="small material-icons">edit</i></a>
                            <a data-target="modal1" class="modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Deletar"  href="#modal1"> <i class="small material-icons">delete</i></a>
                        </td>
                    </tr>
                    </tbody>
                    <!-- Modal Structure -->
                    <div id="modal1" class="modal">
                        <div class="modal-content">
                            <h4>Deletar</h4>
                            <p>Você tem certeza que deseja deletar o avaliador?</p>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ url("/admin/avaliador/deletar/".$avaliador->user->id."/excluir") }}" class="btn red">Sim</a>
                        </div>
                    </div>
                @empty
                    <tbody>
                    <tr>
                        <td>Nenhum avaliador encontrado</td>
                        <td>Nenhum avaliador encontrado</td>
                        <td>Nenhum avaliador encontrado</td>
                        <td>Nenhum avaliador encontrado</td>
                        <td>Nenhum avaliador encontrado</td>
                        <td>Nenhum avaliador encontrado</td>
                    </tr>
                    </tbody>
                @endforelse
            </table>

            <br><br>
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large waves-effect waves-light red tooltipped" data-position="top" data-delay="50" data-tooltip="Adicionar avaliador" href="{{route ('admin/avaliador/cadastro/registro')}}"><i class="material-icons">add</i></a>
            </div>
            <br><br>

            <br><br>




        </div>
    </div>

@endsection
