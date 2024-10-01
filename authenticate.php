<!--authenticate.php-->
<?php
session_start();
require 'config.php'; // Assicurati che il percorso sia corretto

// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'promemoria_app'); // Modifica 'promemoria_app' con il nome corretto del tuo database

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Controlla se il metodo della richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepara la query per cercare l'utente
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Associa la variabile $username al segnaposto ?
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se l'utente esiste
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verifica la password
        if (password_verify($password, $row['password'])) {
            // Avvia la sessione e memorizza le informazioni dell'utente
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            header('Location: pages/promemoria.php'); // Reindirizza all'area protetta
            exit;
        } else {
            echo "Password errata.";
        }
    } else {
        echo "Utente non trovato.";
    }

    $stmt->close();
}
$conn->close();
?>
