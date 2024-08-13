<?php 
  $page = "Profil Admin";
  include('../_header.php');
  include('../_sidebar-pimpinan.php');

  $id=$_SESSION['id'];
  //ambil data dari tabel pengguna
  $pengguna = mysqli_query($conn, "SELECT * FROM tabel_pengguna WHERE id_pengguna = $id") or die (mysqli_error($conn));

  //ambil data pengguna dari object pengguna
  $datapengguna = mysqli_fetch_assoc($pengguna);

    // Cek apakah button edit ditekan
  // Jika ditekan maka jalankan fungsi dibawah ini
  if (isset($_POST['ubah'])) 
  {

    // Tampung data dari inputan kedalam variabel
    $nama_lengkap  = $_POST['nama_admin'];
    $username = $_POST['username']; 
    
    
    // Lalu ubah data yang ada didatabase sesusai hasil inputan
     mysqli_query($conn, "UPDATE tabel_pengguna SET nama_lengkap = '$nama_lengkap', 
                             username = '$username'
                             WHERE id_pengguna = $id " ) or die (mysqli_error($conn));

     // Jika update berhasil dilakukan
     if (mysqli_affected_rows($conn) > 0) {
        // Maka tampilkan pesan berhasil dan pindah kehalaman kategori
       echo"<script>alert('Data anda berhasil diubah');window.location='index.php'</script>";
     }
     else{
      // Jika gagal tampilkan pesan gagal
      echo"<script>alert('Data anda gagal diubah!');</script>"; 
     }
  }
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Ubah Profil</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Ubah Profil</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Ubah Profil</h5>
    
                  <!-- Profile Edit Form -->
                  <form action="" method="post">
                    
                    <div class="row mb-3">                       
                      <label for="nama_admin" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nama_admin" type="text" class="form-control" id="nama_admin" value="<?= $datapengguna['nama_lengkap']; ?>">
                      </div>
                    </div>

                    <div class="row mb-5">
                      <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="username" type="username" class="form-control" id="username" value="<?= $datapengguna['username']; ?>">
                      </div>
                    </div>

                    <div class="text">
                      <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
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
?>