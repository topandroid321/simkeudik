<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltitle">Tambah Transaksi Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body form">
                <form id="formData" method="post">
                    <!-- CSRF token -->
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nisn" class="form-label">Nama Lengkap Taruna</label>
                        <select name="nisn" id="nisn" class="form-select form-control">
                            <option value=""></option>
                            <?php foreach ($peserta as $row) { ?>
                                <option value="<?= $row->nisn ?>"><?= $row->nama_lengkap ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errornama"></div>
                    </div>

                    <div class="form-group">
                        <label for="tgl_transaksi">Tanggal Transaksi</label>
                        <input type="date" class="form-control" name="tgl_transaksi" id="tgl_transaksi" placeholder="Masukan Tanggal">
                        <div class="invalid-feedback errortanggal"></div>
                    </div>
                    <div class="form-group">
                        <label for="jenis_diklat">Jenis Diklat</label>
                        <select name="diklat_id" id="diklat_id" class="form-control">
                            <option value="0">--Pilih Jenis Diklat--</option>
                            <?php foreach ($jenis_diklat as $row) { ?>
                                <option value="<?= $row->id_diklat ?>"><?= $row->nama_diklat ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorjenis"></div>
                    </div>
                    <div class="form-group">
                        <label for="jenis_diklat">Priode Diklat</label>
                        <select name="perencanaan_id" id="perencanaan_id" class="form-control">
                            <option value="0">--Pilih Priode Diklat--</option>
                            <?php foreach ($perencanaan as $row) { ?>
                                <option value="<?= $row->id_perencanaan ?>"><?= $row->nama_diklat ?> |<?= $row->ket ?> | <?= $row->tanggal_pelaksanaan ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorjenis"></div>
                    </div>
                    <div class="form-group">
                        <label for="username">Harga Diklat</label>
                        <input type="text" class="form-control" name="harga" id="harga" placeholder="" readonly>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="username">Total Bayar</label>
                        <input type="number" class="form-control" name="jumlah_bayar" id="jumlah_bayar" placeholder="Masukan Total bayar">
                        <div class="invalid-feedback errortotal"></div>
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
        url = "<?= base_url('TransaksiMasuk/add') ?>"
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
                        $('.errornama').html(response.error.nisn);
                    } else {
                        $('#nisn').removeClass('is-invalid');
                        $('.errornama').html('');
                    }
                    if (response.error.tgl_transaksi) {
                        $('#tgl_transaksi').addClass('is-invalid')
                        $('.errortanggal').html(response.error.tgl_transaksi);
                    } else {
                        $('#nama_lengkap').removeClass('is-invalid');
                        $('.errortanggal').html('');
                    }
                    if (response.error.id_jenis_diklat) {
                        $('#jenis_diklat').addClass('is-invalid');
                        $('.errorjenis').html(response.error.id_jenis_diklat);
                    } else {
                        $('#jenis_diklat').removeClass('is-invalid');
                        $('.errorjenis').html('');
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

    $('#nisn').select2({
        dropdownParent: $('#modaltambah'),
        placeholder: 'Select an option',
        theme: 'bootstrap4',
    });

    $(document).ready(function() {
        $('#perencanaan_id').change(function() {
            var id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?= base_url('TransaksiMasuk/getHarga') ?>",
                dataType: "json",
                data: {
                    id: id
                },
                success: function(response) {
                    document.getElementById('harga').value = response.harga;
                }
            })
        })
    })
</script>