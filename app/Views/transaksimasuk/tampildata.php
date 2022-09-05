<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <h3>Transaksi Masuk</h3>
        <br />
        <button type="button" class="btn btn-success tomboltambah" data-toggle="modal" onclick="">
            <i class="fa fa-pencil"></i>Tambah Transaksi
        </button>
        <br />
        <br />
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transaksi Masuk</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id</th>
                                <th>Nama Taruna</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th>Nama Diklat</th>
                                <th>Priode Pelaksanaan</th>
                                <th>Status Pembayaran</th>
                                <th>Status Verifikasi</th>
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
                ajax: '<?= base_url('TransaksiMasuk/getData') ?>',
                columnDefs: [{
                        targets: -1,
                        orderable: false
                    },
                    {
                        visible: false,
                        targets: 1
                    }
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
                url: "<?= base_url('TransaksiMasuk/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaltambah').modal('show');
                }
            })
        })
        // tombol untuk mengarahkan ke function di controller
        function edit(id) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('kelolaPeserta/formedit') ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            })
        }

        function detail(nisn, diklat_id) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('TransaksiMasuk/detail') ?>",
                data: {
                    nisn: nisn,
                    diklat_id: diklat_id
                },
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            })
        }

        // untuk mengarahkan ke function di controller
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
                        url: "<?= base_url('TransaksiMasuk/hapus') ?>",
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