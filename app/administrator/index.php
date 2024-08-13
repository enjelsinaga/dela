<?php

$page = "dashboard";
include('../_header.php');
include('../_sidebar.php');

$query_jumlah_calon_siswa = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM `tabel-calon-siswa`") or die(mysqli_error($conn));
$jumlah_calon_siswa = mysqli_fetch_assoc($query_jumlah_calon_siswa)['jumlah'];

$query_jumlah_siswa = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM `tabel-siswa`") or die(mysqli_error($conn));
$jumlah_siswa = mysqli_fetch_assoc($query_jumlah_siswa)['jumlah'];

$query_jumlah_user = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM tabel_pengguna") or die(mysqli_error($conn));
$jumlah_user = mysqli_fetch_assoc($query_jumlah_user)['jumlah'];
?>

<main id="main" class="main">

    <div class="pagetitle">
        <!-- <h1>Dashboard</h1> -->
        <!-- <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav> -->
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-15">
                <div class="row">

                    <!-- Hello Card -->
                    <div class="col-xxl-12 col-md-12">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title"></h5>

                                <div class="center">
                                    <div class="ps-3">
                                        <h6 align="center">Halo Admin, Selamat Datang di Halaman Administrator</h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Hello Card -->

                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Calon Siswa<span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $jumlah_calon_siswa; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Siswa<span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $jumlah_siswa; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-4">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah User<span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $jumlah_user; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Card -->
                    <div class="col-xxl-12 col-md-12">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Data Siswa Per Tahun</h5>
                                <canvas id="siswaChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Chart Card -->

                    <!-- Chart Card -->
                    <div class="col-xxl-12 col-md-12">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Data Jumlah Siswa Per Gelombang</h5>
                                <canvas id="gelombangChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- End Chart Card -->

                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>

</main><!-- End #main -->

<?php
include('../_footer.php');
?>