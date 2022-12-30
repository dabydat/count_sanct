@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-around mb-3">
            <div class="col-8">
                <h1>Registrar nuevo estudiante</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('students.index') }}" class="btn btn-outline-primary">Volver atrás</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="{{ route('students.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="name">Nombre</label>
                            <input class="form-control" type="text" name="name" id="name"
                                placeholder="Ingrese el nombre...">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Apellido</label>
                            <input class="form-control" type="text" name="last_name" id="last_name"
                                placeholder="Ingrese el apellido...">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="dni">Cédula</label>
                            <input class="form-control" type="text" name="dni" id="dni"
                                placeholder="Ingrese la cedula...">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Correo Electrónico</label>
                            <input class="form-control" type="text" name="email" id="email"
                                placeholder="Ingrese el correo electrónico...">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="phone">Telefono</label>
                            <input class="form-control" type="text" name="phone" id="phone"
                                placeholder="Ingrese el número de teléfono...">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript"></script>
@endsection
