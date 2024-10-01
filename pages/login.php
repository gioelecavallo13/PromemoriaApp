<?php
session_start();
$error = ""; // Inizializza la variabile dell'errore
include '../config.php'; // Connessione al database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Prepara la query per cercare l'utente
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inputUsername); // Associa la variabile al segnaposto ?
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se l'utente esiste
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verifica la password
        if (password_verify($inputPassword, $row['password'])) {
            // Avvia la sessione e memorizza le informazioni dell'utente
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            header('Location: promemoria.php'); // Reindirizza all'area protetta
            exit; // Assicurati di terminare lo script dopo il redirect
        } else {
            $error = "Username o password errati.";
        }
    } else {
        $error = "Username o password errati."; // Messaggio di errore se l'utente non esiste
    }

    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Promemoria App | Login</title>
</head>
<body style="background-color: #696565;">
    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2c2a2a;">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Promemoria App</a>
        </div>
    </nav>

    <!--Form-->
    <div class="align-items-center d-flex justify-content-center">
        <div class="card m-5" style="background-color: #4a4545; width: 500px;">
            <div class="card-header text-white" style="background-color: #2c2a2a;">
            Login
            </div>
            <form class="card-body" id="loginForm" method="POST" action="">
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <div class="input-group mb-3 usernameDiv">
                    <span class="input-group-text text-white" id="basic-addon1" style="background-color: #2c2a2a; border: none;">@</span>
                    <input required id="usernameInput" type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3 passwordDiv">
                    <span class="input-group-text text-white" id="basic-addon1" style="background-color: #2c2a2a; border: none;">Password</span>
                    <input required id="passwordInput" type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                </div>
                <div class="text-center mt-3 mb-3">
                    <a href="signin.php" class="text-white">Non hai un account? Registrati qui!</a>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Login</button>  
                </div>
            </form>
        </div>
    </div>
    <!--JS Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
