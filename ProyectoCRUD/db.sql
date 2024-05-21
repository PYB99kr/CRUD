CREATE DATABASE IF NOT EXISTS if0_36583898_agenda_contactos;

USE if0_36583898_agenda_contactos;

CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(255),
    notas TEXT
);
