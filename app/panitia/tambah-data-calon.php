<?php 
  $page = "Data Calon Siswa";
  include('../_header.php');
  include('../_sidebar-panitia.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Data Calon Siswa</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Tambah Data Calon Siswa</h5>
    
                  <!-- Tambah dana keluar -->
                  <form action="" method="post"> 
                    
                  <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-8">
                          <input type="text" name="nama_lengkap_calon" class="form-control" id="nama_lengkap_calon" required>
                        </div>
                   </div> 


                <div class="row mb-5">
                        <label for=" " class="col-sm-3 col-form-label">Umur</label>
                        <div class="col-sm-8">
                          <input type="number" name="umur_calon" class="form-control" id="umur_calon" placeholder="   tahun" required>
                        </div>
                 </div>

    
                 <div class="row mb-5">
                        <label for=" " class="col-sm-3 col-form-label">No HP Orang Tua</label>
                        <div class="col-sm-8">
                          <input type="text" name="no_ortu_calon" class="form-control" id="no_ortu_calon" required>
                        </div>
                 </div>

                   <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">Ijazah</label>
                        <div class="col-sm-8">
                          <input type="file" name="ijazah_calon" class="form-control" id="ijazah_calon" required>
                        </div>
                   </div> 

                   <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">KTP Orang Tua</label>
                        <div class="col-sm-8">
                          <input type="file" name="KTP_ortu_calon" class="form-control" id="KTP_ortu_calon" required>
                        </div>
                   </div> 

                   <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">Kartu Keluarga</label>
                        <div class="col-sm-8">
                          <input type="file" name="KK_calon" class="form-control" id="KK_calon" required>
                        </div>
                   </div> 

                   <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">Akte Kelahiran</label>
                        <div class="col-sm-8">
                          <input type="file" name="akteLahir_calon" class="form-control" id="akteLahir_calon" required>
                        </div>
                   </div> 

                   <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">penghargaan</label>
                        <div class="col-sm-8">
                          <input type="file" name="penghargaan" class="form-control" id="penghargaan" required>
                        </div>
                   </div> 
                  
        
             
                    
                    <div class="row mb-3">                      
                      <div class="col-sm-5">
                      
                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>                                      
                      </div>                      
                    </div>
    
                  </form><!-- End Tambah dana keluar -->
    
                </div>
            </div>
  
          </div>
        </div>
      </section>
  

  </main><!-- End #main -->

<?php 
  include('../_footer.php');
  // cek apakah tombol submit sudah ditekan atau belum
  if (isset($_POST['submit'])) {
    // ambil data dari tiap elemen dalam form
    $nama_lengkap_calon = $_POST["nama_lengkap_calon"];
    $umur_calon = $_POST["umur_calon"];
    $no_ortu_calon = $_POST["no_ortu_calon"];
    $ijazah_calon = $_POST["ijazah_calon"];
    $KTP_ortu_calon = $_POST["KTP_ortu_calon"];
    $KK_calon = $_POST["KK_calon"];
    $akteLahir_calon = $_POST["akteLahir_calon"];
    $penghargaan = $_POST["penghargaan"];


    // date_default_timezone_set('Asia/Jakarta');
    // $waktu_sekarang=date("Y-m-d H:i:s"); 
    mysqli_query($conn, "INSERT INTO `tabel-calon-siswa`(id_calon_siswa , nama_lengkap_calon , umur_calon , no_ortu_calon, ijazah_calon , KTP_ortu_calon, KK_calon,  	akteLahir_calon , penghargaan ) 
                            VALUES ('id_calon_siswa', '$nama_lengkap_calon', $umur_calon,'$no_ortu_calon','$ijazah_calon', '$KTP_ortu_calon', '$KK_calon',  '$akteLahir_calon ', '$penghargaan ') 
                          " ) or die (mysqli_error($conn));

   if (mysqli_affected_rows($conn) > 0) {
     echo"<script>alert('Data Calon Siswa Berhasil Ditambahkan');window.location='data-calon-siswa.php'</script>";
   }
   else{
    echo"<script>alert('Data Calon Siswa Gagal ditambahkan!');</script>"; 
   }
  }
?>