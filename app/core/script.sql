-- Création de la base de données
CREATE DATABASE IF NOT EXISTS mvc_db_tp;
USE mvc_db_tp;

-- Table des clients
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des articles
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des commandes
CREATE TABLE IF NOT EXISTS commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('en attente', 'expédiée', 'livrée', 'annulée') DEFAULT 'en attente',
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

-- Table de liaison entre commandes et articles
CREATE TABLE IF NOT EXISTS commande_articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    article_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE
);

-- Insertion de données initiales
INSERT INTO clients (nom, email, telephone) VALUES
('Alice Dupont', 'alice@example.com', '0612345678'),
('Bob Martin', 'bob@example.com', '0623456789');

INSERT INTO articles (nom, description, prix, stock) VALUES
('Ordinateur portable', 'Un super laptop performant', 899.99, 10),
('Souris sans fil', 'Ergonomique et rapide', 29.99, 50),
('Clavier mécanique', 'RGB, switches silencieux', 79.99, 30);

INSERT INTO commandes (client_id, statut) VALUES
(1, 'en attente'),
(2, 'livrée');

INSERT INTO commande_articles (commande_id, article_id, quantite, prix_unitaire) VALUES
(1, 1, 1, 899.99),
(1, 2, 2, 29.99),
(2, 3, 1, 79.99);
