@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-center justify-content-around mb-3">
            <div class="col-8">
                <h1>Categorias</h1>
            </div>
            <div class="col-2">
                <a href="{{ route('categories.create') }}" class="btn btn-outline-primary">Nueva Categoria</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table id="dataTable" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr class="text-center">
                            <th style="width:20px">N°</th>
                            <th>Descripcion</th>
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
            categoriesList();
        });

        $(document).one('click', '.toggle-group', function() {
            $('input[type=checkbox]').on('change', function(event) {
                $.ajax({
                    type: "PATCH",
                    url: "/categories/changeStatus/" + $(this).prop("id").replace("statusCheck", ""),
                    data: {
                        status: $(this).is(':checked') == true ? true : false,
                        _token: '{{ csrf_token() }}',
                    }
                });
            });
        });

        function categoriesList() {
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
                    url: "{{ route('categories.list') }}",
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
                        data: 'status',
                        orderable: false
                    },
                    {
                        data: 'actions',
                        orderable: false
                    },
                ],
                "fnDrawCallback": function() {
                    $('input[type=checkbox][data-toggle^=toggle]').bootstrapToggle()
                },
            });
        }
    </script>
@endsection
