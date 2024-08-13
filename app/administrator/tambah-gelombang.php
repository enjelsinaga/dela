<?php
$page = "gelombang";
include('../_header.php');
include('../_sidebar.php');
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Data Gelombang</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data Gelombang</h5>
                        <form action="" method="post">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nama Gelombang</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama" class="form-control" id="nama" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Tanggal Mulai</label>
                                <div class="col-sm-8">
                                    <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Tanggal Akhir</label>
                                <div class="col-sm-8">
                                    <input type="date" name="tanggal_akhir" class="form-control" id="tanggal_akhir" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Kuota Siswa</label>
                                <div class="col-sm-8">
                                    <input type="number" min="1" name="kuota_siswa" class="form-control" id="kuota_siswa" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-5">
                                    <a href="data-gelombang.php" class="btn btn-secondary mx-1">Batal</a>
                                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
include('../_footer.php');
// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST['submit'])) {
    // ambil data dari tiap elemen dalam form
    $nama = $_POST['nama'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $kuota_siswa = $_POST['kuota_siswa'];
    $waktu_sekarang = date('Y-m-d H:i:s');

    mysqli_query($conn, "INSERT INTO `gelombang_pendaftaran`(`nama`, `tanggal_mulai`, `tanggal_akhir`, `kuota_siswa`, `created_at`, `updated_at`) 
                            VALUES ('$nama', '$tanggal_mulai', '$tanggal_akhir', $kuota_siswa, '$waktu_sekarang', '$waktu_sekarang')");

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['success'] = "Data Gelombang Berhasil ditambahkan";
        echo "<script>window.location.replace('data-gelombang.php');</script>";
        die();
    } else {
        $_SESSION['error'] = "Data Gelombang Gagal ditambahkan!";
        echo "<script>window.location.replace('tambah-gelombang.php');</script>";
        die();
    }
}
?>