<?php
// Include file koneksi ke database
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../koneksi/config.php');

// Cek apakah parameter id_calon_siswa dan status ada dan status adalah 'lunas'
if (isset($_GET['id_calon_siswa']) && isset($_GET['status']) && $_GET['status'] == 'lunas') {
    $id_calon_siswa = $_GET['id_calon_siswa'];
    $status_pembayaran = $_GET['status'];

    // Query untuk mendapatkan data calon siswa berdasarkan id_calon_siswa
    $queryCalon = "SELECT * FROM `tabel-calon-siswa` WHERE id_calon_siswa = '$id_calon_siswa'";
    $resultCalon = mysqli_query($conn, $queryCalon);
    $dataCalon = mysqli_fetch_assoc($resultCalon);

    // Jika data calon siswa ditemukan
    if ($dataCalon) {
        // Query untuk mengubah status pembayaran ulang di tabel `tabel-pembayaran-ulang`
        $queryUpdateCalon = "UPDATE `tabel-pembayaran-ulang` SET status_pembayaran_ulang = '$status_pembayaran' WHERE id_calon_siswa = '$id_calon_siswa'";

        // Eksekusi query
        if (mysqli_query($conn, $queryUpdateCalon)) {
            // Redirect ke halaman data kelola pembayaran ulang dengan pesan sukses
            $_SESSION['success'] = 'Status pembayaran ulang berhasil diubah';
            echo '<script>window.location.replace("kelola-pembayaran-ulang.php");</script>';
            die();
        } else {
            // Jika query gagal, tampilkan pesan error
            $_SESSION['error'] = 'Error: ' . $queryUpdateCalon . '<br>' . mysqli_error($conn);
            echo '<script>window.location.replace("kelola-pembayaran-ulang.php");</script>';
            die();
        }
    } else {
        // Jika data calon siswa tidak ditemukan, tampilkan pesan error
        $_SESSION['error'] = 'Data calon siswa tidak ditemukan.';
        echo '<script>window.location.replace("kelola-pembayaran-ulang.php");</script>';
        die();
    }
} else {
    // Jika parameter tidak lengkap, redirect ke halaman data kelola pembayaran ulang dengan pesan error
    $_SESSION['error'] = 'Parameter tidak lengkap';
    echo '<script>window.location.replace("kelola-pembayaran-ulang.php");</script>';
    die();
}

// Tutup koneksi ke database
mysqli_close($conn);
