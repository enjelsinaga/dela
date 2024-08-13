<?php

include_once('../koneksi/config.php');

// Jika button delete nya di klik, maka jalankan kodingan ini
// Cek apakah variabel yang masuk ke halaman hapus ini namanya : $_GET['id']
// Jika iya jalankan kodingan hapus datanya

if (isset($_GET['id'])) {

    // Tampung id yg diklik ke dalam variabel
    $id = $_GET['id'];

    // Cek apakah id nya ada dalam database
    $cek_gelombang = mysqli_query($conn, "SELECT * FROM `gelombang_pendaftaran` WHERE id = $id") or die(mysqli_error($conn));

    // Jika data transaksi ada, maka hapus datanya
    if (mysqli_affected_rows($conn) > 0) {
        mysqli_query($conn, "DELETE FROM `gelombang_pendaftaran` WHERE id = $id");

        // Cek jika transaksi berhasil dihapus tampilkan pesan nya
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['success'] = "Data Gelombang Berhasil dihapus";
            echo "<script>window.location.replace('data-gelombang.php')</script>";
            die();
        } else {
            $_SESSION['error'] = "Data Gelombang gagal dihapus";
            echo "<script>window.location.replace('data-gelombang.php')</script>";
            die();
        }
    }
    // Jika tidak tampilkan pesan transaksi gagal dihapus
    else {
        $_SESSION['error'] = "Data Gelombang gagal dihapus";
        echo "<script>window.location.replace('data-gelombang.php')</script>";
        die();
    }
}
// Jika bukan , kembalikan ke halaman transaksi
else {
    echo "<script>window.location.replace('data-gelombang.php')</script>";
}
