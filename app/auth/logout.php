<?php 
	// Panggil halaman koneksi ke database
	include_once "../koneksi/config.php";

	// Hancurkan session yg dibuat dihalaman login , agar tidak bisa login lagi
	unset($_SESSION['login']);
	echo '<script>window.location="login.php"</script>';
 ?>