<?php 
  $page = "Ubah Password Admin";
  include('../_header.php');
  include('../_sidebar-pimpinan.php');

  $id=$_SESSION['id'];
  //ambil data dari tabel pengguna
  $pengguna = mysqli_query($conn, "SELECT * FROM tabel_pengguna WHERE id_pengguna=$id") or die (mysqli_error($conn));

  //ambil data pengguna dari object pengguna
  $datapengguna = mysqli_fetch_assoc($pengguna);

  if (isset($_POST['ubah'])) {
    // Tampung data dari inputan kedalam variabel
    $password = $_POST['password'];
    $password_baru = $_POST['newpassword'];
    $password_baru_1 = $_POST['renewpassword'];
  
    if (password_verify($password, $datapengguna['password'])) {
      if ($password_baru_1 == $password_baru) {
        if (password_verify($password_baru, $datapengguna['password'])) {
          echo "<script>alert('Password baru tidak boleh sama dengan password lama!');</script>";
        } else {
          $hashed_password = password_hash($password_baru, PASSWORD_BCRYPT);
  
          mysqli_query($conn, "UPDATE tabel_pengguna SET password ='$hashed_password' WHERE id_pengguna = $id") or die(mysqli_error($conn));
          // Jika update berhasil dilakukan
          if (mysqli_affected_rows($conn) > 0) {
            // Maka tampilkan pesan berhasil
            echo "<script>alert('Password anda berhasil diubah!');window.location='ubah-password-admin.php'</script>";
          } else {
            // Jika gagal tampilkan pesan gagal
            echo "<script>alert('Password gagal diubah!');</script>";
          }
        }
      } else {
        echo "<script>alert('Konfirmasi password baru harus sama dengan password baru!');window.location='ubah-password-admin.php'</script>";
      }
    } else {
      echo "<script>alert('Password anda salah, silahkan coba kembali!');</script>";
    }
  }
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Ubah Password</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Ubah Password</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Ganti Password</h5>
    
                  <!-- Ubah Password Admin -->
                  <form action="" method="post">       
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Password Lama</label>
                        <div class="col-sm-8">
                          <input name="password" type="password" class="form-control" id="inputPassword" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPasswordBaru" class="col-sm-3 col-form-label">Password Baru</label>
                        <div class="col-sm-8">
                          <input name="newpassword" type="password" class="form-control" id="inputPasswordBaru" required>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <label for="inputPasswordBaru2" class="col-sm-3 col-form-label">Konfirmasi Password Baru</label>
                        <div class="col-sm-8">
                          <input name="renewpassword" type="password" class="form-control" id="inputPasswordBaru2" required>
                        </div>
                    </div>                    
                    <div class="row mb-3">                      
                      <div class="col-sm-8">
                        <button name="ubah" type="submit" class="btn btn-primary">Simpan</button>                                        
                      </div>                      
                    </div>
    
                  </form><!-- End Ubah Password Admin -->
    
                </div>
            </div>
  
          </div>
        </div>
      </section>
  

  </main><!-- End #main -->

<?php 
  include('../_footer.php');
?>