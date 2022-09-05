<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Edit Data Jenis Diklat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>

                    <input type="hidden" name="id_diklat" id="id_diklat" value="<?= $id_diklat ?>">

                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama_diklat">Nama Diklat</label>
                        <input type="text" class="form-control" name="nama_diklat" id="nama_diklat" value="<?= $nama_diklat ?>">
                        <div class="invalid-feedback errornama"></div>
                    </div>

                    <div class="form-group">
                        <label for="lama_pelaksanaan">Lama Pelaksanaan</label>
                        <input type="text" class="form-control" name="lama_pelaksanaan" value="<?= $lama_pelaksanaan ?>" id="lama_pelaksanaan">
                        <div class="invalid-feedback errorpelaksanaan"></div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Harga Diklat</label>
                        <input type="text" class="form-control" name="deskripsi" value="<?= $deskripsi ?>" id="deskripsi">
                        <div class="invalid-feedback errorharga"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btnsave" type="button" class="btn btn-primary" onclick="update()">Update Data</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function update() {
        var modal = $('#modaledit')
        var formData = $('#formData')
        var modalTitle = $('#modaltitle')
        var btnSave = $('#btnsave')
        url = "<?= base_url('kelolaDiklat/updatedata') ?>"
        $.ajax({
            type: "POST",
            url: url,
            data: formData.serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $(btnSave.attr('disable', 'disabled'));
                $(btnSave.html('<i class="fa fa-spin fa-spinner"></i>'));
            },
            complete: function() {
                $(btnSave.removeAttr('disable'));
                $(btnSave.html('Update'));
            },
            success: function(response) {
                swal.fire({
                    icon: 'success',
                    titlte: 'Berhasil',
                    text: response.sukses,
                })
                modal.modal('hide');
                formData[0].reset();
                reloadTable();
            }
        });
    }
</script>