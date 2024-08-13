<?php 
  $page = "Kategori Transaksi";
  include('../_header.php');
  include('../_sidebar.php');
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
                  <h5 class="card-title">Tambah Kategori Transaksi</h5>
    
                  <!-- Tambah Kategori Transaksi -->
                  <form action="" method="post">       
                    <div class="row mb-3">
                        <label for="nama_kategori" class="col-sm-3 col-form-label">Nama Kategori</label>
                        <div class="col-sm-8">
                          <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" required>
                        </div>
                    </div>             
                    <div class="row mb-3">
                        <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                          <input type="text" name="keterangan" class="form-control" id="keterangan" required>
                      </div>
                    </div>                    
                    <div class="row mb-5">
                      <label for="jenis" class="col-sm-3 col-form-label">Jenis</label>
                      <div class="col-sm-8">
                          <select name="jenis" class="form-select" aria-label="Default select example" id="jenis" required>
                            <option selected>Pilih disini</option>
                            <option value="Dana masuk">Dana masuk</option>
                            <option value="Dana keluar">Dana keluar</option>
                          </select>
                      </div>
                    </div>
                          <input type="hidden" name="created_by" class="form-control" id="created_by" value="<?= $_SESSION['id']; ?>" readonly>
                  
                    
                    <div class="row mb-3">                      
                      <div class="col-sm-8">
                        <a href="kategori-transaksi.php" class="btn btn-outline-secondary">Kembali</a>
                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>                                        
                      </div>                      
                    </div>
    
                  </form><!-- End Tambah Kategori Transaksi -->
    
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
      $nama_kategori = $_POST["nama_kategori"];
      $keterangan = $_POST["keterangan"];
      $jenis = $_POST["jenis"];

    mysqli_query($conn, "SELECT * FROM tabel_kategori WHERE nama_kategori = '$nama_kategori' " ) or die (mysqli_error($conn));

    if (mysqli_affected_rows($conn) > 0) 
    {
      echo"<script>alert('Kategori ".$nama_kategori." Sudah Ada!');</script>";
    }

    else
    {
      date_default_timezone_set('Asia/Jakarta');
      $waktu_sekarang=date("Y-m-d H:i:s"); 
     mysqli_query($conn, "INSERT INTO tabel_kategori(nama_kategori, keterangan, jenis, created_at, updated_at) 
                              VALUES ('$nama_kategori', '$keterangan', '$jenis', '$waktu_sekarang', '$waktu_sekarang') 
                            " ) or die (mysqli_error($conn));

     if (mysqli_affected_rows($conn) > 0) {
       echo"<script>alert('Kategori ".$nama_kategori." berhasil ditambahkan');window.location='kategori-transaksi.php'</script>";
     }
     else{
      echo"<script>alert('Kategori ".$nama_kategori." gagal ditambahkan!');</script>"; 
     }

    
    }

  }
?>