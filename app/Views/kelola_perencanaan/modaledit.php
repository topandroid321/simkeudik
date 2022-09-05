<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Edit Data Perencanaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>

                    <input type="hidden" name="id_perencanaan" id="id_perencanaan" value="<?= $id_perencanaan ?>">

                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama_diklat">Nama Diklat</label>
                        <select class="form-control" name="diklat_id" id="diklat_id">
                            <option value="<?= $diklat_id ?>"><?= $diklat_id; ?></option>
                            <?php foreach ($diklat as $row) { ?>
                                <option value="<?= $row->id_diklat ?>"><?= $row->nama_diklat ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errornama"></div>
                    </div>

                    <div class="form-group">
                        <label for="nama_lembaga">Nama Lembaga</label>
                        <select class="form-control" name="id_lembaga" id="id_lembaga">
                            <option value="<?= $lembaga_diklat_id ?>"><?= $lembaga_diklat_id ?></option>
                            <?php foreach ($lembaga as $row) { ?>
                                <option value="<?= $row->id_lembaga ?>"><?= $row->nama_lembaga ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorlembaga"></div>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga Diklat</label>
                        <input type="number" class="form-control" name="harga" value="<?= $harga ?>" id="harga_diklat">
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
        url = "<?= base_url('kelolaJenisDiklat/updatedata') ?>"
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