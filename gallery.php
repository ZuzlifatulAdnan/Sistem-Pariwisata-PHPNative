<?php
// Koneksi database
include 'config/db.php';

// Fetch gallery from database
function fetchGallery($conn)
{
    $sql = "SELECT id, nama, foto FROM galeri";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $gallery = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $gallery[] = $row;
        }
    }
    $stmt->close();
    return $gallery;
}

$gallery = fetchGallery($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - Pariwisata Lampung</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <meta name="description" content="Pariwisata Lampung">
    <meta name="digitaltalent:email" content="juslifatuladnan@gmail.com">
    <meta name="keywords" content="Pariwisata Lampung">
    <meta name="author" content="Zuzlifatul Adnan">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/styles2.css" rel="stylesheet">
    <style>
        .gallery-card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include 'templates/userHeader.php'; ?>
    <?php include 'templates/userNav.php'; ?>

    <main class="container content">
        <div class="row">
            <div class="col-md-8">
                <div class="row justify-content-center">
                    <h2 class="text-center">Galeri Foto</h2>
                </div>
                <div class="row">
                    <?php foreach ($gallery as $item): ?>
                        <div class="col-md-4 gallery-card">
                            <div class="card">
                                <img class="card-img-top" src="admin/<?php echo htmlspecialchars($item['foto']); ?>"
                                    alt="<?php echo htmlspecialchars($item['nama']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?php echo htmlspecialchars($item['nama']); ?>
                                    </h5>
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
</body>

</html>
