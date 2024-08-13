<?php 
  $page = "Dana Masuk";
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
      <h1>Dana Masuk</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Pengelolaan Kas</li>
          <li class="breadcrumb-item active">Dana Masuk</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-12">
  
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Transaksi Dana Masuk</h5>
                <p class="card-text"><a href="tambah-dana-masuk.php" class="btn btn-primary">Tambah dana masuk</a></p>
                <br>
                
                  
<!-- Table with stripped rows -->
<table class="table table-hover datatable">
                  <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Waktu Input</th>
                        <th scope="col">Tanggal Transaksi</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

<?php  
    $no = 1;
    // Ambil data kategori dari database
    $querytransaksi = mysqli_query($conn, "SELECT * FROM tabel_transaksi
                                            INNER JOIN tabel_kategori
                                            ON tabel_transaksi.id_kategori = tabel_kategori.id_kategori 
                                            WHERE jenis = 'Dana masuk' 
                                            ORDER BY id_transaksi DESC" ) or die (mysqli_error($conn));

    // Looping data dari database
    while ($data = mysqli_fetch_assoc($querytransaksi)) 
    {    
?>                      
                    <!-- Panggil data nya satu-persatu ke dalam baris & kolom tabel -->
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['waktu_input']; ?></td>
                        <td><?= $data['tgl_transaksi']; ?></td>
                        <td><?= $data['nama_kategori']; ?></td>
                        <td><?= $data['deskripsi_transaksi']; ?></td>
                        <td><?= "Rp. ".number_format($data['jumlah_transaksi']);?></td>                        
                        
                        <td>
                          <a href="edit-dana-masuk.php?id-transaksi=<?= $data['id_transaksi']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                          <a href="hapus-dana-masuk.php?id-transaksi=<?= $data['id_transaksi']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')"><i class="bi bi-trash"></i></a>
                           
    
                        </td>
                      </tr>  
                           
<?php 
    } 
?>    
                   
                  </tbody>
                </table>
                <!-- End Table with stripped rows -->
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