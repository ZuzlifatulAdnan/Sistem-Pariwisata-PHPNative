<?php
// Koneksi database
include 'config/db.php';

// Get the wisata ID from the URL
$wisata = isset($_GET['id']) ? (int) $_GET['id'] : 0;


function fetchWisata($conn, $id)
{
    $sql = "SELECT id, nama, deskripsi, foto, tglUpload FROM objekwisata WHERE id = ?";
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
// Fetch the wisata data
$wisatas = fetchWisata($conn, $wisata);

if (!$wisatas) {
    echo "wisata not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($wisatas['nama']); ?> - Pariwisata Lampung</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <meta name="digitaltalent:email" content="juslifatuladnan@gmail.com">
    <meta name="keywords" content="Pariwisata Lampung, <?php echo htmlspecialchars($wisatas['nama']); ?>">
    <meta name="author" content="Zuzlifatul Adnan">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/styles2.css" rel="stylesheet">
    <style>
        .wisata-header {
            margin: 20px 0;
            text-align: center;
        }

        .wisata-header img {
            width: 100%;
            height: auto;
            max-width: 600px;
            /* Atur lebar maksimum */
            max-height: 400px;
            /* Atur tinggi maksimum */
            object-fit: cover;
            /* Menjaga proporsi gambar */
        }

        .wisata-body {
            margin: 20px 0;
        }

        .wisata-body p {
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
                <div class="wisata-header">
                    <h1>Detail Objek Wisata <?php echo htmlspecialchars($wisatas['nama']); ?></h1>
                    <p><small class="text-muted"><?php echo htmlspecialchars($wisatas['tglUpload']); ?></small></p>
                    <img src="admin/<?php echo htmlspecialchars($wisatas['foto']); ?>"
                        alt="<?php echo htmlspecialchars($wisatas['nama']); ?>">
                </div>

                <div class="wisata-body">
                    <p><?php echo nl2br(htmlspecialchars($wisatas['deskripsi'])); ?></p>
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