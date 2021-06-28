-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 17 mars 2021 à 14:04
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsbv2`
--

-- --------------------------------------------------------

--
-- Structure de la table `comptable`
--

DROP TABLE IF EXISTS `comptable`;
CREATE TABLE IF NOT EXISTS `comptable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` char(30) NOT NULL,
  `prenom` char(30) NOT NULL,
  `login` char(20) NOT NULL,
  `mdp` char(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `comptable`
--

INSERT INTO `comptable` (`id`, `nom`, `prenom`, `login`, `mdp`) VALUES
(1, 'julien', 'julien', 'julien', '$2y$10$ZbJVprd5rNhsRkH7TpQxmu/G8nqT.WCxMafmxxkVKJ6vbJkOKk23e');

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `id` char(2) NOT NULL,
  `libelle` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('RB', 'Remboursée'),
('VA', 'Validée et mise en paiement');

-- --------------------------------------------------------

--
-- Structure de la table `fichefrais`
--

DROP TABLE IF EXISTS `fichefrais`;
CREATE TABLE IF NOT EXISTS `fichefrais` (
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `nbJustificatifs` int(11) DEFAULT NULL,
  `montantValide` decimal(10,2) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `idEtat` char(2) DEFAULT 'CR',
  PRIMARY KEY (`idVisiteur`,`mois`),
  KEY `idEtat` (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fichefrais`
--

INSERT INTO `fichefrais` (`idVisiteur`, `mois`, `nbJustificatifs`, `montantValide`, `dateModif`, `idEtat`) VALUES
('', '202009', 6, '569.00', '2020-09-10', 'CL'),
('', '202103', 0, '0.00', '2021-03-05', 'CR'),
('a131', '202009', 2, '2308.00', '2020-10-13', 'CL'),
('a131', '202010', 6, '500.00', '2020-10-14', 'CR'),
('a131', '202011', 0, '100000.00', '2021-03-05', 'CL'),
('a131', '202103', 0, '0.00', '2021-03-05', 'CR'),
('a17', '202009', 6, '500.00', '2020-09-10', 'CL'),
('a17', '202011', 0, '0.00', '2021-03-13', 'CL'),
('a17', '202103', 0, '0.00', '2021-03-13', 'CR'),
('e5', '202103', 6, '500.00', '2021-03-10', 'CL');

-- --------------------------------------------------------

--
-- Structure de la table `fraisforfait`
--

DROP TABLE IF EXISTS `fraisforfait`;
CREATE TABLE IF NOT EXISTS `fraisforfait` (
  `id` char(3) NOT NULL,
  `libelle` char(20) DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `fraisforfait`
--

INSERT INTO `fraisforfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '0.62'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `lignefraisforfait`
--

DROP TABLE IF EXISTS `lignefraisforfait`;
CREATE TABLE IF NOT EXISTS `lignefraisforfait` (
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `idFraisForfait` char(3) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVisiteur`,`mois`,`idFraisForfait`),
  KEY `idFraisForfait` (`idFraisForfait`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lignefraisforfait`
--

INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`, `idFraisForfait`, `quantite`) VALUES
('', '202103', 'ETP', 2000),
('', '202103', 'KM', 1000),
('', '202103', 'NUI', 865),
('', '202103', 'REP', 50),
('a131', '202011', 'ETP', 2000),
('a131', '202011', 'KM', 1125),
('a131', '202011', 'NUI', 10005),
('a131', '202011', 'REP', 1200),
('a131', '202103', 'ETP', 0),
('a131', '202103', 'KM', 0),
('a131', '202103', 'NUI', 0),
('a131', '202103', 'REP', 0),
('a17', '202011', 'ETP', 52),
('a17', '202011', 'KM', 41),
('a17', '202011', 'NUI', 25),
('a17', '202011', 'REP', 410),
('a17', '202103', 'ETP', 0),
('a17', '202103', 'KM', 0),
('a17', '202103', 'NUI', 0),
('a17', '202103', 'REP', 0);

-- --------------------------------------------------------

--
-- Structure de la table `lignefraishorsforfait`
--

DROP TABLE IF EXISTS `lignefraishorsforfait`;
CREATE TABLE IF NOT EXISTS `lignefraishorsforfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVisiteur` char(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `idEtat` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idVisiteur` (`idVisiteur`,`mois`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lignefraishorsforfait`
--

INSERT INTO `lignefraishorsforfait` (`id`, `idVisiteur`, `mois`, `libelle`, `date`, `dateModif`, `montant`, `idEtat`) VALUES
(2, 'a131', '202103', 'test', '2021-03-13', '2021-03-17', '400.00', 'RB'),
(6, 'a131', '202011', 'test', '2020-11-13', NULL, '400.00', 'CL'),
(8, 'a131', '202011', 'test', '2020-11-13', NULL, '100.00', 'CL'),
(9, 'a17', '202011', 'testss', '2021-08-23', NULL, '40.00', ''),
(15, '', '202103', 'test', '2020-11-13', '2021-03-17', '400.00', 'RE'),
(16, '', '202103', 'jules ferry', '2021-08-23', '2021-03-17', '40.00', 'RE');

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

DROP TABLE IF EXISTS `visiteur`;
CREATE TABLE IF NOT EXISTS `visiteur` (
  `id` char(4) NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `login` char(20) DEFAULT NULL,
  `mdp` char(100) DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateEmbauche`) VALUES
('', 'hugo', 'hugo', 'hugo', 'hugo', 'sfqf', 'sqfqf', 'sqfqs', NULL),
('a131', 'Villechalane', 'Louis', 'lvillachane', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21'),
('a17', 'Andre', 'David', 'dandre', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23'),
('a55', 'Bedos', 'Christian', 'cbedos', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12'),
('a93', 'Tusseau', 'Louis', 'ltusseau', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01'),
('b13', 'Bentot', 'Pascal', 'pbentot', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09'),
('b16', 'Bioret', 'Luc', 'lbioret', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11'),
('b19', 'Bunisset', 'Francis', 'fbunisset', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21'),
('b25', 'Bunisset', 'Denise', 'dbunisset', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '23 rue Manin', '75019', 'paris', '2010-12-05'),
('b28', 'Cacheux', 'Bernard', 'bcacheux', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '114 rue Blanche', '75017', 'Paris', '2009-11-12'),
('b34', 'Cadic', 'Eric', 'ecadic', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '123 avenue de la République', '75011', 'Paris', '2008-09-23'),
('b4', 'Charoze', 'Catherine', 'ccharoze', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '100 rue Petit', '75019', 'Paris', '2005-11-12'),
('b50', 'Clepkens', 'Christophe', 'cclepkens', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '12 allée des Anges', '93230', 'Romainville', '2003-08-11'),
('b59', 'Cottin', 'Vincenne', 'vcottin', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18'),
('c14', 'Daburon', 'François', 'fdaburon', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11'),
('c3', 'De', 'Philippe', 'pde', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '13 rue Barthes', '94000', 'Créteil', '2010-12-14'),
('c54', 'Debelle', 'Michel', 'mdebelle', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23'),
('d13', 'Debelle', 'Jeanne', 'jdebelle', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11'),
('d51', 'Debroise', 'Michel', 'mdebroise', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17'),
('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '14 Place d Arc', '45000', 'Orléans', '2005-11-12'),
('e24', 'Desnost', 'Pierre', 'pdesnost', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05'),
('e39', 'Dudouit', 'Frédéric', 'fdudouit', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01'),
('e49', 'Duncombe', 'Claude', 'cduncombe', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10'),
('e5', 'Enault-Pascreau', 'Céline', 'cenault', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '25 place de la gare', '23200', 'Gueret', '1995-09-01'),
('e52', 'Eynde', 'Valérie', 'veynde', '$2y$10$piVlNKO0y2DgT0QsMBXbde7YXtVb0lF3P.fkgWtdZLSHvLCBCksiu', '3 Grand Place', '13015', 'Marseille', '1999-11-01'),
('f21', 'Finck', 'Jacques', 'jfinck', 'mpb3t', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10'),
('f39', 'Frémont', 'Fernande', 'ffremont', 'xs5tq', '4 route de la mer', '13012', 'Allauh', '1998-10-01'),
('f4', 'Gest', 'Alain', 'agest', 'dywvt', '30 avenue de la mer', '13025', 'Berre', '1985-11-01');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `fichefrais`
--
ALTER TABLE `fichefrais`
  ADD CONSTRAINT `fichefrais_ibfk_1` FOREIGN KEY (`idEtat`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `fichefrais_ibfk_2` FOREIGN KEY (`idVisiteur`) REFERENCES `visiteur` (`id`);

--
-- Contraintes pour la table `lignefraisforfait`
--
ALTER TABLE `lignefraisforfait`
  ADD CONSTRAINT `lignefraisforfait_ibfk_1` FOREIGN KEY (`idVisiteur`,`mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`),
  ADD CONSTRAINT `lignefraisforfait_ibfk_2` FOREIGN KEY (`idFraisForfait`) REFERENCES `fraisforfait` (`id`);

--
-- Contraintes pour la table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  ADD CONSTRAINT `lignefraishorsforfait_ibfk_1` FOREIGN KEY (`idVisiteur`,`mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
