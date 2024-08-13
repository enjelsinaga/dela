<?php 
  $page = "Home - Kas Tensai";
  include('../_header.php');
  include('../_sidebar-panitia.php');
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

<?php
  // Variabel untuk menampung bulan dan tahun saat ini
  $bulan = date('m');
  $tahun = date('Y');

  $querypemasukan = mysqli_query($conn, "SELECT sum(jumlah_transaksi) AS jumlah_transaksi FROM tabel_transaksi INNER JOIN tabel_kategori ON tabel_transaksi.id_kategori = tabel_kategori.id_kategori WHERE jenis = 'Dana masuk' AND YEAR(tgl_transaksi) = '$tahun' AND MONTH(tgl_transaksi) = '$bulan'" ) or die (mysqli_error($conn));
  $pemasukan = mysqli_fetch_assoc($querypemasukan);

  
  $querypengeluaran = mysqli_query($conn, "SELECT sum(jumlah_transaksi) AS jumlah_pengeluaran FROM tabel_transaksi INNER JOIN tabel_kategori ON tabel_transaksi.id_kategori = tabel_kategori.id_kategori WHERE jenis = 'Dana keluar' AND YEAR(tgl_transaksi) = '$tahun' AND MONTH(tgl_transaksi) = '$bulan'" ) or die (mysqli_error($conn));
  $pengeluaran = mysqli_fetch_assoc($querypengeluaran);

?>

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-15">
          <div class="row">

            <!-- Saldo Card -->
            <!-- <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Pemasukan<span></span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-credit-card"></i>
                    </div>
                    <div class="ps-3">
                      <h6></h6>
                    </div>
                  </div>
                </div>

              </div>
            </div> -->
            <!-- End Saldo Card -->

            <!-- Dana Masuk Card -->
            <!-- <div class="col-xxl-4 col-md-4">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Calon Siswa<span></span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-arrow-down"></i> -->
                    <!-- </div>
                    <div class="ps-3">
                      <h6></h6>
                    </div>
                  </div>
                </div> -->

              <!-- </div>
            </div>  -->
        
            <!-- End Dana Masuk Card -->

            <!-- Dana Keluar Card -->
            <!-- <div class="col-xxl-4 col-md-4">

                <div class="card info-card customers-card">                    
                  <div class="card-body">
                    <h5 class="card-title">Data Siswa <span></span></h5>  
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <!-- <i class="bi bi-arrow-up"></i> -->
                      <!-- </div>
                      <div class="ps-3">
                        <h6></h6>
                      </div>
                    </div>  
                  </div>
                </div>
  
              </div>
             --> 
              <!-- End Dana Keluar Card -->

              
          <!-- Hello Card -->
          <div class="col-xxl-12 col-md-12">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title"></h5>

                  <div class="center">
                    <div class="ps-3">
                      <h6 align="center">Panitia MI Muhammadiyah 01 Pekanbaru</h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Hello Card -->

          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <?php 
  include('../_footer.php');
?>