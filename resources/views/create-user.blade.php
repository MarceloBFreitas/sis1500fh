@extends('adminlte::page')

@section('title', 'Cadastro de Staff')

@section('content_header')

    <h1>Cadastro de Pessoas</h1>
@stop

@section('content')

<div class="container">
    <form action="/registrar-usuario" method="post">
        {!! csrf_field() !!}
        <label for="">Nome</label>
        <input type="text" name="nome" placeholder="Nome Completo" class="form-control">
        <label for="">Email</label>
        <input type="text" name="email" placeholder="E-Mail Corporativo" class="form-control">
        <label for="">Tipo de Acesso</label>
        <select name="cargo"  id="" class="form-control">
            <option value="1">Administrativo</option>
            <option value="2">Gerência</option>
            <option value="3">Consultor</option>
        </select>

        <label for="">Digite a Senha</label>
        <strong>Senha para primeiro acesso gerada automaticamente: 121212</strong>
        <input name="senha" type="password" placeholder="E-Mail Corporativo" value="121212" class="form-control">
        <br>
        <a href="/"><button class="btn btn-default">Voltar</button></a> <button type="submit" class="btn btn-success">Cadastrar</button>
    </form>
</div>


@stop