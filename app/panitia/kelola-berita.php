<?php 
  $page = "Kelola Berita";
  include('../_header.php');
  include('../_sidebar-panitia.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Kelola Berita </h1>
  
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-12">
  
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Kelola Berita</h5>
                <p class="card-text"><a href="tambah-berita.php" class="btn btn-primary">Tambah Berita</a></p>
                <br>
                
                  
<!-- Table with stripped rows -->
<table class="table table-hover datatable ">
                  <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Isi Berita</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Aksi</th>
                    </tr>
                  </thead>

                                <tbody>
                                    <?php

                                        
                                        $no=1;
                                        //Tampilkan data dari database
                                        $querytransaksi = mysqli_query($conn, "SELECT * FROM `tabel-berita`") or die (mysqli_error($conn));
                            
                                            // Looping data dari database
                                         while ($data = mysqli_fetch_assoc($querytransaksi)) 
                                        { 
                                     
                                    ?>
                                        <!-- Tampilkan data dari baris dan kolom tabel -->
                                        <tr>
                                            <td class="text-center" width="40px"><?php echo $no++; ?></td>
                                            <td class="text-center"><?php echo $data['judul_artikel'];?></td>
                                            <td class="text-center"><?php echo $data['isi_artikel'];?></td>
                                            <td class="text-center"><?php echo $data['gambar'];?></td>
                                            
                                            <td class="text-center">
                                            <a href="edit-berita.php?id_berita=<?= $data['id_berita']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <a href="hapus-berita.php?id_berita=<?= $data['id_berita']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')"><i class="bi bi-trash"></i></a>
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