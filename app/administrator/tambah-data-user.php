<?php
$page = "user";
include('../_header.php');
include('../_sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data User</h1>

    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data User</h5>

                        <!-- Tambah dana keluar -->
                        <form action="" method="post">

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text" name="username" class="form-control" id="username" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" name="email" class="form-control" id="email" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">No HP</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nohp" class="form-control" id="nohp" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Level Akun</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="level_akun" id="level_akun" required>
                                        <option value="">Pilih Level Akun</option>
                                        <option value="level1">Admin</option>
                                        <option value="level2">Panitia</option>
                                        <option value="level3">Keuangan</option>
                                        <option value="level4">Siswa</option>
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
                                <div class="col-sm-5">
                                    <a href="data-user.php" class="btn btn-secondary mx-1">Batal</a>
                                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>

                        </form><!-- End Tambah data user -->

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
    $nama_lengkap = filter_input(INPUT_POST, 'nama_lengkap', FILTER_DEFAULT);
    $username = filter_input(INPUT_POST, 'username', FILTER_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_DEFAULT);
    $nohp = filter_input(INPUT_POST, 'nohp', FILTER_DEFAULT);
    $level_akun = filter_input(INPUT_POST, 'level_akun', FILTER_DEFAULT);
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $waktu_sekarang = date('Y-m-d H:i:s');

    mysqli_query($conn, "INSERT INTO `tabel_pengguna` (nama_lengkap, username, email, nohp, level_akun, `password`, created_at, updated_at) VALUES ('$nama_lengkap', '$username', '$email', '$nohp', '$level_akun', '$password_hash', '$waktu_sekarang', '$waktu_sekarang')") or die(mysqli_error($conn));

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['success'] = 'Data User Berhasil Ditambahkan';
        echo '<script>window.location.replace("data-user.php");</script>';
        die();
    } else {
        $_SESSION['error'] = 'Data User Gagal ditambahkan!';
        echo '<script>window.location.replace("data-user.php");</script>';
        die();
    }
}
?>