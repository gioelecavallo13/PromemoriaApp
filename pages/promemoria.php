<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Promemoria App | To-Do list</title>
</head>
<body style="background-color: #696565;">
    <!--Navbar-->
    <?php include '../static/header.php'; ?>
    <!--Welcome Message-->
    <?php include '../static/welcomeMessage.php'; ?>
    <!--Form (Done)-->
    <div class="card m-5" style="background-color: #4a4545;">
        <div class="card-header text-white" style="background-color: #2c2a2a;">
          Aggiungi attività
        </div>
        <form class="card-body" id="activityForm">
            <div class="input-group mb-3">
                <span class="input-group-text text-white" style="background-color: #2c2a2a; border: none;" id="inputGroup-sizing-default">Titolo attività</span>
                <input type="text" id="activityTitle" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text text-white" style="background-color: #2c2a2a; border: none;" id="inputGroup-sizing-default">Note</span>
                <input type="text" id="activityNote" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
            <button class="btn btn-primary" type="submit">Aggiungi</button>
        </form>
    </div>

    <!--To-Do list (Done)-->
    <div class="card m-5 text-white" style="background-color: #4a4545;">
        <div class="card-header text-white bg-dark" style="background-color: #2c2a2a;">
            To-Do list
        </div>
        <div class="activityContainer">
            <!--Creazione activityCard-->
        </div>
    </div>

    <!--JS Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    
    <!--JS-->
    <script src="../static/reminders.js"></script>
    <script>
        const form = document.getElementById('activityForm');

        // Event listener per collezionare dati form e aggiungere le attività nelle to-do list
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Previene il comportamento di invio del modulo

            const activityTitle = getActivityTitle(); 
            const activityNote = getActivityNote();
            addActivityCard(activityTitle, activityNote); // Funzione che aggiunge attività, passando i parametri titolo e note
            form.reset(); // Restart del form per aggiungere altre attività
        });

        // Funzioni
        function getActivityTitle() {
            return document.getElementById('activityTitle').value;
        }
        function getActivityNote() {
            return document.getElementById('activityNote').value;
        }
        function addActivityCard(title, note) {
            const activityContainer = document.getElementsByClassName('activityContainer')[0];

            // Creazione dell'oggetto attività
            const activity = { title, note, completed: false };

            // Aggiungi attività al localStorage
            const activities = JSON.parse(localStorage.getItem('activities')) || [];
            activities.push(activity);
            localStorage.setItem('activities', JSON.stringify(activities));

            // Aggiunta dell'attività visibile nella UI
            renderActivity(activity);
        }

        function renderActivity(activity) {
            const activityContainer = document.getElementsByClassName('activityContainer')[0];

            const activityCard = 
            `<div class="card-body mb-2" data-title="${activity.title}" data-completed="${activity.completed}">
                <h5 class="card-title">${activity.title}</h5>
                <p class="card-text">${activity.note}</p>
                <button onclick="activityComplete(this)" type="button" class="btn ${activity.completed ? 'btn-success' : 'btn-primary'}">${activity.completed ? 'Completato' : 'Da fare'}</button>
                <button onclick="removeActivity(this)" type="button" class="btn btn-danger">Elimina</button>
            </div>`;

            // Aggiungi l'attività alla fine se completata, altrimenti in cima
            if (activity.completed) {
                activityContainer.appendChild(createActivityElement(activityCard));
            } else {
                activityContainer.prepend(createActivityElement(activityCard));
            }
        }

        function createActivityElement(cardHtml) {
            const div = document.createElement('div');
            div.innerHTML = cardHtml;
            return div.firstChild;
        }

        function loadActivities() {
            const activities = JSON.parse(localStorage.getItem('activities')) || [];
            activities.forEach(activity => {
                renderActivity(activity);
            });
        }

        function removeActivity(button) {
            const activityDiv = button.closest('.card-body');
            const title = activityDiv.querySelector('.card-title').innerText;

            // Rimuove l'attività dal localStorage
            let activities = JSON.parse(localStorage.getItem('activities')) || [];
            activities = activities.filter(activity => activity.title !== title);
            localStorage.setItem('activities', JSON.stringify(activities));

            activityDiv.remove();
        }

        function activityComplete(button) {
            const activityDiv = button.closest('.card-body');
            const title = activityDiv.querySelector('.card-title').innerText;
            let activities = JSON.parse(localStorage.getItem('activities')) || [];
            
            // Trova l'attività da aggiornare
            const activityIndex = activities.findIndex(activity => activity.title === title);
            if (activityIndex !== -1) {
                // Inverte lo stato di completamento
                activities[activityIndex].completed = !activities[activityIndex].completed;

                // Aggiorna il localStorage
                localStorage.setItem('activities', JSON.stringify(activities));
            }

            // Aggiorna l'interfaccia utente
            updateActivityUI(activityDiv, activities[activityIndex]);
        }

        function updateActivityUI(activityDiv, activity) {
            const button = activityDiv.querySelector('button:first-of-type');
            if (activity.completed) {
                button.innerText = 'Completato';
                button.classList.remove('btn-primary');
                button.classList.add('btn-success');

                // Rimuovi l'attività dalla posizione attuale e aggiungila in fondo
                activityDiv.remove();
                document.getElementsByClassName('activityContainer')[0].appendChild(activityDiv);
            } else {
                button.innerText = 'Da fare';
                button.classList.remove('btn-success');
                button.classList.add('btn-primary');

                // Rimuovi l'attività dalla posizione attuale e aggiungila in cima
                activityDiv.remove();
                document.getElementsByClassName('activityContainer')[0].prepend(activityDiv);
            }
        }

        window.onload = function() {
            loadActivities(); // Carica le attività al caricamento della pagina
        };
    </script>
</body>
</html>
