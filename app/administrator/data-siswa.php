<?php
$page = "siswa";
include('../_header.php');
include('../_sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Siswa</h1>

    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Siswa</h5>
                        <p class="card-text"><a href="tambah-data-siswa.php" class="btn btn-primary">Tambah</a></p>
                        <br>

                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table table-hover" id="tb_data_siswa">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama Lengkap</th>
                                        <th scope="col">Jenis Kelamin</th>
                                        <th scope="col">Umur</th>
                                        <th scope="col">Tempat Lahir</th>
                                        <th scope="col">Tanggal Lahir</th>
                                        <th scope="col">No. Ortu Siswa</th>
                                        <th scope="col">Pas Photo</th>
                                        <th scope="col">KTP Orang Tua</th>
                                        <th scope="col">Kartu Keluarga</th>
                                        <th scope="col">Akte Kelahiran</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php


                                    $no = 1;
                                    //Tampilkan data dari database
                                    $querysiswa = mysqli_query($conn, "SELECT * FROM `tabel-siswa`") or die(mysqli_error($conn));

                                    // Looping data dari database
                                    while ($data = mysqli_fetch_assoc($querysiswa)) {

                                    ?>
                                        <!-- Tampilkan data dari baris dan kolom tabel -->
                                        <tr>
                                            <td class="text-center" width="40px"><?php echo $no++; ?></td>
                                            <td class="text-center"><?php echo $data['nama_lengkap']; ?></td>
                                            <td class="text-center"><?php echo $data['jenis_kelamin'] == 'laki-laki' ? 'Laki-laki' : 'Perempuan'; ?></td>
                                            <td class="text-center"><?php echo $data['umur_siswa'] . ' tahun'; ?></td>
                                            <td class="text-center"><?php echo $data['tempat_lahir']; ?></td>
                                            <td class="text-center"><?php echo $data['tanggal_lahir']; ?></td>
                                            <td class="text-center"><?php echo $data['no_ortu_siswa']; ?></td>
                                            <td class="text-center">
                                                <?php if (file_exists('../../' . $data['pas_photo']) && $data['pas_photo'] != null) : ?>
                                                    <a href="<?= '../../' . $data['pas_photo']; ?>" target="_blank" class="btn btn-success btn-sm" title="Lihat File"><i class="bi bi-file-earmark-text"></i></a>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">File Tidak Ditemukan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (file_exists('../../' . $data['KTP_ortu']) && $data['KTP_ortu'] != null) : ?>
                                                    <a href="<?= '../../' . $data['KTP_ortu']; ?>" target="_blank" class="btn btn-success btn-sm" title="Lihat File"><i class="bi bi-file-earmark-text"></i></a>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">File Tidak Ditemukan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (file_exists('../../' . $data['KK']) && $data['KK'] != null) : ?>
                                                    <a href="<?= '../../' . $data['KK']; ?>" target="_blank" class="btn btn-success btn-sm" title="Lihat File"><i class="bi bi-file-earmark-text"></i></a>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">File Tidak Ditemukan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (file_exists('../../' . $data['akteLahir']) && $data['akteLahir'] != null) : ?>
                                                    <a href="<?= '../../' . $data['akteLahir']; ?>" target="_blank" class="btn btn-success btn-sm" title="Lihat File"><i class="bi bi-file-earmark-text"></i></a>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">File Tidak Ditemukan</span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <a href="edit-siswa.php?id_siswa=<?= $data['id_siswa']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                                <a href="hapus-data-siswa.php?id_siswa=<?= $data['id_siswa']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')"><i class="bi bi-trash"></i></a>
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