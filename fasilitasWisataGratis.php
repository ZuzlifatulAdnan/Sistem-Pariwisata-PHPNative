<?php
include 'config/db.php';

// Function to fetch free facilities from the database
function fetchFasilitasGratis($conn)
{
    $sql = "SELECT f.id, f.nama, f.objekWisataId, f.foto, f.jenisFasilitas, o.nama AS objekWisataNama 
            FROM fasilitaswisata f
            JOIN objekwisata o ON f.objekWisataId = o.id
            WHERE LOWER(f.jenisFasilitas) = 'gratis'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Fetch the fasilitas gratis data
$fasilitas = fetchFasilitasGratis($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas Gratis</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <style>
        .fasilitas-card {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .fasilitas-card img {
            width: 100%;
            height: auto;
            max-width: 300px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        .gratis {
            background-color: #d4edda;
            border-color: #c3e6cb;
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
                    <h2 class="text-center">Fasilitas Wisata Gratis</h2>
                </div>
                <div class="row">
                    <?php foreach ($fasilitas as $f): ?>
                        <div class="col-md-4 mb-4 d-flex align-items-stretch">
                            <div class="fasilitas-card gratis">
                                <h3><?php echo htmlspecialchars($f['nama']); ?></h3>
                                <p><strong>Objek Wisata:</strong> <?php echo htmlspecialchars($f['objekWisataNama']); ?></p>
                                <img src="admin/fasilitas/<?php echo htmlspecialchars($f['foto']); ?>"
                                    alt="<?php echo htmlspecialchars($f['nama']); ?>">
                                <p><strong>Jenis Fasilitas:</strong> <?php echo htmlspecialchars($f['jenisFasilitas']); ?>
                                </p>
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