### Relazione sul Progetto "Promemoria App"

#### 1. **Obiettivo del Progetto**
L'obiettivo del progetto **Promemoria App** è sviluppare un'applicazione web che consenta agli utenti di registrarsi, accedere e gestire promemoria personali. L'app fornisce funzionalità per la registrazione degli utenti e la gestione dei loro promemoria in modo intuitivo e visivamente accattivante.

#### 2. **Struttura e Funzionalità**
- **Registrazione e Login:**
  - Creazione di un modulo di registrazione che accetta **email**, **username** e **password**.
  - Implementazione della logica per controllare la disponibilità di email e username nel database durante la registrazione. Se un'email o uno username esiste già, viene visualizzato un messaggio di errore.
  - La password viene crittografata prima di essere memorizzata nel database.

- **Gestione delle Sessioni:**
  - Utilizzo delle sessioni per mantenere lo stato dell'utente, consentendo il riconoscimento degli utenti loggati e la personalizzazione dell'interfaccia.
  - A seconda dell'azione dell'utente (login o registrazione), viene visualizzato un messaggio di benvenuto appropriato.

#### 3. **Interfaccia Utente**
- **Design dell'Interfaccia:**
  - L'interfaccia utente è costruita utilizzando **Bootstrap** per garantire un design responsivo e attraente.
  - Creazione di una **navbar** per facilitare la navigazione e una **card** per il modulo di registrazione, con stili personalizzati.

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
  -Aggiungere funzionalità per la gestione dei promemoria, inclusa la creazione, la modifica e l'eliminazione di promemoria (già implementata ma non per i singoli utenti).
  -Finire la pagina **profilo.php**
-**Funzionalità da aggiungere:**
  - Integrare notifiche per ricordare agli utenti i loro promemoria.

- **Testing e Ottimizzazione:**
  - Eseguire test approfonditi per garantire che tutte le funzionalità funzionino correttamente.
  - Ottimizzare l'interfaccia utente in base al feedback degli utenti.