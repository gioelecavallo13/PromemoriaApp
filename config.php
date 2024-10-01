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

// Funzione per aggiungere un promemoria
function addReminder($userId, $title, $note) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO reminders (user_id, title, note) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $userId, $title, $note);
    $stmt->execute();
    $stmt->close();
}

// Funzione per ottenere i promemoria di un utente
function getRemindersByUserId($userId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM reminders WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $reminders = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $reminders;
}

// Funzione per eliminare un promemoria
function deleteReminder($reminderId) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM reminders WHERE id = ?");
    $stmt->bind_param("i", $reminderId);
    $stmt->execute();
    $stmt->close();
}

// Funzione per aggiornare lo stato di un promemoria
function updateReminderStatus($reminderId, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE reminders SET completed = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $reminderId);
    $stmt->execute();
    $stmt->close();
}
?>
