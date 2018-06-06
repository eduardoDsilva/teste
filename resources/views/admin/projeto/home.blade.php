
@extends('layout.site')

@section('titulo','Motic Admin')

@section('breadcrumb')
    <a href="{{{route ('admin/home')}}}" class="breadcrumb">Home</a>
    <a href="{{{route ('admin/projeto/home')}}}" class="breadcrumb">Projetos</a>
@endsection

@section('conteudo')

    @if(session('success'))
        {{session('success')}}
    @endif

    <div class="section container">
        <div class="card-panel">
            <h1 class="header center orange-text">Projetos</h1>
            <div class="row center">
                <h5 class="header col s12 light">Essas são os projetos cadastrados no sistema!</h5>
            </div>
        </div>
    </div>

    <div class="section container">
        <div class="card-panel">
        <div class="col s12 m4 l8">

            <table class="centered responsive-table highlight bordered">

                <form method="POST" enctype="multipart/form-data" action="{{ url("admin/escola/show") }}">
                    <div class="input-field">
                        <input id="search" type="search">
                        <label for="search"><i class="material-icons">search</i></label>
                    </div>
                    {{csrf_field()}}
                </form>

                <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Área</th>
                    <th>Estande</th>
                    <th>Resumo</th>
                    <th>Status</th>
                    <th>Categoria</th>
                    <th>Escola</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($projetos as $projeto)
                    <tr>
                        <td>{{$projeto->id}}</td>
                        <td>{{$projeto->titulo}}</td>
                        <td>{{$projeto->area}}</td>
                        <td>{{$projeto->estande == null ? 'Estande não definida' : $projeto->estande}}</td>
                        <td>{{$projeto->resumo}}</td>
                        <td>{{$projeto->status}}</td>
                        <td>{{$projeto->categoria->categoria}}</td>
                        <td>{{$projeto->escola->name}}</td>
                        <td>
                            <a class="modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Editar"  href="{{ url("admin/projeto/update/".$projeto->id."/edita") }}"><i class="small material-icons">edit</i></a>
                            <a data-target="modal1" class="modal-trigger tooltipped" data-position="top" data-delay="50" data-tooltip="Deletar"  href="#modal1" data-id="{{$projeto->id}}" data-name="{{$projeto->titulo}}"> <i class="small material-icons">delete</i></a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td>Nenhuma projeto encontrado</td>
                        <td>Nenhuma projeto encontrado</td>
                        <td>Nenhuma projeto encontrado</td>
                        <td>Nenhuma projeto encontrado</td>
                        <td>Nenhuma projeto encontrado</td>
                        <td>Nenhuma projeto encontrado</td>
                        <td>Nenhuma projeto encontrado</td>
                        <td>Nenhuma projeto encontrado</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="fixed-action-btn">
                <a class="btn-floating btn-large red">
                    <i class="large material-icons">mode_edit</i>
                </a>
                <ul>
                    <li><a class="btn-floating red tooltipped" data-position="left" data-delay="50" data-tooltip="Adicionar projeto" href="{{route ('admin/projeto/cadastro/registro')}}"><i class="material-icons">add</i></a></li>
                    <li><a class="btn-floating yellow darken-1 tooltipped" data-position="left" data-delay="50" data-tooltip="Adicionar aluno" href="{{route ('admin/aluno/cadastro/registro')}}"><i class="material-icons">format_quote</i></a></li>
                    <li><a class="btn-floating green tooltipped" data-position="left" data-delay="50" data-tooltip="Adicionar professor" href="{{route ('admin/professor/cadastro/registro')}}"><i class="material-icons">publish</i></a></li>
                    <li><a class="btn-floating blue tooltipped" data-position="left" data-delay="50" data-tooltip="Adicionar escola" href="{{route ('admin/escola/cadastro/registro')}}"><i class="material-icons">attach_file</i></a></li>
                </ul>
            </div>

        </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Deletar</h4>
            <p>Você tem certeza que deseja deletar o projeto abaixo?</p>
            <div class="row">
                <label for="id_delete">ID</label>
                <div class="input-field col s12">
                    <input disabled class="validate" type="number" id="id_delete">
                </div>
            </div>
            <div class="row">
                <label for="name_delete">Nome do projeto</label>
                <div class="input-field col s12">
                    <input disabled class="validate" type="text" id="name_delete">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn red delete">Sim</a>
        </div>
    </div>

@endsection
