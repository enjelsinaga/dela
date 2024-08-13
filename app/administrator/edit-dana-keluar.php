<?php 
  $page = "Dana Keluar";
  include('../_header.php');
  include('../_sidebar.php');

    // Jika id tidak didapatkan , maka halaman edit tidak akan bisa dibuka
    if (!isset($_GET['id-transaksi'])) {
      echo"<script>window.location='dana-keluar.php'</script>";
  }
  
  // Dapatkan id yang akan diedit data transaksinya
  $id_transaksi        = $_GET['id-transaksi'];
  // Cari datanya dalam database berdasarkan id yg didapat
  $querytransaksi = mysqli_query($conn, "SELECT * FROM tabel_transaksi WHERE id_transaksi = '$id_transaksi' " ) or die (mysqli_error($conn));
  // Jadikan data dari database menjadi array menggunakan fungsi mysqli_fetch_assoc
  $datatr        = mysqli_fetch_assoc($querytransaksi);
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dana Keluar</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Pengelolaan Kas</li>
          <li class="breadcrumb-item active">Dana Keluar</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Edit Dana Keluar</h5>
    
                  <!-- Edit dana masuk -->
                  <form action="" method="post"> 
                    <input type="hidden" name="id-transaksi" value="<?= $datatr['id_transaksi']; ?>">     
                    <div class="row mb-3">
                      <label for="id-kategori" class="col-sm-3 col-form-label">Nama Kategori</label>
                      <div class="col-sm-8">
                          <select name="id-kategori" class="form-select" id="id-kategori" required>
                            
                          <?php  
                              // Tampilkan data kategori dana masuk dari database
                              $querykategori = mysqli_query($conn, "SELECT * FROM tabel_kategori WHERE jenis = 'Dana keluar' " ) or die (mysqli_error($conn));  
                              // Looping data nya
                              while ($data = mysqli_fetch_assoc($querykategori)) {      
                          ?>
                            
                            <option value="<?= $data['id_kategori']; ?>" <?=$datatr['id_kategori']===$data['id_kategori'] ? 'selected' : ''?>><?= $data['nama_kategori']; ?></option>
                          <?php } ?> 
                          </select>
                      </div>
                    </div>
                    <div class="row mb-3">
                        <label for="tgl_transaksi" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                          <input type="date" name="tgl_transaksi" class="form-control" id="tgl_transaksi" value="<?= $datatr['tgl_transaksi']; ?>" required>
                        </div>
                    </div>      
                    <div class="row mb-3">
                        <label for="deskripsi-transaksi" class="col-sm-3 col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                          <input type="text" name="deskripsi-transaksi" class="form-control" id="deskripsi-transaksi" value="<?= $datatr['deskripsi_transaksi']; ?>" required>
                        </div>
                    </div> 
                    <div class="row mb-5">
                        <label for="jumlah-transaksi" class="col-sm-3 col-form-label">Jumlah Transaksi</label>
                        <div class="col-sm-8">
                          <input type="number" name="jumlah-transaksi" class="form-control" id="jumlah-transaksi" value="<?= $datatr['jumlah_transaksi']; ?>" required>
                          <input type="hidden" name="jumlah-transaksi-old" value="<?= $datatr['jumlah_transaksi']; ?>">
                        </div>
                        
                    </div>
                    
                    <div class="row mb-3">                      
                      <div class="col-sm-8">
                          <button type="reset" name="" class="btn btn-warning" style="margin-right: 5px;">Reset</button>  
                          <button type="submit" name="edit" value="edit" class="btn btn-primary">Edit</button>                                     
                      </div>                      
                    </div>
    
                  </form><!-- End Edit dana masuk -->
    
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
    $id_kategori = $_POST["id-kategori"];
    $id_transaksi   = $_POST['id-transaksi']; 
    $deskripsi_transaksi = $_POST['deskripsi-transaksi']; 
    $jumlah_transaksi = $_POST["jumlah-transaksi"];
    $tgl_transaksi = $_POST["tgl_transaksi"];
    
    // Lalu ubah data yang ada didatabase sesusai hasil inputan
     mysqli_query($conn, "UPDATE tabel_transaksi SET  id_kategori = '$id_kategori',
                             deskripsi_transaksi = '$deskripsi_transaksi',
                             jumlah_transaksi = '$jumlah_transaksi',
                             tgl_transaksi = '$tgl_transaksi'
                             WHERE id_transaksi = '$id_transaksi' " ) or die (mysqli_error($conn));

     // Jika update berhasil dilakukan
     if (mysqli_affected_rows($conn) > 0) {
        // Maka tampilkan pesan berhasil dan pindah ke halaman transaksi
       echo"<script>alert('Transaksi berhasil diedit');window.location='dana-keluar.php'</script>";
     }
     else{
      // Jika gagal tampilkan pesan gagal
      echo"<script>alert('Transaksi gagal diedit!');</script>"; 
     }
  }
?>