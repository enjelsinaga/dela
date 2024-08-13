<?php
$page = "gelombang";
include('../_header.php');
include('../_sidebar.php');

// Jika id tidak didapatkan, maka halaman edit tidak akan bisa dibuka
if (!isset($_GET['id'])) {
    echo "<script>window.location='data-gelombang.php'</script>";
}

$id = $_GET['id'];
// Cari datanya dalam database berdasarkan id yg didapat
$querygelombang = mysqli_query($conn, "SELECT * FROM `gelombang_pendaftaran` WHERE id = $id") or die(mysqli_error($conn));
// Jadikan data dari database menjadi array menggunakan fungsi mysqli_fetch_assoc
$datatr = mysqli_fetch_assoc($querygelombang);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Gelombang</h1>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Data Gelombang</h5>

                        <form action="" method="post">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nama Gelombang</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama" class="form-control" id="nama" value="<?= $datatr['nama']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Tanggal Mulai</label>
                                <div class="col-sm-8">
                                    <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai" value="<?= $datatr['tanggal_mulai']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Tanggal Akhir</label>
                                <div class="col-sm-8">
                                    <input type="date" name="tanggal_akhir" class="form-control" id="tanggal_akhir" value="<?= $datatr['tanggal_akhir']; ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Kuota Siswa</label>
                                <div class="col-sm-8">
                                    <input type="number" min="1" name="kuota_siswa" class="form-control" id="kuota_siswa" value="<?= $datatr['kuota_siswa']; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-5">
                                    <a href="data-gelombang.php" class="btn btn-secondary mx-1">Batal</a>
                                    <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
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

// Cek apakah button edit ditekan
// Jika ditekan maka jalankan fungsi dibawah ini
if (isset($_POST['edit'])) {
    // Tampung data dari inputan kedalam variabel
    $nama = $_POST['nama'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $kuota_siswa = $_POST['kuota_siswa'];
    $waktu_sekarang = date('Y-m-d H:i:s');

    // Lalu ubah data yang ada didatabase sesusai hasil inputan
    mysqli_query($conn, "UPDATE `gelombang_pendaftaran` SET `nama` = '$nama', `tanggal_mulai` = '$tanggal_mulai', `tanggal_akhir` = '$tanggal_akhir', `kuota_siswa` = $kuota_siswa, `updated_at` = '$waktu_sekarang' WHERE id = $id");

    // Jika update berhasil dilakukan
    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['success'] = "Data Calon Siswa berhasil diedit";
        echo "<script>window.location.replace('data-gelombang.php');</script>";
        die();
    } else {
        // Jika gagal tampilkan pesan gagal
        $_SESSION['error'] = "Data Calon Siswa gagal diedit";
        echo "<script>window.location.replace('data-gelombang.php');</script>";
        die();
    }
}
?>