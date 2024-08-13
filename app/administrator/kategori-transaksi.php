<?php 
  $page = "Pengelolaan Kas";
  $page = "Kategori Transaksi";
  include('../_header.php');
  include('../_sidebar.php');

  if (isset($_SESSION['level_akun'])) {
    if ($_SESSION['level_akun'] != 'level1') {
      echo '<script>window.location.replace("../pimpinan/index.php");</script>';
    }
  }
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
          <div class="col-lg-12">
  
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Kategori Transaksi</h5>
                <p class="card-text"><a href="tambah-kategori-transaksi.php" class="btn btn-primary">Tambah kategori baru</a></p>
                <br>
                
                  
                <!-- Table with stripped rows -->
                <table class="table table-hover datatable">
                  <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Nama Kategori</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Waktu Dibuat</th>
                        <th scope="col">Diperbarui</th>
                        <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>


<?php  
    $no = 1;
    // Ambil data kategori dari database
    $querykategori = mysqli_query($conn, "SELECT * FROM tabel_kategori 
                                            ORDER BY id_kategori DESC" ) or die (mysqli_error($conn));

    // Looping data dari database
    while ($data = mysqli_fetch_assoc($querykategori)) 
    {    
?>                      
                    <!-- Panggil data nya satu-persatu ke dalam baris & kolom tabel -->
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['nama_kategori']; ?></td>
                        <td><?= $data['keterangan']; ?></td>
                        <td> <?= $data['jenis']; ?></td>                        
                        <td> <?= $data['created_at']; ?></td>
                        <td> <?= $data['updated_at']; ?></td>
                        <td>
                          <a href="edit-kategori-transaksi.php?id-kategori=<?= $data['id_kategori']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                          <a href="hapus-kategori.php?id-kategori=<?= $data['id_kategori']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Peringatan : Data tidak akan bisa dihapus apabila sudah pernah ada dana masuk atau keluar! Apakah anda yakin ingin menghapus kategori ini ?')"><i class="bi bi-trash"></i></a>
                           
    
                        </td>
                      </tr>  
                           
<?php 
    } 
?>    

                  </tbody>
                </table>
                <!-- End Table with stripped rows -->
  
              </div>
            </div>
  
          </div>
        </div>
      </section>
  
</main><!-- End #main -->

<?php 
  include('../_footer.php');
?>