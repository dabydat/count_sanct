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
                        @if ($method == 'show')
                            <input class="form-control" type="text" name="student" id="student"
                                value="{{ $contribution->student->name }} {{ $contribution->student->last_name }}" disabled>
                        @else
                            <select class="form-control form-select" name="students" id="students">
                                <option value="">Seleccione una opción...</option>
                                @foreach ($students as $student)
                                    @if (isset($contribution) && $student->id == $contribution->student_id)
                                        <option value="{{ $student->id }}" selected>{{ $student->name }}
                                            {{ $student->last_name }}</option>
                                    @else
                                        <option value="{{ $student->id }}">{{ $student->name }}
                                            {{ $student->last_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="categories">Categoria</label>
                        @if ($method == 'show')
                            <input class="form-control" type="text" name="category" id="category"
                                value="{{ $contribution->category->description }}" disabled>
                        @else
                            <select class="form-control form-select" name="categories" id="categories">
                                <option value="">Seleccione una opción...</option>
                                @foreach ($categories as $category)
                                    @if (isset($contribution) && $category->id == $contribution->category_id)
                                        <option value="{{ $category->id }}" selected>{{ $category->description }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->description }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
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
                            @if ($method == 'show')
                                <input class="form-control" type="text" name="date" id="date"
                                    value="{{ $contribution->contribution_date }}" disabled>
                            @else
                                <input type="text" class="contribution_date form-control float-right contribution_date"
                                    name="contribution_date" id="contribution_date"
                                    placeholder="Seleccione la fecha del aporte..." readonly
                                    value="{{ isset($contribution->contribution_date) ? $contribution->contribution_date : old('contribution_date') }}" />
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="period">Periodo de Recibo</label>
                        @if ($method == 'show')
                            <input class="form-control" type="text" name="period" id="period"
                                value="{{ $contribution->periods_received }}" disabled>
                        @else
                            <select class="form-control form-select" name="periods_received" id="periods_received">
                                <option value="">Seleccione una opción...</option>
                                @foreach ($periods as $period)
                                    @if (isset($contribution) && $period->id == $contribution->period_received_id)
                                        <option value="{{ $period->id }}" selected>{{ $period->description }}</option>
                                    @else
                                        <option value="{{ $period->id }}">{{ $period->description }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="amount">Monto</label>
                        <input class="form-control" type="text" name="amount" id="amount"
                            placeholder="Ingrese el monto del aporte..."
                            value="{{ isset($contribution->amount) ? $contribution->amount : old('amount') }}"
                            {{ $method == 'show' ? 'disabled' : '' }}>
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="period">Periodo Afectado</label>
                        @if ($method == 'show')
                            <input class="form-control" type="text" name="period" id="period"
                                value="{{ $contribution->periods_affected }}" disabled>
                        @else
                            <select class="form-control form-select" name="periods_affected" id="periods_affected">
                                <option value="">Seleccione una opción...</option>
                                @foreach ($periods as $period)
                                    @if (isset($contribution) && $period->id == $contribution->period_affected_id)
                                        <option value="{{ $period->id }}" selected>{{ $period->description }}</option>
                                    @else
                                        <option value="{{ $period->id }}">{{ $period->description }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="form-group col-md-6">
                        <label for="bs_amount">Monto en BS (Opcional)</label>
                        <input class="form-control" type="text" name="bs_amount" id="bs_amount"
                            placeholder="Ingrese el monto del aporte en Bolivares..."
                            value="{{ isset($contribution->bs_amount) ? $contribution->bs_amount : old('bs_amount') }}"
                            {{ $method == 'show' ? 'disabled' : '' }}>
                        @error('bs_amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="description">Descripcion</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Ingrese una breve descripcion del aporte..." @if ($method == 'show') disabled @endif>{{ isset($contribution->description) ? $contribution->description : old('description') }}</textarea>
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
