<?php

include_once ('../koneksi/config.php');

// Jika button delete nya di klik, maka jalankan kodingan ini
// Cek apakah variabel yang masuk ke halaman hapus ini namanya : $_GET['id-sparepart']
// Jika iya jalankan kodingan hapus datanya

if (isset($_GET['id-kategori'])) {
    
    // Tampung id yg diklik ke dalam variabel
    $id_kategori = $_GET['id-kategori'];

    // Cek apakah id nya ada dalam database
    $cek_kategori = mysqli_query($conn, "SELECT * FROM tabel_kategori where id_kategori ='$id_kategori'" ) or die (mysqli_error($conn));

    // Jika data kategori ada, maka hapus datanya
    if (mysqli_affected_rows($conn) > 0) {
        mysqli_query($conn, "DELETE FROM tabel_kategori WHERE id_kategori ='$id_kategori' ");

        // Cek jika kategori berhasil dihapus tampilkan pesan nya
        if (mysqli_affected_rows($conn) > 0) {
            echo"<script>alert('Kategori berhasil dihapus');window.location='kategori-transaksi.php'</script>";
        }
        else{
            echo"<script>alert('Kategori gagal dihapus');window.location='kategori-transaksi.php'</script>";
        }
    }
    // Jika tidak tampilkan pesan Kategori gagal dihapus
    else{
        echo"<script>alert('Kategori gagal dihapus');window.location='kategori-transaksi.php'</script>";
    }
}
// Jika bukan , kembalikan ke halaman kategori
else{
    echo"<script>window.location='kategori-transaksi.php'</script>";
}

?>