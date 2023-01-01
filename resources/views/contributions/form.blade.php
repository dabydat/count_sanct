@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-around mb-3">
            <div class="col-8">
                <h1>{{ $method == 'show' ? 'Ver' : ($method == 'edit' ? 'Editar' : 'Crear nueva') }}
                    aporte</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('contributions.index') }}" class="btn btn-outline-primary">Volver atrás</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if ($method == 'edit')
                    <form action="{{ route('contributions.update', ['id' => $contribution->id]) }}" method="post"
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
                                @if ($student->id == $contribution->student_id)
                                    <option value="{{ $student->id }}" selected>{{ $student->name }}
                                        {{ $student->last_name }}</option>
                                @else
                                    <option value="{{ $student->id }}">{{ $student->name }} {{ $student->last_name }}
                                    </option>
                                @endif
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
                                @if ($category->id == $contribution->category_id)
                                    <option value="{{ $category->id }}" selected>{{ $category->description }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->description }}</option>
                                @endif
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
                                    <i class="far fa-calendar-alt" style="font-size: 23px"></i>
                                </span>
                            </div>
                            <input type="text" class="contribution_date form-control float-right contribution_date"
                                name="contribution_date" id="contribution_date"
                                placeholder="Seleccione la fecha del aporte..." readonly
                                value="{{ isset($contribution->contribution_date) ? $contribution->contribution_date : old('contribution_date') }}" />
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
                            placeholder="Ingrese el monto del aporte..."
                            value="{{ isset($contribution->amount) ? $contribution->amount : old('amount') }}"
                            {{-- {{ isset($category) ? $category->amount : old('amount') }} --}} {{ $method == 'show' ? 'disabled' : '' }}>
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="period">Periodo</label>
                        <select class="form-control form-select" name="periods" id="periods">
                            <option value="">Seleccione una opción...</option>
                            @foreach ($periods as $period)
                                @if ($period->id == $contribution->period_id)
                                    <option value="{{ $period->id }}" selected>{{ $period->description }}</option>
                                @else
                                    <option value="{{ $period->id }}">{{ $period->description }}</option>
                                @endif
                            @endforeach
                        </select>
                        {{-- <input class="form-control" type="text" name="period" id="period"
                            placeholder="Ingrese el nombre..." value="" {{ isset($category) ? $category->period : old('period') }}
                            {{ $method == 'show' ? 'disabled' : '' }}>
                        @error('period')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror --}}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="description">Descripcion</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Ingrese una breve descripcion del aporte...">{{ isset($contribution->description) ? $contribution->description : old('description') }}</textarea>
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
    {!! JsValidator::formRequest('App\Http\Requests\ContributionRequest') !!}
    <script type="text/javascript">
        $(".contribution_date").datepicker({
            format: "dd-mm-yyyy",
            endView: 2,
            clearBtn: true,
            language: "es",
            orientation: "bottom auto",
            autoclose: true,
        });
    </script>
@endsection
