<?php 
  $page = "Dana Keluar";
  include('../_header.php');
  include('../_sidebar.php');
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
                  <h5 class="card-title">Tambah Dana Keluar</h5>
    
                  <!-- Tambah dana keluar -->
                  <form action="" method="post">       
                  <div class="row mb-3">
                      <label for="id_kategori" class="col-sm-3 col-form-label">Nama Kategori</label>
                      <div class="col-sm-8">
                          <select name="id_kategori" class="form-select"  id="id_kategori" required>
                          <option value="" >-</option>
                          <?php  
                              // Tampilkan data kategori dana keluar dari database
                              $queryktgr = mysqli_query($conn, "SELECT * FROM tabel_kategori WHERE jenis = 'Dana keluar' " ) or die (mysqli_error($conn));  
                              // Looping data nya
                              while ($data = mysqli_fetch_assoc($queryktgr)) {      
                          ?>
                      <option value="<?= $data['id_kategori']; ?>"><?= $data['nama_kategori']; ?>(<?= $data['jenis']; ?>)</option>
                          <?php } ?> 
                          </select>
                      </div>
                    </div>
                          <input type="hidden" name="id_pengguna" class="form-control" id="id_pengguna" value="<?= $_SESSION['id']; ?>">
                    <div class="row mb-3">
                        <label for="tgl_transaksi" class="col-sm-3 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                          <input type="date" name="tgl_transaksi" class="form-control" id="tgl_transaksi" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="deskripsi_transaksi" class="col-sm-3 col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                          <input type="text" name="deskripsi_transaksi" class="form-control" id="deskripsi_transaksi" required>
                        </div>
                    </div> 
                    <div class="row mb-5">
                        <label for="jumlah_transaksi" class="col-sm-3 col-form-label">Jumlah Transaksi</label>
                        <div class="col-sm-8">
                          <input type="number" name="jumlah_transaksi" class="form-control" id="jumlah_transaksi" placeholder="Rp" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">                      
                      <div class="col-sm-8">
                        <button type="reset" name="" class="btn btn-warning">Reset</button> 
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
    $id_kategori = $_POST["id_kategori"];
    $deskripsi_transaksi = $_POST["deskripsi_transaksi"];
    $jumlah_transaksi = $_POST["jumlah_transaksi"];
    $id_pengguna = $_POST["id_pengguna"];
    $tgl_transaksi = $_POST["tgl_transaksi"];

    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang=date("Y-m-d H:i:s"); 
    mysqli_query($conn, "INSERT INTO tabel_transaksi(id_kategori, deskripsi_transaksi, jumlah_transaksi, waktu_input, id_pengguna, tgl_transaksi) 
                            VALUES ('$id_kategori', '$deskripsi_transaksi', $jumlah_transaksi,'$waktu_sekarang', '$id_pengguna', '$tgl_transaksi') 
                          " ) or die (mysqli_error($conn));

   if (mysqli_affected_rows($conn) > 0) {
     echo"<script>alert('Transaksi dana keluar berhasil ditambahkan');window.location='dana-keluar.php'</script>";
   }
   else{
    echo"<script>alert('Transaksi dana keluar gagal ditambahkan!');</script>"; 
   }
  }
?>