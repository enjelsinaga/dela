<?php
$page = "gelombang";
include('../_header.php');
include('../_sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Gelombang</h1>

    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Gelombang</h5>
                        <p class="card-text"><a href="tambah-gelombang.php" class="btn btn-primary">Tambah</a></p>
                        <br>

                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table table-hover" id="tb_gelombang">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama Gelombang</th>
                                        <th scope="col">Tanggal Mulai</th>
                                        <th scope="col">Tanggal Akhir</th>
                                        <th scope="col">Kuota Siswa</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php


                                    $no = 1;
                                    //Tampilkan data dari database
                                    $querygelombang = mysqli_query($conn, "SELECT * FROM `gelombang_pendaftaran`") or die(mysqli_error($conn));

                                    // Looping data dari database
                                    while ($data = mysqli_fetch_assoc($querygelombang)) {

                                    ?>
                                        <!-- Tampilkan data dari baris dan kolom tabel -->
                                        <tr>
                                            <td class="text-center" width="40px"><?php echo $no++; ?></td>
                                            <td class="text-center"><?php echo $data['nama']; ?></td>
                                            <td class="text-center"><?php echo date('d-M-Y', strtotime($data['tanggal_mulai'])); ?></td>
                                            <td class="text-center"><?php echo date('d-M-Y', strtotime($data['tanggal_akhir'])); ?></td>
                                            <td class="text-center"><?php echo $data['kuota_siswa']; ?></td>
                                            <td class="text-center">
                                                <a href="edit-gelombang.php?id=<?= $data['id']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                                <a href="hapus-gelombang.php?id=<?= $data['id']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini ?')"><i class="bi bi-trash"></i></a>
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
        </div>
    </section>

</main><!-- End #main -->

<?php
include('../_footer.php');
?>