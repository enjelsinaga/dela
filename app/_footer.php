<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>MI Muhammadiyah 01 Pekanbaru</span></strong>. All Rights Reserved
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendor/chart.js/chart.min.js"></script>
<script src="../assets/vendor/echarts/echarts.min.js"></script>
<script src="../assets/vendor/quill/quill.min.js"></script>
<script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="../assets/vendor/tinymce/tinymce.min.js"></script>
<script src="../assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Buttons JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script>
    // Customize the default DataTables button styling
    $.extend(true, $.fn.dataTable.Buttons.defaults, {
        dom: {
            button: {
                className: 'd-flex align-items-center btn btn-success mx-1 my-3'
            },
        },
    });

    $('#success_message').fadeIn();
    setTimeout(function() {
        $('#success_message').fadeOut("slow");
    }, 8000);

    $('#error_message').fadeIn();
    setTimeout(function() {
        $('#error_message').fadeOut("slow");
    }, 8000);

    $('#tb_data_siswa').DataTable({
        language: {
            searchPlaceholder: "Kata kunci...",
        },
        dom: 'lBfrtip',
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, -1],
            [10, 25, 50, 100, 500, 1000, 'All']
        ],
        buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                }
            },
            'colvis'
        ],
    });

    $('#tb_calon_siswa').DataTable({
        language: {
            searchPlaceholder: "Kata kunci...",
        },
        dom: 'lBfrtip',
        lengthMenu: [
            [10, 25, 50, 100, 500, 1000, -1],
            [10, 25, 50, 100, 500, 1000, 'All']
        ],
        buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6],
                }
            },
            'colvis'
        ],
    });

    $('#tb_kelola_pembayaran').DataTable({
        language: {
            searchPlaceholder: "Kata kunci...",
        },
    });

    $('#tb_pembayaran_ulang').DataTable({
        language: {
            searchPlaceholder: "Kata kunci...",
        },
    });

    $('#tb_gelombang').DataTable({
        language: {
            searchPlaceholder: "Kata kunci...",
        },
    });

    $('#tb_user').DataTable({
        language: {
            searchPlaceholder: "Kata kunci...",
        },
    });

    // Fetch chart data from PHP
    fetch('chart-data.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('siswaChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: data.datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

    // Fetch chart data from the new PHP script
    fetch('chart-data-gelombang.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('gelombangChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: data.datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
</script>

</body>

</html>