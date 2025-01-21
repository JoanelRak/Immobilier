CREATE DATABASE noel;
USE noel;

-- Création des tables
CREATE TABLE noel_users
(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    age INT NOT NULL
);

CREATE TABLE noel_depot
(
    id_user INT NOT NULL,
    montant DECIMAL(10, 2) NOT NULL
);

CREATE TABLE noel_categorie_cadeau
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(255) NOT NULL
);

CREATE TABLE noel_cadeau
(
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    id_categorie        INT NOT NULL,
    description_cadeau  TEXT NOT NULL,
    prix                DECIMAL(10, 2) NOT NULL,
    image               VARCHAR(255) NOT NULL,
    etoile              TINYINT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES noel_categorie_cadeau(id)
);

-- Insertion des catégories de cadeaux
INSERT INTO noel_categorie_cadeau (nom) VALUES 
('Fille'),
('Garçon'),
('Neutre');

-- Insertion des utilisateurs
INSERT INTO noel_users (nom, mdp, age) VALUES 
('Alice', 'password1', 10),
('Bob', 'password2', 12),
('Charlie', 'password3', 15),
('Diane', 'password4', 8),
('Eve', 'password5', 11);

-- Insertion des dépôts
INSERT INTO noel_depot (id_user, valide, montant) VALUES 
(1, 50.00),
(2, 20.00),
(3, 100.00),
(4, 30.00),
(5, 10.00);

-- Insertion des cadeaux
INSERT INTO noel_cadeau (id_categorie, description_cadeau, prix, image, etoile) VALUES 
(1, 'Poupée magique avec accessoires', 25.99, 'image_fille.png', 5),
(1, 'Kit de maquillage enfant', 15.49, 'image_fille.png', 4),
(1, 'Maison de poupées en bois', 49.99, 'image_fille.png', 5),
(1, 'Sac à dos licorne', 19.99, 'image_fille.png', 4),
(1, 'Boîte à bijoux musicale', 12.99, 'image_fille.png', 5),
(2, 'Voiture télécommandée', 30.99, 'image_garcon.png', 5),
(2, 'Set de construction robotique', 45.49, 'image_garcon.png', 4),
(2, 'Ballon de football', 19.99, 'image_garcon.png', 5),
(2, 'Gants de boxe enfant', 25.00, 'image_garcon.png', 4),
(2, 'Coffret de super-héros', 35.00, 'image_garcon.png', 5),
(3, 'Puzzle 3D neutre', 22.99, 'image_neutre.png', 4),
(3, 'Jeu de société familial', 29.99, 'image_neutre.png', 5),
(3, 'Lampe de chevet étoilée', 18.99, 'image_neutre.png', 4),
(3, 'Tasse personnalisable', 9.99, 'image_neutre.png', 4),
(3, 'Calendrier de l’Avent', 14.99, 'image_neutre.png', 5),
(1, 'Kit de couture enfant', 24.99, 'image_fille.png', 4),
(1, 'Bicyclette rose', 99.99, 'image_fille.png', 5),
(1, 'Carnet et stylos licorne', 8.99, 'image_fille.png', 4),
(1, 'Peignoir enfant licorne', 29.99, 'image_fille.png', 5),
(1, 'Figurines de princesse', 12.99, 'image_fille.png', 4),
(2, 'Drone pour enfant', 49.99, 'image_garcon.png', 5),
(2, 'Skateboard', 59.99, 'image_garcon.png', 4),
(2, 'Montre numérique enfant', 14.99, 'image_garcon.png', 5),
(2, 'Kit d’exploration scientifique', 34.99, 'image_garcon.png', 4),
(2, 'Jeu de fléchettes', 19.99, 'image_garcon.png', 5),
(3, 'Coussin en forme d’animal', 16.99, 'image_neutre.png', 4),
(3, 'Hamac enfant', 35.99, 'image_neutre.png', 5),
(3, 'Thermos décoratif', 11.99, 'image_neutre.png', 4),
(3, 'Tablier de cuisine enfant', 9.49, 'image_neutre.png', 5),
(3, 'Oreiller nuage', 14.49, 'image_neutre.png', 4),
(1, 'Kit de peinture enfant', 22.99, 'image_fille.png', 5),
(2, 'Coffret Lego', 49.99, 'image_garcon.png', 5),
(3, 'Jeu éducatif interactif', 39.99, 'image_neutre.png', 5),
(1, 'Coiffeuse enfant', 79.99, 'image_fille.png', 5),
(2, 'Épée lumineuse', 29.99, 'image_garcon.png', 5),
(3, 'Jeu de construction neutre', 19.99, 'image_neutre.png', 4),
(1, 'Robe de princesse', 25.99, 'image_fille.png', 4),
(2, 'Vélo BMX', 129.99, 'image_garcon.png', 5),
(3, 'Ballon sauteur', 14.99, 'image_neutre.png', 4),
(1, 'Accessoires de danse', 19.99, 'image_fille.png', 5),
(2, 'Casque audio enfant', 27.99, 'image_garcon.png', 4),
(3, 'Jeu de logique', 15.99, 'image_neutre.png', 4),
(3, 'Tablette éducative', 89.99, 'image_neutre.png', 5),
(2, 'Kit de pêche enfant', 24.99, 'image_garcon.png', 5),
(1, 'Jouet en peluche géant', 39.99, 'image_fille.png', 5),
(3, 'Kit de jardinage enfant', 19.99, 'image_neutre.png', 4),
(1, 'Bracelets personnalisables', 12.99, 'image_fille.png', 4),
(2, 'T-shirt super-héros', 15.99, 'image_garcon.png', 5),
(3, 'Poster éducatif', 9.99, 'image_neutre.png', 4),
(1, 'Kit de création de bijoux', 22.99, 'image_fille.png', 5);


CREATE TABLE noel_cadeau_user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_cadeau INT NOT null ,
  id_user INT,
  FOREIGN KEY (id_cadeau) REFERENCES noel_cadeau(id),
  FOREIGN KEY (id_user) REFERENCES noel_users(id)
);