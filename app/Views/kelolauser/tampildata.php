<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <h3>Data User</h3>
        <br />
        <button type="button" class="btn btn-success" data-toggle="modal" onclick="add()">
            <i class="fas fa-pencil"></i>Tambah User
        </button>
        <br />
        <br />
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Data User</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id User</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Photo</th>
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
    <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaltitle">Tambah Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form">
                    <form id="formData">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukan Nama Lengkap">
                            <div class="invalid-feedback errornama"></div>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Masukan Username">
                            <div class="invalid-feedback errorusername"></div>

                        </div>

                        <div class="form-group">
                            <label for="nama_lengkap">Role</label>
                            <select class="form-control" name="role" id="role">
                                <option value="1">Admin</option>
                                <option value="2">Bendahara</option>
                                <option value="3">Kepala Program</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btnsave" type="button" class="btn btn-primary" onclick="save()">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

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
                ajax: '<?= base_url('kelolauser/getDataUser') ?>',
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

        function add() {
            formData[0].reset();
            modal.modal('show');
            modalTitle.text('Tambah Data');
        }
        // tombol simpan
        function save() {
            url = "<?= base_url('kelolauser/add') ?>"
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
                        if (response.error.nama_lengkap) {
                            $('#nama_lengkap').addClass('is-invalid')
                            $('.errornama').html(response.error.nama_lengkap);
                        } else {
                            $('#nama_lengkap').removeClass('is-invalid');
                            $('.errornama').html('');
                        }
                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errorusername').html(response.error.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('.errorusername').html('');
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
        // tombol untuk mengarahkan ke function di controller
        function edit(id) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('kelolauser/formedit') ?>",
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
                        url: "<?= base_url('kelolauser/hapus') ?>",
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
                            modal.modal('hide');
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