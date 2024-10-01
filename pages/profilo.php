<?php
include '../config.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Promemoria App | Profilo</title>
</head>
<body style="background-color: #696565;">
    <!--Navbar (commentato per test)-->
    <?php include '../static/header.php'; ?>

    <!--Card-->
    <div class="card custom-max-width text-center m-5">
        <div class="card-header">
            Profilo
        </div>
        <div class="card-body">
            <h5 class="card-title">Dati</h5>
            <p class="card-text">e-mail: <?php echo $_SESSION['email']?></p>
            <p class="card-text">Username: <?php echo $_SESSION['username']?></p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
        <div class="card-footer text-muted">
            2 days ago
        </div>
    </div>

    <!--JS Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
