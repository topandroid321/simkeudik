<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Edit Data Lemdik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>

                    <input type="hidden" name="id" id="id" value="<?= $id_lembaga ?>">

                    <div class="form-group">
                        <label for="nama_lembaga">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lembaga" value="<?= $nama_lembaga ?>" id="nama_lembaga" placeholder="Masukan Nama lembaga">
                        <div class="invalid-feedback errornama"></div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Lembaga</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="10"><?= $alamat ?></textarea>
                        <div class="invalid-feedback erroralamat"></div>
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
        url = "<?= base_url('kelolaLemdik/updatedata') ?>"
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