<?php
$page = "Data Siswa";
include('../_header.php');
include('../_sidebar.php');

// Jika id tidak didapatkan , maka halaman edit tidak akan bisa dibuka
if (!isset($_GET['id_pembayaran_ulang'])) {
    echo "<script>window.location='data-siswa.php'</script>";
}

// Dapatkan id yang akan diedit data transaksinya
$id_pembayaran_ulang   = $_GET['id_pembayaran_ulang'];
// Cari datanya dalam database berdasarkan id yg didapat
$queryulang = mysqli_query(
    $conn,
    "SELECT tpu.id_pembayaran_ulang, tpu.id_calon_siswa, tcs.nama_lengkap_calon, tpu.bukti_pembayaran_ulang, tpu.status_pembayaran_ulang FROM `tabel-pembayaran-ulang` AS tpu JOIN `tabel-calon-siswa` AS tcs ON tpu.id_calon_siswa = tcs.id_calon_siswa WHERE id_pembayaran_ulang = '$id_pembayaran_ulang'"
) or die(mysqli_error($conn));
// Jadikan data dari database menjadi array menggunakan fungsi mysqli_fetch_assoc
$datatr        = mysqli_fetch_assoc($queryulang);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Pembayaran ulang</h1>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ubah Status Pembayaran Ulang</h5>

                        <!-- Edit dana masuk -->
                        <form action="" method="post" enctype='multipart/form-data'>
                            <input type="hidden" name="id_pembayaran_ulang" value="<?= $datatr['id_pembayaran_ulang']; ?>">
                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Nama </label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama_lengkap_calon" class="form-control" value="<?= $datatr['nama_lengkap_calon']; ?>" id="nama_lengkap_calon" disabled>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label for=" " class="col-sm-3 col-form-label">Status Pembayaran ulang</label>
                                <div class="col-sm-8">
                                    <select name="status_pembayaran_ulang" class="form-select" required>
                                        <option value="lunas" <?php if ($datatr['status_pembayaran_ulang'] == 'lunas') echo 'selected'; ?>>Lunas</option>
                                        <option value="belumlunas" <?php if ($datatr['status_pembayaran_ulang'] == 'belumlunas') echo 'selected'; ?>>Belum Lunas</option>
                                    </select>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-8">

                                        <button type="submit" name="edit" value="edit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                        </form><!-- End Edit data siswa -->

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
    $id_pembayaran_ulang = $_POST['id_pembayaran_ulang'];
    $status_pembayaran_ulang = $_POST['status_pembayaran_ulang'];

    // Lalu ubah data yang ada didatabase sesusai hasil inputan
    mysqli_query($conn, "UPDATE `tabel-pembayaran-ulang` SET 
                            status_pembayaran_ulang = '$status_pembayaran_ulang'
                             WHERE id_pembayaran_ulang = '$id_pembayaran_ulang' ") or die(mysqli_error($conn));

    // Jika update berhasil dilakukan
    if (mysqli_affected_rows($conn) > 0) {
        // Maka tampilkan pesan berhasil dan pindah ke halaman transaksi
        $_SESSION['success'] = 'Status pembayaran ulang berhasil diubah';
        echo '<script>window.location.replace("kelola-pembayaran-ulang.php");</script>';
        die();
    } else {
        // Jika gagal tampilkan pesan gagal
        $_SESSION['error'] = 'Data pembayaran ulang gagal diubah';
        echo '<script>window.location.replace("kelola-pembayaran-ulang.php");</script>';
        die();
    }
}
?>