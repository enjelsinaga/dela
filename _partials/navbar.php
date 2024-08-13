<?php

require_once 'koneksi.php';

$siswa = [];

if (isset($_SESSION['id_pengguna'])) {
    $id_pengguna = $_SESSION['id_pengguna'];

    $query = "SELECT `status` FROM `tabel-calon-siswa` WHERE id_pengguna = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('i', $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $siswa = $result->fetch_assoc();
}

?>

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="index.php" class="logo d-flex align-items-center me-auto">
            <img src="assets/img/logo_mi.png" alt="Logo MI Muhammadiyah 01 Pekanbaru" class="px-1">
            <h1 class="sitename d-none d-md-block" style="font-size: 17px;">
                MI Muhammadiyah 01<br><span class="subtext">Pekanbaru</span>
            </h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index.php" <?= $page == 'home' ? 'class="active"' : '' ?>>Home</a></li>
                <li><a href="formulir.php" <?= $page == 'formulir' ? 'class="active"' : '' ?>>Formulir</a></li>
                <li><a href="profile.php" <?= $page == 'profile' ? 'class="active"' : '' ?>>Profile</a></li>
                <li><a href="berita.php" <?= $page == 'berita' ? 'class="active"' : '' ?>>Berita</a></li>
                <li><a href="kontak.php" <?= $page == 'kontak' ? 'class="active"' : '' ?>>Kontak</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <?php if (isset($_SESSION['level_akun'])) : ?>
            <div class="notification-container">
                <a href="javascript:void(0);" class="notification-icon" id="notificationBell">
                    <i class="bi bi-bell"></i>
                    <?php if (!empty($siswa['status']) && $siswa['status'] == 'lulus') : ?>
                        <span class="badge">1</span>
                    <?php endif; ?>
                </a>
                <?php if (!empty($siswa['status']) && $siswa['status'] == 'lulus') : ?>
                    <div class="dropdown-content" id="dropdownContent">
                        <div class="notification-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Anda lulus seleksi</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <a class="btn-getstarted" href="logout.php">Logout</a>
        <?php else : ?>
            <a class="btn-getstarted" href="login.php">Login</a>
        <?php endif; ?>

    </div>
</header>