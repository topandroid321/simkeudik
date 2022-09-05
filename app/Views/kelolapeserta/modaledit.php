<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Edit Data Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>

                    <input type="hidden" name="id" id="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="nisn">NISN</label>
                        <input type="text" class="form-control" name="nisn" id="nisn" value="<?= $nisn ?>" placeholder="Masukan NISN" readonly>
                        <div class="invalid-feedback errornisn"></div>
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" value="<?= $nama_lengkap ?>" id="nama_lengkap" placeholder="Masukan Nama Lengkap">
                        <div class="invalid-feedback errornama"></div>
                    </div>

                    <div class="form-group">
                        <label for="tahun_masuk">Tahun Masuk</label>
                        <input type="text" class="form-control" name="tahun_masuk" id="tahun_masuk" value="<?= $tahun_masuk ?>" placeholder="Masukan Username">
                        <div class="invalid-feedback errortahun"></div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $username ?>" placeholder="Masukan Username">
                        <div class="invalid-feedback errorusername"></div>
                    </div>
                    <div class="form-group">
                        <label for="jk">JK</label>
                        <select class="form-control" name="jk" id="jk">
                            <option value="L" <?php if ($jk == "L") echo "selected"; ?>>Laki Laki</option>
                            <option value="P" <?php if ($jk == "P") echo "selected"; ?>>Perempuan</option>
                        </select>
                        <div class="invalid-feedback errorjk"></div>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select class="form-control" name="kelas" id="kelas">
                            <option value="X" <?php if ($kelas == "X") echo "selected"; ?>>X</option>
                            <option value="XI" <?php if ($kelas == "XI") echo "selected"; ?>>XI</option>
                            <option value="XII" <?php if ($kelas == "XII") echo "selected"; ?>>XII</option>
                        </select>
                        <div class="invalid-feedback errornama"></div>
                    </div>
                    <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <select class="form-control" name="jurusan" id="jurusan">
                            <option value="NKN" <?php if ($jurusan == "NKN") echo "selected"; ?>>NAUTIKA KAPAL NIAGA</option>
                            <option value="TKN" <?php if ($jurusan == "TKN") echo "selected"; ?>>TEKNIKA KAPAL NIAGA</option>
                            <option value="NKPI" <?php if ($jurusan == "NKPI") echo "selected"; ?>>NAUTIKA KAPAL PENANGKAP IKAN</option>
                        </select>
                        <div class="invalid-feedback errornama"></div>
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
        url = "<?= base_url('kelolapeserta/updatedata') ?>"
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