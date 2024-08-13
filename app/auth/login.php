<?php  
  
  include_once '../koneksi/config.php';


  // Jika button login ditekan , maka akan menjalankan kodingan di bawah ini
  if (isset($_POST['login'])) {
      // tampung data yg di inputkan kedalam variabel
      $username  = $_POST['username'];
      $password  = $_POST['password'];
      
      $ceklogin = mysqli_query($conn, "SELECT * FROM tabel_pengguna WHERE username = '$username'"); 
      
      // cek apakah data username dan password yg di inputkan ada didalam database dan sama isinya
      if (mysqli_affected_rows($conn) > 0) {
        $datalogin = mysqli_fetch_assoc($ceklogin);
        if(password_verify($password, $datalogin['password'])) {
          $_SESSION['level_akun'] = $datalogin['level_akun'];
          $_SESSION['login'] = $datalogin['nama_lengkap'];
          $_SESSION['id'] = $datalogin['id_pengguna'];
          // Cek pengguna sebagai admin
          if ($datalogin['level_akun']=="level1") {           
            // echo '<script>alert("Anda Berhasil Login !!");window.location.replace("../administrator/index.php");</script>';
            // Mengalihkan ke halaman home admin
            echo '<script>window.location.replace("../administrator/index.php");</script>';
         }
         // Cek pengguna sebagai pimpinan
         else if ($datalogin['level_akun']=="level2") {
           // Mengalihkan ke halaman home pimpinan
           echo '<script>window.location.replace("../panitia/index.php");</script>';
         
         }

         else if ($datalogin['level_akun']=="level3") {
          // Mengalihkan ke halaman home pimpinan
          echo '<script>window.location.replace("../keuangan/index.php");</script>';
        
        }
         else {
          // Jika tidak memiliki level akun (tidak memiliki akses)
          echo "<script>alert('Anda tidak memiliki hak akses')</script>";
         }
        } else {
         echo "<script>alert('Password Anda salah. Silahkan coba lagi!')</script>";
        }
    } else {
        //  Jika username atau password salah
        echo "<script>alert('Username Anda salah. Silahkan coba lagi!')</script>";
    }    
  }

?> 

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Login - MI-Muhammadiyah-01</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/logo_mi.png" rel="icon">
  <link href="../assets/img/logo-mi.png" rel="logo-mi">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="../assets/img/logo_mi.png" alt="">
                  <span class="d-none d-lg-block">MI MUHAMMADIYAH 01</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">                    
                    <p class="text-center small">Silahkan login untuk melanjutkan</p>
                  </div>

                  <form action=" " method="post" class="row g-3">
                    <div class="col-12">
                      <label for="username" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="username" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="login" >Login</button>
                    </div>
                  </form>

                </div>
              </div>

              <div class="copyright">
                &copy; Copyright <strong><span>MI Muhammadiyah 01</span></strong>. All Rights Reserved
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.min.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>



