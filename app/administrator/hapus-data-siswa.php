<?php

include_once ('../koneksi/config.php');

// Jika button delete nya di klik, maka jalankan kodingan ini
// Cek apakah variabel yang masuk ke halaman hapus ini namanya : $_GET['id-sparepart']
// Jika iya jalankan kodingan hapus datanya

if (isset($_GET['id_siswa'])) {
    
    // Tampung id yg diklik ke dalam variabel
    $id_siswa = $_GET['id_siswa'];

    // Cek apakah id nya ada dalam database
    $cek_siswa = mysqli_query($conn, "SELECT * FROM `tabel-siswa` WHERE id_siswa ='$id_siswa'" ) or die (mysqli_error($conn));

    // Jika data transaksi ada, maka hapus datanya
    if (mysqli_affected_rows($conn) > 0) {
        mysqli_query($conn, "DELETE FROM `tabel-siswa` WHERE id_siswa ='$id_siswa'");

        // Cek jika transaksi berhasil dihapus tampilkan pesan nya
        if (mysqli_affected_rows($conn) > 0) {
            echo"<script>alert('Data Siswa berhasil dihapus');window.location='data-siswa.php'</script>";
        }
        else{
            echo"<script>alert('Data Siswa gagal dihapus');window.location='data-siswa.php'</script>";
        }
    }
    // Jika tidak tampilkan pesan transaksi gagal dihapus
    else{
        echo"<script>alert('Data Siswa gagal dihapus');window.location='data-siswa.php'</script>";
    }
}
// Jika bukan , kembalikan ke halaman transaksi
else{
    echo"<script>window.location='data-siswa.php'</script>";
}

?>