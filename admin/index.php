<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Pariwisata Lampung</title>
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
    <meta name="description" content="Pariwisata Lampung">
    <meta name="digitaltalent:email" content="juslifatuladnan@gmail.com">
    <meta name="keywords" content="Pariwisata Lampung">
    <meta name="author" content="Zuzlifatul Adnan">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles2.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="text-center">Admin Login</h2>
                <form action="prosesLogin.php" method="post">
                    <div class="form-group">
                        <label for="inputUsername">Username</label>
                        <input id="inputUsername" class="form-control" type="text" name="username"
                            placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input id="inputPassword" class="form-control" type="password" name="password"
                            placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Start Script JS -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- Start Script JS -->
</body>

</html>