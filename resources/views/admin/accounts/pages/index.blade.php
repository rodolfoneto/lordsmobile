@extends('adminlte::page')

@section('title', 'Contas Lord Mobile')

@section('content_header')
    <h1>
        Contas Lord Mobile
        <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
    </h1>

@stop

@section('content')
    @include('admin.includes.alert')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Contas Lord Mobile</h3>
            <div class="card-tools">
                {!! $accounts->links() !!}
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table">
                <thead>
                <tr>
                    <th style="width: 100px">#</th>
                    <th style="width: 100px">{{ __('User') }}</th>
                    <th style="width: 30px">{{ __('Ativa') }}</th>
                    <th style="width: 100px">{{ __('Dt Ativada') }}</th>
                    <th style="width: 100px">{{ __('Dt Desativada') }}</th>
                    <th style="width:120px">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accounts as $item)
                    <tr>
                        <td>{{ $item->lord_account_id }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td><input type="checkbox" disabled @if($item->is_active === true) checked @endif/></td>
                        <td>{{ $item->activated_at?->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ $item->deactivated_at?->format('d/m/Y') ?? '-' }}</td>
                        <td>
                            <form class="form-inline" action="{{ route('admin.accounts.destroy', $item->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <a href="{{ route('admin.accounts.edit', $item->id) }}" class="btn text-green border"><i class="fa fa-pen"></i></a>
                                <a href="{{ route('admin.accounts.show', $item->id) }}" class="btn text-green border mx-1"><i class="fa fa-eye"></i></a>
                                <button type="submit" class="btn text-red border"><i class="fa fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
