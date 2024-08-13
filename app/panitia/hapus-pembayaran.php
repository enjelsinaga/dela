<?php

include_once ('../koneksi/config.php');

// Jika button delete nya di klik, maka jalankan kodingan ini
// Cek apakah variabel yang masuk ke halaman hapus ini namanya : $_GET['id-sparepart']
// Jika iya jalankan kodingan hapus datanya

if (isset($_GET['id_formulir'])) {
    
    // Tampung id yg diklik ke dalam variabel
    $id_siswa = $_GET['id_formulir'];

    // Cek apakah id nya ada dalam database
    $cek_siswa = mysqli_query($conn, "SELECT * FROM `tabel-pembayaran-formulir` WHERE id_formulir ='$id_formulir'" ) or die (mysqli_error($conn));

    // Jika data transaksi ada, maka hapus datanya
    if (mysqli_affected_rows($conn) > 0) {
        mysqli_query($conn, "DELETE FROM `tabel-pembayaran-formulir` WHERE id_formulir ='$id_formulir'");

        // Cek jika transaksi berhasil dihapus tampilkan pesan nya
        if (mysqli_affected_rows($conn) > 0) {
            echo"<script>alert('Data Pembayaran berhasil dihapus');window.location='kelola-pembayaran-formulir.php'</script>";
        }
        else{
            echo"<script>alert('Data Pembayaran dihapus');window.location='kelola-pembayaran-formulir.php'</script>";
        }
    }
    // Jika tidak tampilkan pesan transaksi gagal dihapus
    else{
        echo"<script>alert('Data Siswa gagal dihapus');window.location='kelola-pembayaran-formulir.php'</script>";
    }
}
// Jika bukan , kembalikan ke halaman transaksi
else{
    echo"<script>window.location='kelola-pembayaran-formulir.php'</script>";
}

?>