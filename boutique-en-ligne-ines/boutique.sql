-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 28 avr. 2025 à 08:23
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `livre_id` int NOT NULL,
  `note` int NOT NULL,
  `commentaire` text NOT NULL,
  `modere` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `livre_id` (`livre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id`, `user_id`, `livre_id`, `note`, `commentaire`, `modere`) VALUES
(1, 2, 1, 5, 'Chef-d\'œuvre incontournable.', 1),
(2, 3, 10, 4, 'Super livre, captivant.', 1),
(3, 4, 17, 5, 'Un classique de la SF.', 1),
(4, 5, 6, 3, 'Joli conte mais un peu court.', 1),
(5, 6, 3, 4, 'Très bon roman.', 1),
(6, 7, 25, 5, 'Terrifiant et passionnant.', 1),
(7, 8, 28, 4, 'Intrigue très prenante.', 1);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`) VALUES
(1, 'Science-fiction'),
(2, 'Roman classique'),
(3, 'Jeunesse'),
(4, 'Fantasy'),
(5, 'Fantastique'),
(6, 'Aventure'),
(7, 'Roman historique');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('panier','payée','expédiée','annulée') NOT NULL DEFAULT 'panier',
  `montant_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `user_id`, `date`, `statut`, `montant_total`) VALUES
(1, 2, '2025-04-27 20:00:08', 'payée', 25.40),
(2, 3, '2025-04-27 20:00:08', 'panier', 31.00),
(3, 4, '2025-04-27 20:00:08', 'expédiée', 16.00),
(4, 5, '2025-04-27 20:00:08', 'payée', 28.50),
(5, 6, '2025-04-27 20:00:08', 'annulée', 12.90);

-- --------------------------------------------------------

--
-- Structure de la table `lignecommande`
--

DROP TABLE IF EXISTS `lignecommande`;
CREATE TABLE IF NOT EXISTS `lignecommande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int NOT NULL,
  `livre_id` int NOT NULL,
  `quantité` int NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  KEY `livre_id` (`livre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `lignecommande`
--

INSERT INTO `lignecommande` (`id`, `commande_id`, `livre_id`, `quantité`, `prix_unitaire`) VALUES
(1, 1, 1, 5, 12.90),
(2, 1, 2, 3, 12.50),
(3, 2, 3, 2, 10.00),
(4, 2, 4, 9, 11.00),
(5, 3, 10, 7, 16.00),
(6, 4, 17, 1, 15.50),
(7, 4, 18, 4, 13.00),
(8, 5, 1, 1, 12.90);

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

DROP TABLE IF EXISTS `livre`;
CREATE TABLE IF NOT EXISTS `livre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `annee_publication` varchar(20) NOT NULL,
  `description` varchar(500) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `categorie_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categorie_id` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id`, `titre`, `auteur`, `annee_publication`, `description`, `prix`, `stock`, `image`, `categorie_id`) VALUES
(1, '1984', 'George Orwell', '1949', 'Roman dystopique.', 12.90, 10, '1984.jpg', 1),
(2, 'Le Meilleur des mondes', 'Aldous Huxley', '1932', 'Science-fiction.', 13.50, 8, 'meilleur_mondes.jpg', 1),
(3, 'La Peste', 'Albert Camus', '1947', 'Roman philosophique.', 10.00, 12, 'peste.jpg', 2),
(4, 'L’Étranger', 'Albert Camus', '1942', 'Roman existentiel.', 9.50, 7, 'etranger.jpg', 2),
(5, 'Fahrenheit 451', 'Ray Bradbury', '1953', 'Science-fiction.', 11.80, 9, 'fahrenheit.jpg', 1),
(6, 'Le Petit Prince', 'Antoine de Saint-Exupéry', '1943', 'Conte poétique.', 8.90, 15, 'petitprince.jpg', 3),
(7, 'Les Misérables', 'Victor Hugo', '1862', 'Roman historique.', 14.20, 5, 'miserables.jpg', 2),
(8, 'Notre-Dame de Paris', 'Victor Hugo', '1831', 'Roman gothique.', 13.00, 6, 'notredame.jpg', 2),
(9, 'Le Seigneur des Anneaux', 'J.R.R. Tolkien', '1954', 'Fantasy.', 25.00, 4, 'seigneur_anneaux.jpg', 4),
(10, 'Harry Potter à l\'école des sorciers', 'J.K. Rowling', '1997', 'Fantasy.', 16.00, 10, 'hp1.jpg', 4),
(11, 'Harry Potter et la Chambre des secrets', 'J.K. Rowling', '1998', 'Fantasy.', 16.00, 9, 'hp2.jpg', 4),
(12, 'Harry Potter et le Prisonnier d\'Azkaban', 'J.K. Rowling', '1999', 'Fantasy.', 16.00, 8, 'hp3.jpg', 4),
(13, 'Harry Potter et la Coupe de feu', 'J.K. Rowling', '2000', 'Fantasy.', 17.00, 7, 'hp4.jpg', 4),
(14, 'Harry Potter et l\'Ordre du Phénix', 'J.K. Rowling', '2003', 'Fantasy.', 18.00, 7, 'hp5.jpg', 4),
(15, 'Harry Potter et le Prince de sang-mêlé', 'J.K. Rowling', '2005', 'Fantasy.', 18.00, 6, 'hp6.jpg', 4),
(16, 'Harry Potter et les Reliques de la Mort', 'J.K. Rowling', '2007', 'Fantasy.', 19.00, 5, 'hp7.jpg', 4),
(17, 'Fondation', 'Isaac Asimov', '1951', 'Science-fiction.', 15.50, 8, 'fondation.jpg', 1),
(18, 'Dune', 'Frank Herbert', '1965', 'Science-fiction.', 17.50, 7, 'dune.jpg', 1),
(19, 'Le Comte de Monte-Cristo', 'Alexandre Dumas', '1844', 'Aventure.', 14.90, 6, 'montecristo.jpg', 2),
(20, 'Les Trois Mousquetaires', 'Alexandre Dumas', '1844', 'Aventure.', 13.90, 6, 'mousquetaires.jpg', 2),
(21, 'Le Rouge et le Noir', 'Stendhal', '1830', 'Roman.', 11.90, 8, 'rouge_noir.jpg', 2),
(22, 'Voyage au centre de la Terre', 'Jules Verne', '1864', 'Aventure.', 12.50, 10, 'voyage_terre.jpg', 3),
(23, 'Vingt mille lieues sous les mers', 'Jules Verne', '1870', 'Aventure.', 13.20, 9, '20mille.jpg', 3),
(24, 'L’Île mystérieuse', 'Jules Verne', '1874', 'Aventure.', 14.00, 8, 'ile_mysterieuse.jpg', 3),
(25, 'Dracula', 'Bram Stoker', '1897', 'Fantastique.', 11.50, 7, 'dracula.jpg', 5),
(26, 'Frankenstein', 'Mary Shelley', '1818', 'Fantastique.', 10.50, 6, 'frankenstein.jpg', 5),
(27, 'Le Parfum', 'Patrick Süskind', '1985', 'Roman.', 12.00, 8, 'parfum.jpg', 2),
(28, 'Le Nom de la rose', 'Umberto Eco', '1980', 'Roman historique.', 13.00, 7, 'nom_rose.jpg', 2),
(29, 'Orgueil et Préjugés', 'Jane Austen', '1813', 'Roman.', 10.90, 9, 'orgueil.jpg', 2),
(30, 'Don Quichotte', 'Miguel de Cervantes', '1605', 'Roman.', 14.50, 5, 'donquichotte.jpg', 2),
(31, 'Les Piliers de la Terre', 'Ken Follett', '1989', 'Roman historique sur la construction d\'une cathédrale au XIIe siècle en Angleterre.', 14.90, 10, 'piliers_terre.jpg', 7),
(32, 'Les Rois Maudits', 'Maurice Druon', '1955', 'Série de romans sur la malédiction des rois de France au XIVe siècle.', 13.50, 8, 'rois_maudits.jpg', 7),
(33, 'Notre-Dame de Paris', 'Victor Hugo', '1831', 'Roman historique se déroulant au XVe siècle à Paris.', 12.90, 12, 'notre_dame.jpg', 7),
(34, 'La Reine Margot', 'Alexandre Dumas', '1845', 'Roman sur les guerres de religion et la Saint-Barthélemy.', 13.00, 9, 'reine_margot.jpg', 7),
(35, 'Quo Vadis ?', 'Henryk Sienkiewicz', '1896', 'Roman historique sur la Rome antique sous Néron.', 12.50, 7, 'quovadis.jpg', 7),
(36, 'Spartacus', 'Howard Fast', '1951', 'Roman sur la révolte des esclaves dans la Rome antique.', 11.80, 8, 'spartacus.jpg', 7),
(37, 'Salammbô', 'Gustave Flaubert', '1862', 'Roman se déroulant à Carthage au IIIe siècle avant J.-C.', 13.20, 10, 'salammbo.jpg', 7),
(38, 'Moi, Claude', 'Robert Graves', '1934', 'Autobiographie fictive de l\'empereur romain Claude.', 14.00, 6, 'claude.jpg', 7),
(39, 'Les Derniers Jours de Pompéi', 'Edward Bulwer-Lytton', '1834', 'Roman sur l\'éruption du Vésuve.', 12.00, 8, 'pompei.jpg', 7),
(40, 'Imperium', 'Robert Harris', '2006', 'Roman sur la vie de Cicéron dans la Rome antique.', 15.00, 5, 'imperium.jpg', 7);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf16;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `role`) VALUES
(1, 'ines.charfi@laplateforme.io', '1234', 'admin'),
(2, 'meriam.goudadi@laplateforme.io', '1234', 'admin'),
(3, 'alex.bachir@laplateforme.io', 'hash', 'user'),
(4, 'lil@example.com', 'hash', 'user'),
(5, 'mimi@example.com', 'hash', 'user'),
(6, 'jiji@example.com', 'hash', 'user'),
(7, 'grace@example.com', 'hash', 'user'),
(8, 'heidi@example.com', 'hash', 'user'),
(9, 'ivan@example.com', 'hash', 'user'),
(60, 'ines@laplateforme.io', '1234', 'admin'),
(61, 'meriam@laplateforme.io', '1234', 'admin'),
(62, 'alex@laplateforme.io', 'hash1', 'user'),
(63, 'lili@example.com', 'hash2', 'user');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`),
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `lignecommande`
--
ALTER TABLE `lignecommande`
  ADD CONSTRAINT `lignecommande_ibfk_1` FOREIGN KEY (`id`) REFERENCES `livre` (`id`);

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `livre_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
