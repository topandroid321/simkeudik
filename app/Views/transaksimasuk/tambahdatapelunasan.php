<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data</h1>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            Tambah Data Pembayaran
        </div>
        <div class="card-body">
            <form action="/transaksimasuk/simpantransaksi" method="POST">
                <div class="row">
                    <div class="col-6">
                        <input class="form-control" type="text" name="id_transaksi_masuk" id="id_transaksi_masuk" value="<?= $transaksi->id_transaksi_masuk; ?>" readonly>
                        <label for="">Peserta Didik</label>
                        <input class="form-control" type="text" name="nisn" id="nisn" value="<?= $transaksi->nisn; ?>" readonly>
                        <br>
                        <label for="">Kelas / Jurusan</label>
                        <input class="form-control" type="text" name="" id="kelas" value="<?= $transaksi->kelas; ?> / <?= $transaksi->jurusan; ?>" readonly>
                        <br>
                        <label for="">Jenis Diklat</label>
                        <input class="form-control" type="text" name="" id="kelas" value="<?= $transaksi->nama_diklat; ?>" readonly>
                        <br>
                    </div>
                    <div class="col-6">

                        <label for="">Tanggal Transaksi</label>
                        <input class="form-control" type="date" name="tgl_transaksi" id="tgl_transaksi">
                        <br>
                        <label for="">Sisa Pembayaran</label>
                        <input class="form-control" type="number" name="sisabayar" value="<?= $transaksi->sisa_pembayaran ?>" readonly>
                        <br>
                        <label for="">Jumlah Bayar</label>
                        <input class="form-control" type="number" name="jumlah_bayar" id="jumlah_bayar">

                        <button class="btn btn-primary mt-3">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>