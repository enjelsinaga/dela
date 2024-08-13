<?php
$page = "calon_siswa";
include('../_header.php');
include('../_sidebar.php');

if (isset($_GET['id_calon_siswa'])) {
    $query_calon_siswa = mysqli_query($conn, "SELECT * FROM `tabel-calon-siswa` WHERE id_calon_siswa = '$_GET[id_calon_siswa]'") or die(mysqli_error($conn));
    $calon_siswa = mysqli_fetch_assoc($query_calon_siswa);
} else {
    header('Location: data-calon-siswa.php');
    exit();
}
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Calon Siswa</h1>

    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Input Nilai Calon Siswa</h5>

                        <!-- Tambah dana keluar -->
                        <form action="" method="post">
                            <input type="hidden" name="id_calon_siswa" value="<?= $calon_siswa['id_calon_siswa'] ?>">

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Pas Photo</label>
                                <div class="col-sm-8">
                                    <?php if (file_exists('../../' . $calon_siswa['pas_photo']) && !empty($calon_siswa['pas_photo'])) : ?>
                                        <img src="../../<?= $calon_siswa['pas_photo'] ?>" alt="Pas Photo" class="img-thumbnail" width="100">
                                    <?php else : ?>
                                        <img src="../../assets/img/No-Image-Placeholder.png" alt="Pas Photo" class="img-thumbnail" width="100">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" value="<?= $calon_siswa['nama_lengkap_calon'] ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Nilai</label>
                                <div class="col-sm-8">
                                    <input type="number" mi="0" name="nilai" class="form-control" id="nilai" value="<?= !empty($calon_siswa['nilai']) ? $calon_siswa['nilai'] : '' ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-5">
                                    <a href="data-calon-siswa.php" class="btn btn-secondary mx-1">Batal</a>
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

// Untuk simpan input nilai
if (isset($_POST['submit'])) {
    $id_calon_siswa = $_POST['id_calon_siswa'];
    $nilai = $_POST['nilai'];

    $query = "UPDATE `tabel-calon-siswa` SET nilai = '$nilai' WHERE id_calon_siswa = '$id_calon_siswa'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success'] = 'Input nilai berhasil disimpan';
        echo '<script>window.location.replace("data-calon-siswa.php");</script>';
        die();
    } else {
        $_SESSION['error'] = 'Input nilai gagal disimpan';
        echo '<script>window.location.replace("data-calon-siswa.php");</script>';
        die();
    }
}
?>