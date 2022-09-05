<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

   <!-- Begin Page Content -->
   <div class="container-fluid">
      <h3>Data Gaji Pengajar</h3>
      <br />
      <button type="button" class="btn btn-success tomboltambah" data-toggle="modal" onclick="">
         <i class="fa fa-pencil"></i>Tambah Data Gaji
      </button>
      <br />
      <br />
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Data Pengajar</h6>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Nama Pengajar</th>
                        <th>Nama Diklat</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Jumlah Jam</th>
                        <th>Gaji Perjam</th>
                        <th>Gaji Total</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>

                  </tbody>
               </table>
            </div>
         </div>
      </div>

   </div>
   <!-- /.container-fluid -->
   <div class="viewmodal" style="display: none;"></div>
   <!-- Modal -->
   <script type="text/javascript">
      var modal = $('#modalData')
      var tableData = $('#table')
      var formData = $('#formData')
      var modalTitle = $('#modaltitle')
      var btnSave = $('#btnsave')
      $(document).ready(function() {
         tableData.DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= base_url('kelolagajipengajar/getDatagaji') ?>',
            columnDefs: [{
                  targets: -1,
                  orderable: false
               }, //target -1 means last column
            ]
         });
      });

      function reloadTable() {
         tableData.DataTable().ajax.reload();
      }

      $('.tomboltambah').click(function(e) {
         e.preventDefault();
         $.ajax({
            type: "POST",
            url: "<?= base_url('kelolaGajiPengajar/formtambah') ?>",
            dataType: "json",
            success: function(response) {
               $('.viewmodal').html(response.sukses).show();
               $('#modaltambah').modal('show');
            }
         })
      })
      // tombol untuk mengarahkan ke function di controller
      function edit(id_gaji) {
         $.ajax({
            type: "POST",
            url: "<?= base_url('kelolaGajiPengajar/formedit') ?>",
            data: {
               id_gaji: id_gaji
            },
            dataType: "json",
            success: function(response) {
               $('.viewmodal').html(response.sukses).show();
               $('#modaledit').modal('show');
            }
         })
      }

      function hapus(id) {
         swal.fire({
            title: 'Hapus Data',
            text: `Yakin Mau Hapus data dengan id ${id}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Tidak ah'
         }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
                  type: "POST",
                  url: "<?= base_url('kelolaGajiPengajar/hapus') ?>",
                  data: {
                     id: id
                  },
                  dataType: "json",
                  success: function(response) {
                     swal.fire({
                        icon: 'success',
                        titlte: 'Berhasil',
                        text: response.sukses,
                     })
                     reloadTable();
                     formData[0].reset();
                  }
               })
            }
         })
      }
   </script>

</div>
<?= $this->endSection() ?>