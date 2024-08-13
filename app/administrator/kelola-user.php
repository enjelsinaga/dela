<?php 
  $page = "Data-Siswa";
  include('../_header.php');
  include('../_sidebar.php');
?>
 <main id="main" class="main">

<div class="pagetitle">
  <h1>Kelola User</h1>  
</div><!-- End Page Title -->

<!--main-->
<section class="section dashboard ">
          
            <div class="col-lg-12" >

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>


            <!-- General Form Elements -->
            <form  action="" method="post">
                    
                <table class="table ">
                            <thead >
                            <tr>
                                <th class="text-center" width="40px">No.</th>
                                <th class="text-center" >Nama Lengkap</th>
                                <th class="text-center" >Jurusan</th>
                                <th class="text-center" >Sekolah</th>
                                <th class="text-center" >Aksi</th>
                                
                            </tr>
                            </thead>

                            <tbody>
                                <?php


                                    $no = 1;
                                    // Ambil data transaksi dari database
                                     $querydatasiswa = mysqli_query($conn, "SELECT * FROM tabel-siswa")or die (mysqli_error($conn));
                        
                                    //Looping data dari database
                                    while($dataproject = mysqli_fetch_assoc(querydatasiswa))
                                    {  
                                ?>
                                    <!-- Tampilkan data dari baris dan kolom tabel -->
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td class="text-center"><?php echo $dataproject['nama_lengkap'];?></td>
                                        <td class="text-center"><?php echo $dataproject['jurusan'];?></td>
                                        <td class="text-center"><?php echo $dataproject['sekolah'];?></td>
                                  
                                        <td class="text-center">
                                                <a href="edit-customer.php?id=<?php echo $dataproject['id_customer'];?>" title="Edit">
                                                    <i class="bi bi-pencil-fill btn btn-warning"></i>
                                                </a>
                                                
                                        </td>
                                    
                                    </tr>
                                <?php
                                    }
                                ?>
                    
                            </tbody>
                </table>
            </form><!-- End General Form Elements -->

                    </div>
                </div>

            </div>
</section>

</main><!-- End #main -->



<?php 
  include('../_footer.php');
?>