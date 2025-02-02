<?php
// Koneksi database
include 'config/db.php';

// Fungsi untuk memotong teks ke jumlah karakter tertentu
function limitCharacters($string, $char_limit)
{
    if (strlen($string) > $char_limit) {
        return substr($string, 0, $char_limit) . '...';
    } else {
        return $string;
    }
}

// Fetch articles from database
function fetchArticles($conn)
{
    $sql = "SELECT id, judul, deskripsi, foto, tglUpload FROM artikel";
    $result = $conn->query($sql);

    $articles = [];
    if ($result && $result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
    }
    return $articles;
}

$articles = fetchArticles($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel - Pariwisata Lampung</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <meta name="description" content="Pariwisata Lampung">
    <meta name="digitaltalent:email" content="juslifatuladnan@gmail.com">
    <meta name="keywords" content="Pariwisata Lampung">
    <meta name="author" content="Zuzlifatul Adnan">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/styles2.css" rel="stylesheet">
</head>

<body>
    <?php include 'templates/userHeader.php'; ?>
    <?php include 'templates/userNav.php'; ?>

    <main class="container content">
        <div class="row">
            <div class="col-md-8">
                <div class="row justify-content-center">
                    <h2 class="text-center">Artikel</h2>
                </div>
                <div class="row">
                    <?php foreach ($articles as $article): ?>
                        <div class="col-md-4 mb-4 d-flex align-items-stretch">
                            <div class="card">
                                <img class="card-img-top" src="admin/<?php echo htmlspecialchars($article['foto']); ?>"
                                    alt="Article Image">
                                <div class="card-body">
                                    <h2 class="card-title">
                                        <?php echo htmlspecialchars(limitCharacters($article['judul'], 25)); ?>
                                    </h2>
                                    <p class="card-text"><small
                                            class="text-muted"><?php echo htmlspecialchars($article['tglUpload']); ?></small>
                                    </p>
                                    <p><?php echo htmlspecialchars(limitCharacters($article['deskripsi'], 35)); ?></p>
                                    <div class="read-more">
                                        <a href="artikelDetail.php?id=<?php echo $article['id']; ?>">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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
    </main>

    <?php include 'templates/footer.php'; ?>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table-1').DataTable();
        });
    </script>
</body>

</html>