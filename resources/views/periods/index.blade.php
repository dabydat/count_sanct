@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-around mb-3">
            <div class="col-8">
                <h1>Periodos</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('periods.create') }}" class="btn btn-outline-primary">Nuevo Periodo</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="dataTable" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr class="text-center">
                            <th style="width:20px">N°</th>
                            <th>Descripcion</th>
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
            periodsList();
        });

        function periodsList() {
            var token = $("input[name~='_token']").val();
            $("#dataTable").DataTable({
                serverSide: true,
                processing: false,
                destroy: true,
                responsive: true,
                autoWidth: false,
                searching: false,
                info: true,
                pagingType: "full_numbers",
                pageLength: 10,
                bLengthChange: false,
                language: {
                    "url": "../vendor/datatables/es/es.json",
                },
                ajax: {
                    url: "{{ route('periods.list') }}",
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
                        data: 'description',
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
