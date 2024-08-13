<?php
$page = "calon_siswa";
include('../_header.php');
include('../_sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Calon Siswa </h1>

    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Calon Siswa</h5>
                        <!-- <p class="card-text"><a href="tambah-data-calon.php" class="btn btn-primary">Tambah Data Calon Siswa</a></p> -->
                        <br>

                        <div style="overflow-x:auto;">
                            <!-- Table with stripped rows -->
                            <table class="table table-hover" id="tb_calon_siswa">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Kartu Ujian</th>
                                        <th scope="col">Nama Lengkap</th>
                                        <th scope="col">Jenis Kelamin</th>
                                        <th scope="col">Tempat Lahir</th>
                                        <th scope="col">Tanggal Lahir</th>
                                        <th scope="col">Umur</th>
                                        <th scope="col">No. Ortu Calon</th>
                                        <th scope="col">Pas Photo</th>
                                        <th scope="col">KTP Orang Tua</th>
                                        <th scope="col">Kartu Keluarga</th>
                                        <th scope="col">Akte Kelahiran</th>
                                        <th scope="col">Aksi</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    //Tampilkan data dari database
                                    $querycalon = mysqli_query($conn, "SELECT * FROM `tabel-calon-siswa`") or die(mysqli_error($conn));

                                    // Looping data dari database
                                    while ($data = mysqli_fetch_assoc($querycalon)) {
                                    ?>
                                        <!-- Tampilkan data dari baris dan kolom tabel -->
                                        <tr>
                                            <td class="text-center" width="40px"><?php echo $no++; ?></td>
                                            <td class="text-center">
                                                <?php
                                                $id_calon_siswa = $data['id_calon_siswa'];

                                                echo "<div class='d-flex'>
                                                        <a href='lihat-kartu-ujian.php?id_calon_siswa=$id_calon_siswa' class='btn btn-sm btn-primary mx-1' target='_blank' title='Lihat Kartu Ujian'><i class='bi bi-eye'></i></a>
                                                        <a href='input-nilai.php?id_calon_siswa=$id_calon_siswa' class='btn btn-sm btn-warning' title='Input Nilai'><i class='bi bi-pencil'></i></a>        
                                                    </div>
                                                ";
                                                ?>
                                            </td>
                                            <td class="text-center"><?php echo $data['nama_lengkap_calon']; ?></td>
                                            <td class="text-center"><?php echo $data['jenis_kelamin'] == 'laki-laki' ? 'Laki-laki' : 'Perempuan'; ?></td>
                                            <td class="text-center"><?php echo $data['tempat_lahir']; ?></td>
                                            <td class="text-center"><?php echo !empty($data['tanggal_lahir']) ? date('d-m-Y', strtotime($data['tanggal_lahir'])) : ''; ?></td>
                                            <td class="text-center"><?php echo $data['umur_calon'] . ' tahun'; ?></td>
                                            <td class="text-center"><?php echo $data['no_ortu_calon']; ?></td>
                                            <td class="text-center">
                                                <?php if (file_exists('../../' . $data['pas_photo']) && $data['pas_photo'] != null) : ?>
                                                    <a href="<?= '../../' . $data['pas_photo']; ?>" target="_blank" class="btn btn-success btn-sm" title="Lihat File"><i class="bi bi-file-earmark-text"></i></a>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">File Tidak Ditemukan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (file_exists('../../' . $data['KTP_ortu_calon']) && $data['KTP_ortu_calon'] != null) : ?>
                                                    <a href="<?= '../../' . $data['KTP_ortu_calon']; ?>" target="_blank" class="btn btn-success btn-sm" title="Lihat File"><i class="bi bi-file-earmark-text"></i></a>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">File Tidak Ditemukan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (file_exists('../../' . $data['KK_calon']) && $data['KK_calon'] != null) : ?>
                                                    <a href="<?= '../../' . $data['KK_calon']; ?>" target="_blank" class="btn btn-success btn-sm" title="Lihat File"><i class="bi bi-file-earmark-text"></i></a>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">File Tidak Ditemukan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (file_exists('../../' . $data['akteLahir_calon']) && $data['akteLahir_calon'] != null) : ?>
                                                    <a href="<?= '../../' . $data['akteLahir_calon']; ?>" target="_blank" class="btn btn-success btn-sm" title="Lihat File"><i class="bi bi-file-earmark-text"></i></a>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">File Tidak Ditemukan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <!-- <a href="edit-calon-siswa.php?id_calon_siswa=" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a> -->
                                                <a href="hapus-data-calon.php?id_calon_siswa=<?= $data['id_calon_siswa']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?')"><i class="bi bi-trash"></i></a>
                                            </td>
                                            <td class="text-center">
                                                <a href="ubah-status-calon.php?id_calon_siswa=<?= $data['id_calon_siswa']; ?>&status=lulus" onclick="return confirm('Apakah anda yakin ingin mengubah status calon siswa ini menjadi Lulus?')" class="btn btn-sm btn-success" title="Lulus"><i class="bi bi-check"></i></a>
                                                <a href="ubah-status-calon.php?id_calon_siswa=<?= $data['id_calon_siswa']; ?>&status=tidaklulus" onclick="return confirm('Apakah anda yakin ingin mengubah status calon siswa ini menjadi Tidak Lulus?')" class="btn btn-sm btn-danger" title="Tidak Lulus"><i class="bi bi-x"></i></a>
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