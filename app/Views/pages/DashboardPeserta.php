<?= $this->extend('layouts/template') ?>
<?php $session = session() ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <h3>Jadwal Pelaksanaan Diklat</h3>
        <br />
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Perencanaan Diklat</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Diklat</th>
                                <th>Tgl Pelaksanaan</th>
                                <th>Lama Pelaksanaan</th>
                                <th>Nama Lembaga</th>
                                <th>Harga</th>
                                <th>Ket</th>
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
                ajax: '<?= base_url('kelolaPerencanaan/getDatajadwal') ?>',
            });
        });

        function reloadTable() {
            tableData.DataTable().ajax.reload();
        }
    </script>
</div>
<?= $this->endSection() ?>