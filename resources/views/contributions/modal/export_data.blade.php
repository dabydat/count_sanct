<div class="modal fade" id="modalExportData" data-backdrop="static" tabindex="-1" aria-labelledby="modalExportData"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLongTitle">Exportar datos</h5>
            </div>
            <div class="modal-body row">
                <div id="error_msg" class="alert alert-danger" style="display: none"></div>
                <div class="col-12 mb-2" id="colSelMotivo" name="colSelMotivo">
                    <label for="periods">Periodos:</label>
                    <select class="form-control" name="periods" id="periods">
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-primary" onclick="exportData();">Aceptar</button>
            </div>
        </div>
    </div>
</div>
