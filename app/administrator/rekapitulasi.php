<?php 
  $page = "Rekapitulasi";
  include('../_header.php');
  include('../_sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Rekapitulasi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Pengelolaan Kas</li>
          <li class="breadcrumb-item active">Rekapitulasi</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-12">
  
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Rekapitulasi Transaksi</h5>
                <p class="card-text"><a href="tambah-transaksi.php" class="btn btn-primary">Tambah Transaksi</a></p>
                <br>
                
                  
<!-- Table with stripped rows -->
<table class="table table-hover datatable">
                  <thead>
                    <tr>
                        <!-- <th scope="col">No.</th> -->
                        <th scope="col">Waktu Input</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Dana Masuk</th>
                        <th scope="col">Dana Keluar</th>
                        <th scope="col">Saldo Terakhir</th>
                        <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

<?php  
    $no = 1;
    // Ambil data transaksi dari database
    $querytransaksi = mysqli_query($conn, "SELECT * FROM tabel_transaksi
                                            INNER JOIN tabel_kategori
                                            ON tabel_transaksi.id_kategori = tabel_kategori.id_kategori 
                                            ORDER BY waktu_input" ) or die (mysqli_error($conn));
    $saldo=0;

    // Looping data dari database
    while ($data = mysqli_fetch_assoc($querytransaksi)) 
    {    
      if($data['jenis']==="Dana masuk") {
        $saldo = $saldo+$data['jumlah_transaksi'];
      }else if($data['jenis']==="Dana keluar"){
        $saldo = $saldo-$data['jumlah_transaksi'];
      }
?>                      
                    <!-- Panggil data nya satu-persatu ke dalam baris & kolom tabel -->
                    <tr>
                        <!-- <td><?= $no++; ?></td> -->
                        <td><?= $data['waktu_input']; ?></td>
                        <td><?= $data['tgl_transaksi']; ?></td>
                        <td><?= $data['nama_kategori']; ?></td>
                        <td><?= $data['deskripsi_transaksi']; ?></td>
                        <?php if($data['jenis']==="Dana masuk"): ?>
                          <td><?= number_format($data['jumlah_transaksi']); ?></td>                        
                          <td>-</td>
                        <?php else: ?>
                          <td>-</td>                        
                          <td><?= number_format($data['jumlah_transaksi']); ?></td>
                        <?php endif; ?>
                        <td><?= number_format($saldo); ?></td>
                        <td>
                          <a href="edit-transaksi.php?id-transaksi=<?= $data['id_transaksi']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                          <a href="hapus-transaksi.php?id-transaksi=<?= $data['id_transaksi']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')"><i class="bi bi-trash"></i></a>
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