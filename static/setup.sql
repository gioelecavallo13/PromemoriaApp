-- Creazione del database
CREATE DATABASE IF NOT EXISTS promemoria_app;

-- Seleziona il database
USE promemoria_app;

-- Creazione della tabella users
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Creazione della tabella activities con note e status
CREATE TABLE IF NOT EXISTS activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    activity_name VARCHAR(255) NOT NULL,
    note TEXT, -- Aggiunta della colonna note
    activity_date DATETIME NOT NULL,
    status ENUM('pending', 'completed') DEFAULT 'pending', -- Aggiunta della colonna status
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
