<?php
session_start(); // Avvia la sessione
include_once '../config.php'; // Include il file di configurazione

// Aggiunta di attività
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['activityTitle'];
    $note = isset($_POST['activityNote']) ? $_POST['activityNote'] : ''; // Assicurati che la nota sia definita
    
    // Verifica che l'utente sia loggato
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id']; // Recupera l'ID utente dalla sessione

        // Prepara e esegui la query per inserire l'attività
        $stmt = $conn->prepare("INSERT INTO activities (activity_name, note, activity_date, user_id, status) VALUES (?, ?, NOW(), ?, 'pending')"); 
        $stmt->bind_param("ssi", $title, $note, $userId); // Bind anche 'note'
        $stmt->execute();
        $stmt->close();
    } else {
        die("Accesso negato. Si prega di effettuare il login.");
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Promemoria App | To-Do list</title>
</head>
<body style="background-color: #696565;">
    <!--Navbar-->
    <?php include '../static/header.php'; ?>
    <!--Messaggio di benvenuto-->
    <?php include '../static/welcomeMessage.php'; ?>

    <!-- Form per l'aggiunta di attività -->
    <div class="card m-5" style="background-color: #4a4545;">
        <div class="card-header text-white" style="background-color: #2c2a2a;">Aggiungi attività</div>
        <form class="card-body" method="POST" action="promemoria.php">
            <div class="input-group mb-3">
                <span class="input-group-text text-white" style="background-color: #2c2a2a;">Titolo attività</span>
                <input type="text" name="activityTitle" class="form-control" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text text-white" style="background-color: #2c2a2a;">Note</span>
                <input type="text" name="activityNote" class="form-control">
            </div>
            <button class="btn btn-primary" type="submit">Aggiungi</button>
        </form>
    </div>

    <!-- To-Do List -->
    <div class="card m-5 text-white" style="background-color: #4a4545;">
        <div class="card-header text-white" style="background-color: #2c2a2a;">To-Do list</div>
        <div class="activityContainer">
            <?php
            // Recupera e mostra le attività dell'utente
            // Recupera e mostra le attività dell'utente
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $sql = "SELECT * FROM activities WHERE user_id = ?";
                $stmt = $conn->prepare($sql); // Modificato per preparare la query SELECT
                $stmt->bind_param("i", $userId); // Assicurati di passare solo l'ID utente
                $stmt->execute();
                $result = $stmt->get_result();

                while ($activity = $result->fetch_assoc()) {
                    $statusButton = $activity['status'] == 'completed' ? 
    '<button onclick="updateActivityStatus(this, ' . $activity['id'] . ')" type="button" class="btn btn-success">Completato</button>' : 
    '<button onclick="updateActivityStatus(this, ' . $activity['id'] . ')" type="button" class="btn btn-primary">Da fare</button>';



                    
                    echo '<div class="card-body mb-2" data-title="' . htmlspecialchars($activity['activity_name']) . '" data-id="' . $activity['id'] . '">
                        <h5 class="card-title">' . htmlspecialchars($activity['activity_name']) . '</h5>
                        <p class="card-text">' . htmlspecialchars($activity['note']) . '</p>
                        <div class="d-flex justify-content-between">
                            ' . $statusButton . '
                            <button onclick="removeActivity(this)" type="button" class="btn btn-danger">Elimina</button>
                        </div>
                    </div>';
                }

                $stmt->close();
            } else {
                echo "<p>Accesso negato. Si prega di effettuare il login.</p>";
            }?>
        </div>
    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script>
    function removeActivity(button) {
        const activityDiv = button.closest('.card-body');
        const activityId = activityDiv.getAttribute('data-id'); // Ottieni l'ID dell'attività

        // Rimozione tramite AJAX
        fetch('../static/removeActivity.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: activityId })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Errore sconosciuto'); // Ottieni un messaggio di errore dal server
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                activityDiv.remove(); // Rimuove l'attività dalla UI
            } else {
                alert('Errore durante l\'eliminazione dell\'attività: ' + (data.message || 'Errore sconosciuto'));
            }
        })
        .catch(error => {
            console.error('Errore:', error);
            alert('Errore: ' + error.message);
        });

    }

    function updateActivityStatus(button, activityId) {
        const currentStatus = button.innerText === 'Completato' ? 'completed' : 'pending';
        const newStatus = currentStatus === 'completed' ? 'pending' : 'completed';

        fetch('../static/updateActivityStatus.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: activityId, status: newStatus })
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text); });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Cambia il testo e il colore del pulsante
                if (newStatus === 'completed') {
                    button.innerText = 'Completato'; // Cambia il testo per completato
                    button.classList.remove('btn-primary'); // Rimuovi classe da fare
                    button.classList.add('btn-success'); // Aggiungi classe completato
                } else {
                    button.innerText = 'Da fare'; // Cambia il testo per da fare
                    button.classList.remove('btn-success'); // Rimuovi classe completato
                    button.classList.add('btn-primary'); // Aggiungi classe da fare
                }
            } else {
                alert('Errore durante l\'aggiornamento dello stato dell\'attività.');
            }
        })
        .catch(error => {
            console.error('Errore:', error);
            alert('Errore: ' + error.message);
        });
    }
</script>
</body>
</html>
