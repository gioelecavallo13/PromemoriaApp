<?php
session_start();
include_once '../config.php'; // Include il file di configurazione

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ottieni i dati JSON dalla richiesta
    $data = json_decode(file_get_contents('php://input'), true);
    $activityId = $data['id'];

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        
        // Prepara e esegui la query per eliminare l'attività
        $stmt = $conn->prepare("DELETE FROM activities WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $activityId, $userId); // Assicurati di legare l'ID e l'ID utente

        if ($stmt->execute()) {
            // Restituisci una risposta JSON di successo
            echo json_encode(['success' => true]);
        } else {
            // Restituisci un errore se l'eliminazione fallisce
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }

        $stmt->close();
    } else {
        // Restituisci un errore di accesso non autorizzato
        echo json_encode(['success' => false, 'error' => 'Accesso negato.']);
    }
} else {
    // Restituisci un errore se il metodo non è POST
    echo json_encode(['success' => false, 'error' => 'Metodo non valido.']);
}
?>
