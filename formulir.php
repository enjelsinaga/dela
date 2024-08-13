<?php

require_once 'koneksi.php';
include_once 'helpers.php';

session_start();

$page = 'formulir';
$title = 'Formulir Pendaftaran - MI Muhammadiyah 01 Pekanbaru';

if (isset($_SESSION['id_pengguna'])) {
    $cek_calon_siswa = "SELECT * FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
    $stmt_cek_calon_siswa = $koneksi->prepare($cek_calon_siswa);
    $stmt_cek_calon_siswa->bind_param('i', $_SESSION['id_pengguna']);
    $stmt_cek_calon_siswa->execute();
    $result_cek_calon_siswa = $stmt_cek_calon_siswa->get_result();
    $calon_siswa = $result_cek_calon_siswa->fetch_assoc();

    if (!empty($calon_siswa) && !empty($calon_siswa['id_gelombang_pendaftaran'])) {
        $id_gelombang = $calon_siswa['id_gelombang_pendaftaran'];

        header("Location: ./formulir_siswa.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include '_partials/head.php'; ?>

<body class="index-page">

    <?php
    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
    ?>
        <div id="success_message" class="alert alert-success fixed-bottom" role="alert">
            <i class="fa fa-check-circle"></i>
            <?= $success; ?>
        </div>
    <?php
        unset($_SESSION['success']);
    } ?>

    <?php
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
    ?>
        <div id="error_message" class="alert alert-danger fixed-bottom" role="alert">
            <i class="fa fa-ban"></i>
            <?= $error; ?>
        </div>
    <?php
        unset($_SESSION['error']);
    } ?>

    <?php include '_partials/navbar.php'; ?>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1>Formulir Pendaftaran Siswa Baru</h1>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="index.php">Home</a></li>
                        <li class="current">Formulir Pendaftaran</li>
                    </ol>
                </div>
            </nav>
        </div>
        <!-- End Page Title -->

        <nav class="custom-nav">
            <ul class="nav justify-content-center">
                <?php
                // Fetch Gelombang Pendaftaran
                $query_gelombang = "SELECT * FROM `gelombang_pendaftaran`";
                $result_gelombang = $koneksi->query($query_gelombang);

                $gelombang_count = $result_gelombang->num_rows;
                $first_gelombang = true;

                if ($gelombang_count > 0) {
                    while ($gelombang = $result_gelombang->fetch_assoc()) {
                        $nama_gelombang = $gelombang['nama'];
                        $id_gelombang = $gelombang['id'];

                        $query_calon_siswa = "SELECT * FROM `tabel-calon-siswa` WHERE id_gelombang_pendaftaran = ?";
                        $stmt_calon_siswa = $koneksi->prepare($query_calon_siswa);
                        $stmt_calon_siswa->bind_param('i', $id_gelombang);
                        $stmt_calon_siswa->execute();

                        $result_calon_siswa = $stmt_calon_siswa->get_result();
                        $calon_siswa_count = $result_calon_siswa->num_rows;

                        // Set the first gelombang as active
                        $active_class = $first_gelombang ? 'active' : '';

                        // Display the navigation link
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link ' . $active_class . '" href="#gelombang-' . $id_gelombang . '">' . $nama_gelombang . '</a>';
                        echo '</li>';

                        $first_gelombang = false; // Only the first gelombang should be active
                    }
                } else {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link disabled" href="#">No Registration Available</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </nav>

        <!-- Sections for each Gelombang Pendaftaran -->
        <?php
        if ($gelombang_count > 0) {
            $result_gelombang->data_seek(0); // Reset the result pointer to the beginning

            $current_date = date('Y-m-d');
            $first_gelombang = true;

            // Store a mapping between id_gelombang and token
            $_SESSION['gelombang_tokens'] = [];

            while ($gelombang = $result_gelombang->fetch_assoc()) {
                $id_gelombang = $gelombang['id'];
                $nama_gelombang = $gelombang['nama'];
                $tanggal_mulai = $gelombang['tanggal_mulai'];
                $tanggal_akhir = $gelombang['tanggal_akhir'];
                $kuota_siswa = $gelombang['kuota_siswa'];
                $is_within_period = ($current_date >= $tanggal_mulai && $current_date <= $tanggal_akhir);
                $is_quota_available = ($kuota_siswa > 0 && $calon_siswa_count < $kuota_siswa);

                // Generate a secure token for each gelombang
                $token = generate_token();
                $_SESSION['gelombang_tokens'][$id_gelombang] = $token;

                // Set the first gelombang as visible
                $display_style = $first_gelombang ? 'block' : 'none';

                echo '<section id="gelombang-' . $id_gelombang . '" class="gelombang-section section pt-5" style="display: ' . $display_style . ';">';
                echo '<div class="container">';
                echo '<div class="row">';
                echo '<div class="col-lg-12">';
                echo '<h2 class="text-center mb-5">' . $nama_gelombang . '</h2>';
                echo '<p><i class="bi bi-calendar-event"></i> Tanggal Mulai: ' . date('d F Y', strtotime($tanggal_mulai)) . '</p>';
                echo '<p><i class="bi bi-calendar-event"></i> Tanggal Akhir: ' . date('d F Y', strtotime($tanggal_akhir)) . '</p>';

                if (isset($_SESSION['level_akun'])) {
                    echo '<a href="formulir_siswa.php?id_gelombang=' . $id_gelombang . '&token=' . $token . '" class="btn ' . ($is_within_period && $is_quota_available ? 'btn-success' : 'btn-secondary disabled') . '">';
                } else {
                    echo '<a href="login.php" class="btn ' . ($is_within_period && $is_quota_available ? 'btn-success' : 'btn-secondary disabled') . '">';
                }

                echo $is_within_period && $is_quota_available ? 'Daftar' : 'Kuota Penuh atau Lewat Waktu';
                echo '</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</section>';

                $first_gelombang = false; // Only the first gelombang should be visible
            }
        } else {
            echo '<section class="gelombang-section section pt-5">';
            echo '<div class="container">';
            echo '<div class="row">';
            echo '<div class="col-lg-12 text-center">';
            echo '<h2>Yaah..!! Belum ada formulir yang aktif 😢</h2>';
            echo '<p>📢 untuk saat ini belum ada formulir pendaftaran yang dibuka,</p>';
            echo '<p>silahkan pantengin terus website atau media sosial kami ya..,</p>';
            echo '<p>atau hubungi marketing kami sekarang untuk mengetahui informasi lebih lanjut.</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</section>';
        }
        ?>

    </main>

    <!-- Modal Pembayaran Formulir -->
    <div class="modal fade" id="pembayaranFormulirModal" tabindex="-1" aria-labelledby="pembayaranFormulirModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pembayaranFormulirModalLabel">Detail Pembayaran Formulir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>No. Rekening: 1234567890</p>
                    <p>Atas Nama: MI Muhammadiyah 01 Pekanbaru</p>
                    <p>Bank: Bank BSI</p>
                    <p>Sebesar: Rp. 500.000</p>
                    <p>Setelah melakukan pembayaran, silakan upload bukti pembayaran. Kami akan segera memverifikasi pembayaran Anda.</p>
                    <p>Terima kasih.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '_partials/footer.php'; ?>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <?php include '_partials/js.php'; ?>

    <script>
        $('#success_message').fadeIn();
        setTimeout(function() {
            $('#success_message').fadeOut("slow");
        }, 8000);

        $('#error_message').fadeIn();
        setTimeout(function() {
            $('#error_message').fadeOut("slow");
        }, 8000);

        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll('.custom-nav .nav-link');
            const sections = document.querySelectorAll('.gelombang-section');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);

                    // Remove active class from all nav links
                    navLinks.forEach(nav => {
                        nav.classList.remove('active');
                    });

                    // Add active class to the clicked nav link
                    this.classList.add('active');

                    // Hide all sections
                    sections.forEach(section => {
                        section.style.display = 'none';
                    });

                    // Show the target section
                    document.getElementById(targetId).style.display = 'block';
                });
            });
        });
    </script>

</body>

</html>