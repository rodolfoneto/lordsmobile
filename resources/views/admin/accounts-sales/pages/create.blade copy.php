@extends('adminlte::page')

@section('title',"Contar a Venda")

@section('content_header')
    <h1>{{ __('Create a new') }} Contas a Venda</h1>
@stop

@section('content')
    @include('admin.includes.alert')
    <div class="card">
        <form action="{{ route('admin.accounts-sales.store') }}" method="post" class="form" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h5>{{ __('Basic Information') }}</h5>
            </div>
            <div class="card-body">
                @include('admin.accounts-sales.includes.form')
            </div>
            <div class="card-footer">
                <x-adminlte-button theme="primary" type="submit" label="{{ __('Save') }}" icon="fas fa-save"/>
            </div>
        </form>
    </div>
@stop
