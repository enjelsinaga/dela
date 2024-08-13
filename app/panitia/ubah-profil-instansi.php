<?php 
  $page = "Profil Instansi";
  include('../_header.php');
  include('../_sidebar.php');

// Cari datanya dalam database berdasarkan id yg didapat
$queryinstansi = mysqli_query($conn, "SELECT * FROM tabel_instansi WHERE id_instansi = 1 " ) or die (mysqli_error($conn));
// Jadikan data dari database menjadi array menggunakan fungsi mysqli_fetch_assoc
$datainstansi  = mysqli_fetch_assoc($queryinstansi);
?>
 
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Ubah Profil Instansi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Ubah Profil Instansi</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Pengaturan Profil Instansi</h5>
    
                  <!-- Profile Edit Form -->
                  <form action="" method="post" enctype="multipart/form-data">
                    <!-- <div class="row mb-3">
                      <label for="logo_instansi" class="col-md-4 col-lg-3 col-form-label">Logo</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="../assets/img/<?= $datainstansi['logo_instansi']; ?>" alt="Profile">
                        <div class="pt-2"> -->
                          <!-- <input type="file" name="logo_instansi" class="form-control"> -->
                          <!-- <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a> -->
                        <!-- </div>
                      </div>
                    </div> -->

                    <div class="row mb-3">
                      <label for="nama_instansi" class="col-md-4 col-lg-3 col-form-label">Nama Instansi</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nama_instansi" type="text" class="form-control" id="nama_instansi" value="<?= $datainstansi['nama_instansi']; ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="nama_pimpinan" class="col-md-4 col-lg-3 col-form-label">CEO</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nama_pimpinan" type="text" class="form-control" id="nama_pimpinan" value="<?= $datainstansi['nama_pimpinan']; ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="nama_bendahara" class="col-md-4 col-lg-3 col-form-label">Bendahara</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nama_bendahara" type="text" class="form-control" id="nama_bendahara" value="<?= $datainstansi['nama_bendahara']; ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                        <label for="alamat_instansi" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                        <div class="col-md-8 col-lg-9">
                          <textarea name="alamat_instansi" class="form-control" id="alamat_instansi" required><?= $datainstansi['alamat_instansi']; ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="telepon_instansi" class="col-md-4 col-lg-3 col-form-label">Telepon</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="telepon_instansi" type="text" class="form-control" id="telepon_instansi" value="<?= $datainstansi['telepon_instansi']; ?>" required>
                        </div>
                    </div>
  
                    <div class="row mb-3">
                        <label for="email_instansi" class="col-md-4 col-lg-3 col-form-label">Email</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="email_instansi" type="email" class="form-control" id="email_instansi" value="<?= $datainstansi['email_instansi']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-5">
                      <label for="website_instansi" class="col-md-4 col-lg-3 col-form-label">Website</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="website_instansi" type="text" class="form-control" id="website_instansi" value="<?= $datainstansi['website_instansi']; ?>" required>
                      </div>
                    </div>

                    <div class="text">
                      <button type="submit" name="ubah" value="update" class="btn btn-primary">Simpan</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

    
                </div>
            </div>
  
          </div>
        </div>
      </section>
  

  </main><!-- End #main -->

<?php 
  include('../_footer.php');

   // Cek apakah button edit ditekan
  // Jika ditekan maka jalankan fungsi dibawah ini
  if (isset($_POST['ubah'])) 
  {

    // Tampung data dari inputan kedalam variabel
    $nama_instansi=$_POST['nama_instansi'];
    $nama_pimpinan=$_POST['nama_pimpinan'];
    $nama_bendahara=$_POST['nama_bendahara'];
    $alamat_instansi=$_POST['alamat_instansi'];
    $telepon_instansi=$_POST['telepon_instansi'];
    $email_instansi=$_POST['email_instansi'];
    $website_instansi=$_POST['website_instansi'];

      $run = mysqli_query($conn,  "UPDATE tabel_instansi SET 
                            nama_instansi='$nama_instansi',
                            nama_pimpinan='$nama_pimpinan',
                            nama_bendahara='$nama_bendahara', 
                            alamat_instansi='$alamat_instansi', 
                            telepon_instansi='$telepon_instansi', 
                            email_instansi='$email_instansi', 
                            website_instansi='$website_instansi' WHERE id_instansi=1" ) or die (mysqli_error($conn));
      if ($run) { 
        echo"<script>alert('Data instansi berhasil diedit');window.location='profil-instansi.php'</script>";
      } else { 
        echo"<script>alert('Data instansi gagal diedit!');</script>";   
      } 
  }

?>