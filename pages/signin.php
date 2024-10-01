<?php
session_start();
require '../config.php'; // Assicurati che il percorso sia corretto
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Crittografia della password

    // Controlla se l'email o l'username esistono già
    $sql = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errorMessage = "Email o username già utilizzati.";
    } else {
        // Inserisci il nuovo utente nel database
        $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $username, $password);
        if ($stmt->execute()) {
            // Imposta le variabili di sessione
            $_SESSION['username'] = $username; // Salva l'username nella sessione
            $_SESSION['action'] = 'register'; // Imposta l'azione per il messaggio di benvenuto

            header('Location: promemoria.php'); // Reindirizza a promemoria.php
            exit; // Assicurati di terminare lo script dopo il redirect
        } else {
            echo "Errore durante la registrazione: " . $conn->error;
        }
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
    <title>Promemoria App | Sign In</title>
</head>
<body style="background-color: #696565;">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2c2a2a;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Promemoria App</a>
        </div>
    </nav>

    <div class="align-items-center d-flex justify-content-center">
        <div class="card m-5" style="background-color: #4a4545; width: 500px;">
            <div class="card-header text-white" style="background-color: #2c2a2a;">
                Sign In
            </div>
            <form class="card-body" action="" method="POST" id="signInForm">
                <?php if ($errorMessage): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
                <div class="input-group mb-3">
                    <span class="input-group-text text-white" style="background-color: #2c2a2a; border: none;">Email</span>
                    <input required id="emailInput" name="email" type="email" class="form-control" placeholder="Email" aria-label="Email">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text text-white" style="background-color: #2c2a2a; border: none;">@</span>
                    <input required id="usernameInput" name="username" type="text" class="form-control" placeholder="Username" aria-label="Username">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text text-white" style="background-color: #2c2a2a; border: none;">Password</span>
                    <input required id="password1Input" name="password" type="password" class="form-control" placeholder="Password" aria-label="Password">
                </div>
                <div class="text-center mt-3 mb-3">
                    <a href="login.php" class="text-white">Hai un account? Accedi qui!</a>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Registrati</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
