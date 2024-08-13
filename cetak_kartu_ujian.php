<?php

require_once 'koneksi.php';

session_start();

$query_calon_siswa = "SELECT * FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
$stmt = $koneksi->prepare($query_calon_siswa);
$stmt->bind_param('i', $_SESSION['id_pengguna']);
$stmt->execute();
$res_stmt = $stmt->get_result();
$stmt->close();

$calon_siswa = $res_stmt->fetch_assoc();

$tahun_siswa = !empty($calon_siswa['created_at']) ? date('Y', strtotime($calon_siswa['created_at'])) : date('Y');
$id_kartu_siswa = !empty($calon_siswa['id_calon_siswa']) ? 'KU' . $tahun_siswa . sprintf('%05s', $calon_siswa['id_calon_siswa']) : '';

if (empty($calon_siswa)) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Ujian Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        img {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="card">
        <img src="assets/img/logo_mi.png" alt="Foto">
        <h1><?= !empty($calon_siswa['id_calon_siswa']) ? $id_kartu_siswa : 'Tidak Ada ID' ?></h1>
        <p>
        <h1><?= !empty($calon_siswa['nama_lengkap_calon']) ? $calon_siswa['nama_lengkap_calon'] : 'Tidak Ada Nama' ?></h1>
        </p>
        <p>
        <h3>MI MUHAMMADIYAH 01 PEKANBARU</h3>
        </p>
        <button type="button" onclick="window.print()">Print Kartu Ujian</button>
    </div>
</body>

</html>