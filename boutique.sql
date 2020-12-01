-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 05 nov. 2019 à 23:44
-- Version du serveur :  10.1.30-MariaDB
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `caissier`
--

CREATE TABLE `caissier` (
  `num_i_c` varchar(13) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `sexe` char(1) NOT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `tel` varchar(14) DEFAULT NULL,
  `age` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL,
  `groupe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `caissier`
--

INSERT INTO `caissier` (`num_i_c`, `prenom`, `nom`, `sexe`, `adresse`, `email`, `tel`, `age`, `status`, `groupe`) VALUES
('1245454666775', 'Lamine', 'Faty', 'M', 'thise', 'faty@gmail.com', '775414488', 22, 0, 'groupe2'),
('1689667856567', 'Laye', 'Sarr', 'M', 'thies', 'laye@gmail.com', '771234561', 21, 1, 'groupe1'),
('2574634866489', 'Ndeye', 'Sene', 'F', 'Grand Yoff', 'nsene@gmail.com', '776554455', 26, 0, 'groupe1');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `nom_categ` char(50) NOT NULL,
  `description` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`nom_categ`, `description`) VALUES
('Quincaillerie', ''),
('Telephone', ''),
('Vetement', 'xavvhsvvasjhvvasajvjasvcbn xaA');

-- --------------------------------------------------------

--
-- Structure de la table `compte_personne`
--

CREATE TABLE `compte_personne` (
  `login` varchar(20) NOT NULL,
  `mdp` varchar(8) NOT NULL,
  `etat` int(11) DEFAULT NULL,
  `num_i_n` char(13) NOT NULL,
  `type_compte` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compte_personne`
--

INSERT INTO `compte_personne` (`login`, `mdp`, `etat`, `num_i_n`, `type_compte`) VALUES
('gerant', '11111111', 1, '1790199900044', 'gerant'),
('lamine', '44444444', 1, '1245454666775', 'caissier simple'),
('patron', '00000000', 1, '1136508700147', 'proprietaire'),
('sarr', '33333333', 1, '1689667856567', 'caissier chef'),
('sene', '22222222', 1, '2574634866489', 'caissier simple');

-- --------------------------------------------------------

--
-- Structure de la table `emplacement`
--

CREATE TABLE `emplacement` (
  `nom_empl` varchar(20) NOT NULL,
  `capacite` int(10) UNSIGNED NOT NULL,
  `nb_ranges` int(10) UNSIGNED NOT NULL,
  `nb_zones` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `emplacement`
--

INSERT INTO `emplacement` (`nom_empl`, `capacite`, `nb_ranges`, `nb_zones`) VALUES
('empl1', 300, 6, 5),
('emplPiece', 200, 3, 5),
('emplTelephone', 200, 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `gerant`
--

CREATE TABLE `gerant` (
  `num_i_ng` varchar(13) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `sexe` char(1) NOT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `tel` varchar(14) DEFAULT NULL,
  `age` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `gerant`
--

INSERT INTO `gerant` (`num_i_ng`, `prenom`, `nom`, `sexe`, `adresse`, `email`, `tel`, `age`) VALUES
('1790199900044', 'birane', 'kebe', 'M', 'hlm', 'birane@gmail.com', '+221778828442', 30);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `nom_groupe` varchar(20) NOT NULL,
  `mun_i_c_chef` char(13) DEFAULT NULL,
  `nb_c_ajouter` int(11) DEFAULT NULL,
  `nb_c_max` int(11) NOT NULL,
  `etat_g` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `groupe`
--

INSERT INTO `groupe` (`nom_groupe`, `mun_i_c_chef`, `nb_c_ajouter`, `nb_c_max`, `etat_g`) VALUES
('groupe1', '1689667856567', 2, 10, 1),
('groupe2', '', 1, 10, 1),
('groupe3', '', 0, 15, 0);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `nom_prod` varchar(50) NOT NULL,
  `nb_ech` int(11) NOT NULL,
  `prix` float NOT NULL,
  `num_i_n` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `nom_prod` varchar(50) NOT NULL,
  `nom_categ` varchar(50) DEFAULT NULL,
  `nom_empl_conteneur` varchar(20) DEFAULT NULL,
  `zone_conteneur` char(1) NOT NULL,
  `range_conteneur` int(10) UNSIGNED NOT NULL,
  `date_dexpiration` date DEFAULT NULL,
  `prix_revient` float UNSIGNED DEFAULT NULL,
  `prix_vente` float UNSIGNED DEFAULT NULL,
  `stock` int(10) UNSIGNED NOT NULL,
  `stock_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`nom_prod`, `nom_categ`, `nom_empl_conteneur`, `zone_conteneur`, `range_conteneur`, `date_dexpiration`, `prix_revient`, `prix_vente`, `stock`, `stock_max`) VALUES
('Bonbons', 'Alimentation', 'empl1', 'B', 2, '2020-05-17', 75, 100, 23, 1000),
('Chemise', 'Vetement', 'empl1', 'B', 3, '2023-11-09', 2000, 2500, 17, 300),
('Pantalon', 'Vetement', 'empl1', 'B', 5, '2021-03-05', 5000, 5500, 11, 300),
('Piece voiture', 'Quincaillerie', 'emplPiece', 'A', 1, '2031-01-20', 80000, 100000, 30, 100),
('Samsung S6', 'Telephone', 'empl1', 'B', 2, '2023-11-05', 60000, 70000, 48, 100);

-- --------------------------------------------------------

--
-- Structure de la table `proprietaire`
--

CREATE TABLE `proprietaire` (
  `num_i_n` varchar(13) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `sexe` char(1) NOT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `tel` varchar(14) DEFAULT NULL,
  `age` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `proprietaire`
--

INSERT INTO `proprietaire` (`num_i_n`, `prenom`, `nom`, `sexe`, `adresse`, `email`, `tel`, `age`) VALUES
('1136508700147', 'Patron', 'KEBE', 'M', 'Fann,Dakar', 'patron@gmail.com', '+221 778574521', 50);

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id_vente` int(11) NOT NULL,
  `nom_prod_v` varchar(50) NOT NULL,
  `num_i_n_caissier` varchar(13) NOT NULL,
  `num_i_n_achteur` varchar(13) DEFAULT NULL,
  `nb_ech_vendu` int(11) NOT NULL,
  `date_vente` date DEFAULT NULL,
  `prix_vente` float UNSIGNED NOT NULL,
  `groupe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`id_vente`, `nom_prod_v`, `num_i_n_caissier`, `num_i_n_achteur`, `nb_ech_vendu`, `date_vente`, `prix_vente`, `groupe`) VALUES
(29, 'bonbons', '1689667856567', '1111111111111', 40, '2019-11-05', 4000, 'groupe1'),
(30, 'pantalon', '1689667856567', '1111111111111', 40, '2019-11-05', 220000, 'groupe1'),
(31, 'Bonbons', '1689667856567', '1111111111122', 2, '2019-11-05', 200, 'groupe1'),
(32, 'Pantalon', '1689667856567', '1111111111122', 12, '2019-11-05', 66000, 'groupe1'),
(33, 'Bonbons', '1689667856567', '1111111111122', 2, '2019-11-05', 200, 'groupe1'),
(34, 'Pantalon', '1689667856567', '1111111111122', 2, '2019-11-05', 11000, 'groupe1'),
(35, 'Chemise', '1245454666775', '1499848877587', 12, '2019-11-05', 30000, 'groupe2'),
(36, 'Samsung S6', '1245454666775', '1499848877587', 2, '2019-11-05', 140000, 'groupe2'),
(37, 'Piece voiture', '1245454666775', '2643787478847', 3, '2019-11-05', 300000, 'groupe2'),
(38, 'Piece voiture', '2574634866489', '1334364745475', 3, '2019-11-05', 300000, 'groupe1'),
(39, 'Chemise', '2574634866489', '1235347454756', 21, '2019-11-05', 52500, 'groupe1'),
(40, 'Piece voiture', '1689667856567', '2337475877763', 4, '2019-11-05', 400000, 'groupe1');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `caissier`
--
ALTER TABLE `caissier`
  ADD PRIMARY KEY (`num_i_c`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_groupe` (`groupe`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`nom_categ`);

--
-- Index pour la table `compte_personne`
--
ALTER TABLE `compte_personne`
  ADD PRIMARY KEY (`login`);

--
-- Index pour la table `emplacement`
--
ALTER TABLE `emplacement`
  ADD PRIMARY KEY (`nom_empl`);

--
-- Index pour la table `gerant`
--
ALTER TABLE `gerant`
  ADD PRIMARY KEY (`num_i_ng`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`nom_groupe`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD UNIQUE KEY `nom_prod` (`nom_prod`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`nom_prod`),
  ADD KEY `fk_nom_empl_conteneur` (`nom_empl_conteneur`);

--
-- Index pour la table `proprietaire`
--
ALTER TABLE `proprietaire`
  ADD PRIMARY KEY (`num_i_n`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id_vente`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id_vente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `caissier`
--
ALTER TABLE `caissier`
  ADD CONSTRAINT `fk_groupe` FOREIGN KEY (`groupe`) REFERENCES `groupe` (`nom_groupe`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_nom_empl_conteneur` FOREIGN KEY (`nom_empl_conteneur`) REFERENCES `emplacement` (`nom_empl`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
