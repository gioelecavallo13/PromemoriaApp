<?php
$servername = "localhost"; // Di solito è localhost
$username = "root"; // Nome utente di default in XAMPP
$password = ""; // Lascia vuoto se non hai impostato una password per l'utente root
$dbname = "promemoria_app"; // Nome del tuo database

// Crea la connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Esegui il file setup.sql solo se non esistono tabelle
$checkTableQuery = "SHOW TABLES LIKE 'users'";
$result = $conn->query($checkTableQuery);

if ($result->num_rows == 0) {
    // Se le tabelle non esistono, esegui il file setup.sql
    $sql = file_get_contents(__DIR__ . '/static/setup.sql');
    if ($conn->multi_query($sql)) {
        do {
            // Ottieni il risultato di ogni query
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());
    } else {
        echo "Errore durante l'esecuzione del file setup.sql: " . $conn->error;
    }
}
?>
