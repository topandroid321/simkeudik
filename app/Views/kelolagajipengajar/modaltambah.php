<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="modaltitle">Tambah Data Gaji Pengajar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body form">
            <form id="formData">
               <?= csrf_field(); ?>
               <div class="form-group">
                  <label for="pengajar_id">Nama Pengajar</label>
                  <select name="pengajar_id" id="pengajar_id" class="form-select form-control">
                     <option value="">--Pilih Pengajar--</option>
                     <?php foreach ($pengajar as $row) { ?>
                        <option value="<?= $row->id_pengajar ?>"><?= $row->nama_pengajar ?></option>
                     <?php } ?>
                  </select>
                  <div class="invalid-feedback errornama"></div>
               </div>

               <div class="form-group">
                  <label for="tgl_pembayaran_gaji"></label>
                  <input type="date" class="form-control" name="tgl_pembayaran_gaji" id="tgl_pembayaran_gaji" placeholder="Masukan Tanggal">
                  <div class="invalid-feedback errortgl"></div>
               </div>

               <div class="form-group">
                  <label for="pengajar_id">Nama Diklat</label>
                  <select name="diklat_id" id="diklat_id" class="form-select form-control">
                     <option value="">--Pilih Diklat--</option>
                     <?php foreach ($diklat as $row) { ?>
                        <option value="<?= $row->id_diklat ?>"><?= $row->nama_diklat ?></option>
                     <?php } ?>
                  </select>
                  <div class="invalid-feedback errordiklat"></div>
               </div>

               <div class="form-group">
                  <label for="jumlah_jam">Jumlah Jam</label>
                  <input type="text" class="form-control" name="jumlah_jam" id="jumlah_jam" placeholder="Masukan Jumlah Jam">
                  <div class="invalid-feedback errorjumlah"></div>
               </div>

               <div class="form-group">
                  <label for="gaji_perjam">Gaji Perjam</label>
                  <input type="text" class="form-control" name="gaji_perjam" id="gaji_perjam" placeholder="Masukan Gaji Jam">
                  <div class="invalid-feedback errorgaji"></div>
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
      url = "<?= base_url('kelolaGajiPengajar/add') ?>"
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
               if (response.error.pengajar_id) {
                  $('#pengajar_id').addClass('is-invalid')
                  $('.errornama').html(response.error.pengajar_id);
               } else {
                  $('#pengajar_id').removeClass('is-invalid');
                  $('.errornama').html('');
               }
               if (response.error.diklat_id) {
                  $('#diklat_id').addClass('is-invalid')
                  $('.errordiklat').html(response.error.diklat_id);
               } else {
                  $('#diklat_id').removeClass('is-invalid');
                  $('.errordiklat').html('');
               }
               if (response.error.tgl_pembayaran_gaji) {
                  $('#tgl_pembayaran_gaji').addClass('is-invalid');
                  $('.errortgl').html(response.error.tgl_pembayaran_gaji);
               } else {
                  $('#tgl_pembayaran_gaji').removeClass('is-invalid');
                  $('.errortgl').html('');
               }
               if (response.error.jumlah_jam) {
                  $('#jumlah_jam').addClass('is-invalid');
                  $('.errorjumlah').html(response.error.jumlah_jam);
               } else {
                  $('#jumlah_jam').removeClass('is-invalid');
                  $('.errorjumlah').html('');
               }
               if (response.error.gaji_perjam) {
                  $('#gaji_perjam').addClass('is-invalid');
                  $('.errorgaji').html(response.error.gaji_perjam);
               } else {
                  $('#gaji_perjam').removeClass('is-invalid');
                  $('.errorgaji').html('');
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
   $('#pengajar_id').select2({
      dropdownParent: $('#modaltambah'),
      placeholder: 'Select an option',
      theme: 'bootstrap4',
   });
</script>