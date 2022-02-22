<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="modal_content"></div>
    </div>
</div>
<!-- Modal DELETE Form -->
<div class="modal modal-danger" id="delForm" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h5 class="modal-title">Konfirmasi Hapus</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idDelete" name="idDelete">
                <h6><span id="info_delete"></span>Yakin ingin menghapus data ini?</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-rounded" id="delConfirm">
                    <span> <i class="icon-trash"> </i> Ya</span>
                </button>
                <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">
                    <span><i class="icon-exit">Tidak</i></span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Suspend Form -->
<div class="modal" data-easein="flipYIn" id="suspendForm" tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="del-title"></h4>
            </div>
            <div class="modal-body" id="data-body">
                <input type="hidden" id="id_suspend" name="id_suspend">
                <input type="hidden" id="lock_status" name="lock_status">
                <h2><span id="info_suspend"></span> </h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-rounded" id="suspendConfirm">
                    <span> <i class="icon-trash"> </i> Yes</span>
                </button>
                <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">
                    <span><i class="icon-exit">No</i></span>
                </button>
            </div>
        </div>
    </div>
</div>