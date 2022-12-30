@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-around mb-3">
            <div class="col-8">
                <h1>Estudiantes</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('students.create') }}" class="btn btn-outline-primary">Nuevo Estudiante</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="dataTable" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr class="text-center">
                            <th style="width:20px">N°</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Cedula</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            studentsList();
        });

        function studentsList() {
            var token = $("input[name~='_token']").val();
            $("#dataTable").DataTable({
                serverSide: true,
                processing: true,
                destroy: true,
                responsive: true,
                autoWidth: false,
                searching: false,
                info: true,
                pagingType: "full_numbers",
                pageLength: 10,
                bLengthChange: false,
                language: {
                    "url": "../vendor/datatables/es/es.json"
                },
                ajax: {
                    url: "{{ route('students.list') }}",
                    type: "POST",
                    data: {
                        "_token": token,
                    },
                },
                columns: [{
                        data: 'nro',
                        orderable: false
                    },
                    {
                        data: 'name',
                        orderable: false
                    },
                    {
                        data: 'last_name',
                        orderable: false
                    }, {
                        data: 'dni',
                        orderable: false
                    }, {
                        data: 'phone',
                        orderable: false
                    }, {
                        data: 'email',
                        orderable: false
                    },
                    {
                        data: 'status',
                        orderable: false
                    },
                    {
                        data: 'actions',
                        orderable: false
                    },
                ],
            });
        }
    </script>
@endsection
