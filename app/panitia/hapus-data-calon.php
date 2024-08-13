<?php

include_once ('../koneksi/config.php');

// Jika button delete nya di klik, maka jalankan kodingan ini
// Cek apakah variabel yang masuk ke halaman hapus ini namanya : $_GET['id-sparepart']
// Jika iya jalankan kodingan hapus datanya

if (isset($_GET['id_calon_siswa'])) {
    
    // Tampung id yg diklik ke dalam variabel
    $id_calon_siswa = $_GET['id_calon_siswa'];

    // Cek apakah id nya ada dalam database
    $cek_calon_siswa = mysqli_query($conn, "SELECT * FROM `tabel-calon-siswa` WHERE id_calon_siswa ='$id_calon_siswa'" ) or die (mysqli_error($conn));

    // Jika data transaksi ada, maka hapus datanya
    if (mysqli_affected_rows($conn) > 0) {
        mysqli_query($conn, "DELETE FROM `tabel-calon-siswa` WHERE id_calon_siswa ='$id_calon_siswa'");

        // Cek jika transaksi berhasil dihapus tampilkan pesan nya
        if (mysqli_affected_rows($conn) > 0) {
            echo"<script>alert('Data Calon Siswa berhasil dihapus');window.location='data-calon-siswa.php'</script>";
        }
        else{
            echo"<script>alert('Data Calon Siswa gagal dihapus');window.location='data-calon-siswa.php'</script>";
        }
    }
    // Jika tidak tampilkan pesan transaksi gagal dihapus
    else{
        echo"<script>alert('Data Calon Siswa gagal dihapus');window.location='data-calon-siswa.php'</script>";
    }
}
// Jika bukan , kembalikan ke halaman transaksi
else{
    echo"<script>window.location='data-calon-siswa.php'</script>";
}

?>