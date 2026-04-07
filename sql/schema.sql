CREATE DATABASE smart_municipality CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE smart_municipality;

CREATE TABLE signalements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NULL,
    categorie VARCHAR(100) NOT NULL,
    latitude DECIMAL(10,8) NOT NULL,
    longitude DECIMAL(11,8) NOT NULL,
    statut ENUM('en_attente', 'en_cours', 'resolu', 'rejete') DEFAULT 'en_attente',
    date_signalement DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_id INT NULL
);

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(255),
    role ENUM('citoyen', 'admin') DEFAULT 'citoyen'
);

INSERT INTO utilisateurs (nom, email, mot_de_passe, role)
VALUES ('Admin Demo', 'admin@demo.tn', '$2y$10$abcdefghijklmnopqrstuv', 'admin');
