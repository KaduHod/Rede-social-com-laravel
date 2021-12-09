@extends('layouts.main')

@section('title','Crud')
@section('content')
<div class='mainContent'>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <table class="table">
    <thead>
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Nome</th>
        <th scope="col">Email</th>
        <th scope="col">Admin</th>
        <th scope="col">Editar/Excluir</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            
        <tr>
            <th scope="row">{{$user->id}}</th>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->isAdmin}}</td>
            <td>
                <a href="/tabelaDeUsuarios/editUser/{{$user->id}}" class='btn btn-info'><ion-icon name="create"></ion-icon></a>
                @if($user->id != Auth::user()->id)
                    <a href="/tabelaDeUsuarios/exclude/{{$user->id}}" class='btn btn-danger'><ion-icon name="trash"></ion-icon></a>
                @endif
                
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>

</div>

@endsection