// reminders.js

function saveReminder(reminder) {
    const reminders = JSON.parse(localStorage.getItem('reminders')) || [];
    reminders.push(reminder);
    localStorage.setItem('reminders', JSON.stringify(reminders));
}

function loadReminders() {
    const reminders = JSON.parse(localStorage.getItem('reminders')) || [];
    reminders.forEach(reminder => {
        // codice per mostrare il promemoria nella pagina
    });
}

// Chiamato quando la pagina viene caricata
window.onload = loadReminders;
