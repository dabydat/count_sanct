<div class="modal fade" id="modalExportData" data-backdrop="static" tabindex="-1" aria-labelledby="modalExportData"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('contributions.export') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="exampleModalLongTitle">Rechazo del Trámite</h5>
                </div>
                <div class="modal-body row">
                    <div class="col-12 mb-2" id="colSelMotivo" name="colSelMotivo">
                        <label for="periods">Periodo:</label>
                        <select class="form-control" name="periods" id="periods">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary">Aceptar</button>
                    <button id="cerrarModal" type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
