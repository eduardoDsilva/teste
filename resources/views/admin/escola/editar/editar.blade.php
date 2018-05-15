@extends('layout.site')

@section('titulo','Motic Admin')

@section('conteudo')

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <a class="btn green" href="{{url()->previous()}}">Voltar</a>

    <section class="container">
        <div class="row">
            <h3 class="center-align">Editar escola</h3>
            <article class="col s12">
                <form method="POST" enctype="multipart/form-data" action="{{ url("/admin/escola/".$escola->id) }}">
                    {{ csrf_field() }}
                    <h5>Dados básicos</h5>

                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">perm_identity</i>
                            <label for="nome">Nome da escola</label>
                            <input type="text" name="name" required value="{{$escola->name}}">
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">school</i>
                            <select name="tipoEscola">
                                <option value="" disabled>Tipo</option>
                                <option value="publica" @if($escola->tipoEsola=="publica") selected @endif>Pública</option>
                                <option value="privada" @if($escola->tipoEsola=="privada") selected @endif>Privada</option>
                            </select>
                            <label>Tipo Escola</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">email</i>
                            <label for="email">Email</label>
                            <input type="email" name="email" required value="{{$escola->users->email}}">
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">local_phone</i>
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" required value="{{$escola->telefone}}">
                        </div>
                    </div>

                    <h5>Endereço</h5>

                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">explore</i>
                            <label for="cep">CEP</label>
                            <input type="number" name="cep" required value="{{$escola->users->endereco->cep}}">
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">business</i>
                            <label for="bairro">Bairro</label>
                            <input type="text" name="bairro" value="{{$escola->users->endereco->bairro}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s4">
                            <i class="material-icons prefix">home</i>
                            <label for="rua">Rua</label>
                            <input type="text" name="rua" required value="{{$escola->users->endereco->rua}}">
                        </div>

                        <div class="input-field col s4">
                            <i class="material-icons prefix">filter_1</i>
                            <label for="numero">N°</label>
                            <input type="number" name="numero" required value="{{$escola->users->endereco->numero}}">
                        </div>

                        <div class="input-field col s4">
                            <i class="material-icons prefix">home</i>
                            <label for="complemento">Complemento</label>
                            <input type="text" name="complemento" required value="{{$escola->users->endereco->complemento}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s4">
                            <i class="material-icons prefix">location_city</i>
                            <label for="cidade">Cidade</label>
                            <input type="text" name="cidade" required value="{{$escola->users->endereco->cidade}}">
                        </div>

                        <div class="input-field col s4">
                            <i class="material-icons prefix">location_city</i>
                            <label for="estado">Estado</label>
                            <input type="text" name="estado" required value="{{$escola->users->endereco->estado}}">
                    </div>

                        <div class="input-field col s4">
                            <i class="material-icons prefix">location_city</i>
                            <label for="pais">País</label>
                            <input type="text" name="pais" required value="{{$escola->users->endereco->pais}}">
                        </div>
                    </div>

                    <h5>Usuário</h5>

                    <div class="input-field">
                        <i class="material-icons prefix">person</i>
                        <label for="usuario">Usuário</label>
                        <input type="text" name="username" required value="{{$escola->users->username}}">
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">person_pin</i>
                            <label for="password">Senha</label>
                            <input type="password" name="password" required value="{{$escola->users->password}}">
                        </div>

                        <div class="input-field col s6">
                            <i class="material-icons prefix">person_pin</i>
                            <label for="password_confirmation">Confirmar senha</label>
                            <input type="password" name="password_confirmation" required value="{{$escola->users->password}}">
                        </div>
                    </div>

                    <p class="center-align">
                        <button class="waves-effect waves-light btn" type="submit"><i class="material-icons right">send</i>salvar</button>
                    </p>

                </form>

            </article>
        </div>
    </section>

@endsection