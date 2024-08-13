<?php
$page = "user";
include('../_header.php');
include('../_sidebar.php');

// Jika id tidak didapatkan , maka halaman edit tidak akan bisa dibuka
if (!isset($_GET['id_pengguna'])) {
    echo "<script>window.location='data-user.php'</script>";
}

// Dapatkan id yang akan diedit data transaksinya
$id_pengguna    = $_GET['id_pengguna'];
// Cari datanya dalam database berdasarkan id yg didapat
$queryuser = mysqli_query($conn, "SELECT * FROM `tabel_pengguna` WHERE id_pengguna= $id_pengguna") or die(mysqli_error($conn));
// Jadikan data dari database menjadi array menggunakan fungsi mysqli_fetch_assoc
$datatr        = mysqli_fetch_assoc($queryuser);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data User</h1>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Data User</h5>

                        <!-- Edit dana masuk -->
                        <form action="" method="post" enctype='multipart/form-data'>
                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" value="<?= $datatr['nama_lengkap'] ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" name="username" class="form-control" id="username" value="<?= $datatr['username'] ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" name="email" class="form-control" id="email" value="<?= $datatr['email'] ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">No HP</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nohp" class="form-control" id="nohp" value="<?= $datatr['nohp'] ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Level Akun</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="level_akun" id="level_akun" required>
                                        <option value="">Pilih Level Akun</option>
                                        <option value="level1" <?= $datatr['level_akun'] == 'level1' ? 'selected' : '' ?>>Admin</option>
                                        <option value="level2" <?= $datatr['level_akun'] == 'level2' ? 'selected' : '' ?>>Panitia</option>
                                        <option value="level3" <?= $datatr['level_akun'] == 'level3' ? 'selected' : '' ?>>Keuangan</option>
                                        <option value="level4" <?= $datatr['level_akun'] == 'level4' ? 'selected' : '' ?>>Siswa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password" class="form-control" id="password" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-8">
                                    <a href="data-user.php" class="btn btn-secondary mx-1">Batal</a>
                                    <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>

                        </form><!-- End Edit data user -->

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
    $nama_lengkap = filter_input(INPUT_POST, 'nama_lengkap', FILTER_DEFAULT);
    $username = filter_input(INPUT_POST, 'username', FILTER_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
    $nohp = filter_input(INPUT_POST, 'nohp', FILTER_DEFAULT);
    $level_akun = filter_input(INPUT_POST, 'level_akun', FILTER_DEFAULT);
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $waktu_sekarang = date('Y-m-d H:i:s');

    // Query untuk mengupdate data user
    $query = "UPDATE `tabel_pengguna` SET
                nama_lengkap = '$nama_lengkap',
                username = '$username',
                email = '$email',
                nohp = '$nohp',
                level_akun = '$level_akun',
                `password` = '$password_hash',
                updated_at = '$waktu_sekarang'
                WHERE id_pengguna = $id_pengguna";
    // Jalankan query
    $update = mysqli_query($conn, $query);
    // Cek apakah query berhasil dijalankan
    if ($update) {
        $_SESSION['success'] = 'Data user berhasil diubah.';
        echo '<script>window.location.replace("data-user.php");</script>';
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengubah data user.';
        echo '<script>window.location.replace("data-user.php");</script>';
    }
}
?>