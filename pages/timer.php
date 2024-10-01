<!--/pages/timer.php-->
<?php
session_start(); // Avvia la sessione
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Reindirizza alla pagina di login se non è autenticato
    exit; // Termina lo script
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Promemoria App | Timer</title>
</head>
<body style="background-color: #696565;">
    <!--Navbar-->
    <?php include '../static/header.php'; ?>
    <!--Finestra timer-->
    <div class="card m-5" style="background-color: #4a4545;">
        <div class="card-header text-white" style="background-color: #2c2a2a;">
          Timer
        </div>
        <form class="card-body" id="timerForm">
            <div class="input-group mb-3">
                <span class="input-group-text text-white" style="background-color: #2c2a2a; border: none;" id="inputGroup-sizing-default">Imposta timer (minuti)</span>
                <input type="number" id="inputTimer" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
            </div>
            <p class="fs-1 fw-bold text-white text-center" id="timerDisplay">00:00</p>
            <div class="text-center">
                <button class="btn btn-primary" type="submit">Start</button>
                <button class="btn btn-danger" id="stopButton" type="button">Stop</button>
                <button class="btn btn-secondary" id="resetButton" type="button">azzera</button>
            </div>
        </form>
    </div>
    <!--JS-->
    <script>
        let form = document.getElementById('timerForm');
        let display = document.getElementById('timerDisplay');
        let secondsRemaining = 0;
        let timer;
        let isPaused = false;
        form.addEventListener('submit', function(event){
            event.preventDefault(); // Previene il comportamento di invio del modulo

            const minute = getTimerInput();
            secondsRemaining = minute * 60;
            startTimer();
            form.reset();
        });

        function getTimerInput(){
            return document.getElementById('inputTimer').value;
        }

        function startTimer() {
            // Pulisci qualsiasi timer esistente prima di avviarne uno nuovo
            if (timer) clearInterval(timer);

            timer = setInterval(function() {
                if (secondsRemaining > 0) {
                    secondsRemaining--;
                    updateDisplay();
                } else {
                    clearInterval(timer);
                    alert('Tempo scaduto!');
                }
            }, 1000);
        }

        function updateDisplay(){
            let minutes = Math.floor(secondsRemaining / 60);
            let seconds = secondsRemaining % 60;
            display.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }


        document.getElementById('stopButton').addEventListener('click', function() {
            if (isPaused) {
                startTimer(); // Riprendi il timer
                this.textContent = 'Stop'; // Cambia il testo del pulsante
                this.classList.remove('btn-success');
                this.classList.add('btn-danger');
            } else {
                clearInterval(timer); // Ferma il timer
                this.textContent = 'Resume'; // Cambia il testo del pulsante
                this.classList.remove('btn-danger');
                this.classList.add('btn-success');
            }
            isPaused = !isPaused; // Alterna tra stop e resume
        });

        document.getElementById('resetButton').addEventListener('click', function(){
            secondsRemaining = 0;
            updateDisplay();
        })

    </script>
    <!--JS Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>