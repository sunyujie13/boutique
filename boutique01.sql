-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 10 fév. 2020 à 11:19
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `id_membre` int(11) DEFAULT NULL,
  `montant` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  `etat` enum('en cours de traitement,envoyé,livré') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE `details_commande` (
  `id_details_commande` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(3) NOT NULL,
  `prix` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `ville` varchar(20) NOT NULL,
  `code_postal` int(5) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `status`) VALUES
(1, 'membre', '$2y$10$TuqJbXsu7yNMeZW0MM0L4OI79fpmC.tb3sqt7fQxnO9hUvU4jawSS', 'membre', 'membre', 'membre@exemple.com', 'f', 'Toulouse', 31000, '55 rue bayard', 0),
(2, 'admin', '$2y$10$DTLHxTGP90/jF5vagdWM3u1tbhNCeSOFFQa2rmwasDwnT2cYxww7e', 'admin', 'admin', 'admin@exemple.com', 'm', 'Paris', 75015, '33 rue mademoiselle', 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `categorie` varchar(20) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `couleur` varchar(7) NOT NULL,
  `taille` varchar(5) NOT NULL,
  `public` enum('m','f','mixte') NOT NULL,
  `photo` varchar(250) NOT NULL,
  `prix` int(3) NOT NULL,
  `stock` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES
(1, '11-d-23', 'tshirt', 'Tshirt Col V', 'Tee-shirt en coton flammé liseré contrastant', 'bleu', 'M', 'm', 'http://localhost/PHPSQL/boutique/img/100_bleu.jpg', 20, 53),
(2, '66-f-15', 'tshirt', 'Tshirt Col V rouge', 'c\'est vraiment un super tshirt en soir&eacute;e !', 'rouge', 'L', 'm', 'http://localhost/PHPSQL/boutique/img/102_rouge.png', 15, 230),
(3, '88-g-77', 'tshirt', 'Tshirt Col rond vert', 'Il vous faut ce tshirt Made In France !!!', 'vert', 'L', 'm', 'http://localhost/PHPSQL/boutique/img/103_vert.png', 29, 63),
(4, '55-b-38', 'tshirt', 'Tshirt jaune', 'le jaune reviens &agrave; la mode, non? :-)', 'jaune', 'S', 'm', 'http://localhost/PHPSQL/boutique/img/101_jaune.png', 20, 3),
(5, '31-p-33', 'tshirt', 'Tshirt noir original', 'voici un tshirt noir tr&egrave;s original :p', 'noir', 'XL', 'm', 'http://localhost/PHPSQL/boutique/img/2332_full_t-shirt.jpg', 25, 80),
(6, '56-a-65', 'chemise', 'Chemise Blanche', 'Les chemises c\'est bien mieux que les tshirts', 'blanc', 'L', 'm', 'http://localhost/PHPSQL/boutique/img/105_chemiseblanchem.jpg', 49, 73),
(7, '63-s-63', 'chemise', 'Chemise Noir', 'Comme vous pouvez le voir c\'est une chemise noir...', 'noir', 'M', 'm', 'http://localhost/PHPSQL/boutique/img/106_chemisenoirm.jpg', 59, 120),
(8, '77-p-79', 'pull', 'Pull gris', 'Pull gris pour l\'hiver', 'gris', 'XL', 'f', '/PHPSQL/boutique/img/104_pullgrism2.jpg', 79, 99);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_membre` (`id_membre`);

--
-- Index pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD PRIMARY KEY (`id_details_commande`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_produit` (`id_produit`),
  ADD KEY `id_commande_2` (`id_commande`),
  ADD KEY `id_produit_2` (`id_produit`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `details_commande`
--
ALTER TABLE `details_commande`
  MODIFY `id_details_commande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD CONSTRAINT `details_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `details_commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
