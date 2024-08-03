<?php
//$page function menampung nilai sementara
//$_GET['page] function menerima pengiriman data melalui link
//?? ketika function penerima belum mendapatkan value/nilai maka function secara default menambahkan nilai kosonh
$page = $_GET['page'] ?? "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Wisata Pulesari</title>
    <meta name="description" content="Pariwisata Lampung">
    <meta name="digitaltalent:email" content="juslifatuladnan@gmail.com">
    <meta name="keywords" content="Pariwisata Lampung">
    <meta name="author" content="Zuzlifatul Adnan">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="header">
        <img src="assets/image/1.jpeg" alt="Desa Wisata Pulesari" width="100%" height="50%">
        <div class="header-text">
            <h1>Desa Wisata Pulesari</h1>
            <p>Wisata Alam dan Budaya Tradisi</p>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Desa Wisata Pulesari</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="?page=home">Beranda</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            About
                        </a>
                        <div class="dropdown-menu" aria-labelledby="aboutDropdown">
                            <a class="dropdown-item" href="?page=about">About Us</a>
                            <a class="dropdown-item" href="?page=team">Our Team</a>
                            <a class="dropdown-item" href="?page=contact">Contact Us</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="?page=objekWisata">Obyek Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=fasilitasWisata">Fasilitas Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=paketWisata">Paket Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=museum">Museum Lampung</a>
                    <li class="nav-item"><a class="nav-link" href="?page=pemesanan">Pemesanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=galery">Gallery</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container content">
        <div class="row">
            <div class="col-md-8">
                <?php
                //kodisi ketika pesan aktif
                if ($page == "pesan") {
                    require "formPesan.php";
                }
                //kondisi ketika home aktif
                else {
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <a href="">
                                    <img class="card-img-top" src="upload/pngegg.png" alt="Article Image 1">
                                    <div class="card-body">
                                        <h2 class="card-title">Paket Mendaki Gunung Batur dan Ayung Rafting Ubud</h2>
                                        <p class="card-text"><small class="text-muted">11 September 2021</small></p>
                                        <p>Description for the first article goes here...</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" src="assets/images/placeholder-image-2.jpg" alt="Article Image 2">
                                <div class="card-body">
                                    <h2 class="card-title">Paket Kuber Bali ATV dan Ayung Rafting – Harga Promo Mulai 650rb
                                    </h2>
                                    <p class="card-text"><small class="text-muted">29 Agustus 2021</small></p>
                                    <p>Description for the second article goes here...</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" src="assets/images/placeholder-image-3.jpg" alt="Article Image 3">
                                <div class="card-body">
                                    <h2 class="card-title">Paket Wisata Lainnya</h2>
                                    <p class="card-text"><small class="text-muted">15 Juli 2021</small></p>
                                    <p>Description for the third article goes here...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } ?>
            </div>
            <div class="col-md-4">
                <div class="embed-responsive embed-responsive-16by9 mb-4">
                    <video class="embed-responsive-item" controls>
                        <source src="assets/video/video.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy;
                <script>document.write(new Date().getFullYear());</script> Pariwisata Lampung. All rights reserved.
            </p>
        </div>
    </footer>
    <!-- End Footer -->

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>