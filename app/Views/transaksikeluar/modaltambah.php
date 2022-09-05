<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modaltitle">Tambah Data Transaksi Keluar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body form">
            <form id="formData">
               <?= csrf_field(); ?>
               <div class="form-group">
                  <label for="tgl_transaksi_keluar">Tanggal Transaksi Keluar</label>
                  <input type="date" class="form-control" name="tgl_transaksi_keluar" id="tgl_transaksi_keluar" placeholder="Masukan Tanggal">
                  <div class="invalid-feedback errortgl"></div>
               </div>

               <div class="form-group">
                  <label for="jenis_diklat">Jenis Diklat</label>
                  <div class="invalid-feedback errordiklat"></div>
                  <select name="diklat_id" id="diklat_id" class="form-control">
                     <option value="0">--Pilih Jenis Diklat--</option>
                     <?php foreach ($jenis_diklat as $row) { ?>
                        <option value="<?= $row->id_diklat ?>"><?= $row->nama_diklat ?></option>
                     <?php } ?>
                  </select>
               </div>

               <div class="form-group">
                  <label for="perencanaan_id">Priode Diklat</label>
                  <select name="perencanaan_id" id="perencanaan_id" class="form-control">
                     <option value="0">--Pilih Priode Diklat--</option>
                     <?php foreach ($perencanaan as $row) { ?>
                        <option value="<?= $row->id_perencanaan ?>"><?= $row->nama_diklat ?> |<?= $row->ket ?> | <?= $row->tanggal_pelaksanaan ?></option>
                     <?php } ?>
                  </select>
                  <div class="invalid-feedback errorjenis"></div>
               </div>

               <div class="form-group">
                  <label for="total_biaya">Biaya Transaksi</label>
                  <input type="number" class="form-control" name="total_biaya" id="total_biaya" placeholder="Masukan Jumlah Transaki">
                  <div class="invalid-feedback errorbiaya"></div>
               </div>

               <div class="form-group">
                  <label for="no_tlp">Ket Transaksi</label>
                  <input type="text" class="form-control" name="ket" id="keterangan" placeholder="Masukan Keterangan Transaksi">
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
      url = "<?= base_url('Transaksikeluar/add') ?>"
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
               if (response.error.tgl_transaksi_keluar) {
                  $('#tgl_transaksi_keluar').addClass('is-invalid')
                  $('.errortgl').html(response.error.tgl_transaksi_keluar);
               } else {
                  $('#tgl_transaksi_keluar').removeClass('is-invalid');
                  $('.errortgl').html('');
               }
               if (response.error.diklat_id) {
                  $('#diklat_id').addClass('is-invalid')
                  $('.errordiklat').html(response.error.diklat_id);
               } else {
                  $('#diklat_id').removeClass('is-invalid');
                  $('.errordiklat').html('');
               }
               if (response.error.total_biaya) {
                  $('#total_biaya').addClass('is-invalid');
                  $('.errorbiaya').html(response.error.total_biaya);
               } else {
                  $('#total_biaya').removeClass('is-invalid');
                  $('.errorbiaya').html('');
               }
               if (response.error.ket) {
                  $('#ket').addClass('is-invalid');
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