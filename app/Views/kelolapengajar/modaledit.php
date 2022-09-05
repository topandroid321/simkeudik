<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Edit Data Pengajar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>

                    <input type="hidden" name="id_pengajar" id="id_pengajar" value="<?= $id_pengajar ?>">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Pengajar</label>
                        <input type="text" class="form-control" name="nama_pengajar" value="<?= $nama_pengajar ?>" id="nama_pengajar">
                        <div class="invalid-feedback errornama"></div>
                    </div>

                    <div class="form-group">
                        <label for="kelas">Jenis Kelamin</label>
                        <select class="form-control" name="jk" id="jk">
                            <option value="">--Pilih Jenis Kelamin--</option>
                            <option value="L" <?php if ($jk == "L") echo "selected"; ?>>Laki laki</option>
                            <option value="P" <?php if ($jk == "P") echo "selected"; ?>>Perempuan</option>
                        </select>
                        <div class="invalid-feedback errorjk"></div>
                    </div>

                    <div class="form-group">
                        <label for="no_tlp">Nomor Telpon</label>
                        <input type="text" class="form-control" name="no_tlp" id="no_tlp" value="<?= $no_tlp ?>" placeholder="Masukan No Telp">
                        <div class="invalid-feedback errornotlp"></div>
                    </div>
                    <div class="form-group">
                        <label for="alamat"></label>
                        <input type="text" class="form-control" name="alamat" id="alamat" value="<?= $alamat ?>" placeholder="Masukan Alamat">
                        <div class="invalid-feedback erroralamat"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btnsave" type="button" class="btn btn-primary" onclick="update()">Simpan</button>
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
        url = "<?= base_url('kelolapengajar/updatedata') ?>"
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