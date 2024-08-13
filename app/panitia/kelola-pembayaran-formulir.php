<?php
$page = "Kelola Pembayaran";
include('../_header.php');
include('../_sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Kelola Pembayaran </h1>

    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Pembayaran</h5>
                        <!-- <p class="card-text"><a href="tambah-berita.php" class="btn btn-primary">Tambah Berita</a></p> -->
                        <br>
                        <!-- Table with stripped rows -->
                        <table class="table table-hover" id="tb_kelola_pembayaran">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Bukti Pembayaran</th>
                                    <th scope="col">Status Pembayaran</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php

                                $no = 1;
                                //Tampilkan data dari database
                                $query = mysqli_query(
                                    $conn,
                                    "SELECT tpf.id_formulir, tpf.id_calon_siswa, tcs.nama_lengkap_calon, tpf.bukti_pembayaran_formulir, tpf.status_pembayaran_formulir FROM `tabel-pembayaran-formulir` AS tpf JOIN `tabel-calon-siswa` AS tcs ON tpf.id_calon_siswa = tcs.id_calon_siswa"
                                ) or die(mysqli_error($conn));

                                // Looping data dari database
                                while ($data = mysqli_fetch_assoc($query)) {
                                ?>
                                    <!-- Tampilkan data dari baris dan kolom tabel -->
                                    <tr>
                                        <td class="text-center" width="40px"><?php echo $no++; ?></td>
                                        <td class="text-center"><?php echo $data['nama_lengkap_calon']; ?></td>
                                        <td class="text-center">
                                            <?php if (file_exists('../../' . $data['bukti_pembayaran_formulir']) && $data['bukti_pembayaran_formulir'] != null) : ?>
                                                <a href="<?= '../../' . $data['bukti_pembayaran_formulir']; ?>" target="_blank" class="btn btn-sm btn-primary" title="Lihat File"><i class="bi bi-file-earmark-text"></i></a>
                                            <?php else : ?>
                                                <span class="badge bg-danger">File Tidak Ditemukan</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?php echo $data['status_pembayaran_formulir'] == 'lunas' ? '<span class="badge bg-success">Lunas</span>' : '<span class="badge bg-danger">Belum Lunas</span>'; ?></td>
                                        <td class="text-center">
                                            <a href="konfirmasi-pembayaran-formulir.php?id_calon_siswa=<?= $data['id_calon_siswa']; ?>&status=lunas" onclick="return confirm('Apakah anda yakin ingin mengubah status pembayaran ini menjadi Lunas?')" class="btn btn-sm btn-success" title="Ubah Status Menjadi Lunas"><i class="bi bi-check"></i></a>
                                            <a href="edit-pembayaran.php?id_formulir=<?= $data['id_formulir']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                            <a href="hapus-pembayaran.php?id_formulir=<?= $data['id_formulir']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></a>
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