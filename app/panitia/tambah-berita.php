<?php 
  $page = "Berita";
  include('../_header.php');
  include('../_sidebar-panitia.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Berita</h1>

    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Berita</h5>
    
                  <!-- Tambah dana keluar -->
                  <form action="" method="post"> 
                    
                  <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">Judul Berita</label>
                        <div class="col-sm-8">
                          <input type="text" name="judul_artikel" class="form-control" id="judul_artikel" required>
                        </div>
                   </div> 


                <div class="row mb-5">
                        <label for=" " class="col-sm-3 col-form-label">Isi Berita</label>
                        <div class="col-sm-8">
                          <input type="text" name="isi_artikel" class="form-control" id="isi_artikel" required>
                        </div>
                 </div>

                 <div class="row mb-5">
                        <label for=" " class="col-sm-3 col-form-label">Gambar</label>
                        <div class="col-sm-8">
                          <input type="file" name="gambar" class="form-control" id="gambar" required>
                        </div>
                 </div>

                    <div class="row mb-3">                      
                      <div class="col-sm-5">
                        <!-- <button type="reset" name="" class="btn btn-warning">Reset</button>  -->
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
    $judul_artikel = $_POST["judul_artikel"];
    $isi_artikel = $_POST["isi_artikel"];
    $gambar = $_POST["gambar"];

    // date_default_timezone_set('Asia/Jakarta');
    // $waktu_sekarang=date("Y-m-d H:i:s"); 
    mysqli_query($conn, "INSERT INTO `tabel-berita`(id_berita , judul_artikel, isi_artikel, gambar) 
                            VALUES ('id_berita', '$judul_artikel','$isi_artikel','$gambar') 
                          " ) or die (mysqli_error($conn));

   if (mysqli_affected_rows($conn) > 0) {
     echo"<script>alert('Berita Berhasil Ditambahkan');window.location='kelola-berita.php'</script>";
   }
   else{
    echo"<script>alert('Berita Gagal ditambahkan!');</script>"; 
   }
  }
?>