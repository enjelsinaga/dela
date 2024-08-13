<?php

require_once 'koneksi.php';
include_once 'helpers.php';

session_start();

$page = 'formulir';
$title = 'Formulir Pendaftaran - MI MUHAMMADIYAH 01 PEKANBARU';

$level_akun_sess = $_SESSION['level_akun'];
$level_akun = 'level4';

if ($level_akun_sess != $level_akun) {
    header("Location: ./index.php");
}

// Verify the token and id_gelombang mapping
if (isset($_GET['id_gelombang'], $_GET['token']) && isset($_SESSION['gelombang_tokens'][$_GET['id_gelombang']]) && hash_equals($_SESSION['gelombang_tokens'][$_GET['id_gelombang']], $_GET['token'])) {
    // Store the id_gelombang if token and id_gelombang are valid
    $_SESSION['gelombang'] = $_GET['id_gelombang'];
}

// Fetch the gelombang details if present
$id_gelombang = isset($_SESSION['gelombang']) ? $_SESSION['gelombang'] : null;
$gelombang_details = null;

if ($id_gelombang) {
    $query_gelombang = "SELECT * FROM `gelombang_pendaftaran` WHERE id = ?";
    $stmt = $koneksi->prepare($query_gelombang);
    $stmt->bind_param('i', $id_gelombang);
    $stmt->execute();
    $res_stmt = $stmt->get_result();
    $stmt->close();

    $gelombang_details = $res_stmt->fetch_assoc();
}

// Untuk simpan data formulir pendaftaran calon siswa
if (isset($_POST['submitFormulirPendaftaranCalon'])) {
    $id_pengguna = $_SESSION['id_pengguna'];
    $id_gelombang_pendaftaran = filter_input(INPUT_POST, 'id_gelombang_pendaftaran', FILTER_DEFAULT);
    $nama_lengkap_calon = filter_input(INPUT_POST, 'nama_lengkap_calon', FILTER_DEFAULT);
    $umur_calon = filter_input(INPUT_POST, 'umur_calon', FILTER_DEFAULT);
    $no_ortu_calon = filter_input(INPUT_POST, 'no_ortu_calon', FILTER_DEFAULT);
    $jenis_kelamin = filter_input(INPUT_POST, 'jenis_kelamin', FILTER_DEFAULT);
    $tempat_lahir = filter_input(INPUT_POST, 'tempat_lahir', FILTER_DEFAULT);
    $tanggal_lahir = filter_input(INPUT_POST, 'tanggal_lahir', FILTER_DEFAULT);
    $status = 'belumlulus';

    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'pdf');
    $dir_upload = 'files/';
    $status_file_upload_pas_photo = false;
    $status_file_upload_ktp_ortu = false;
    $status_file_upload_kk = false;
    $status_file_upload_akte_lahir = false;

    // Cek apakah file berkas ada di database dan di server, jika ada hapus filenya
    $query_calon_siswa = "SELECT * FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
    $stmt = $koneksi->prepare($query_calon_siswa);
    $stmt->bind_param('i', $id_pengguna);
    $stmt->execute();
    $res_stmt = $stmt->get_result();
    $stmt->close();

    $calon_siswa = $res_stmt->fetch_assoc();

    if ($res_stmt->num_rows > 0) {
        if (!empty($calon_siswa['pas_photo'])) {
            if (file_exists($calon_siswa['pas_photo'])) {
                unlink($calon_siswa['pas_photo']);
            }
        }

        if (!empty($calon_siswa['KTP_ortu_calon'])) {
            if (file_exists($calon_siswa['KTP_ortu_calon'])) {
                unlink($calon_siswa['KTP_ortu_calon']);
            }
        }

        if (!empty($calon_siswa['KK_calon'])) {
            if (file_exists($calon_siswa['KK_calon'])) {
                unlink($calon_siswa['KK_calon']);
            }
        }

        if (!empty($calon_siswa['akteLahir_calon'])) {
            if (file_exists($calon_siswa['akteLahir_calon'])) {
                unlink($calon_siswa['akteLahir_calon']);
            }
        }
    }

    try {
        $random_string = bin2hex(random_bytes(16));
        $pas_photo = $_FILES['pas_photo']['name'];
        $x = explode('.', $pas_photo);
        $ekstensi = strtolower(end($x));
        $file_new_name = preg_replace('/[^A-Za-z0-9?!]/', '', $pas_photo) . '-' . $random_string . '.' . $ekstensi;
        $ukuran = $_FILES['pas_photo']['size'];
        $file_tmp = $_FILES['pas_photo']['tmp_name'];
        $file_save_pas_photo = $dir_upload . $file_new_name;

        if ($ukuran <= 10485760) { // 10 MB dalam satuan bytes
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if (move_uploaded_file($file_tmp, $file_save_pas_photo)) {
                    $status_file_upload_pas_photo = true;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file pas photo.';
                    header("Refresh:0; url=formulir_siswa.php#student-registration");
                    die();
                }
            } else {
                $_SESSION['error'] = 'Ekstensi file yang diupload tidak diperbolehkan.';
                header("Refresh:0; url=formulir_siswa.php#student-registration");
                die();
            }
        } else {
            $_SESSION['error'] = 'Ukuran file terlalu besar. Maksimal 10 MB.';
            header("Refresh:0; url=formulir_siswa.php#student-registration");
            die();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file pas photo. ' . $e->getMessage();
        header("Refresh:0; url=formulir_siswa.php#student-registration");
        die();
    }

    try {
        $random_string = bin2hex(random_bytes(16));
        $ktp_ortu_calon = $_FILES['ktp_ortu_calon']['name'];
        $x = explode('.', $ktp_ortu_calon);
        $ekstensi = strtolower(end($x));
        $file_new_name = preg_replace('/[^A-Za-z0-9?!]/', '', $ktp_ortu_calon) . '-' . $random_string . '.' . $ekstensi;
        $ukuran = $_FILES['ktp_ortu_calon']['size'];
        $file_tmp = $_FILES['ktp_ortu_calon']['tmp_name'];
        $file_save_ktp_ortu_calon = $dir_upload . $file_new_name;

        if ($ukuran <= 10485760) { // 10 MB dalam satuan bytes
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if (move_uploaded_file($file_tmp, $file_save_ktp_ortu_calon)) {
                    $status_file_upload_ktp_ortu = true;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file KTP Ortu.';
                    header("Refresh:0; url=formulir_siswa.php#student-registration");
                    die();
                }
            } else {
                $_SESSION['error'] = 'Ekstensi file yang diupload tidak diperbolehkan.';
                header("Refresh:0; url=formulir_siswa.php#student-registration");
                die();
            }
        } else {
            $_SESSION['error'] = 'Ukuran file terlalu besar. Maksimal 10 MB.';
            header("Refresh:0; url=formulir_siswa.php#student-registration");
            die();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file KTP Ortu. ' . $e->getMessage();
        header("Refresh:0; url=formulir_siswa.php#student-registration");
        die();
    }

    try {
        $random_string = bin2hex(random_bytes(16));
        $kk_calon = $_FILES['kk_calon']['name'];
        $x = explode('.', $kk_calon);
        $ekstensi = strtolower(end($x));
        $file_new_name = preg_replace('/[^A-Za-z0-9?!]/', '', $kk_calon) . '-' . $random_string . '.' . $ekstensi;
        $ukuran = $_FILES['kk_calon']['size'];
        $file_tmp = $_FILES['kk_calon']['tmp_name'];
        $file_save_kk_calon = $dir_upload . $file_new_name;

        if ($ukuran <= 10485760) { // 10 MB dalam satuan bytes
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if (move_uploaded_file($file_tmp, $file_save_kk_calon)) {
                    $status_file_upload_kk = true;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file Kartu Keluarga.';
                    header("Refresh:0; url=formulir_siswa.php#student-registration");
                    die();
                }
            } else {
                $_SESSION['error'] = 'Ekstensi file yang diupload tidak diperbolehkan.';
                header("Refresh:0; url=formulir_siswa.php#student-registration");
                die();
            }
        } else {
            $_SESSION['error'] = 'Ukuran file terlalu besar. Maksimal 10 MB.';
            header("Refresh:0; url=formulir_siswa.php#student-registration");
            die();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file Kartu Keluarga. ' . $e->getMessage();
        header("Refresh:0; url=formulir_siswa.php#student-registration");
        die();
    }

    try {
        $random_string = bin2hex(random_bytes(16));
        $akte_lahir_calon = $_FILES['akte_lahir_calon']['name'];
        $x = explode('.', $akte_lahir_calon);
        $ekstensi = strtolower(end($x));
        $file_new_name = preg_replace('/[^A-Za-z0-9?!]/', '', $akte_lahir_calon) . '-' . $random_string . '.' . $ekstensi;
        $ukuran = $_FILES['akte_lahir_calon']['size'];
        $file_tmp = $_FILES['akte_lahir_calon']['tmp_name'];
        $file_save_akte_lahir_calon = $dir_upload . $file_new_name;

        if ($ukuran <= 10485760) { // 10 MB dalam satuan bytes
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if (move_uploaded_file($file_tmp, $file_save_akte_lahir_calon)) {
                    $status_file_upload_akte_lahir = true;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file Akte Lahir Calon.';
                    header("Refresh:0; url=formulir_siswa.php#student-registration");
                    die();
                }
            } else {
                $_SESSION['error'] = 'Ekstensi file yang diupload tidak diperbolehkan.';
                header("Refresh:0; url=formulir_siswa.php#student-registration");
                die();
            }
        } else {
            $_SESSION['error'] = 'Ukuran file terlalu besar. Maksimal 10 MB.';
            header("Refresh:0; url=formulir_siswa.php#student-registration");
            die();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file Akte Lahir Calon. ' . $e->getMessage();
        header("Refresh:0; url=formulir_siswa.php#student-registration");
        die();
    }

    try {
        if ($status_file_upload_pas_photo && $status_file_upload_ktp_ortu && $status_file_upload_kk && $status_file_upload_akte_lahir) {
            $check_calon_siswa = "SELECT * FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
            $stmt = $koneksi->prepare($check_calon_siswa);
            $stmt->bind_param('i', $id_pengguna);
            $stmt->execute();
            $res_stmt = $stmt->get_result();
            $stmt->close();

            if ($res_stmt->num_rows > 0) {
                $sql = "UPDATE `tabel-calon-siswa` SET nama_lengkap_calon = ?, umur_calon = ?, jenis_kelamin = ?, tempat_lahir = ?, tanggal_lahir = ?, no_ortu_calon = ?, pas_photo = ?, KTP_ortu_calon = ?, KK_calon = ?, akteLahir_calon = ?, `status` = ?, updated_at = ? WHERE id_pengguna = ?";
                $stmt = $koneksi->prepare($sql);
                $stmt->bind_param('sissssssssssi', $nama_lengkap_calon, $umur_calon, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $no_ortu_calon, $file_save_pas_photo, $file_save_ktp_ortu_calon, $file_save_kk_calon, $file_save_akte_lahir_calon, $status, $sekarang, $id_pengguna);
                $stmt->execute();
                $stmt->close();

                $_SESSION['success'] = 'Formulir pendaftaran siswa baru berhasil diupdate.';
                header("Refresh:0; url=formulir_siswa.php#student-registration");
                die();
            } else {
                $sql = "INSERT INTO `tabel-calon-siswa` (id_pengguna, id_gelombang_pendaftaran, nama_lengkap_calon, umur_calon, jenis_kelamin, tempat_lahir, tanggal_lahir, no_ortu_calon, pas_photo, KTP_ortu_calon, KK_calon, akteLahir_calon, `status`, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $koneksi->prepare($sql);
                $stmt->bind_param('iisisssssssssss', $id_pengguna, $id_gelombang_pendaftaran, $nama_lengkap_calon, $umur_calon, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $no_ortu_calon, $file_save_pas_photo, $file_save_ktp_ortu_calon, $file_save_kk_calon, $file_save_akte_lahir_calon, $status, $sekarang, $sekarang);
                $stmt->execute();
                $stmt->close();

                $_SESSION['success'] = 'Formulir pendaftaran siswa baru berhasil disimpan.';
                header("Refresh:0; url=formulir_siswa.php#student-registration");
                die();
            }
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan. ' . $e->getMessage();
        header("Refresh:0; url=formulir_siswa.php#student-registration");
        die();
    }
}

// Untuk simpan data pembayaran formulir calon siswa
if (isset($_POST['submitPembayaranFormulir'])) {
    $id_pengguna = $_SESSION['id_pengguna'];
    $status_pembayaran_formulir = 'belumlunas';

    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
    $dir_upload = 'files/';
    $status_file_upload_bukti_bayar = false;

    // Cek apakah file berkas ada di database dan di server, jika ada hapus filenya
    $query_calon_siswa = "SELECT id_calon_siswa FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
    $stmt = $koneksi->prepare($query_calon_siswa);
    $stmt->bind_param('i', $id_pengguna);
    $stmt->execute();
    $res_stmt = $stmt->get_result();
    $stmt->close();

    $calon_siswa = $res_stmt->fetch_assoc();
    $id_calon_siswa = $calon_siswa['id_calon_siswa'];

    $query_pembayaran_formulir = "SELECT bukti_pembayaran_formulir FROM `tabel-pembayaran-formulir` WHERE id_calon_siswa = ?";
    $stmt = $koneksi->prepare($query_pembayaran_formulir);
    $stmt->bind_param('i', $id_calon_siswa);
    $stmt->execute();
    $res_stmt_pembayaran_formulir = $stmt->get_result();
    $stmt->close();

    $pembayaran_formlir = $res_stmt_pembayaran_formulir->fetch_assoc();

    if ($res_stmt_pembayaran_formulir->num_rows > 0) {
        if (!empty($pembayaran_formlir['bukti_pembayaran_formulir'])) {
            if (file_exists($pembayaran_formlir['bukti_pembayaran_formulir'])) {
                unlink($pembayaran_formlir['bukti_pembayaran_formulir']);
            }
        }
    }

    try {
        $random_string = bin2hex(random_bytes(16));
        $bukti_bayar = $_FILES['bukti_bayar']['name'];
        $x = explode('.', $bukti_bayar);
        $ekstensi = strtolower(end($x));
        $file_new_name = preg_replace('/[^A-Za-z0-9?!]/', '', $bukti_bayar) . '-' . $random_string . '.' . $ekstensi;
        $ukuran = $_FILES['bukti_bayar']['size'];
        $file_tmp = $_FILES['bukti_bayar']['tmp_name'];
        $file_save_bukti_bayar = $dir_upload . $file_new_name;

        if ($ukuran <= 10485760) { // 10 MB dalam satuan bytes
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if (move_uploaded_file($file_tmp, $file_save_bukti_bayar)) {
                    $status_file_upload_bukti_bayar = true;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file bukti bayar.';
                    header("Refresh:0; url=formulir_siswa.php#payment-form");
                    die();
                }
            } else {
                $_SESSION['error'] = 'Ekstensi file yang diupload tidak diperbolehkan.';
                header("Refresh:0; url=formulir_siswa.php#payment-form");
                die();
            }
        } else {
            $_SESSION['error'] = 'Ukuran file terlalu besar. Maksimal 10 MB.';
            header("Refresh:0; url=formulir_siswa.php#payment-form");
            die();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file bukti bayar. ' . $e->getMessage();
        header("Refresh:0; url=formulir_siswa.php#payment-form");
        die();
    }

    try {
        if ($status_file_upload_bukti_bayar) {
            $check_calon_siswa = "SELECT id_calon_siswa FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
            $stmt = $koneksi->prepare($check_calon_siswa);
            $stmt->bind_param('i', $id_pengguna);
            $stmt->execute();
            $res_stmt = $stmt->get_result();
            $stmt->close();

            $calon_siswa = $res_stmt->fetch_assoc();
            $id_calon_siswa = $calon_siswa['id_calon_siswa'];

            $check_pembayaran_formulir = "SELECT * FROM `tabel-pembayaran-formulir` WHERE id_calon_siswa = ?";
            $stmt = $koneksi->prepare($check_pembayaran_formulir);
            $stmt->bind_param('i', $id_calon_siswa);
            $stmt->execute();
            $res_stmt_pembayaran_formulir = $stmt->get_result();
            $stmt->close();

            if ($res_stmt_pembayaran_formulir->num_rows > 0) {
                $sql = "UPDATE `tabel-pembayaran-formulir` SET bukti_pembayaran_formulir = ?, updated_at = ? WHERE id_calon_siswa = ?";
                $stmt = $koneksi->prepare($sql);
                $stmt->bind_param('ssi', $file_save_bukti_bayar, $sekarang, $id_calon_siswa);
                $stmt->execute();
                $stmt->close();

                $_SESSION['success'] = 'Bukti pembayaran formulir berhasil diupdate.';
                header("Refresh:0; url=formulir_siswa.php#payment-form");
                die();
            } else {
                $sql_insert = "INSERT INTO `tabel-pembayaran-formulir` (id_calon_siswa, bukti_pembayaran_formulir, status_pembayaran_formulir, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
                $stmt = $koneksi->prepare($sql_insert);
                $stmt->bind_param('issss', $id_calon_siswa, $file_save_bukti_bayar, $status_pembayaran_formulir, $sekarang, $sekarang);
                $stmt->execute();
                $stmt->close();

                $_SESSION['success'] = 'Bukti pembayaran formulir berhasil disimpan.';
                header("Refresh:0; url=formulir_siswa.php#payment-form");
                die();
            }
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan. ' . $e->getMessage();
        header("Refresh:0; url=formulir_siswa.php#payment-form");
        die();
    }
}

// Untuk simpan data pembayaran ulang calon siswa
if (isset($_POST['submitPembayaranUlang'])) {
    $id_pengguna = $_SESSION['id_pengguna'];
    $status_pembayaran_ulang = 'belumlunas';

    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
    $dir_upload = 'files/';
    $status_file_upload_bukti_bayar = false;

    // Cek apakah file berkas ada di database dan di server, jika ada hapus filenya
    $query_calon_siswa = "SELECT id_calon_siswa FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
    $stmt = $koneksi->prepare($query_calon_siswa);
    $stmt->bind_param('i', $id_pengguna);
    $stmt->execute();
    $res_stmt = $stmt->get_result();
    $stmt->close();

    $calon_siswa = $res_stmt->fetch_assoc();
    $id_calon_siswa = $calon_siswa['id_calon_siswa'];

    $query_pembayaran_ulang = "SELECT bukti_pembayaran_ulang FROM `tabel-pembayaran-ulang` WHERE id_calon_siswa = ?";
    $stmt = $koneksi->prepare($query_pembayaran_ulang);
    $stmt->bind_param('i', $id_calon_siswa);
    $stmt->execute();
    $res_stmt_pembayaran_ulang = $stmt->get_result();
    $stmt->close();

    $pembayaran_ulang = $res_stmt_pembayaran_ulang->fetch_assoc();

    if ($res_stmt_pembayaran_ulang->num_rows > 0) {
        if (!empty($pembayaran_ulang['bukti_pembayaran_ulang'])) {
            if (file_exists($pembayaran_ulang['bukti_pembayaran_ulang'])) {
                unlink($pembayaran_ulang['bukti_pembayaran_ulang']);
            }
        }
    }

    try {
        $random_string = bin2hex(random_bytes(16));
        $bukti_bayar_ulang = $_FILES['bukti_bayar_ulang']['name'];
        $x = explode('.', $bukti_bayar_ulang);
        $ekstensi = strtolower(end($x));
        $file_new_name = preg_replace('/[^A-Za-z0-9?!]/', '', $bukti_bayar_ulang) . '-' . $random_string . '.' . $ekstensi;
        $ukuran = $_FILES['bukti_bayar_ulang']['size'];
        $file_tmp = $_FILES['bukti_bayar_ulang']['tmp_name'];
        $file_save_bukti_bayar_ulang = $dir_upload . $file_new_name;

        if ($ukuran <= 10485760) { // 10 MB dalam satuan bytes
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                if (move_uploaded_file($file_tmp, $file_save_bukti_bayar_ulang)) {
                    $status_file_upload_bukti_bayar = true;
                } else {
                    $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file bukti bayar ulang.';
                    header("Refresh:0; url=formulir_siswa.php#re-registration");
                    die();
                }
            } else {
                $_SESSION['error'] = 'Ekstensi file yang diupload tidak diperbolehkan.';
                header("Refresh:0; url=formulir_siswa.php#re-registration");
                die();
            }
        } else {
            $_SESSION['error'] = 'Ukuran file terlalu besar. Maksimal 10 MB.';
            header("Refresh:0; url=formulir_siswa.php#re-registration");
            die();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan dalam mengupload file bukti bayar ulang. ' . $e->getMessage();
        header("Refresh:0; url=formulir_siswa.php#re-registration");
        die();
    }

    try {
        if ($status_file_upload_bukti_bayar) {
            $check_calon_siswa = "SELECT id_calon_siswa FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
            $stmt = $koneksi->prepare($check_calon_siswa);
            $stmt->bind_param('i', $id_pengguna);
            $stmt->execute();
            $res_stmt = $stmt->get_result();
            $stmt->close();

            $calon_siswa = $res_stmt->fetch_assoc();
            $id_calon_siswa = $calon_siswa['id_calon_siswa'];

            $check_pembayaran_ulang = "SELECT * FROM `tabel-pembayaran-ulang` WHERE id_calon_siswa = ?";
            $stmt = $koneksi->prepare($check_pembayaran_ulang);
            $stmt->bind_param('i', $id_calon_siswa);
            $stmt->execute();
            $res_stmt_pembayaran_ulang = $stmt->get_result();
            $stmt->close();

            if ($res_stmt_pembayaran_ulang->num_rows > 0) {
                $sql = "UPDATE `tabel-pembayaran-ulang` SET bukti_pembayaran_ulang = ?, updated_at = ? WHERE id_calon_siswa = ?";
                $stmt = $koneksi->prepare($sql);
                $stmt->bind_param('ssi', $file_save_bukti_bayar_ulang, $sekarang, $id_calon_siswa);
                $stmt->execute();
                $stmt->close();

                $_SESSION['success'] = 'Bukti pembayaran ulang berhasil diupdate.';
                header("Refresh:0; url=formulir_siswa.php#re-registration");
                die();
            } else {
                $sql_insert = "INSERT INTO `tabel-pembayaran-ulang` (id_calon_siswa, bukti_pembayaran_ulang, status_pembayaran_ulang, created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
                $stmt = $koneksi->prepare($sql_insert);
                $stmt->bind_param('issss', $id_calon_siswa, $file_save_bukti_bayar_ulang, $status_pembayaran_ulang, $sekarang, $sekarang);
                $stmt->execute();
                $stmt->close();

                $_SESSION['success'] = 'Bukti pembayaran ulang berhasil disimpan.';
                header("Refresh:0; url=formulir_siswa.php#re-registration");
                die();
            }
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Terjadi kesalahan. ' . $e->getMessage();
        header("Refresh:0; url=formulir_siswa.php#re-registration");
        die();
    }
}

// Untuk simpan data daftar ulang calon siswa
if (isset($_POST['submitFormulirDaftarUlang'])) {
    $id_pengguna = $_SESSION['id_pengguna'];
    $id_calon_siswa_daftar_ulang = filter_input(INPUT_POST, 'id_calon_siswa_daftar_ulang', FILTER_DEFAULT);
    $tanggal_sekarang = date('Y-m-d H:i:s');

    // Get data from tabel calon siswa and then insert it to tabel siswa
    $query_calon_siswa = "SELECT * FROM `tabel-calon-siswa` WHERE id_calon_siswa = ?";
    $stmt = $koneksi->prepare($query_calon_siswa);
    $stmt->bind_param('i', $id_calon_siswa_daftar_ulang);
    $stmt->execute();
    $res_stmt = $stmt->get_result();
    $stmt->close();

    $calon_siswa = $res_stmt->fetch_assoc();

    if (!empty($calon_siswa)) {
        $id_gelombang_pendaftaran = $calon_siswa['id_gelombang_pendaftaran'];
        $nama_lengkap_calon = $calon_siswa['nama_lengkap_calon'];
        $umur_calon = $calon_siswa['umur_calon'];
        $jenis_kelamin = $calon_siswa['jenis_kelamin'];
        $tempat_lahir = $calon_siswa['tempat_lahir'];
        $tanggal_lahir = $calon_siswa['tanggal_lahir'];
        $no_ortu_calon = $calon_siswa['no_ortu_calon'];
        $pas_photo = $calon_siswa['pas_photo'];
        $KTP_ortu_calon = $calon_siswa['KTP_ortu_calon'];
        $KK_calon = $calon_siswa['KK_calon'];
        $akteLahir_calon = $calon_siswa['akteLahir_calon'];

        $sql_insert_siswa = "INSERT INTO `tabel-siswa` (id_pengguna, id_gelombang_pendaftaran, nama_lengkap, umur_siswa, jenis_kelamin, tempat_lahir, tanggal_lahir, no_ortu_siswa, pas_photo, KTP_ortu, KK, akteLahir, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql_insert_siswa);
        $stmt->bind_param('iissssssssssss', $id_pengguna, $id_gelombang_pendaftaran, $nama_lengkap_calon, $umur_calon, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $no_ortu_calon, $pas_photo, $KTP_ortu_calon, $KK_calon, $akteLahir_calon, $tanggal_sekarang, $tanggal_sekarang);
        $stmt->execute();
        $stmt->close();

        $_SESSION['success'] = 'Formulir daftar ulang siswa baru berhasil disimpan.';
        header("Refresh:0; url=formulir_siswa.php#re-registration");
        die();
    } else {
        $_SESSION['error'] = 'Data calon siswa tidak ditemukan.';
        header("Refresh:0; url=formulir_siswa.php#re-registration");
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include '_partials/head.php'; ?>

<body class="index-page">

    <?php
    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
    ?>
        <div id="success_message" class="alert alert-success fixed-bottom" role="alert">
            <i class="fa fa-check-circle"></i>
            <?= $success; ?>
        </div>
    <?php
        unset($_SESSION['success']);
    } ?>

    <?php
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
    ?>
        <div id="error_message" class="alert alert-danger fixed-bottom" role="alert">
            <i class="fa fa-ban"></i>
            <?= $error; ?>
        </div>
    <?php
        unset($_SESSION['error']);
    } ?>

    <?php include '_partials/navbar.php'; ?>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1>Tahapan Pendaftaran Siswa Baru</h1>
                            <p class="mb-0">Silakan ikuti langkah-langkah berikut untuk mendaftarkan diri sebagai siswa baru.</p>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="index.html">Home</a></li>
                        <li class="current">Formulir Pendaftaran</li>
                    </ol>
                </div>
            </nav>
        </div>
        <!-- End Page Title -->

        <nav class="custom-nav">
            <ul class="nav justify-content-center">
                <?php
                $cek_calon_siswa_exist = "SELECT * FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
                $stmt = $koneksi->prepare($cek_calon_siswa_exist);
                $stmt->bind_param('i', $_SESSION['id_pengguna']);
                $stmt->execute();
                $res_stmt = $stmt->get_result();
                $stmt->close();

                $calon_siswa_exist = $res_stmt->fetch_assoc();
                ?>
                <li class="nav-item">
                    <a class="nav-link active" href="#student-registration">Pendaftaran Siswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= empty($calon_siswa_exist) ? 'disabled' : ''; ?>" href="#payment-form">Pembayaran Formulir</a>
                </li>
                <?php
                $cek_pembayaran_formulir = "SELECT * FROM `tabel-pembayaran-formulir` WHERE id_calon_siswa = ?";
                $stmt = $koneksi->prepare($cek_pembayaran_formulir);
                $stmt->bind_param('i', $calon_siswa_exist['id_calon_siswa']);
                $stmt->execute();
                $res_stmt_pembayaran_formulir = $stmt->get_result();
                $stmt->close();

                $pembayaran_formulir = $res_stmt_pembayaran_formulir->fetch_assoc();
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= empty($pembayaran_formulir) || $pembayaran_formulir['status_pembayaran_formulir'] == 'belumlunas' ? 'disabled' : ''; ?>" href="#card-exam-print">Cetak Kartu Ujian</a>
                </li>
                <?php
                $cek_status_kelulusan = "SELECT * FROM `tabel-calon-siswa` WHERE id_calon_siswa = ?";
                $stmt = $koneksi->prepare($cek_status_kelulusan);
                $stmt->bind_param('i', $calon_siswa_exist['id_calon_siswa']);
                $stmt->execute();
                $res_stmt_status_kelulusan = $stmt->get_result();
                $stmt->close();

                $status_kelulusan = $res_stmt_status_kelulusan->fetch_assoc();
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= empty($pembayaran_formulir) || $pembayaran_formulir['status_pembayaran_formulir'] == 'belumlunas' ? 'disabled' : ''; ?>" href="#graduation-status">Status Kelulusan</a>
                </li>
                <?php
                $cek_pembayaran_ulang = "SELECT * FROM `tabel-pembayaran-ulang` WHERE id_calon_siswa = ?";
                $stmt = $koneksi->prepare($cek_pembayaran_ulang);
                $stmt->bind_param('i', $siswa_exist['id_calon_siswa']);
                $stmt->execute();
                $res_stmt_pembayaran_ulang = $stmt->get_result();
                $stmt->close();

                $pembayaran_ulang = $res_stmt_pembayaran_ulang->fetch_assoc();
                ?>
                <li class="nav-item">
                    <a class="nav-link <?= empty($status_kelulusan) || $status_kelulusan['status'] != 'lulus' ? 'disabled' : ''; ?>" href="#re-registration">Daftar Ulang</a>
                </li>
            </ul>
        </nav>

        <!-- Student Registration Section -->
        <section id="student-registration" class="student-registration section pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="text-center mb-5">Formulir Pendaftaran Siswa Baru</h2>

                        <?php
                        $query_calon_siswa = "SELECT * FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
                        $stmt = $koneksi->prepare($query_calon_siswa);
                        $stmt->bind_param('i', $_SESSION['id_pengguna']);
                        $stmt->execute();
                        $res_stmt = $stmt->get_result();
                        $stmt->close();

                        $calon_siswa = $res_stmt->fetch_assoc();
                        ?>

                        <?php if (!empty($gelombang_details) || !empty($calon_siswa)) : ?>
                            <form action="formulir_siswa.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_gelombang_pendaftaran" value="<?= !empty($gelombang_details) ? $gelombang_details['id'] : ''; ?>">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="fullname">Nama Lengkap Siswa</label>
                                        <input type="text" name="nama_lengkap_calon" class="form-control" id="nama_lengkap_calon" value="<?= $res_stmt->num_rows > 0 ? $calon_siswa['nama_lengkap_calon'] : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="age">Umur</label>
                                        <input type="number" min="1" name="umur_calon" class="form-control" id="umur_calon" value="<?= $res_stmt->num_rows > 0 ? $calon_siswa['umur_calon'] : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="laki-laki" <?= $res_stmt->num_rows > 0 && $calon_siswa['jenis_kelamin'] == 'laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                            <option value="perempuan" <?= $res_stmt->num_rows > 0 && $calon_siswa['jenis_kelamin'] == 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="no_ortu_calon">No. HP Orang Tua</label>
                                        <input type="number" min="0" name="no_ortu_calon" class="form-control" id="no_ortu_calon" value="<?= $res_stmt->num_rows > 0 ? $calon_siswa['no_ortu_calon'] : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" value="<?= $res_stmt->num_rows > 0 ? $calon_siswa['tempat_lahir'] : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" value="<?= $res_stmt->num_rows > 0 ? $calon_siswa['tanggal_lahir'] : ''; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="pas_photo">Pas Photo</label>
                                        <input type="file" class="form-control" id="pas_photo" name="pas_photo" required>
                                        <?php if ($res_stmt->num_rows > 0 && !empty($calon_siswa['pas_photo'])) : ?>
                                            <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                                <a href="<?= $calon_siswa['pas_photo']; ?>" target="_blank" class="text-success">Lihat File</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="familycard">KTP Orang Tua</label>
                                        <input type="file" class="form-control" id="ktp_ortu_calon" name="ktp_ortu_calon" required>
                                        <?php if ($res_stmt->num_rows > 0 && !empty($calon_siswa['KTP_ortu_calon'])) : ?>
                                            <?php if (file_exists($calon_siswa['KTP_ortu_calon'])) : ?>
                                                <a href="<?= $calon_siswa['KTP_ortu_calon']; ?>" target="_blank" class="text-success">Lihat File</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="familycard">Kartu Keluarga</label>
                                        <input type="file" class="form-control" id="kk_calon" name="kk_calon" required>
                                        <?php if ($res_stmt->num_rows > 0 && !empty($calon_siswa['KK_calon'])) : ?>
                                            <?php if (file_exists($calon_siswa['KK_calon'])) : ?>
                                                <a href="<?= $calon_siswa['KK_calon']; ?>" target="_blank" class="text-success">Lihat File</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="grades">Akte Lahir</label>
                                        <input type="file" class="form-control" id="akte_lahir_calon" name="akte_lahir_calon" required>
                                        <?php if ($res_stmt->num_rows > 0 && !empty($calon_siswa['akteLahir_calon'])) : ?>
                                            <?php if (file_exists($calon_siswa['akteLahir_calon'])) : ?>
                                                <a href="<?= $calon_siswa['akteLahir_calon']; ?>" target="_blank" class="text-success">Lihat File</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-12 text-center p-3">
                                        <?php if (!empty($calon_siswa['id_calon_siswa'])) : ?>
                                            <button type="button" class="btn btn-success" disabled>Submit</button>
                                        <?php else : ?>
                                            <button type="submit" name="submitFormulirPendaftaranCalon" class="btn btn-success">Submit</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        <?php else : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger" role="alert">
                                        <i class="fa fa-exclamation-circle"></i>
                                        Maaf, silakan pilih formulir terlebih dahulu.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <a href="formulir.php" class="btn btn-success">Pilih Formulir</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section><!-- End Student Registration Section -->

        <!-- Payment Form Section -->
        <section id="payment-form" class="payment-form section pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="text-center mb-5">Pembayaran Formulir</h2>

                        <?php
                        $query_pembayaran_formulir = "SELECT * FROM `tabel-pembayaran-formulir` WHERE id_calon_siswa = ?";
                        $stmt = $koneksi->prepare($query_pembayaran_formulir);
                        $stmt->bind_param('i', $calon_siswa['id_calon_siswa']);
                        $stmt->execute();
                        $res_stmt = $stmt->get_result();
                        $stmt->close();

                        $pembayaran_formulir = $res_stmt->fetch_assoc();
                        ?>

                        <?php if (!empty($calon_siswa['id_calon_siswa'])) : ?>
                            <?php if ($res_stmt->num_rows > 0 && $pembayaran_formulir['status_pembayaran_formulir'] == 'lunas') : ?>
                                <div class="row">
                                    <!-- Photo placeholder on the left -->
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                            <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                            <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                                <img src="<?= $calon_siswa['pas_photo']; ?>" alt="Pas Photo" style="width: 200px; height: 200px;">
                                            <?php else : ?>
                                                <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- Form inputs on the right -->
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal">Lunas</button>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fullname">Nama Lengkap Siswa</label>
                                            <input type="text" class="form-control" value="<?= !empty($calon_siswa['nama_lengkap_calon']) ? $calon_siswa['nama_lengkap_calon'] : ''; ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <div class="alert alert-success" role="alert">
                                                <i class="fa fa-check-circle"></i>
                                                Terima kasih, pembayaran formulir Anda sudah kami verifikasi. Silakan lanjut dengan cetak kartu ujian.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <form action="formulir_siswa.php" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <!-- Photo placeholder on the left -->
                                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                                            <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                                <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                                <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                                    <img src="<?= $calon_siswa['pas_photo']; ?>" alt="Pas Photo" style="width: 200px; height: 200px;">
                                                <?php else : ?>
                                                    <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <!-- Form inputs on the right -->
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <div class="payment-info">
                                                    <div class="item">
                                                        <span class="label"><i class="fa fa-money"></i> Nominal</span>
                                                        <span class="value">Rp. 500.000</span>
                                                    </div>
                                                    <div class="item">
                                                        <span class="label"><i class="fa fa-calendar"></i> Batas Pembayaran</span>
                                                        <span class="value"><?= date('d-M-Y', strtotime('+2 days')); ?></span>
                                                    </div>
                                                    <div class="item">
                                                        <span class="label"><i class="fa fa-exclamation-circle"></i> Status Pembayaran</span>
                                                        <span class="value status-pending">Belum Lunas</span>
                                                    </div>
                                                    <div class="item">
                                                        <span class="label"><i class="fa fa-credit-card"></i> Bank BSI</span>
                                                        <span class="value virtual-account">1234567890</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-1"></div>
                                            <div class="mb-3">
                                                <label for="fullname">Nama Lengkap Siswa</label>
                                                <input type="text" name="nama_lengkap_siswa" class="form-control" id="nama_lengkap_siswa" value="<?= !empty($calon_siswa['nama_lengkap_calon']) ? $calon_siswa['nama_lengkap_calon'] : ''; ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jumlabayar">Jumlah Yang Harus Dibayar (Rp. )</label>
                                                <input type="text" name="jumlah_bayar" class="form-control" id="jumlah_bayar" value="Rp. 500.000" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="proof">Foto Bukti Bayar</label>
                                                <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar" required>
                                                <?php if ($res_stmt->num_rows > 0 && !empty($pembayaran_formulir['bukti_pembayaran_formulir'])) : ?>
                                                    <?php if (file_exists($pembayaran_formulir['bukti_pembayaran_formulir'])) : ?>
                                                        <a href="<?= $pembayaran_formulir['bukti_pembayaran_formulir']; ?>" target="_blank" class="text-success">Lihat File</a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center p-3">
                                            <button type="submit" name="submitPembayaranFormulir" class="btn btn-success">Upload Bukti Bayar</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="row">
                                <!-- Photo placeholder on the left -->
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                        <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                        <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                    </div>
                                </div>
                                <!-- Form inputs on the right -->
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <div class="alert alert-warning" role="alert">
                                            <i class="fa fa-exclamation-triangle"></i>
                                            Maaf, Anda belum bisa melanjutkan ke tahap pembayaran formulir karena data formulir pendaftaran siswa baru Anda belum lengkap.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section><!-- End Payment Form Section -->

        <!-- Card Exam Print Section -->
        <section id="card-exam-print" class="card-exam-print section pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="text-center mb-5">Cetak Kartu Ujian</h2>
                        <?php
                        $tahun_siswa = !empty($calon_siswa['created_at']) ? date('Y', strtotime($calon_siswa['created_at'])) : date('Y');
                        $id_kartu_siswa = !empty($calon_siswa['id_calon_siswa']) ? 'KU' . $tahun_siswa . sprintf('%05s', $calon_siswa['id_calon_siswa']) : '';
                        ?>
                        <?php if (!empty($calon_siswa['id_calon_siswa'])) : ?>
                            <?php if ($res_stmt->num_rows > 0 && $pembayaran_formulir['status_pembayaran_formulir'] == 'lunas') : ?>
                                <form action="cetak_kartu_ujian_siswa.php" method="post">
                                    <input type="hidden" name="id_calon_siswa" id="id_calon_siswa" value="<?= !empty($calon_siswa['id_calon_siswa']) ? $calon_siswa['id_calon_siswa'] : ''; ?>">
                                    <div class="row">
                                        <!-- Photo placeholder on the left -->
                                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                                            <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                                <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                                <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                                    <img src="<?= $calon_siswa['pas_photo']; ?>" alt="Pas Photo" style="width: 200px; height: 200px;">
                                                <?php else : ?>
                                                    <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <!-- Form inputs on the right -->
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="examcard">ID Kartu Ujian</label>
                                                <input type="text" name="id_kartu_siswa" class="form-control" id="id_kartu_siswa" value="<?= $id_kartu_siswa; ?>" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fullname">Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap_calon" class="form-control" id="nama_lengkap_calon" value="<?= !empty($calon_siswa['nama_lengkap_calon']) ? $calon_siswa['nama_lengkap_calon'] : ''; ?>" disabled>
                                            </div>
                                            <div class="text-center p-3">
                                                <a href="cetak_kartu_ujian.php" target="_blank" class="btn btn-success">Cetak Kartu Ujian</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php else : ?>
                                <div class="row">
                                    <!-- Photo placeholder on the left -->
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                            <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                            <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                                <img src="<?= $calon_siswa['pas_photo']; ?>" alt="Pas Photo" style="width: 200px; height: 200px;">
                                            <?php else : ?>
                                                <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- Form inputs on the right -->
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-warning">Belum Lunas</button>
                                        </div>
                                        <div class="mb-3">
                                            <div class="alert alert-warning" role="alert">
                                                <i class="fa fa-exclamation-triangle"></i>
                                                Maaf, Anda belum bisa mencetak kartu ujian karena pembayaran formulir Anda belum lunas.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="row">
                                <!-- Photo placeholder on the left -->
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                        <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                        <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                            <img src="<?= $calon_siswa['pas_photo']; ?>" alt="Pas Photo" style="width: 200px; height: 200px;">
                                        <?php else : ?>
                                            <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- Form inputs on the right -->
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <div class="alert alert-warning" role="alert">
                                            <i class="fa fa-exclamation-triangle"></i>
                                            Maaf, Anda belum bisa mencetak kartu ujian karena data formulir pendaftaran siswa baru Anda belum lengkap.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section><!-- End Card Exam Print Section -->

        <!-- Graduation Status Section -->
        <section id="graduation-status" class="graduation-status section pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="text-center mb-5">Status Kelulusan</h2>
                        <?php

                        $query_status_kelulusan = "SELECT * FROM `tabel-calon-siswa` WHERE id_calon_siswa = ?";
                        $stmt = $koneksi->prepare($query_status_kelulusan);
                        $stmt->bind_param('i', $calon_siswa['id_calon_siswa']);
                        $stmt->execute();
                        $res_stmt = $stmt->get_result();
                        $stmt->close();

                        $status_kelulusan = $res_stmt->fetch_assoc();

                        ?>

                        <?php if (!empty($calon_siswa['id_calon_siswa'])) : ?>
                            <?php if ($res_stmt->num_rows > 0 && $status_kelulusan['status'] == 'belumlulus') : ?>
                                <p class="mt-3"><b>STATUS KELULUSAN ANDA</b></p>
                                <div class="result-icon info my-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M16 8a8 8 0 1 1-16 0 8 8 0 0 1 16 0zM8 1.5a6.5 6.5 0 1 0 0 13 6.5 6.5 0 0 0 0-13zM5.496 6.033a.237.237 0 0 1 .24-.233h.522c.668 0 1.116.596 1.134 1.276v.006c0 .614-.377 1.122-.965 1.624l-.206.175c-.274.23-.445.463-.445.842v.856a.42.42 0 0 0 .42.42h.602a.425.425 0 0 0 .424-.425v-.662c0-.223.158-.407.331-.569l.177-.151c.723-.62 1.349-1.494 1.349-2.481v-.007c0-1.738-1.573-2.601-2.97-2.601h-.54a.228.228 0 0 1-.236-.228zm.008 6.906c0-.49.395-.888.882-.888.488 0 .885.398.885.888 0 .49-.397.887-.885.887a.893.893 0 0 1-.882-.887z" />
                                    </svg>
                                </div>
                                <p class="result-message info mb-3">Informasi status kelulusan Anda masih dalam proses verifikasi.</p>
                            <?php elseif ($res_stmt->num_rows > 0 && $status_kelulusan['status'] == 'lulus') : ?>
                                <p class="mt-3"><b>SELAMAT STATUS KELULUSAN SUDAH KELUAR</b></p>
                                <div class="result-icon my-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08 0L7.477 8.09 5.384 5.997a.75.75 0 1 0-1.06 1.06L6.97 9.712l3.998-3.998a.75.75 0 0 0 0-1.06z" />
                                    </svg>
                                </div>
                                <p class="result-message mb-3">Anda Lulus Seleksi!!!</p>
                                <p class="result-message">Silakan daftar ulang untuk melanjutkan ke tahap selanjutnya.</p>
                            <?php elseif ($res_stmt->num_rows > 0 && $status_kelulusan['status'] == 'tidaklulus') : ?>
                                <p class="mt-3"><b>STATUS KELULUSAN ANDA</b></p>
                                <div class="result-icon danger my-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zm3.97 3.03a.75.75 0 0 0-1.08 0L8 6.92 5.11 4.03a.75.75 0 0 0-1.06 1.06L6.92 8 4.03 10.89a.75.75 0 1 0 1.06 1.06L8 9.08l2.89 2.89a.75.75 0 0 0 1.06-1.06L9.08 8l2.89-2.89a.75.75 0 0 0 0-1.06z" />
                                    </svg>
                                </div>
                                <p class="result-message danger mb-3">Maaf, Anda Tidak Lulus Seleksi.</p>
                                <p class="result-message danger">Silakan coba lagi pada tahun berikutnya.</p>
                            <?php endif; ?>
                        <?php else : ?>
                            <p class="mt-3"><b>STATUS KELULUSAN ANDA</b></p>
                            <p class="result-message info my-4">Anda belum mendaftar sebagai calon siswa baru.</p>
                            <p class="result-message info my-4">Silakan daftar formulir pendaftaran siswa baru terlebih dahulu.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Graduation Status Section -->

        <!-- Re-Registration Section -->
        <section id="re-registration" class="re-registration section pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="text-center mb-5">Pembayaran Daftar Ulang</h2>

                        <?php
                        $query_pembayaran_ulang = "SELECT * FROM `tabel-pembayaran-ulang` WHERE id_calon_siswa = ?";
                        $stmt = $koneksi->prepare($query_pembayaran_ulang);
                        $stmt->bind_param('i', $calon_siswa['id_calon_siswa']);
                        $stmt->execute();
                        $res_stmt = $stmt->get_result();
                        $stmt->close();

                        $pembayaran_ulang = $res_stmt->fetch_assoc();
                        ?>

                        <?php if (!empty($calon_siswa['id_calon_siswa'])) : ?>
                            <?php if (!empty($status_kelulusan['status']) && $status_kelulusan['status'] == 'lulus') : ?>
                                <?php if (!empty($pembayaran_ulang) && $pembayaran_ulang['status_pembayaran_ulang'] == 'lunas') : ?>
                                    <form action="formulir_siswa.php" method="post">
                                        <input type="hidden" name="id_calon_siswa_daftar_ulang" id="id_calon_siswa_daftar_ulang" value="<?= !empty($calon_siswa['id_calon_siswa']) ? $calon_siswa['id_calon_siswa'] : ''; ?>">
                                        <div class="row">
                                            <!-- Photo placeholder on the left -->
                                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                                <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                                    <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                                    <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                                        <img src="<?= $calon_siswa['pas_photo']; ?>" alt="Pas Photo" style="width: 200px; height: 200px;">
                                                    <?php else : ?>
                                                        <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <!-- Form inputs on the right -->
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal">Lunas</button>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fullname">Nama Lengkap Siswa</label>
                                                    <input type="text" class="form-control" value="<?= !empty($calon_siswa['nama_lengkap_calon']) ? $calon_siswa['nama_lengkap_calon'] : ''; ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="alert alert-success" role="alert">
                                                        <i class="fa fa-check-circle"></i>
                                                        Terima kasih, pembayaran daftar ulang Anda sudah kami verifikasi. Silakan lanjut dengan klik tombol submit di bawah ini.
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center p-3">
                                                    <?php
                                                    $cek_submit_siswa = "SELECT * FROM `tabel-siswa` WHERE id_pengguna = ?";
                                                    $stmt = $koneksi->prepare($cek_submit_siswa);
                                                    $stmt->bind_param('i', $_SESSION['id_pengguna']);
                                                    $stmt->execute();
                                                    $res_stmt_submit_siswa = $stmt->get_result();
                                                    $stmt->close();

                                                    $submit_siswa = $res_stmt_submit_siswa->fetch_assoc();
                                                    ?>
                                                    <?php if (!empty($submit_siswa['id_siswa'])) : ?>
                                                        <button type="button" class="btn btn-success" disabled>Submit</button>
                                                    <?php else : ?>
                                                        <button type="submit" name="submitFormulirDaftarUlang" class="btn btn-success">Submit</button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php else : ?>
                                    <form action="formulir_siswa.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <!-- Photo placeholder on the left -->
                                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                                <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                                    <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                                    <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                                        <img src="<?= $calon_siswa['pas_photo']; ?>" alt="Pas Photo" style="width: 200px; height: 200px;">
                                                    <?php else : ?>
                                                        <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <!-- Form inputs on the right -->
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <div class="payment-info">
                                                        <div class="item">
                                                            <span class="label"><i class="fa fa-money"></i> Nominal</span>
                                                            <span class="value">Rp. 500.000</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label"><i class="fa fa-calendar"></i> Batas Pembayaran</span>
                                                            <span class="value"><?= date('d-M-Y', strtotime('+2 days')); ?></span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label"><i class="fa fa-exclamation-circle"></i> Status Pembayaran</span>
                                                            <span class="value status-pending">Belum Lunas</span>
                                                        </div>
                                                        <div class="item">
                                                            <span class="label"><i class="fa fa-credit-card"></i> Bank BSI</span>
                                                            <span class="value virtual-account">1234567890</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="p-1"></div>
                                                <div class="mb-3">
                                                    <label for="nama_lengkap_calon">Nama Lengkap</label>
                                                    <input type="text" class="form-control" value="<?= !empty($calon_siswa['nama_lengkap_calon']) ? $calon_siswa['nama_lengkap_calon'] : ''; ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jumlah_bayar">Jumlah (Rp)</label>
                                                    <input type="text" name="jumlah_bayar_ulang" class="form-control" id="jumlah_bayar_ulang" value="Rp. 500.000" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="proof">Foto Bukti Bayar</label>
                                                    <input type="file" class="form-control" id="bukti_bayar_ulang" name="bukti_bayar_ulang" required>
                                                    <?php if (!empty($pembayaran_ulang['bukti_pembayaran_ulang'])) : ?>
                                                        <?php if (file_exists($pembayaran_ulang['bukti_pembayaran_ulang'])) : ?>
                                                            <a href="<?= $pembayaran_ulang['bukti_pembayaran_ulang']; ?>" target="_blank" class="text-success">Lihat File</a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center p-3">
                                                <button type="submit" name="submitPembayaranUlang" class="btn btn-success">Upload Bukti Bayar</button>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            <?php elseif ($res_stmt->num_rows > 0 && $status_kelulusan['status'] == 'belumlulus') : ?>
                                <div class="row">
                                    <!-- Photo placeholder on the left -->
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                            <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                            <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                                <img src="<?= $calon_siswa['pas_photo']; ?>" alt="Pas Photo" style="width: 200px; height: 200px;">
                                            <?php else : ?>
                                                <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- Form inputs on the right -->
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <div class="alert alert-warning" role="alert">
                                                <i class="fa fa-exclamation-triangle"></i>
                                                Maaf, Anda belum bisa mendaftar ulang karena status kelulusan Anda masih dalam proses verifikasi.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="row">
                                    <!-- Photo placeholder on the left -->
                                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                                        <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                            <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                            <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                                <img src="<?= $calon_siswa['pas_photo']; ?>" alt="Pas Photo" style="width: 200px; height: 200px;">
                                            <?php else : ?>
                                                <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- Form inputs on the right -->
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <div class="alert alert-warning" role="alert">
                                                <i class="fa fa-exclamation-triangle"></i>
                                                Maaf, Anda tidak bisa mendaftar ulang karena Anda tidak lulus seleksi.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="row">
                                <!-- Photo placeholder on the left -->
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <div class="image-placeholder" style="width: 200px; height: 200px; background-color: #ccc;">
                                        <!-- Optionally, add an <img> tag if a dynamic image is needed -->
                                        <?php if (file_exists($calon_siswa['pas_photo'])) : ?>
                                            <img src="<?= $calon_siswa['pas_photo']; ?>" alt="Pas Photo" style="width: 200px; height: 200px;">
                                        <?php else : ?>
                                            <img src="assets/img/No-Image-Placeholder.png" alt="Placeholder" style="width: 200px; height: 200px;">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- Form inputs on the right -->
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <div class="alert alert-warning" role="alert">
                                            <i class="fa fa-exclamation-triangle"></i>
                                            Maaf, Anda belum bisa mendaftar ulang karena data formulir pendaftaran siswa baru Anda belum lengkap.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section><!-- End Re-Registration Section -->

    </main>

    <!-- Modal Pembayaran Formulir -->
    <div class="modal fade" id="pembayaranFormulirModal" tabindex="-1" aria-labelledby="pembayaranFormulirModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pembayaranFormulirModalLabel">Detail Pembayaran Formulir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>No. Rekening: 1234567890</p>
                    <p>Atas Nama: MI Muhammadiyah 01 Pekanbaru</p>
                    <p>Bank: Bank BSI</p>
                    <p>Sebesar: Rp. 500.000</p>
                    <p>Setelah melakukan pembayaran, silakan upload bukti pembayaran. Kami akan segera memverifikasi pembayaran Anda.</p>
                    <p>Terima kasih.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '_partials/footer.php'; ?>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <?php include '_partials/js.php'; ?>

    <script>
        $('#success_message').fadeIn();
        setTimeout(function() {
            $('#success_message').fadeOut("slow");
        }, 8000);

        $('#error_message').fadeIn();
        setTimeout(function() {
            $('#error_message').fadeOut("slow");
        }, 8000);

        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll('.custom-nav .nav-link');
            const sections = document.querySelectorAll('section');

            // Function to update visibility of sections
            function updateSectionVisibility(targetId) {
                sections.forEach(section => {
                    if (section.id === targetId) {
                        section.style.display = 'block'; // show the current section
                    } else {
                        section.style.display = 'none'; // hide other sections
                    }
                });

                navLinks.forEach(link => {
                    if (link.getAttribute('href') === '#' + targetId) {
                        link.classList.add('active'); // add active class to the current link
                    } else {
                        link.classList.remove('active'); // remove active class from other links
                    }
                });
            }

            // Initialize the page with the registration form active
            updateSectionVisibility('student-registration');

            // Function to handle URL hash change on initial load
            function handleInitialHash() {
                const hash = window.location.hash.substring(1); // get the hash without the #
                if (hash) {
                    updateSectionVisibility(hash);
                } else {
                    updateSectionVisibility('student-registration');
                }
            }

            // Check the URL hash on initial load
            handleInitialHash();

            // Add click event listener to nav links
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1); // get the id without the hash
                    updateSectionVisibility(targetId);
                    // window.location.hash = targetId; // update the URL hash
                });
            });
        });
    </script>

</body>

</html>