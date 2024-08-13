<?php 
  $page = "Cetak Laporan Kas";
  include('../_header.php');
  include('../_sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Cetak Laporan Kas</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Cetak Laporan Kas</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-8">
  
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Cetak Laporan Kas</h5>
    
                  <!-- Laporan Kas -->
                  <form action="cetak-laporan-kas.php" method="POST" target="_blank" >  
                  <div class="row mb-5">  
                    <div class="form-group" id="simpledate4">
                        <label for="dateRangePicker" class="col-sm-3 col-form-label">Periode Tanggal</label>
                        <div class="input-daterange input-group">
                        <input type="date" class="input-sm form-control" name="start" />
                        <div class="input-group-prepend">
                          <span class="input-group-text">sampai</span>
                        </div>
                        <input type="date" class="input-sm form-control" name="end" />
                      </div>
                    </div>
                  </div> 

                    <div>
                      <div class="col-sm-8">
                        <button type="submit" name="cetak" class="m-0 float-right btn btn-sm btn-primary">Cetak</button>
                      </div>
                    </div>
                  </form>
                  <!-- Laporan Kas -->
    
                </div>
            </div>
  
          </div>
        </div>
      </section>
  

  </main><!-- End #main -->

<?php 
  include('../_footer.php');
?>