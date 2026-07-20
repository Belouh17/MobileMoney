CREATE DATABASE bibliotheque CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
user biblioxd
CREATE TABLE livres 
    id INT AUTO_INCREMENT PRIMARY KEY,

    \ CREATE TABLE emprunts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livre_id INT,
    emprunteur VARCHAR(255),
    date_emprunt DATE,
    date_retour DATE NULL,
    FOREIGN KEY (livre_id) REFERENCES livres(id)
);
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    isbn VARCHAR(50) UNIQUE NOT NULL,
    annee INT NOT NULL,
    categorie VARCHAR(100),
    resume TEXT,
    couverture VARCHAR(255),
    statut ENUM('disponible', 'prete') DEFAULT 'disponible',
    created_at DATETIME,
    updated_at DATETIME
);
