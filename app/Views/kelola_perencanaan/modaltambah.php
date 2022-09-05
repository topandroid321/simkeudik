<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Tambah Data Perencanaan Diklat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama_lembaga">Nama Diklat</label>
                        <select class="form-control" name="diklat_id" id="diklat_id">
                            <option value="">--Pilih Jenis Diklat--</option>
                            <?php foreach ($diklat as $row) { ?>
                                <option value="<?= $row->id_diklat ?>"><?= $row->nama_diklat ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errornama"></div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_pelaksanaan">Tanggal Pelaksanaan</label>
                        <input type="date" class="form-control" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan">
                        <div class="invalid-feedback errortgl"></div>
                    </div>

                    <div class="form-group">
                        <label for="nama_lembaga">Nama Lembaga</label>
                        <select class="form-control" name="lembaga_diklat_id" id="lembaga_diklat_id">
                            <option value="">--Pilih Lembaga--</option>
                            <?php foreach ($lembaga as $row) { ?>
                                <option value="<?= $row->id_lembaga ?>"><?= $row->nama_lembaga ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorlembaga"></div>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga Diklat</label>
                        <input type="number" class="form-control" name="harga" id="harga">
                        <div class="invalid-feedback errorharga"></div>
                    </div>

                    <div class="form-group">
                        <label for="ket">Keterangan</label>
                        <input type="text" class="form-control" name="ket" id="ket">
                        <div class="invalid-feedback errorket"></div>
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
        url = "<?= base_url('kelolaPerencanaan/add') ?>"
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
                    if (response.error.diklat_id) {
                        $('#diklat_id').addClass('is-invalid')
                        $('.errornama').html(response.error.diklat_id);
                    } else {
                        $('#diklat_id').removeClass('is-invalid');
                        $('.errornama').html('');
                    }
                    if (response.error.tanggal_pelaksanaan) {
                        $('#tanggal_pelaksanaan').addClass('is-invalid')
                        $('.errortgl').html(response.error.tanggal_pelaksanaan);
                    } else {
                        $('#diklat_id').removeClass('is-invalid');
                        $('.errortgl').html('');
                    }
                    if (response.error.lembaga_diklat_id) {
                        $('#lembaga_diklat_id').addClass('is-invalid')
                        $('.errorlembaga').html(response.error.lembaga_diklat_id);
                    } else {
                        $('#lembaga_diklat_id').removeClass('is-invalid');
                        $('.errorlembaga').html('');
                    }
                    if (response.error.harga) {
                        $('#harga').addClass('is-invalid')
                        $('.errorharga').html(response.error.harga);
                    } else {
                        $('#harga').removeClass('is-invalid');
                        $('.errorharga').html('');
                    }
                    if (response.error.ket) {
                        $('#ket').addClass('is-invalid')
                        $('.errorket').html(response.error.ket);
                    } else {
                        $('#ket').removeClass('is-invalid');
                        $('.errorket').html('');
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