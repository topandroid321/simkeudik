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

               <input type="hidden" name="id_gaji" id="id_gaji" value=" <?= $gaji->id_gaji; ?>">
               <div class="form-group">
                  <label for="pengajar_id">Nama Pengajar</label>
                  <select name="pengajar_id" id="pengajar_id" class="form-select form-control" disabled>
                     <option value="<?= $gaji->pengajar_id ?>"><?= $gaji->nama_pengajar ?></option>
                     <?php foreach ($pengajar as $row) { ?>
                        <option value="<?= $row->id_pengajar ?>"><?= $row->nama_pengajar ?></option>
                     <?php } ?>
                  </select>
                  <div class="invalid-feedback errornama"></div>
               </div>
               <div class="form-group">
                  <label for="tgl_pembayaran_gaji"></label>
                  <input type="date" class="form-control" value="<?= $gaji->tgl_pembayaran_gaji ?>" name="tgl_pembayaran_gaji" id="tgl_pembayaran_gaji" placeholder="Masukan Tanggal">
                  <div class="invalid-feedback errortgl"></div>
               </div>
               <div class="form-group">
                  <label for="pengajar_id">Nama Diklat</label>
                  <select name="diklat_id" id="diklat_id" class="form-select form-control">
                     <option value="<?= $gaji->diklat_id; ?>"><?= $gaji->nama_diklat; ?></option>
                     <?php foreach ($diklat as $row) { ?>
                        <option value="<?= $row->id_diklat ?>"><?= $row->nama_diklat ?></option>
                     <?php } ?>
                  </select>
                  <div class="invalid-feedback errordiklat"></div>
               </div>

               <div class="form-group">
                  <label for="jumlah_jam">Jumlah Jam</label>
                  <input type="number" class="form-control" name="jumlah_jam" value="<?= $gaji->jumlah_jam ?>" id="jumlah_jam" placeholder="Masukan Jumlah Jam">
                  <div class="invalid-feedback errorjumlah"></div>
               </div>

               <div class="form-group">
                  <label for="gaji_perjam">Gaji Perjam</label>
                  <input type="number" class="form-control" name="gaji_perjam" value="<?= $gaji->gaji_perjam ?>" id="gaji_perjam" placeholder="Masukan Gaji Jam">
                  <div class="invalid-feedback errorgaji"></div>
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
      url = "<?= base_url('KelolaGajiPengajar/updatedata') ?>"
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