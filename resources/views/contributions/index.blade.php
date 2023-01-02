@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-around mb-3">
            <div class="col-8">
                <h1>Aportes</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('contributions.create') }}" class="btn btn-outline-primary">Nuevo Aporte</a>
            </div>
            <div class="col-2">
                <a href="{{ route('contributions.export') }}" class="btn btn-outline-success">Exportar Datos</a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-sm-12">
                <table id="dataTable" class="table table-bordered table-striped text-center" >
                    <thead>
                        <tr class="text-center">
                            <th style="width:20px">N°</th>
                            <th>Dia de aporte</th>
                            <th>Estudiante</th>
                            <th>Categoria</th>
                            <th>Aporte</th>
                            <th>Descripcion</th>
                            <th>Periodo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="contributionsPerPeriods" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr class="text-center">
                            <th style="width:20px">N°</th>
                            <th>Periodo</th>
                            <th>Monto Total</th>
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
            contributionsList();
            contributionsPerPeriodsList();
        });

        function contributionsList() {
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
                    // "processing": '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
                },
                ajax: {
                    url: "{{ route('contributions.list') }}",
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
                        data: 'contribution_date',
                        orderable: false
                    },
                    {
                        data: 'student',
                        orderable: false
                    },
                    {
                        data: 'category',
                        orderable: false
                    },
                    {
                        data: 'amount',
                        orderable: false
                    },
                    {
                        data: 'description',
                        orderable: false
                    },
                    {
                        data: 'period',
                        orderable: false
                    },
                    {
                        data: 'actions',
                        orderable: false
                    },
                ]
            });
        }

        function contributionsPerPeriodsList() {
            var token = $("input[name~='_token']").val();
            $("#contributionsPerPeriods").DataTable({
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
                    // "processing": '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
                },
                ajax: {
                    url: "{{ route('contributions.contributionsPerPeriodsList') }}",
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
                        data: 'total_amount',
                        orderable: false
                    }
                ],
            });
        }

        
    </script>
@endsection
