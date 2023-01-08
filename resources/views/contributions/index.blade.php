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
                <button id="btnExportData" class="btn btn-outline-success">Exportar Datos</button>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-sm-12">
                <table id="dataTable" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr class="text-center">
                            <th style="width:20px">N°</th>
                            <th>Dia de aporte</th>
                            <th>Periodo Recibido</th>
                            <th>Estudiante</th>
                            <th>Categoria</th>
                            <th>Aporte</th>
                            <th>Descripcion</th>
                            <th>Periodo Afectado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <h1>Aporte total del estudiante en un periodo</h1>
            </div>
            <div class="col-sm-12">
                <table id="contributionsPerStudentPerPeriodsList" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr class="text-center">
                            <th style="width:20px">N°</th>
                            <th>Estudiante</th>
                            <th>Periodo</th>
                            <th>Aporte Total Por Periodo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <h1>Monto total efectuado de un periodo</h1>
            </div>
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
        <div class="row">
            <div class="col-8">
                <h1>Dinero total recibido por periodo</h1>
            </div>
            <div class="col-sm-12">
                <table id="contributionsPerPeriodsReceived" class="table table-bordered table-striped text-center">
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
    @include('contributions.modal.export_data')
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            contributionsList();
            contributionsPerPeriodsList();
            contributionsPerStudentPerPeriodsList();
            contributionsPerPeriodsReceivedList();
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
                        data: 'period_received',
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
                        data: 'period_affected',
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

        function contributionsPerStudentPerPeriodsList() {
            var token = $("input[name~='_token']").val();
            $("#contributionsPerStudentPerPeriodsList").DataTable({
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
                    url: "{{ route('contributions.contributionsPerStudentPerPeriodsList') }}",
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
                        data: 'student_full_name',
                        orderable: false
                    },
                    {
                        data: 'period',
                        orderable: false
                    },
                    {
                        data: 'total_amount_student',
                        orderable: false
                    }
                ],
            });
        }

        function contributionsPerPeriodsReceivedList() {
            var token = $("input[name~='_token']").val();
            $("#contributionsPerPeriodsReceived").DataTable({
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
                    url: "{{ route('contributions.contributionsPerPeriodsReceivedList') }}",
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

        function getPeriods() {
            let periodSelect = document.getElementById('periods');
            let period_id = document.getElementById('periods').value;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $.ajax({
                method: "GET",
                url: "{{ route('periods.getPeriods') }}",
                dataType: 'json',
                success: (res) => {
                    $(periodSelect).empty();
                    $(periodSelect).append('<option value="" selected>Seleccione una opción...</option>')
                    if (res.code === 3 && res.type === 'success') {
                        res.data.map(data => {
                            periodSelect.options[periodSelect.options.length] = new Option(data
                                .description, data.id);
                        })
                    }
                },
                error: (res) => {
                    $('#error_msg').show();
                    $('#error_msg').html('Ha ocurrido un error al cargar los periodos.');
                    setTimeout(function() {
                        $("#error_msg").fadeOut(1500);
                    }, 3000);
                    periodSelect.value = "";
                },
                beforeSend: () => {
                    periodSelect.add(new Option('Cargando...', 'cargando'));
                    periodSelect.value = "cargando";
                },
                complete: (res) => {
                    $('#error_msg').html('');
                },
            })
        }

        $('#btnExportData').on('click', function() {
            getPeriods();
            $('#modalExportData').modal('toggle');
        })

        $('#cerrarModal').on('click', function() {
            $('#modalExportData').modal('toggle');
        })
    </script>
@endsection
