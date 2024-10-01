<?php
session_start();
include_once '../config.php'; // Include il file di configurazione

// Verifica che la richiesta sia una POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $activityId = $data['id'];
    $status = $data['status'];

    // Verifica che l'utente sia loggato
    if (isset($_SESSION['user_id'])) {
        $stmt = $conn->prepare("UPDATE activities SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $activityId);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore nell\'aggiornamento dello stato.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Accesso negato.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Richiesta non valida.']);
}
?>
