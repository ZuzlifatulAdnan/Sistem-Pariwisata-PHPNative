<?php
// Koneksi database
include 'config/db.php';

// Get the article ID from the URL
$articleId = isset($_GET['id']) ? (int) $_GET['id'] : 0;


function fetchArticle($conn, $id)
{
    $sql = "SELECT id, judul, deskripsi, foto, tglUpload FROM artikel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
// Fetch the article data
$article = fetchArticle($conn, $articleId);

if (!$article) {
    echo "Article not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['judul']); ?> - Pariwisata Lampung</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <meta name="digitaltalent:email" content="juslifatuladnan@gmail.com">
    <meta name="keywords" content="Pariwisata Lampung, <?php echo htmlspecialchars($article['judul']); ?>">
    <meta name="author" content="Zuzlifatul Adnan">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/styles2.css" rel="stylesheet">
    <style>
        .article-header {
            margin: 20px 0;
            text-align: center;
        }

        .article-header img {
            width: 100%;
            height: auto;
            max-width: 600px;
            /* Atur lebar maksimum */
            max-height: 400px;
            /* Atur tinggi maksimum */
            object-fit: cover;
            /* Menjaga proporsi gambar */
        }

        .article-body {
            margin: 20px 0;
        }

        .article-body p {
            text-align: justify;
        }
    </style>
</head>

<body>
    <?php include 'templates/userHeader.php'; ?>
    <?php include 'templates/userNav.php'; ?>

    <main class="container content">
        <div class="row">
            <div class="col-md-8">
                <div class="article-header">
                    <h1>Detail Artikel <?php echo htmlspecialchars($article['judul']); ?></h1>
                    <p><small class="text-muted"><?php echo htmlspecialchars($article['tglUpload']); ?></small></p>
                    <img src="admin/<?php echo htmlspecialchars($article['foto']); ?>"
                        alt="<?php echo htmlspecialchars($article['judul']); ?>">
                </div>

                <div class="article-body">
                    <p><?php echo nl2br(htmlspecialchars($article['deskripsi'])); ?></p>
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
</body>

</html>