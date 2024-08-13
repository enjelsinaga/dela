<?php

    session_start();

    $server = "localhost";
    $user = "root";
    $password = "";
    $nama_database = "mi-muhammadiyah-01";
    
    $conn = mysqli_connect($server, $user, $password, $nama_database);

    if( !$conn ){
        die("Gagal terhubung dengan database: " . mysqli_connect_error());
    }

    date_default_timezone_set('Asia/Jakarta');

    function cekSaldo(){
        global $conn;
        $danaMasuk = mysqli_query($conn, "SELECT sum(jumlah_transaksi) AS masuk FROM tabel_transaksi INNER JOIN tabel_kategori
                        ON tabel_transaksi.id_kategori = tabel_kategori.id_kategori 
                        WHERE jenis = 'Dana masuk'");
        $pemasukan = mysqli_fetch_assoc($danaMasuk);
        $danaKeluar = mysqli_query($conn, "SELECT sum(jumlah_transaksi) AS keluar FROM tabel_transaksi INNER JOIN tabel_kategori
                        ON tabel_transaksi.id_kategori = tabel_kategori.id_kategori 
                        WHERE jenis = 'Dana keluar'");
        $pengeluaran = mysqli_fetch_assoc($danaKeluar);
        return $pemasukan['masuk']-$pengeluaran['keluar'];
    }

?>
