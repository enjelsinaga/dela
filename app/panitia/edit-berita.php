<?php 
  $page = "Berita";
  include('../_header.php');
  include('../_sidebar-panitia.php');

    // Jika id tidak didapatkan , maka halaman edit tidak akan bisa dibuka
    if (!isset($_GET['id_berita'])) {
      echo"<script>window.location='kelola-berita.php'</script>";
  }
  
  // Dapatkan id yang akan diedit data transaksinya
  $id_berita   = $_GET['id_berita'];
  // Cari datanya dalam database berdasarkan id yg didapat
  $queryberita= mysqli_query($conn, "SELECT * FROM `tabel-berita` WHERE id_berita= '$id_berita'" ) or die (mysqli_error($conn));
  // Jadikan data dari database menjadi array menggunakan fungsi mysqli_fetch_assoc
  $datatr        = mysqli_fetch_assoc($queryberita);
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Berita</h1>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Edit Berita</h5>
    
                  <!-- Edit dana masuk -->
                  <form action="" method="post"> 
                  <div class="row mb-3">
                        <label for=" " class="col-sm-3 col-form-label">Judul Berita</label>
                        <div class="col-sm-8">
                          <input type="text" name="judul_artikel" class="form-control" id="judul_artikel" value="<?= $datatr['judul_artikel']; ?>" required>
                        </div>
                   </div> 


                <div class="row mb-5">
                        <label for=" " class="col-sm-3 col-form-label">Isi Berita</label>
                        <div class="col-sm-8">
                          <input type="text" name="isi_artikel" class="form-control" id="isi_artikel"  value="<?= $datatr['isi_artikel']; ?>" required>
                        </div>
                 </div>

                 <div class="row mb-5">
                        <label for=" " class="col-sm-3 col-form-label">Gambar</label>
                        <div class="col-sm-8">
                          <input type="file" name="gambar" class="form-control" id="gambar"  value="<?= $datatr['gambar']; ?>" required>
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
    $judul_artikel = $_POST["judul_artikel"];
    $isi_artikel = $_POST["isi_artikel"];
    $gambar = $_POST["gambar "];

    // Lalu ubah data yang ada didatabase sesusai hasil inputan
     mysqli_query($conn, "UPDATE `tabel-berita` SET  id_berita = '$id_berita',
                             judul_artikel = '$judul_artikel',
                             isi_artikel  = '$isi_artikel',
                             gambar  = '$gambar'      
                             WHERE id_berita = '$id_berita' " ) or die (mysqli_error($conn));

     // Jika update berhasil dilakukan
     if (mysqli_affected_rows($conn) > 0) {
        // Maka tampilkan pesan berhasil dan pindah ke halaman transaksi
       echo"<script>alert('Berita berhasil diedit');window.location='kelola-berita.php'</script>";
     }
     else{
      // Jika gagal tampilkan pesan gagal
      echo"<script>alert('Berita gagal diedit!');</script>"; 
     }
  }
?>