<?php

include_once ('../koneksi/config.php');

// Jika button delete nya di klik, maka jalankan kodingan ini
// Cek apakah variabel yang masuk ke halaman hapus ini namanya : $_GET['id-sparepart']
// Jika iya jalankan kodingan hapus datanya

if (isset($_GET['id-transaksi'])) {
    
    // Tampung id yg diklik ke dalam variabel
    $id_transaksi = $_GET['id-transaksi'];

    // Cek apakah id nya ada dalam database
    $cek_transaksi = mysqli_query($conn, "SELECT * FROM tabel_transaksi WHERE id_transaksi ='$id_transaksi'" ) or die (mysqli_error($conn));

    // Jika data transaksi ada, maka hapus datanya
    if (mysqli_affected_rows($conn) > 0) {
        mysqli_query($conn, "DELETE FROM tabel_transaksi WHERE id_transaksi ='$id_transaksi' ");

        // Cek jika transaksi berhasil dihapus tampilkan pesan nya
        if (mysqli_affected_rows($conn) > 0) {
            echo"<script>alert('Transaksi berhasil dihapus');window.location='rekapitulasi.php'</script>";
        }
        else{
            echo"<script>alert('Transaksi gagal dihapus');window.location='rekapitulasi.php'</script>";
        }
    }
    // Jika tidak tampilkan pesan transaksi gagal dihapus
    else{
        echo"<script>alert('transaksi gagal dihapus');window.location='rekapitulasi.php'</script>";
    }
}
// Jika bukan , kembalikan ke halaman transaksi
else{
    echo"<script>window.location='rekapitulasi.php'</script>";
}

?>