<?php

require_once('../koneksi/config.php');

if (isset($_GET['id_calon_siswa'])) {
    $query_calon_siswa = mysqli_query($conn, "SELECT * FROM `tabel-calon-siswa` WHERE id_calon_siswa = '$_GET[id_calon_siswa]'") or die(mysqli_error($conn));
    $calon_siswa = mysqli_fetch_assoc($query_calon_siswa);

    $tahun_siswa = !empty($calon_siswa['created_at']) ? date('Y', strtotime($calon_siswa['created_at'])) : date('Y');
    $id_kartu_siswa = !empty($calon_siswa['id_calon_siswa']) ? 'KU' . $tahun_siswa . sprintf('%05s', $calon_siswa['id_calon_siswa']) : '';
} else {
    header('Location: data-calon-siswa.php');
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
        <img src="../../assets/img/logo_mi.png" alt="Foto">
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