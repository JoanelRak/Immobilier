USE immobilier;

CREATE TABLE Immobilier_client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    numTel INT NOT NULL
);

CREATE TABLE Immobilier_type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    designation VARCHAR(255) NOT NULL
);

CREATE TABLE Immobilier_habitation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_type INT NOT NULL,
    nombre_chambre INT NOT NULL,
    loyer DECIMAL(10,2),
    quartier VARCHAR(255) NOT NULL,
    designation VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_type) REFERENCES Immobilier_type(id)
);

CREATE TABLE Immobilier_img (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_habitation INT NOT NULL,
    img_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_habitation) REFERENCES Immobilier_habitation(id)
);

CREATE TABLE Immobilier_reservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT NOT NULL,
    id_habitation INT NOT NULL,
    date_arrivee DATETIME,
    date_depart DATETIME,
    FOREIGN KEY (id_client) REFERENCES Immobilier_client(id),
    FOREIGN KEY (id_habitation) REFERENCES Immobilier_habitation(id)
);

-- Insérer des clients
INSERT INTO Immobilier_client (nom, email, mdp, numTel) VALUES
('Jean', 'jean@example.com', 'lol', 1234567890),
('Marie', 'marie@example.com', 'lol', 9876543210),
('Paul', 'paul@example.com', 'lol', 5555555555);

-- Insérer des types d'immobilier
INSERT INTO Immobilier_type (designation) VALUES
('Appartement'),
('Maison'),
('Studio');

-- Insérer des habitations
INSERT INTO Immobilier_habitation (id_type, nombre_chambre, loyer, quartier, designation) VALUES
(1, 3, 1200.00, 'Centre-ville', 'Appartement spacieux au centre-ville'),
(2, 5, 2500.00, 'Banlieue', 'Grande maison avec jardin'),
(3, 1, 800.00, 'Quartier étudiant', 'Studio moderne proche université');

-- Insérer des images d'habitations
INSERT INTO Immobilier_img (id_habitation, img_url) VALUES
(1, 'images/appartement.jpg'),
(2, 'mages/maison.jpg'),
(3, 'images/studio.jpg');

-- Insérer des réservations
INSERT INTO Immobilier_reservation (id_client, id_habitation, date_depart, date_arrivee) VALUES
(1, 1, '2025-02-01 14:00:00', '2025-02-15 12:00:00'),
(2, 2, '2025-03-01 14:00:00', '2025-03-10 12:00:00'),
(3, 3, '2025-04-01 14:00:00', '2025-04-05 12:00:00');
