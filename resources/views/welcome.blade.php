@extends('layouts.main')

@section('title','Crud')
@section('content')

@if(Auth::user())
<h1>Bem vindo {{Auth::user()->name}}</h1>
@else
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endif
@endsection