<?php

require_once('../koneksi/config.php');

$jumlah_pembayaran = 0;
$query_kelola_pembayaran_formulir = mysqli_query($conn, "SELECT * FROM `tabel-pembayaran-formulir` WHERE status_pembayaran_formulir = 'belumlunas'") or die(mysqli_error($conn));
$jumlah_kelola_pembayaran_formulir = mysqli_num_rows($query_kelola_pembayaran_formulir);

$query_kelola_pembayaran_ulang = mysqli_query($conn, "SELECT * FROM `tabel-pembayaran-ulang` WHERE status_pembayaran_ulang = 'belumlunas'") or die(mysqli_error($conn));
$jumlah_kelola_pembayaran_ulang = mysqli_num_rows($query_kelola_pembayaran_ulang);

$jumlah_pembayaran = $jumlah_kelola_pembayaran_formulir + $jumlah_kelola_pembayaran_ulang;

?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar ">
    <ul class="sidebar-nav " id="sidebar-nav">
        <img src="../assets/img/logo_mi.png" class="item-center-medium " alt="">
        <!--  -->
        </li><!-- End Home Nav -->

        <!-- Dashboard -->
        <li class="nav-item">
            <?php if ($page == "dashboard") { ?>
                <a class="nav-link active" href="index.php">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Dashboard</span>
                </a>
            <?php } else { ?>
                <a class="nav-link collapsed" href="index.php">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Dashboard</span>
                </a>
            <?php } ?>
        </li><!-- End Dashboard -->

        <!-- Data Siswa -->
        <li class="nav-item">
            <?php if ($page == "siswa") { ?>
                <a class="nav-link active" href="data-siswa.php">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Data Siswa</span>
                </a>
            <?php } else { ?>
                <a class="nav-link collapsed" href="data-siswa.php">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Data Siswa</span>
                </a>
            <?php } ?>
        </li><!-- End Data Siswa -->

        <!-- Data Calon Siswa -->
        <li class="nav-item">
            <?php if ($page == "calon_siswa") { ?>
                <a class="nav-link " href="data-calon-siswa.php">
                    <i class="bi bi-file-person-fill"></i>
                    <span>Data Calon Siswa</span>
                </a>
            <?php } else { ?>
                <a class="nav-link collapsed" href="data-calon-siswa.php">
                    <i class="bi bi-file-person-fill"></i>
                    <span>Data Calon Siswa</span>
                </a>
            <?php } ?>
        </li><!-- End Data Calon Siswa-->

        <!-- Data Calon Gelombang Pendaftaran -->
        <li class="nav-item">
            <?php if ($page == "gelombang") { ?>
                <a class="nav-link " href="data-gelombang.php">
                    <i class="bi bi-calendar-check"></i>
                    <span>Data Gelombang</span>
                </a>
            <?php } else { ?>
                <a class="nav-link collapsed" href="data-gelombang.php">
                    <i class="bi bi-calendar-check"></i>
                    <span>Data Gelombang</span>
                </a>
            <?php } ?>
        </li><!-- End Data Gelombang Pendaftaran -->

        <!-- Data Kelola Pembayaran -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#pengelolaan-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Kelola Pembayaran</span>
                <span class="badge bg-danger rounded-pill mx-2"><?= $jumlah_pembayaran > 0 ? $jumlah_pembayaran : ''; ?></span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="pengelolaan-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li class="nav-item">
                    <?php if ($page == "pembayaran_formulir") { ?>
                        <a class="nav-link" href="kelola-pembayaran-formulir.php">
                            <i class="bi bi-circle"></i>
                            <span>Kelola Pembayaran Formulir</span>
                            <span class="badge bg-danger rounded-pill mx-1"><?= $jumlah_kelola_pembayaran_formulir > 0 ? $jumlah_kelola_pembayaran_formulir : ''; ?></span>
                        </a>
                    <?php } else { ?>
                        <a class="nav-link collapsed" href="kelola-pembayaran-formulir.php">
                            <i class="bi bi-circle"></i>
                            <span>Kelola Pembayaran Formulir</span>
                            <span class="badge bg-danger rounded-pill mx-1"><?= $jumlah_kelola_pembayaran_formulir > 0 ? $jumlah_kelola_pembayaran_formulir : ''; ?></span>
                        </a>
                    <?php } ?>
                </li><!-- End Kategori Transaksi Nav -->

                <li class="nav-item">
                    <?php if ($page == "pembayaran_formulir") { ?>
                        <a class="nav-link active" href="kelola-pembayaran-ulang.php">
                            <i class="bi bi-circle"></i>
                            <span>Kelola Pembayaran Daftar Ulang</span>
                            <span class="badge bg-danger rounded-pill mx-1"><?= $jumlah_kelola_pembayaran_ulang > 0 ? $jumlah_kelola_pembayaran_ulang : ''; ?></span>
                        </a>
                    <?php } else { ?>
                        <a class="nav-link collapsed" href="kelola-pembayaran-ulang.php">
                            <i class="bi bi-circle"></i>
                            <span>Kelola Pembayaran Daftar Ulang</span>
                            <span class="badge bg-danger rounded-pill mx-1"><?= $jumlah_kelola_pembayaran_ulang > 0 ? $jumlah_kelola_pembayaran_ulang : ''; ?></span>
                        </a>
                    <?php } ?>
                </li><!-- End Rekapitulasi Nav -->
            </ul>
        </li> <!-- End Pengelolaan Pembayaran -->

        <!-- kelola Berita -->
        <li class="nav-item">
            <?php if ($page == "berita") { ?>
                <a class="nav-link active" href="kelola-berita.php">
                    <i class="bi bi-newspaper"></i>
                    <span>Kelola Berita</span>
                </a>
            <?php } else { ?>
                <a class="nav-link collapsed" href="kelola-berita.php">
                    <i class="bi bi-newspaper"></i>
                    <span>Kelola Berita</span>
                </a>
            <?php } ?>
        </li><!-- End Kelola Berita-->

        <!-- Data User -->
        <li class="nav-item">
            <?php if ($page == "user") { ?>
                <a class="nav-link active" href="data-user.php">
                    <i class="bi bi-people-fill"></i>
                    <span>Data User</span>
                </a>
            <?php } else { ?>
                <a class="nav-link collapsed" href="data-user.php">
                    <i class="bi bi-people-fill"></i>
                    <span>Data User</span>
                </a>
            <?php } ?>
        </li><!-- End Data User -->

        <li class="nav-item ">
            <a class="nav-link collapsed" href="../auth/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li><!-- End Logout Page Nav -->
    </ul>
</aside><!-- End Sidebar-->