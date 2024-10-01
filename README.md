### Relazione sul Progetto "Promemoria App"

#### 1. **Obiettivo del Progetto**
L'obiettivo del progetto **Promemoria App** è sviluppare un'applicazione web che consenta agli utenti di registrarsi, accedere e gestire promemoria personali. L'app fornisce funzionalità per la registrazione degli utenti e la gestione dei loro promemoria in modo intuitivo e visivamente accattivante.

#### 2. **Struttura e Funzionalità**
- **Pagine create (PromemoriaApp/pages/...)**
  - **login.php:** Gestisce l'accesso degli utenti nel sito web.
  - **logout.php:** Puro codice php che distrugge la sessione dell'utente.
  - **profilo.php:** Stampa le informazioni di accesso dell'utente.
  - **promemoria.php:** La pagina consente agli utenti di gestire le loro attività. Gli utenti possono visualizzare un elenco delle attività, aggiungerne di nuove e modificare lo stato delle attività esistenti contrassegnandole come "da fare" o "completate". I pulsanti per cambiare lo stato delle attività presentano colori distintivi per facilitare la comprensione visiva del loro stato attuale.
  - **signin.php:** Gestisce la registrazione degli utenti al sito web.
  - **timer.php:** Permette all'utente di avviare un timer scegliendo il minutaggio, stopparlo, farlo ripartire o azzerarlo.

- **Pagine create (PromemoriaApp/static/...)**
  - **header.php:** codice HTML che crea la navbar per ogni pagina del sito, con i rispettivi collegamenti alle pagine del sito e rende i link attivi in base alla pagina che stiamo visitando.
  - **removeActivity.php:** Questo codice PHP gestisce la richiesta di eliminazione di un'attività nel database. Quando riceve una richiesta POST, estrae l'ID dell'attività da eliminare e verifica se l'utente è autenticato (verificando la sessione). Se l'utente è autenticato, esegue una query SQL per eliminare l'attività associata all'ID dell'utente e restituisce un messaggio di successo o errore in formato JSON. Se l'utente non è autenticato o il metodo della richiesta non è POST, restituisce un errore.
  - **setup.sql:** Crea le tabelle che gestiscono gli utenti e le attività se **config.php** non ha trovato la connessione nel server **SQL phpmyadmin**.
  - **updateActivityStatus.php:** Gestisce lo status delle attività nel server SQL.
  - **welcomeMessage.php:** Stampa nella pagina promemoria.php un messaggio di benvenuto personalizzato, se l'utente si è loggato, registrato oppure ha fatto l'accesso senza credenziali.

- **Pagine create (PromemoriaApp/...)**
  - **authenticate.php:** autentica l'utente che effettua il login e crea una sessione.
  - **config.php:** Il codice gestisce la connessione a un database MySQL per un'applicazione di promemoria. Stabilisce la connessione, verifica se esistono tabelle specifiche e, se necessario, esegue script per crearle (setup.sql). Inoltre, fornisce funzioni per aggiungere, recuperare, eliminare e aggiornare i promemoria degli utenti, consentendo così la gestione dei dati relativi ai promemoria all'interno dell'applicazione.

#### 3. **Interfaccia Utente**
- **Design dell'Interfaccia:**
  - L'interfaccia utente è costruita utilizzando **Bootstrap** per garantire un design responsivo e attraente.
  - Creazione di una **navbar** per facilitare la navigazione e una **card** per il modulo di registrazione, e accesso con stili personalizzati.

- **Messaggio di Benvenuto:**
  - Implementazione di un messaggio di benvenuto che viene visualizzato all'utente dopo il login o la registrazione, mostrando informazioni personalizzate.

#### 4. **Problemi e Risoluzioni**
- **Visualizzazione del Messaggio di Benvenuto:**
  - È stato riscontrato un problema in cui, dopo la registrazione, veniva visualizzato un messaggio di benvenuto generico invece di quello personalizzato.
  - Modifica della logica per garantire che le variabili di sessione siano correttamente impostate e accessibili nella pagina di reindirizzamento (`promemoria.php`).

- **Collegamenti per Registrazione e Login:**
  - È stato implementato un collegamento tra le pagine di registrazione e login nel file **promemoria.php** quando un utente non è registrato, consentendo agli utenti di accedere facilmente a queste funzionalità.

#### 5. **Prossimi Passi**
- **Progetti da terminare:**
  - Completare la pagina **profilo.php**.
  - Migliorare la logica di gestione degli ID delle attività quando vengono eliminate.
  - Risolvere il bug di duplicazione delle attività quando si ricarica la pagina.
    - riguardare il codice di **config.php** per vedere se ci sono collegamenti con la funzione getRemindersByUserId(), nelle altre pagine. Nel caso fosse rilevante, ricreare il file reminders.js e ricreare la tabella reminders in sql. Codice **reminders.js:**
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

- **Funzionalità da aggiungere:**
  - Integrare notifiche per ricordare agli utenti i loro promemoria.

- **Testing e Ottimizzazione:**
  - Eseguire test approfonditi per garantire che tutte le funzionalità funzionino correttamente.
  - Ottimizzare l'interfaccia utente in base al feedback degli utenti.