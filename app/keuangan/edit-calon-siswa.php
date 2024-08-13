<?php 
  $page = "Data Calon Siswa";
  include('../_header.php');
  include('../_sidebar-keuangan.php');

    // Jika id tidak didapatkan , maka halaman edit tidak akan bisa dibuka
    if (!isset($_GET['id_calon_siswa'])) {
      echo"<script>window.location='data-calon-siswa.php'</script>";
  }
  
  // Dapatkan id yang akan diedit data transaksinya
  $id_calon_siswa    = $_GET['id_calon_siswa'];
  // Cari datanya dalam database berdasarkan id yg didapat
  $querycalonsiswa = mysqli_query($conn, "SELECT * FROM `tabel-calon-siswa` WHERE id_calon_siswa= '$id_calon_siswa'" ) or die (mysqli_error($conn));
  // Jadikan data dari database menjadi array menggunakan fungsi mysqli_fetch_assoc
  $datatr        = mysqli_fetch_assoc($querycalonsiswa);
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Data Calon Siswa</h1>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Edit Data Calon Siswa</h5>
    
                  <!-- Edit dana masuk -->
                  <form action="" method="post"> 
                  <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-8">
                          <input type="text" name="nama_lengkap_calon" class="form-control" id="nama_lengkap_calon" value="<?= $datatr['nama_lengkap_calon']; ?>" required>
                        </div>
                   </div> 
 
                   <div class="row mb-5">
                        <label for=" " class="col-sm-3 col-form-label">Umur</label>
                        <div class="col-sm-8">
                          <input type="number" name="umur_calon" class="form-control" id="umur_calon" value="<?= $datatr['umur_calon']; ?>"  required>
                        </div>
                 </div>


                 <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">No HP Orang Tua</label>
                        <div class="col-sm-8">
                          <input type="text" name="no_ortu_calon" class="form-control" id="no_ortu_calon"  value="<?= $datatr['no_ortu_calon']; ?>" required>
                        </div>
                   </div> 

                   <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">Ijazah</label>
                        <div class="col-sm-8">
                          <input type="file" name="ijazah_calon" class="form-control" id="ijazah_calon"  value="<?= $datatr['ijazah_calon']; ?>" required>
                        </div>
                   </div> 

                   <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">KTP Orang Tua</label>
                        <div class="col-sm-8">
                          <input type="file" name="KTP_ortu_calon" class="form-control" id="KTP_ortu_calon"  value="<?= $datatr['KTP_ortu_calon']; ?>" required>
                        </div>
                   </div> 

                   <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">Kartu Keluarga</label>
                        <div class="col-sm-8">
                          <input type="file" name="KK_calon" class="form-control" id="KK_calon"  value="<?= $datatr['KK_calon']; ?>" required>
                        </div>
                   </div> 

                   <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">Akte Kelahiran</label>
                        <div class="col-sm-8">
                          <input type="file" name="akteLahir_calon" class="form-control" id="akteLahir_calon"  value="<?= $datatr['akteLahir_calon']; ?>" required>
                        </div>
                   </div> 

                   <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">penghargaan</label>
                        <div class="col-sm-8">
                          <input type="file" name="penghargaan" class="form-control" id="penghargaan" value="<?= $datatr['penghargaan']; ?>" required>
                        </div>
                   </div> 
                  
                    <div class="row mb-3">                      
                      <div class="col-sm-5">
                        <!-- <button type="reset" name="" class="btn btn-warning">Reset</button>  -->
                        <button type="submit" name="edit" value="edit" class="btn btn-primary">Edit</button>                                     
                      </div>                      
                    </div>
    
    
                  </form><!-- End Edit data siswa -->
    
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
  if (isset($_POST['edit'])) 
  {

    // Tampung data dari inputan kedalam variabel
    $nama_lengkap_calon = $_POST["nama_lengkap_calon"];
    $umur_calon = $_POST["umur_calon"];
    $no_ortu_calon = $_POST["no_ortu_calon"];
    $ijazah_calon = $_POST["ijazah_calon"];
    $KTP_ortu_calon = $_POST["KTP_ortu_calon"];
    $KK_calon= $_POST["KK_calon"];
    $akteLahir_calon = $_POST["akteLahir_calon"];
    $penghargaan = $_POST["penghargaan"];

    // Lalu ubah data yang ada didatabase sesusai hasil inputan
     mysqli_query($conn, "UPDATE `tabel-calon-siswa` SET  id_calon_siswa = '$id_calon_siswa',
                             nama_lengkap_calon = '$nama_lengkap_calon',
                             umur_calon  = '$umur_calon',
                             no_ortu_calon  = '$no_ortu_calon',
                             ijazah_calon = '$ijazah_calon',
                             KTP_ortu_calon = 'KTP_ortu_calon',
                             KK_calon= '$KK_calon',
                             akteLahir_calon= '$akteLahir_calon',
                             penghargaan = '$penghargaan'
                             WHERE id_calon_siswa = '$id_calon_siswa' " ) or die (mysqli_error($conn));

     // Jika update berhasil dilakukan
     if (mysqli_affected_rows($conn) > 0) {
        // Maka tampilkan pesan berhasil dan pindah ke halaman transaksi
       echo"<script>alert('Data Calon Siswa berhasil diedit');window.location='data-calon-siswa.php'</script>";
     }
     else{
      // Jika gagal tampilkan pesan gagal
      echo"<script>alert('Data Calon Siswa gagal diedit!');</script>"; 
     }
  }
?>