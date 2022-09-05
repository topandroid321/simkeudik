<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Tambah Data Jenis Diklat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama_diklat">Nama Diklat</label>
                        <input type="text" class="form-control" name="nama_diklat" id="nama_diklat" placeholder="Masukan Nama Lembaga">
                        <div class="invalid-feedback errornama"></div>
                    </div>
                    <div class="form-group">
                        <label for="lama_pelaksanaan">Lama Pelaksanaan</label>
                        <input type="text" class="form-control" name="lama_pelaksanaan" id="lama_pelaksanaan" placeholder="Masukan Lama Pelaksanaan">
                        <div class="invalid-feedback errorpelaksanaan"></div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Diklat</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi">
                        <div class="invalid-feedback errordeskripsi"></div>
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
        url = "<?= base_url('kelolaDiklat/add') ?>"
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
                    if (response.error.nama_diklat) {
                        $('#nama_diklat').addClass('is-invalid')
                        $('.errornama').html(response.error.nama_diklat);
                    } else {
                        $('#nama_diklat').removeClass('is-invalid');
                        $('.errornama').html('');
                    }
                    if (response.error.lama_pelaksanaan) {
                        $('#lama_pelaksanaan').addClass('is-invalid')
                        $('.errorpelaksanaan').html(response.error.lama_pelaksanaan);
                    } else {
                        $('#lama_pelaksanaan').removeClass('is-invalid');
                        $('.errorpelaksanaan').html('');
                    }
                    if (response.error.deskripsi_diklat) {
                        $('#deskripsi').addClass('is-invalid')
                        $('.errordeskripsi').html(response.error.deskripsi);
                    } else {
                        $('#deskripsi').removeClass('is-invalid');
                        $('.errordeskripsi').html('');
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