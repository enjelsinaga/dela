<?php
$page = "Data Calon Siswa";
include('../_header.php');
include('../_sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Siswa</h1>

    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-8">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data Siswa</h5>

                        <!-- Tambah dana keluar -->
                        <form action="" method="post" enctype='multipart/form-data'>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" required>
                                </div>
                            </div>


                            <div class="row mb-5">
                                <label for=" " class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-8">
                                    <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label for=" " class="col-sm-3 col-form-label">Umur</label>
                                <div class="col-sm-8">
                                    <input type="number" name="umur_siswa" class="form-control" id="umur_siswa" placeholder="   tahun" required>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label for=" " class="col-sm-3 col-form-label">Tempat Lahir</label>
                                <div class="col-sm-8">
                                    <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" required>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label for=" " class="col-sm-3 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-8">
                                    <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" required>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label for=" " class="col-sm-3 col-form-label">No HP Orang Tua </label>
                                <div class="col-sm-8">
                                    <input type="text" name="no_ortu_siswa" class="form-control" id="no_ortu_siswa" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Pas Photo</label>
                                <div class="col-sm-8">
                                    <input type="file" name="pas_photo" class="form-control" id="pas_photo" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">KTP Orang Tua</label>
                                <div class="col-sm-8">
                                    <input type="file" name="KTP_ortu" class="form-control" id="KTP_ortu" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Kartu Keluarga</label>
                                <div class="col-sm-8">
                                    <input type="file" name="KK" class="form-control" id="KK" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for=" " class="col-sm-3 col-form-label">Akte Kelahiran</label>
                                <div class="col-sm-8">
                                    <input type="file" name="akteLahir" class="form-control" id="akteLahir" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-5">
                                    <a href="data-siswa.php" class="btn btn-secondary mx-1">Batal</a>
                                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>

                        </form><!-- End Tambah dana keluar -->

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
    $umur_siswa = filter_input(INPUT_POST, 'umur_siswa', FILTER_DEFAULT);
    $jenis_kelamin = filter_input(INPUT_POST, 'jenis_kelamin', FILTER_DEFAULT);
    $tempat_lahir = filter_input(INPUT_POST, 'tempat_lahir', FILTER_DEFAULT);
    $tanggal_lahir = filter_input(INPUT_POST, 'tanggal_lahir', FILTER_DEFAULT);
    $no_ortu_siswa = filter_input(INPUT_POST, 'no_ortu_siswa', FILTER_DEFAULT);
    $waktu_sekarang = date('Y-m-d H:i:s');

    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'pdf');
    $dir_upload = '../../files/';
    $dir_save = 'files/';
    $status_file_upload_pas_photo = false;
    $status_file_upload_ktp_ortu = false;
    $status_file_upload_kk = false;
    $status_file_upload_akte_lahir = false;
    $status_file_upload_penghargaan = false;

    try {
        $random_string = bin2hex(random_bytes(16));
        $pas_photo = $_FILES['pas_photo']['name'];
        $x = explode('.', $pas_photo);
        $ekstensi = strtolower(end($x));
        $file_new_name = preg_replace('/[^A-Za-z0-9?!]/', '', $pas_photo) . '-' . $random_string . '.' . $ekstensi;
        $ukuran = $_FILES['pas_photo']['size'];
        $file_tmp = $_FILES['pas_photo']['tmp_name'];
        $file_upload_pas_photo = $dir_upload . $file_new_name;
        $file_save_pas_photo = $dir_save . $file_new_name;

        if ($ukuran <= 10485760) { // 10 MB dalam satuan bytes
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if (move_uploaded_file($file_tmp, $file_upload_pas_photo)) {
                    $status_file_upload_pas_photo = true;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file pas photo.';
                    echo '<script>window.location.replace("data-siswa.php");</script>';
                    die();
                }
            } else {
                $_SESSION['error'] = 'Ekstensi file yang diupload tidak diperbolehkan.';
                echo '<script>window.location.replace("data-siswa.php");</script>';
                die();
            }
        } else {
            $_SESSION['error'] = 'Ukuran file terlalu besar. Maksimal 10 MB.';
            echo '<script>window.location.replace("data-siswa.php");</script>';
            die();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file pas photo. ' . $e->getMessage();
        echo '<script>window.location.replace("data-siswa.php");</script>';
        die();
    }

    try {
        $random_string = bin2hex(random_bytes(16));
        $KTP_ortu = $_FILES['KTP_ortu']['name'];
        $x = explode('.', $KTP_ortu);
        $ekstensi = strtolower(end($x));
        $file_new_name = preg_replace('/[^A-Za-z0-9?!]/', '', $KTP_ortu) . '-' . $random_string . '.' . $ekstensi;
        $ukuran = $_FILES['KTP_ortu']['size'];
        $file_tmp = $_FILES['KTP_ortu']['tmp_name'];
        $file_upload_KTP_ortu = $dir_upload . $file_new_name;
        $file_save_KTP_ortu = $dir_save . $file_new_name;

        if ($ukuran <= 10485760) { // 10 MB dalam satuan bytes
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if (move_uploaded_file($file_tmp, $file_upload_KTP_ortu)) {
                    $status_file_upload_ktp_ortu = true;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file KTP Orang Tua.';
                    echo '<script>window.location.replace("data-siswa.php");</script>';
                    die();
                }
            } else {
                $_SESSION['error'] = 'Ekstensi file yang diupload tidak diperbolehkan.';
                echo '<script>window.location.replace("data-siswa.php");</script>';
                die();
            }
        } else {
            $_SESSION['error'] = 'Ukuran file terlalu besar. Maksimal 10 MB.';
            echo '<script>window.location.replace("data-siswa.php");</script>';
            die();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file KTP Orang Tua. ' . $e->getMessage();
        echo '<script>window.location.replace("data-siswa.php");</script>';
        die();
    }

    try {
        $random_string = bin2hex(random_bytes(16));
        $KK = $_FILES['KK']['name'];
        $x = explode('.', $KK);
        $ekstensi = strtolower(end($x));
        $file_new_name = preg_replace('/[^A-Za-z0-9?!]/', '', $KK) . '-' . $random_string . '.' . $ekstensi;
        $ukuran = $_FILES['KK']['size'];
        $file_tmp = $_FILES['KK']['tmp_name'];
        $file_upload_KK = $dir_upload . $file_new_name;
        $file_save_KK = $dir_save . $file_new_name;

        if ($ukuran <= 10485760) { // 10 MB dalam satuan bytes
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if (move_uploaded_file($file_tmp, $file_upload_KK)) {
                    $status_file_upload_kk = true;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file Kartu Keluarga.';
                    echo '<script>window.location.replace("data-siswa.php");</script>';
                    die();
                }
            } else {
                $_SESSION['error'] = 'Ekstensi file yang diupload tidak diperbolehkan.';
                echo '<script>window.location.replace("data-siswa.php");</script>';
                die();
            }
        } else {
            $_SESSION['error'] = 'Ukuran file terlalu besar. Maksimal 10 MB.';
            echo '<script>window.location.replace("data-siswa.php");</script>';
            die();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file Kartu Keluarga. ' . $e->getMessage();
        echo '<script>window.location.replace("data-siswa.php");</script>';
        die();
    }

    try {
        $random_string = bin2hex(random_bytes(16));
        $akteLahir = $_FILES['akteLahir']['name'];
        $x = explode('.', $akteLahir);
        $ekstensi = strtolower(end($x));
        $file_new_name = preg_replace('/[^A-Za-z0-9?!]/', '', $akteLahir) . '-' . $random_string . '.' . $ekstensi;
        $ukuran = $_FILES['akteLahir']['size'];
        $file_tmp = $_FILES['akteLahir']['tmp_name'];
        $file_upload_akteLahir = $dir_upload . $file_new_name;
        $file_save_akteLahir = $dir_save . $file_new_name;

        if ($ukuran <= 10485760) { // 10 MB dalam satuan bytes
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if (move_uploaded_file($file_tmp, $file_upload_akteLahir)) {
                    $status_file_upload_akte_lahir = true;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file Akte Kelahiran.';
                    echo '<script>window.location.replace("data-siswa.php");</script>';
                    die();
                }
            } else {
                $_SESSION['error'] = 'Ekstensi file yang diupload tidak diperbolehkan.';
                echo '<script>window.location.replace("data-siswa.php");</script>';
                die();
            }
        } else {
            $_SESSION['error'] = 'Ukuran file terlalu besar. Maksimal 10 MB.';
            echo '<script>window.location.replace("data-siswa.php");</script>';
            die();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file Akte Kelahiran. ' . $e->getMessage();
        echo '<script>window.location.replace("data-siswa.php");</script>';
        die();
    }

    if ($status_file_upload_pas_photo && $status_file_upload_ktp_ortu && $status_file_upload_kk && $status_file_upload_akte_lahir) {
        mysqli_query($conn, "INSERT INTO `tabel-siswa`(nama_lengkap, jenis_kelamin, tempat_lahir, tanggal_lahir, umur_siswa, no_ortu_siswa, pas_photo, KTP_ortu, KK, akteLahir, created_at, updated_at ) 
                            VALUES ('$nama_lengkap', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', $umur_siswa, '$no_ortu_siswa', '$file_save_pas_photo', '$file_save_KTP_ortu', '$file_save_KK',  '$file_save_akteLahir', '$waktu_sekarang', '$waktu_sekarang')
                          ") or die(mysqli_error($conn));

        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['success'] = 'Data Siswa Berhasil Ditambahkan';
            echo '<script>window.location.replace("data-siswa.php");</script>';
            die();
        } else {
            $_SESSION['error'] = 'Data Siswa Gagal ditambahkan!';
            echo '<script>window.location.replace("data-siswa.php");</script>';
            die();
        }
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file. Silahkan coba lagi.';
        echo '<script>window.location.replace("data-siswa.php");</script>';
        die();
    }
}
?>