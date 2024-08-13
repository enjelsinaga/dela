<?php

include_once ('../koneksi/config.php');

// Jika button delete nya di klik, maka jalankan kodingan ini
// Cek apakah variabel yang masuk ke halaman hapus ini namanya : $_GET['id-sparepart']
// Jika iya jalankan kodingan hapus datanya

if (isset($_GET['id_berita'])) {
    
    // Tampung id yg diklik ke dalam variabel
    $id_berita = $_GET['id_berita'];

    // Cek apakah id nya ada dalam database
    $cek_berita= mysqli_query($conn, "SELECT * FROM `tabel-berita` WHERE id_berita='$id_berita'" ) or die (mysqli_error($conn));

    // Jika data transaksi ada, maka hapus datanya
    if (mysqli_affected_rows($conn) > 0) {
        mysqli_query($conn, "DELETE FROM `tabel-berita` WHERE id_berita ='$id_berita'");

        // Cek jika transaksi berhasil dihapus tampilkan pesan nya
        if (mysqli_affected_rows($conn) > 0) {
            echo"<script>alert('Berita berhasil dihapus');window.location='kelola-berita.php'</script>";
        }
        else{
            echo"<script>alert('Berita gagal dihapus');window.location='kelola-berita.php'</script>";
        }
    }
    // Jika tidak tampilkan pesan transaksi gagal dihapus
    else{
        echo"<script>alert('Berita gagal dihapus');window.location='kelola-berita.php'</script>";
    }
}
// Jika bukan , kembalikan ke halaman transaksi
else{
    echo"<script>window.location='kelola-berita.php'</script>";
}

?>