<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Tambah Data Lembaga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama_lembaga">Nama Lembaga</label>
                        <input type="text" class="form-control" name="nama_lembaga" id="nama_lembaga" placeholder="Masukan Nama Lembaga">
                        <div class="invalid-feedback errornama"></div>
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Alamat Lembaga</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="10"></textarea>
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
        url = "<?= base_url('kelolaLemdik/add') ?>"
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
                    if (response.error.nama_lembaga) {
                        $('#nama_lembaga').addClass('is-invalid')
                        $('.errornama').html(response.error.nama_lembaga);
                    } else {
                        $('#nama_lembaga').removeClass('is-invalid');
                        $('.errornama').html('');
                    }
                    if (response.error.alamat) {
                        $('#alamat').addClass('is-invalid')
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