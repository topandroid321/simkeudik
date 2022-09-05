<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Tambah Data Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nisn">NISN</label>
                        <input type="text" class="form-control" name="nisn" id="nisn" placeholder="Masukan NISN">
                        <div class="invalid-feedback errornisn"></div>
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukan Nama Lengkap">
                        <div class="invalid-feedback errornama"></div>
                    </div>

                    <div class="form-group">
                        <label for="JK">Jenis Kelamin</label>
                        <select class="form-control" name="jk" id="jk">
                            <option value="">--Pilih Jenis Kelamin--</option>
                            <option value="L">Laki - Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        <div class="invalid-feedback errorjk"></div>
                    </div>

                    <div class="form-group">
                        <label for="tahun_masuk">Tahun Masuk</label>
                        <input type="text" class="form-control" name="tahun_masuk" id="tahun_masuk" placeholder="Masukan Tahun Masuk">
                        <div class="invalid-feedback errortahun"></div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Masukan Username">
                        <div class="invalid-feedback errorusername"></div>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select class="form-control" name="kelas" id="kelas">
                            <option value="">--Pilih Kelas--</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                        <div class="invalid-feedback errornama"></div>
                    </div>
                    <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <select class="form-control" name="jurusan" id="jurusan">
                            <option value="">--Pilih Jurusan--</option>
                            <option value="NKN">NAUTIKA KAPAL NIAGA</option>
                            <option value="TKN">TEKNIKA KAPAL NIAGA</option>
                        </select>
                        <div class="invalid-feedback errornama"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btnsave" type="button" class="btn btn-primary" onclick="save()">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    // tombol simpan
    function save() {
        var modal = $('#modaltambah')
        var formData = $('#formData')
        var btnSave = $('#btnsave')
        url = "<?= base_url('kelolaPeserta/add') ?>"
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
                $(btnSave.html('simpan'));
            },
            success: function(response) {
                if (response.error) {
                    if (response.error.nisn) {
                        $('#nisn').addClass('is-invalid')
                        $('.errornisn').html(response.error.nisn);
                    } else {
                        $('#nisn').removeClass('is-invalid');
                        $('.errornisn').html('');
                    }
                    if (response.error.tahun_masuk) {
                        $('#tahun_masuk').addClass('is-invalid')
                        $('.errortahun').html(response.error.tahun_masuk);
                    } else {
                        $('#tahun_masuk').removeClass('is-invalid');
                        $('.errortahun').html('');
                    }
                    if (response.error.jk) {
                        $('#jk').addClass('is-invalid')
                        $('.errorjk').html(response.error.jk);
                    } else {
                        $('#jk').removeClass('is-invalid');
                        $('.errorjk').html('');
                    }
                    if (response.error.nama_lengkap) {
                        $('#nama_lengkap').addClass('is-invalid')
                        $('.errornama').html(response.error.nama_lengkap);
                    } else {
                        $('#nama_lengkap').removeClass('is-invalid');
                        $('.errornama').html('');
                    }
                    if (response.error.username) {
                        $('#username').addClass('is-invalid');
                        $('.errorusername').html(response.error.username);
                    } else {
                        $('#username').removeClass('is-invalid');
                        $('.errorusername').html('');
                    }
                } else {
                    swal.fire({
                        icon: 'success',
                        titlte: 'Berhasil',
                        text: response.sukses,
                    })
                    modal.modal('hide');
                    formData[0].reset();
                    reloadTable();
                }
            },
            error: function() {
                console.log('error database');
            }
        });

        if ($("#formData").length > 0) {
            $("#formData")
        }

    }
</script>