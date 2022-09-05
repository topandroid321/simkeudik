<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <h3>Data Lembaga Diklat</h3>
        <br />
        <button type="button" class="btn btn-success tomboltambah" data-toggle="modal" onclick="">
            <i class="fas fa-pencil"></i>Tambah Lembaga Diklat
        </button>
        <br />
        <br />
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Data Lembaga Diklat</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Lembaga</th>
                                <th>Nama Lembaga</th>
                                <th data-priority="1">Alamat</th>
                                <th data-priority="2">Aksi</th>
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
                responsive: true,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 4
                    }
                ],
                ajax: '<?= base_url('kelolaLemdik/getDataUser') ?>',
            });
        });

        function reloadTable() {
            tableData.DataTable().ajax.reload();
        }

        // function untuk menampilkan modal tambah data

        $('.tomboltambah').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?= base_url('kelolaLemdik/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaltambah').modal('show');
                }
            })
        })
        // tombol untuk mengarahkan ke function di controller
        function edit(id_lembaga) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('kelolaLemdik/formedit') ?>",
                data: {
                    id_lembaga: id_lembaga
                },
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            })
        }

        function hapus(id_lembaga) {
            swal.fire({
                title: 'Hapus Data',
                text: `Yakin Mau Hapus data dengan id ${id_lembaga}?`,
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
                        url: "<?= base_url('kelolaLemdik/hapus') ?>",
                        data: {
                            id_lembaga: id_lembaga
                        },
                        dataType: "json",
                        success: function(response) {
                            swal.fire({
                                icon: 'success',
                                titlte: 'Berhasil',
                                text: response.sukses,
                            })
                            formData[0].reset();
                            reloadTable();
                        }
                    })
                }
            })
        }
    </script>

</div>
<?= $this->endSection() ?>