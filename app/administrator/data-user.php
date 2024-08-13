<?php
$page = "user";
include('../_header.php');
include('../_sidebar.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data User</h1>

    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data User</h5>
                        <p class="card-text"><a href="tambah-data-user.php" class="btn btn-primary">Tambah</a></p>
                        <br>

                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table table-hover" id="tb_user">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama Lengkap</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">No. HP</th>
                                        <th scope="col">Level Akun</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $no = 1;
                                    //Tampilkan data dari database
                                    $queryuser = mysqli_query($conn, "SELECT * FROM `tabel_pengguna`") or die(mysqli_error($conn));

                                    // Looping data dari database
                                    while ($data = mysqli_fetch_assoc($queryuser)) {

                                    ?>
                                        <!-- Tampilkan data dari baris dan kolom tabel -->
                                        <tr>
                                            <td class="text-center" width="40px"><?php echo $no++; ?></td>
                                            <td class="text-center"><?php echo $data['nama_lengkap']; ?></td>
                                            <td class="text-center"><?php echo $data['username']; ?></td>
                                            <td class="text-center"><?php echo $data['email']; ?></td>
                                            <td class="text-center"><?php echo $data['nohp']; ?></td>
                                            <td class="text-center">
                                                <?php

                                                if ($data['level_akun'] == 'level1') {
                                                    echo '<span class="badge bg-primary">Admin</span>';
                                                } elseif ($data['level_akun'] == 'level2') {
                                                    echo '<span class="badge bg-success">Panitia</span>';
                                                } elseif ($data['level_akun'] == 'level3') {
                                                    echo '<span class="badge bg-warning">Keuangan</span>';
                                                } elseif ($data['level_akun'] == 'level4') {
                                                    echo '<span class="badge bg-info">Siswa</span>';
                                                } else {
                                                    echo '<span class="badge bg-secondary">Tidak ada level</span>';
                                                }

                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="edit-user.php?id_pengguna=<?= $data['id_pengguna']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                                <a href="hapus-data-user.php?id_pengguna=<?= $data['id_pengguna']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></a>
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