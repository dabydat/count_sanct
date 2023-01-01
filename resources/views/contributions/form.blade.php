@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-around mb-3">
            <div class="col-8">
                <h1>{{ $method == 'show' ? 'Ver' : ($method == 'edit' ? 'Editar' : 'Crear nueva') }}
                    categoria</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('contributions.index') }}" class="btn btn-outline-primary">Volver atrás</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if ($method == 'edit')
                    <form action="{{ route('contributions.update', ['id' => $category->id]) }}" method="post"
                        enctype="multipart/form-data">
                @endif
                @if ($method == 'create')
                    <form action="{{ route('contributions.store') }}" method="post" enctype="multipart/form-data">
                @endif
                @csrf
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="students">Estudiante</label>
                        <select class="form-control form-select" name="students" id="students">
                            <option value="">Seleccione una opción...</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} {{ $student->last_name }}</option>
                            @endforeach
                        </select>
                        {{-- <input class="form-control" type="text" name="student" id="student"
                            placeholder="Ingrese el nombre..." value="" {{ isset($category) ? $category->student : old('student') }}
                            {{ $method == 'show' ? 'disabled' : '' }}>
                        @error('student')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror --}}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="categories">Categoria</label>
                        <select class="form-control form-select" name="categories" id="categories">
                            <option value="">Seleccione una opción...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->description }}</option>
                            @endforeach
                        </select>
                        {{-- <input class="form-control" type="text" name="category" id="category"
                            placeholder="Ingrese el nombre..." value="" {{ isset($category) ? $category->category : old('category') }}
                            {{ $method == 'show' ? 'disabled' : '' }}>
                        @error('category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror --}}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="contribution_date">Dia de Aporte</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="contribution_date form-control float-right contribution_date"
                                name="contribution_date" id="contribution_date" readonly value="" />
                        </div>
                        {{-- <input class="form-control" type="text" name="contribution_date" id="contribution_date"
                            placeholder="Ingrese el nombre..." value="" {{ isset($category) ? $category->contribution_date : old('contribution_date') }}
                            {{ $method == 'show' ? 'disabled' : '' }}>
                        @error('contribution_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror --}}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="amount">Monto</label>
                        <input class="form-control" type="text" name="amount" id="amount"
                            placeholder="Ingrese el nombre..." value="" {{-- {{ isset($category) ? $category->amount : old('amount') }} --}}
                            {{ $method == 'show' ? 'disabled' : '' }}>
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="period">Periodo</label>
                        <input class="form-control" type="text" name="period" id="period"
                            placeholder="Ingrese el nombre..." value="" {{-- {{ isset($category) ? $category->period : old('period') }} --}}
                            {{ $method == 'show' ? 'disabled' : '' }}>
                        @error('period')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="description">Descripcion</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                        {{-- <input class="form-control text-area" type="text" name="description" id="description"
                            placeholder="Ingrese el nombre..." value="" {{ isset($category) ? $category->description : old('description') }} 
                            {{ $method == 'show' ? 'disabled' : '' }}> --}}
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
    <script type="text/javascript">
        $(".contribution_date").datepicker({
            format: "dd-mm-yyyy",
            endView: 2,
            clearBtn: true,
            language: "es",
            orientation: "bottom auto",
            autoclose: true
        });
    </script>
@endsection
