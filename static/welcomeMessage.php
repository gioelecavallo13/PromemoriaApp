<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Avvia la sessione solo se non è già attiva
}
include_once '../config.php';

// Controlla se l'utente è loggato o registrato
if (isset($_SESSION['username'])) {
    $username = htmlspecialchars($_SESSION['username']); // Evita attacchi XSS con htmlspecialchars

    // Messaggio diverso a seconda dell'azione (login o registrazione)
    if (isset($_SESSION['action'])) {
        if ($_SESSION['action'] == 'login') {
            $welcomeMessage = "Bentornato, $username!";
        } elseif ($_SESSION['action'] == 'register') {
            $welcomeMessage = "Grazie per esserti registrato, $username! Benvenuto nella nostra app.";
        }

        // Dopo aver mostrato il messaggio, rimuove la variabile dell'azione
        unset($_SESSION['action']);
    } else {
        $welcomeMessage = "Benvenuto, $username."; // Messaggio per utenti loggati senza azioni recenti
    }
} else {
    $welcomeMessage = 'Benvenuto! <a href="signin.php" class="text-white">Registrati</a> o <a href="login.php" class="text-white">Accedi</a>.'; // Messaggio per utenti non loggati
}
?>
<div class="card-header text-white" style="background-color: #2c2a2a; border: none; text-align: center;">
    <?php echo $welcomeMessage; ?>
</div>
