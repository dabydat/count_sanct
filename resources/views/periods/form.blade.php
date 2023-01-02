@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-around mb-3">
            <div class="col-8">
                <h1>{{ $method == 'show' ? 'Ver' : ($method == 'edit' ? 'Editar' : 'Crear nuevo') }}
                    periodo</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('periods.index') }}" class="btn btn-outline-primary">Volver atrás</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if ($method == 'edit')
                    <form action="{{ route('periods.update', ['id' => $period->id]) }}" method="post"
                        enctype="multipart/form-data">
                @endif
                @if ($method == 'create')
                    <form action="{{ route('periods.store') }}" method="post" enctype="multipart/form-data">
                @endif
                @csrf
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="description">Descripcion</label>
                        <input class="form-control" type="text" name="description" id="description"
                            placeholder="Ingrese el periodo..." value="{{ isset($period) ? $period->description : old('description') }}"
                            {{ $method == 'show' ? 'disabled' : '' }}>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if ($method != 'show')
                    <button type="submit" class="btn btn-primary">Guardar</button>
                @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {!! JsValidator::formRequest('App\Http\Requests\PeriodRequest') !!}
    <script type="text/javascript"></script>
@endsection
