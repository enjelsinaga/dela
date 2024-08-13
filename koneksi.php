<?php

$host     = "localhost";
$username = "root";
$password = "";
$database = "mi-muhammadiyah-01";

$koneksi  = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

date_default_timezone_set("Asia/Jakarta");

$sekarang = date("Y-m-d H:i:s");
