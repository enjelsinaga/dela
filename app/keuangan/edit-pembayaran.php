<?php
$page = "Data Siswa";
include('../_header.php');
include('../_sidebar.php');

// Jika id tidak didapatkan , maka halaman edit tidak akan bisa dibuka
if (!isset($_GET['id_formulir'])) {
    echo "<script>window.location='data-siswa.php'</script>";
}

// Dapatkan id yang akan diedit data transaksinya
$id_formulir   = $_GET['id_formulir'];
// Cari datanya dalam database berdasarkan id yg didapat
// $queryformulir = mysqli_query($conn, "SELECT * FROM `tabel-pembayaran-formulir` WHERE id_formulir= '$id_formulir'" ) or die (mysqli_error($conn));
$queryformulir = mysqli_query(
    $conn,
    "SELECT tpf.id_formulir, tpf.id_calon_siswa, tcs.nama_lengkap_calon, tpf.bukti_pembayaran_formulir, tpf.status_pembayaran_formulir FROM `tabel-pembayaran-formulir` AS tpf JOIN `tabel-calon-siswa` AS tcs ON tpf.id_calon_siswa = tcs.id_calon_siswa WHERE id_formulir = '$id_formulir'"
) or die(mysqli_error($conn));
// Jadikan data dari database menjadi array menggunakan fungsi mysqli_fetch_assoc
$datatr        = mysqli_fetch_assoc($queryformulir);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Pembayaran Formulir</h1>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ubah Status Pembayaran Formulir</h5>

                        <!-- Edit dana masuk -->
                        <form action="" method="post" enctype='multipart/form-data'>
                            <input type="hidden" name="id_formulir" value="<?= $datatr['id_formulir']; ?>">
                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Nama </label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama_lengkap_calon" class="form-control" value="<?= $datatr['nama_lengkap_calon']; ?>" id="nama_lengkap_calon" disabled>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label for=" " class="col-sm-3 col-form-label">Status Pembayaran Formulir</label>
                                <div class="col-sm-8">
                                    <select name="status_pembayaran_formulir" class="form-select" required>
                                        <option value="lunas" <?php if ($datatr['status_pembayaran_formulir'] == 'lunas') echo 'selected'; ?>>Lunas</option>
                                        <option value="belumlunas" <?php if ($datatr['status_pembayaran_formulir'] == 'belumlunas') echo 'selected'; ?>>Belum Lunas</option>
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
    $id_formulir = $_POST['id_formulir'];
    $status_pembayaran_formulir = $_POST['status_pembayaran_formulir'];

    // Lalu ubah data yang ada didatabase sesusai hasil inputan
    mysqli_query($conn, "UPDATE `tabel-pembayaran-formulir` SET 
                            status_pembayaran_formulir = '$status_pembayaran_formulir'
                             WHERE id_formulir = '$id_formulir' ") or die(mysqli_error($conn));

    // Jika update berhasil dilakukan
    if (mysqli_affected_rows($conn) > 0) {
        // Maka tampilkan pesan berhasil dan pindah ke halaman transaksi
        $_SESSION['success'] = 'Status pembayaran formulir berhasil diubah';
        echo '<script>window.location.replace("kelola-pembayaran-formulir.php");</script>';
        die();
    } else {
        // Jika gagal tampilkan pesan gagal
        $_SESSION['error'] = 'Data pembayaran formulir gagal diubah';
        echo '<script>window.location.replace("kelola-pembayaran-formulir.php");</script>';
        die();
    }
}
?>