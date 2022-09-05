<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Tambah Data Pengajar Diklat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Pengajar</label>
                        <input type="text" class="form-control" name="nama_pengajar" id="nama_pengajar" placeholder="Masukan Nama Pengajar">
                        <div class="invalid-feedback errornama"></div>
                    </div>

                    <div class="form-group">
                        <label for="kelas">Jenis Kelamin</label>
                        <select class="form-control" name="jk" id="jk">
                            <option value="">--Pilih Jenis Kelamin--</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        <div class="invalid-feedback errorjk"></div>
                    </div>

                    <div class="form-group">
                        <label for="no_tlp">Nomor Telpon</label>
                        <input type="text" class="form-control" name="no_tlp" id="no_tlp" placeholder="Masukan No Telp">
                        <div class="invalid-feedback errornotlp"></div>
                    </div>
                    <div class="form-group">
                        <label for="alamat"></label>
                        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukan Alamat">
                        <div class="invalid-feedback erroralamat"></div>
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
        url = "<?= base_url('kelolaPengajar/add') ?>"
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
                    if (response.error.nama_pengajar) {
                        $('#nama_pengajar').addClass('is-invalid')
                        $('.errornama').html(response.error.nama_pengajar);
                    } else {
                        $('#nama_pengajar').removeClass('is-invalid');
                        $('.errornama').html('');
                    }
                    if (response.error.jk) {
                        $('#jk').addClass('is-invalid')
                        $('.errorjk').html(response.error.jk);
                    } else {
                        $('#jk').removeClass('is-invalid');
                        $('.errorjk').html('');
                    }
                    if (response.error.no_tlp) {
                        $('#no_tlp').addClass('is-invalid');
                        $('.errornotlp').html(response.error.no_tlp);
                    } else {
                        $('#no_tlp').removeClass('is-invalid');
                        $('.errornotlp').html('');
                    }
                    if (response.error.alamat) {
                        $('#alamat').addClass('is-invalid');
                        $('.erroralamat').html(response.error.alamat);
                    } else {
                        $('#alamat').removeClass('is-invalid');
                        $('.erroralamat').html('');
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