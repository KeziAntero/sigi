@extends('layouts.app')

@section('title', __('imovel.list'))

@section('content')

<div class="mb-3">
    <br>
    <div class="float-right">
        @can('create', new App\Imovel)
            <a href="{{ route('imoveis.create') }}" class="btn btn-success">{{ __('imovel.create') }}</a>
        @endcan
    </div>
    <br>
    <h2 class="page-title">{{ __('imovel.list') }}</h2>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <input placeholder="{{ __('imovel.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('imovel.search') }}" class="btn btn-secondary">
                    <a href="{{ route('imoveis.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('imovel.seq') }}</th>
                        <th>{{ __('imovel.tipo') }}</th>
                        <th>{{ __('imovel.setor') }}</th>
                        <th>{{ __('imovel.quadra') }}</th>
                        <th>{{ __('imovel.lote') }}</th>
                        <th>{{ __('imovel.cpf') }}</th>
                        <th>{{ __('imovel.name_owner') }}</th>
                        <th>{{ __('imovel.latitude') }}</th>
                        <th>{{ __('imovel.longitude') }}</th>
                        
                    <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($imoveis as $key => $imovel)
                    <tr>
                        <td class="text-center">{{ $imoveis->firstItem() + $key }}</td>
                        
                        <td>{!!$imovel->seq_link !!}</td>
                        <td>{{$imovel->tipo}}</td>
                        <td>{{ $imovel->setor }}</td>
                        <td>{{ $imovel->quadra }}</td>
                        <td>{{ $imovel->lote }}</td>
                        <td>{{ $imovel->owner->cpf }}</td>
                        <td>{{ $imovel->owner->name_owner }}</td>
                        <td>{{ $imovel->latitude }}</td>
                        <td>{{ $imovel->longitude }}</td>
                      
                        <td>
                           <a href="{{ route('imoveis.show', $imovel->id) }}" id="show-imovel-{{ $imovel->id }}" class="btn btn-primary">{{ __('imovel.show') }} </a>
                           <a href="{{ route('imoveis.edit', $imovel->id) }}" id="edit-imovel-{{ $imovel->id }}" class="btn btn-warning">{{ __('imovel.edit') }} </a>
                           
                           <form method="POST" action="{{ route('imoveis.destroy', $imovel) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                                {{ csrf_field() }} {{ method_field('delete') }}
                                <input name="imovel_id" type="hidden" value="{{ $imovel->id }}">
                               <button type="submit" class="btn btn-danger btn-sm">{{ __('app.delete_confirm_button') }}</button>
                            </form>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $imoveis->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
<small>{{ __('app.total') }} {{ __('imovel.imovel') }}  : {{ $imoveis->total() }} </small>
@endsection
