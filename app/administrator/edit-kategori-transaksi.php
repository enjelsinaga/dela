<?php 
  $page = "Kategori Transaksi";
  include('../_header.php');
  include('../_sidebar.php');

  // Jika id tidak didapatkan , maka halaman edit tidak akan bisa dibuka
  if (!isset($_GET['id-kategori'])) {
    echo"<script>window.location='kategori-transaksi.php'</script>";
}

// Dapatkan id yang akan diedit data kategorinya
$id_kategori        = $_GET['id-kategori'];
// Cari datanya dalam database berdasarkan id yg didapat
$querykategori = mysqli_query($conn, "SELECT * FROM tabel_kategori WHERE id_kategori = '$id_kategori' " ) or die (mysqli_error($conn));
// Jadikan data dari database menjadi array menggunakan fungsi mysqli_fetch_assoc
$data        = mysqli_fetch_assoc($querykategori);
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Kategori Transaksi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Pengelolaan Kas</li>
          <li class="breadcrumb-item active">Kategori Transaksi</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Edit Kategori Transaksi</h5>
    
                  <!-- Edit Kategori Transaksi -->
                  <form action="" method="post">  
                    <input type="hidden" name="id-kategori" value="<?= $data['id_kategori']; ?>">     
                    <div class="row mb-3">
                        <label for="nama-kategori" class="col-sm-3 col-form-label">Nama Kategori</label>
                        <div class="col-sm-8">
                          <input type="text" name="nama-kategori" class="form-control" id="nama-kategori" value="<?= $data['nama_kategori']; ?>" required>
                        </div>
                    </div>             
                    <div class="row mb-3">
                      <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                      <div class="col-sm-8">
                          <input type="text" name="keterangan" class="form-control" id="keterangan" value="<?= $data['keterangan']; ?>" required>
                      </div>
                    </div>                    
                    <div class="row mb-3">
                      <label for="jenis" class="col-sm-3 col-form-label">Jenis</label>
                      <div class="col-sm-8">
                          <select name="jenis" class="form-select" aria-label="Default select example" id="jenis" required>
                            <option selected><?= $data['jenis']; ?></option>
                            <option value="Dana masuk">Dana masuk</option>
                            <option value="Dana keluar">Dana keluar</option>
                          </select>
                      </div>
                    </div>
                    
                    <div class="row mb-3">                      
                      <div class="col-sm-8">
                          <button type="reset" name="" class="btn btn-warning" style="margin-right: 5px;">Reset</button>  
                          <button type="submit" name="edit" value="edit" class="btn btn-primary">Edit kategori</button>                                  
                      </div>                      
                    </div>
    
                  </form><!-- End Edit Kategori Transaksi -->
    
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
    $id_kategori   = $_POST['id-kategori']; 
    $nama_kategori = $_POST['nama-kategori']; 
    $keterangan  = $_POST['keterangan']; 
    $jenis  = $_POST['jenis'];
    
    // Lalu ubah data yang ada didatabase sesusai hasil inputan
     mysqli_query($conn, "UPDATE tabel_kategori SET nama_kategori = '$nama_kategori', 
                             keterangan = '$keterangan',
                             jenis = '$jenis' 
                             WHERE id_kategori = '$id_kategori' " ) or die (mysqli_error($conn));

     // Jika update berhasil dilakukan
     if (mysqli_affected_rows($conn) > 0) {
        // Maka tampilkan pesan berhasil dan pindah kehalaman kategori
       echo"<script>alert('kategori ".$nama_kategori." berhasil diedit');window.location='kategori-transaksi.php'</script>";
     }
     else{
      // Jika gagal tampilkan pesan gagal
      echo"<script>alert('kategori ".$nama_kategori." gagal diedit!');</script>"; 
     }
  }
?>