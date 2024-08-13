<?php

session_start();

require_once "koneksi.php";

if (empty($_SESSION['csrf_sess_token'])) {
    $_SESSION['csrf_sess_token'] = bin2hex(random_bytes(32));
}

if (isset($_SESSION['level_akun'])) {
    if ($_SESSION['level_akun'] == "level4") {
        header("Location: ./formulir.php");
    } else {
        header("Location: ./logout.php");
    }
}

if (isset($_POST['register'])) {
    if (!empty($_POST['csrf_input_token'])) {
        $csrf_input_token = $_POST['csrf_input_token'];

        if (hash_equals($_SESSION['csrf_sess_token'], $csrf_input_token)) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            if (preg_match("~^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$~", $email)) {
                $nama_lengkap = filter_input(INPUT_POST, 'nama_lengkap', FILTER_DEFAULT);
                $nohp = filter_input(INPUT_POST, 'nohp', FILTER_DEFAULT);
                $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
                $level_akun = 'level4';

                $stmt = $koneksi->prepare("SELECT email, nohp FROM tabel_pengguna WHERE email = ? OR nohp = ?");
                $stmt->bind_param("ss", $email, $nohp);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                $row_data = $result->fetch_assoc();

                if (isset($row_data)) {
                    if ($row_data['email'] === $email) {
                        $_SESSION['error'] = 'Email sudah ada.';

                        echo '<script>window.location.replace("register.php");</script>';
                        die();
                    } elseif (strtolower($row_data['nohp']) === strtolower($nohp)) {
                        $_SESSION['error'] = 'No. HP sudah ada.';

                        echo '<script>window.location.replace("register.php");</script>';
                        die();
                    }
                } else {
                    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
                    $stmt2 = $koneksi->prepare("INSERT INTO tabel_pengguna(nama_lengkap, nohp, email, level_akun, `password`, created_at, updated_at) VALUES(?, ?, ?, ?, ?, ?, ?)");
                    $stmt2->bind_param("sssssss", $nama_lengkap, $nohp, $email, $level_akun, $hashed_pass, $sekarang, $sekarang);
                    $execute = $stmt2->execute();
                    $stmt2->close();

                    if ($execute) {
                        $_SESSION['success'] = 'Akun telah didaftarkan.';

                        echo '<script>window.location.replace("login.php");</script>';
                        die();
                    } else {
                        $_SESSION['error'] = 'Gagal mendaftar, silakan hubungi Admin untuk info lebih lanjut.';

                        echo '<script>window.location.replace("register.php");</script>';
                        die();
                    }
                }
            } else {
                $_SESSION['error'] = 'Gagal mendaftar, silakan mendaftar menggunakan email yang valid.';

                echo '<script>window.location.replace("register.php");</script>';
                die();
            }
        } else {
            header('HTTP/1.0 403 Forbidden');

            exit('The action you have requested is not allowed.');
        }
    } else {
        header('HTTP/1.0 403 Forbidden');

        exit('The action you have requested is not allowed.');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Register - MI Muhammadiyah 01 Pekanbaru</title>
    <!-- Favicons -->
    <link href="assets/img/logo_mi.png" rel="icon">
    <link href="" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
        }

        .login-container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #4CAF50;
            /* Adjusted the green background */
        }

        .login-form {
            width: 600px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 24px;
        }

        .login-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #45a049;
        }

        .login-form input[type="email"],
        .login-form input[type="password"],
        .login-form input[type="text"],
        .login-form input[type="number"] {
            /* Added text and number input types */
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        .login-form input[type="email"]:focus,
        .login-form input[type="password"]:focus,
        .login-form input[type="text"]:focus,
        .login-form input[type="number"]:focus {
            /* Added focus styles */
            background-color: #ddd;
            outline: none;
        }

        .login-form .register {
            background-color: #f1f1f1;
            text-align: center;
            padding: 20px;
        }
    </style>

</head>

<body class="index-page">

    <?php
    if (isset($_SESSION['error'])) {
        $error = $_SESSION['error'];
    ?>
        <div id="error_message" class="alert alert-danger fixed-bottom" role="alert">
            <i class="fa fa-ban"></i>
            <?= $error; ?>
        </div>
    <?php
        unset($_SESSION['error']);
    } ?>

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <a href="index.php" class="logo d-flex align-items-center me-auto">
                <img src="assets/img/logo_mi.png" alt="Logo MI Muhammadiyah 01 Pekanbaru" class="px-1">
                <h1 class="sitename d-none d-md-block" style="font-size: 17px;">
                    MI Muhammadiyah 01<br><span class="subtext">Pekanbaru</span>
                </h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="berita.php">Berita</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <a class="btn-getstarted" href="login.php">Login</a>
        </div>
    </header>

    <div class="login-container">
        <form class="login-form" action="register.php" method="post">
            <input type="hidden" name="csrf_input_token" value="<?= !empty($_SESSION['csrf_sess_token']) ? $_SESSION['csrf_sess_token'] : ''; ?>">
            <h2 class="text-center mb-4">REGISTER</h2>
            <p class="text-center mb-4">Daftar akun siswa baru untuk login</p>
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
            <input type="number" min="0" name="nohp" class="form-control" placeholder="No. HP (08xxx)" required>
            <input type="email" name="email" class="form-control" placeholder="Email" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" name="register">REGISTER</button>
            <div class="mb-4"></div>
            <div class="register">
                Sudah Punya Akun? <a href="login.php">Login</a>
            </div>
        </form>
    </div>

    <footer id="footer" class="footer position-relative">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-6 col-md-4 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">MI MUHAMMADIYAH 01 PEKANBARU</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>JL ....</p>
                        <p>Pekanbaru</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+62823 6789 6534</span></p>
                        <p><strong>Email:</strong> <span>mimuhammadiyah01pekanbaru.gmail.com</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <!-- <a href=""><i class="bi bi-twitter-x"></i></a> -->
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <!-- <a href=""><i class="bi bi-linkedin"></i></a> -->
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">LOKASI</span>
                    </a>
                    <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
                        <iframe style="border:0; width: 100%; height: 300px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <!-- <div class="footer-contact pt-3">
            <p>JL ....</p>
            <p>Pekanbaru</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+62823 6789 6534</span></p>
            <p><strong>Email:</strong> <span>mimuhammadiyah01pekanbaru.gmail.com</span></p>
          </div> -->
                    <!-- <div class="social-links d-flex mt-4"> -->
                    <!-- <a href=""><i class="bi bi-twitter-x"></i></a> -->
                    <!-- <a href=""><i class="bi bi-facebook"></i></a> -->
                    <!-- <a href=""><i class="bi bi-instagram"></i></a> -->
                    <!-- <a href=""><i class="bi bi-linkedin"></i></a> -->
                </div>
            </div>

        </div>

        <div class="container copyright text-center mt-4">

            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                <p>© <span>Copyright</span> <strong class="px-1 sitename"> MI MUHAMMADIYAH 01 PEKANBARU</p>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script type="text/javascript">
        $('#error_message').fadeIn();
        setTimeout(function() {
            $('#error_message').fadeOut("slow");
        }, 8000);
    </script>
</body>

</html>