<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar ">
    <ul class="sidebar-nav " id="sidebar-nav">
         <img src="../assets/img/logo_mi.png" class="item-center-medium "alt="">
        <!--  -->
        </li><!-- End Home Nav -->      

           <!-- Data Siswa -->
           <li class="nav-item">
              <?php if( $page == "Data-Siswa") { ?>
                  <a class="nav-link active" href="data-siswa.php">
                      <i class="bi bi-person-badge-fill"></i>
                      <span>Data Siswa</span>
                  </a>
              <?php } else { ?>
                  <a class="nav-link collapsed" href="data-siswa.php">
                      <i class="bi bi-person-badge-fill"></i>
                      <span>Data Siswa</span>
                  </a>
              <?php } ?>
          </li><!-- End Data Siswa -->

          <!-- Data Calon Siswa -->
          <li class="nav-item">
              <?php if( $page == "Profil Instansi") { ?>
                  <a class="nav-link " href="data-calon-siswa.php">
                      <i class="bi bi-file-person-fill"></i>
                      <span>Data Calon Siswa</span>
                  </a>
              <?php } else { ?>
                  <a class="nav-link collapsed" href="data-calon-siswa.php">
                      <i class="bi bi-file-person-fill"></i>
                      <span>Data Calon Siswa</span>
                  </a>
              <?php } ?>
          </li><!-- End Data Calon Siswa--> 


  


        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#pengelolaan-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Kelola Pembayaran</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="pengelolaan-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li class="nav-item">
              <?php if( $page == "Kategori Transaksi") { ?>
                  <a class="nav-link active" href="kelola-pembayaran-formulir.php">
                      <i class="bi bi-circle"></i>
                      <span>Kelola Pembayaran Formulir</span>
                  </a>
              <?php } else { ?>
                  <a class="nav-link collapsed" href="kelola-pembayaran-formulir.php">
                      <i class="bi bi-circle"></i>
                      <span>Kelola Pembayaran Formulir</span>
                  </a>
              <?php } ?>
          </li><!-- End Kategori Transaksi Nav -->
       
          <li class="nav-item">
              <?php if( $page == "Rekapitulasi") { ?>
                  <a class="nav-link active" href="kelola-pembayaran-ulang.php">
                      <i class="bi bi-circle"></i>
                      <span>Kelola Pembayaran Daftar Ulang</span>
                  </a>
              <?php } else { ?>
                  <a class="nav-link collapsed" href="kelola-pembayaran-ulang.php">
                      <i class="bi bi-circle"></i>
                      <span>Kelola Pembayaran Daftar Ulang</span>
                  </a>
              <?php } ?>
          </li><!-- End Rekapitulasi Nav -->
        </ul>
        </li> <!-- End Pengelolaan Nav -->

      
      
      <li class="nav-item ">
        <a class="nav-link collapsed" href="../auth/logout.php">
          <i class="bi bi-box-arrow-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Logout Page Nav -->
    </ul>
  </aside><!-- End Sidebar-->
