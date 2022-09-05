<!-- Modal Tambah-->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Edit Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>
                    <input type="hidden" id="id" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="<?= $nama_lengkap ?>" placeholder="Masukan Nama Lengkap">
                        <div class="invalid-feedback errornama"></div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $username ?>" placeholder="Masukan Username">
                        <div class="invalid-feedback errorusername"></div>

                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Role</label>
                        <select class="form-control" name="role" id="role">
                            <option value="1" <?php if ($role == "1") echo "selected"; ?>>Admin</option>
                            <option value="2" <?php if ($role == "2") echo "selected"; ?>>Bendahara</option>
                            <option value="3" <?php if ($role == "3") echo "selected"; ?>>Kepala Program</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btnsave" type="button" class="btn btn-primary" onclick="update()">Update</button>
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
        url = "<?= base_url('kelolauser/updatedata') ?>"
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