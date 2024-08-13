<?php
// Include file koneksi ke database
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../koneksi/config.php');

function sendWhatsAppMessage($nomorWa, $message)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $nomorWa,
            'message' => $message,
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: UpMT3xXEa_PDVfvi7ztW'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

// Cek apakah parameter id_calon_siswa dan status ada
if (isset($_GET['id_calon_siswa']) && isset($_GET['status'])) {
    $id_calon_siswa = $_GET['id_calon_siswa'];
    $status = $_GET['status'];

    // Query untuk mendapatkan data calon siswa berdasarkan id_calon_siswa
    $queryCalon = "SELECT * FROM `tabel-calon-siswa` WHERE id_calon_siswa = '$id_calon_siswa'";
    $resultCalon = mysqli_query($conn, $queryCalon);
    $dataCalon = mysqli_fetch_assoc($resultCalon);

    // Jika data calon siswa ditemukan
    if ($dataCalon) {
        $nama_calon = $dataCalon['nama_lengkap_calon'];
        $nomorWa = $dataCalon['no_ortu_calon']; // Ganti dengan field yang tepat untuk nomor WA orang tua

        // Query untuk mengubah status calon siswa di tabel `tabel-calon-siswa`
        $queryUpdateCalon = "UPDATE `tabel-calon-siswa` SET status = '$status' WHERE id_calon_siswa = '$id_calon_siswa'";

        // Eksekusi query
        if (mysqli_query($conn, $queryUpdateCalon)) {
            // Kirim pesan WhatsApp
            $statusText = ($status == 'lulus') ? 'Lulus' : 'Tidak Lulus';
            $textWhatsapp = '';

            if ($status == 'lulus') {
                $textWhatsapp = "Selamat Ananda atas nama " . $nama_calon  . " " . $statusText . "\n";
                $textWhatsapp .= "Di MI Muhammadiyah 01 Pekanbaru\n";
                $textWhatsapp .= "Silakan untuk segera melakukan daftar ulang\n";
            } else {
                $textWhatsapp = "Mohon maaf, Ananda atas nama " . $nama_calon  . " " . $statusText . " seleksi penerimaan siswa baru di MI Muhammadiyah 01 Pekanbaru\n";
            }

            sendWhatsAppMessage($nomorWa, $textWhatsapp);

            // Redirect ke halaman data siswa dengan pesan sukses
            $_SESSION['success'] = 'Status berhasil diubah';
            echo '<script>window.location.replace("data-calon-siswa.php");</script>';
            die();
        } else {
            // Jika query gagal, tampilkan pesan error
            $_SESSION['error'] = 'Error: ' . $queryUpdateCalon . '<br>' . mysqli_error($conn);
            echo '<script>window.location.replace("data-calon-siswa.php");</script>';
            die();
        }
    } else {
        // Jika data calon siswa tidak ditemukan, tampilkan pesan error
        $_SESSION['error'] = 'Data calon siswa tidak ditemukan.';
        echo '<script>window.location.replace("data-calon-siswa.php");</script>';
        die();
    }
} else {
    // Jika parameter tidak lengkap, redirect ke halaman data siswa dengan pesan error;
    $_SESSION['error'] = 'Parameter tidak lengkap';
    echo '<script>window.location.replace("data-calon-siswa.php");</script>';
    die();
}

// Tutup koneksi ke database
mysqli_close($conn);
