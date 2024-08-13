<?php

include_once('../koneksi/config.php');

// Jika button delete nya di klik, maka jalankan kodingan ini
// Cek apakah variabel yang masuk ke halaman hapus ini namanya : $_GET['id-sparepart']
// Jika iya jalankan kodingan hapus datanya

if (isset($_GET['id_pengguna'])) {

    // Tampung id yg diklik ke dalam variabel
    $id_pengguna = $_GET['id_pengguna'];

    // Cek apakah id nya ada dalam database
    $cek_user = mysqli_query($conn, "SELECT * FROM `tabel_pengguna` WHERE id_pengguna ='$id_pengguna'") or die(mysqli_error($conn));

    // Jika data user ada, maka hapus datanya
    if (mysqli_affected_rows($conn) > 0) {
        mysqli_query($conn, "DELETE FROM `tabel_pengguna` WHERE id_pengguna ='$id_pengguna'");

        // Cek jika user berhasil dihapus tampilkan pesan nya
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['success'] = 'Data user berhasil dihapus.';
            echo '<script>window.location.replace("data-user.php");</script>';
        } else {
            $_SESSION['error'] = 'Data user gagal dihapus.';
            echo '<script>window.location.replace("data-user.php");</script>';
        }
    }
    // Jika tidak tampilkan pesan user gagal dihapus
    else {
        $_SESSION['error'] = 'Data user gagal dihapus.';
        echo '<script>window.location.replace("data-user.php");</script>';
    }
}
// Jika bukan , kembalikan ke halaman user
else {
    echo "<script>window.location='data-user.php'</script>";
}
