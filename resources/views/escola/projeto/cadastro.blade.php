@extends('_layouts._app')

@section('titulo','Motic Admin')

@section('breadcrumb')
    <a href="{{route ('escola')}}" class="breadcrumb">Home</a>
    <a href="{{route ('escola.projeto')}}" class="breadcrumb">Projetos</a>
    <a href="{{route ('escola.projeto.create')}}" class="breadcrumb">Cadastro</a>
@endsection

@section('content')

@section('titulo-header', 'Cadastrar projeto')

@section('conteudo-header', "- Os campos com ' * ' são de preenchimento obrigatório e deve-se selecionar exatamente 3 alunos.")

@includeIf('_layouts._sub-titulo')

<section class="section container">
    <div class="card-panel">
        <div class="row">
            @includeIf('_layouts._mensagem-erro')
            <article class="col s12">
                <form method="POST" enctype="multipart/form-data" action="{{ route('escola.projeto.store') }}">

                    <h5>Dados básicos</h5>

                    <div class="row">
                        <div class="input-field col s12 m12 l6">
                            <i class="material-icons prefix">perm_identity</i>
                            <label for="nome">Título *</label>
                            <input type="text" name="titulo" value="{{old('titulo')}}" required>
                        </div>
                        <div class="input-field col s12 m12 l6">
                            <i class="material-icons prefix">perm_identity</i>
                            <label for="nome">Área *</label>
                            <input type="text" name="area" value="{{old('area')}}" required>
                        </div>
                    </div>


                    <blockquote>
                        ATENÇÃO!
                        O resumo deve ter entre 50 e 3000 caracteres.
                    </blockquote>

                    <div class='row'>
                        <div class="input-field col s12 m12 l12">
                            <i class="material-icons prefix">assignment</i>
                            <textarea name="resumo" id="textarea1" data-length="3000"
                                      class="materialize-textarea">{{old('resumo')}}</textarea>
                            <label for="textarea1">Resumo *</label>
                        </div>
                    </div>

                    <blockquote>
                        Você pode escolher mais de uma disciplina.
                    </blockquote>

                    <div class="row">
                        <div class="input-field col s12 m12 l12">
                            <i class="material-icons prefix">assignment</i>
                            <select multiple name="disciplina_id[]">
                                <option value="" disabled selected>Selecione as disciplinas</option>
                                @forelse ($disciplinas as $disciplina)
                                    <option value="{{$disciplina->id}}">{{$disciplina->name}}</option>
                                @empty
                                    <option value="">Nenhuma disciplina cadastrada no sistema! Entre em contato com
                                        o administrador.
                                    </option>
                                @endforelse
                            </select>
                            <label>Disciplinas *</label>
                        </div>
                    </div>

                    <div class="row">

                        <div class="input-field col s12 m12 l12">
                            <i class="material-icons prefix">assignment</i>
                            <input type="text" name="escola_id" value="{{$escola->name or old('name')}}" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <blockquote>
                            Atenção!
                            Primeiro selecione a categoria, e então os alunos serão carregados.
                        </blockquote>
                        <div class="input-field col s12 m12 l6">
                            <i class="material-icons prefix">assignment</i>
                            <select id='categoria' name="categoria_id" required>
                                @forelse ($categorias as $categoria)
                                    <option value="{{$categoria->id}}">{{$categoria->categoria}}</option>
                                @empty
                                    <option value="" disabled selected>Nenhuma categoria cadastrada no sistema!
                                        Entre em contato com o administrador.
                                    </option>
                                @endforelse
                            </select>
                            <label>Categoria *</label>
                        </div>

                        <div class="input-field col s12 m12 l6">
                            <i class="material-icons prefix">assignment</i>
                            <select multiple name="aluno_id[]" id="alunos" required>
                            </select>
                            <label>Alunos *</label>
                        </div>
                    </div>

                    <div class="row">

                        <div class="input-field col s12 m12 l6">
                            <i class="material-icons prefix">assignment</i>
                            <select name="orientador" id="orientador" required>
                                <option value="" disable selected>Escolha um orientador...</option>
                                @forelse ($professores as $professor)
                                    <option value="{{$professor->id}}">{{$professor->name}}</option>
                                @empty
                                    <option value="" disabled selected>Nenhum professor cadastrado no sistema.
                                    </option>
                                @endforelse
                            </select>
                            <label>Orientador *</label>
                        </div>

                        <div class="input-field col s12 m12 l6">
                            <i class="material-icons prefix">assignment</i>
                            <select name="coorientador" id="coorientador">
                                <option value="" disable selected>Escolha um coorientador...</option>
                                @forelse ($professores as $professor)
                                    <option value="{{$professor->id}}">{{$professor->name}}</option>
                                @empty
                                    <option value="" disabled selected>Nenhum professor cadastrado no sistema.
                                    </option>
                                @endforelse
                            </select>
                            <label>Coorientador</label>
                        </div>

                    </div>

                    {{csrf_field()}}

                    <div class="fixed-action-btn">
                        <button id="envia" disabled type="submit"
                                class="btn-floating btn-large waves-effect waves-light red tooltipped  modal-trigger"
                                data-position="top" data-delay="50" data-tooltip="Cadastrar"><i
                                    class="material-icons">add_circle_outline</i></button>
                    </div>

                </form>

            </article>
        </div>
    </div>
</section>
@endsection


























