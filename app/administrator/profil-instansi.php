<?php 
  $page = "Profil Instansi";
  include('../_header.php');
  include('../_sidebar.php');

  //ambil data dari tabel instansi
  $instansi = mysqli_query($conn, "SELECT * FROM tabel_instansi WHERE id_instansi = 1") or die (mysqli_error($conn));

  //ambil data instansi dari object instansi
  $datainstansi = mysqli_fetch_assoc($instansi);
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Profil Instansi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Profil Instansi</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
  
          <div class="col-xl-8">
  
            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <!-- <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
        
                      <img src="../assets/img/<?= $datainstansi['logo_instansi']; ?>" alt="Profile" class="rounded-circle">
                      <h2><?= $datainstansi['nama_instansi']; ?></h2>
                                     
                    </div>
                </div> -->
                
                <div class="tab-content pt-2">
  
                  <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    
                    <h5 class="card-title">Detail Profil Instansi</h5>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Nama Instansi</div>
                      <div class="col-lg-9 col-md-8"><?= $datainstansi['nama_instansi']; ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">CEO</div>
                      <div class="col-lg-9 col-md-8"><?= $datainstansi['nama_pimpinan']; ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Bendahara</div>
                      <div class="col-lg-9 col-md-8"><?= $datainstansi['nama_bendahara']; ?></div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Alamat</div>
                      <div class="col-lg-9 col-md-8"><?= $datainstansi['alamat_instansi']; ?></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Telepon</div>
                        <div class="col-lg-9 col-md-8"><?= $datainstansi['telepon_instansi']; ?></div>
                    </div>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8"><?= $datainstansi['email_instansi']; ?></div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-lg-3 col-md-4 label">Website</div>
                        <div class="col-lg-9 col-md-8"><?= $datainstansi['website_instansi']; ?></div>
                      </div>
  
                </div><!-- End Bordered Tabs -->
  
              </div>
            </div>
  
          </div>
        </div>
      </section>
  

  </main><!-- End #main -->

<?php 
  include('../_footer.php');
?>