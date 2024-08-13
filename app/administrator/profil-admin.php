<?php 
  $page = "Profil Admin";
  include('../_header.php');
  include('../_sidebar.php');

  $id=$_SESSION['id'];
  //ambil data dari tabel pengguna
  $pengguna = mysqli_query($conn, "SELECT * FROM tabel_pengguna WHERE id_pengguna='$id'") or die (mysqli_error($conn));

  //ambil data pengguna dari object pengguna
  $datapengguna = mysqli_fetch_assoc($pengguna);

?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Profil Saya</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Profil Saya</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
  
          <div class="col-xl-8">
  
            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                
                
                <div class="tab-content pt-2">
  
                  <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    
                    <h5 class="card-title">Profil Saya</h5>
  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Nama</div>
                      <div class="col-lg-9 col-md-8"><?= $datapengguna['nama_lengkap']; ?></div>
                    </div>
  
                    <div class="row mb-5">
                      <div class="col-lg-3 col-md-4 label">Username</div>
                      <div class="col-lg-9 col-md-8"><?= $datapengguna['username']; ?></div>
                    </div>
                    <div class="row">                      
                        <div class="col-sm-8">
                          <a href="ubah-profil-admin.php" class="btn btn-primary">Ubah</a>                                        
                        </div>                      
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