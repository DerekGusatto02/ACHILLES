-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 30, 2021 alle 14:18
-- Versione del server: 10.4.14-MariaDB
-- Versione PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `achilles`
--
CREATE DATABASE IF NOT EXISTS `achilles` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `achilles`;

-- --------------------------------------------------------

--
-- Struttura della tabella `autore`
--

CREATE TABLE `autore` (
  `idAutore` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `sesso` varchar(1) DEFAULT NULL,
  `nazionalita` varchar(40) NOT NULL,
  `dataNascita` date NOT NULL,
  `dataMorte` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `autore`
--

INSERT INTO `autore` (`idAutore`, `nome`, `cognome`, `sesso`, `nazionalita`, `dataNascita`, `dataMorte`) VALUES
(1, 'Medeline', 'Miller', 'F', 'americana', '1978-07-24', NULL),
(2, 'Luigi', 'Pirandello', 'M', 'italiana', '1867-06-28', '1936-12-10'),
(3, 'Juno', 'Dawson', NULL, 'inglese', '1981-07-10', NULL),
(4, 'John', 'Green', 'M', 'americana', '1977-08-24', NULL),
(5, 'Niccolò', 'Ammaniti', 'M', 'italiana', '1966-09-25', NULL),
(6, 'Angie', 'Thomas', 'F', 'americana', '1988-09-20', NULL),
(7, 'Herbie', 'Brennan', 'M', 'inglese', '1940-07-05', NULL),
(8, 'Benjamin', 'Alire Sáenz', 'M', 'messicana', '1954-08-16', NULL),
(9, 'Italo', 'Svevo', 'M', 'italiana', '1861-12-19', '1928-09-13');

-- --------------------------------------------------------

--
-- Struttura della tabella `biblioteca`
--

CREATE TABLE `biblioteca` (
  `idBiblioteca` int(11) NOT NULL,
  `denominazione` varchar(50) NOT NULL,
  `via` varchar(40) NOT NULL,
  `numCivico` varchar(4) NOT NULL,
  `cap` varchar(5) NOT NULL,
  `fkComune` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `biblioteca`
--

INSERT INTO `biblioteca` (`idBiblioteca`, `denominazione`, `via`, `numCivico`, `cap`, `fkComune`) VALUES
(1, 'Biblioteca di Montebelluna', 'Largo Dieci Martiri', '1', '31044', 5),
(2, 'Biblioteca di Possagno', 'Via Molinetto', '10', '31054', 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `collocazione`
--

CREATE TABLE `collocazione` (
  `codice` int(11) NOT NULL,
  `sezione` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `collocazione`
--

INSERT INTO `collocazione` (`codice`, `sezione`) VALUES
(111, 'Letteratura italiana'),
(222, 'Letteratura americana'),
(333, 'Letteratura inglese'),
(444, 'Bambini'),
(555, 'Ragazzi');

-- --------------------------------------------------------

--
-- Struttura della tabella `comprendere`
--

CREATE TABLE `comprendere` (
  `fkGenere` int(11) NOT NULL,
  `fkLibro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `comprendere`
--

INSERT INTO `comprendere` (`fkGenere`, `fkLibro`) VALUES
(1, 5),
(2, 7),
(2, 8),
(4, 1),
(4, 2),
(4, 4),
(4, 6),
(5, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `comune`
--

CREATE TABLE `comune` (
  `idComune` int(11) NOT NULL,
  `comune` varchar(40) NOT NULL,
  `provincia` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `comune`
--

INSERT INTO `comune` (`idComune`, `comune`, `provincia`) VALUES
(2, 'Roma', 'Roma'),
(3, 'Torino', 'Torino'),
(4, 'Milano', 'Milano'),
(5, 'Montebelluna', 'Treviso'),
(6, 'Possagno', 'Treviso'),
(7, 'San Zenone degli Ezzelini', 'Vicenza'),
(8, 'Firenze', 'Firenze'),
(9, 'Asolo', 'Treviso'),
(10, 'Monfumo', 'Treviso');

-- --------------------------------------------------------

--
-- Struttura della tabella `editore`
--

CREATE TABLE `editore` (
  `idEditore` int(11) NOT NULL,
  `denominazione` varchar(40) NOT NULL,
  `via` varchar(40) NOT NULL,
  `numCivico` varchar(4) NOT NULL,
  `cap` varchar(5) NOT NULL,
  `fkComune` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `editore`
--

INSERT INTO `editore` (`idEditore`, `denominazione`, `via`, `numCivico`, `cap`, `fkComune`) VALUES
(2, 'Einaudi', 'Via Biancamano', '2', '10121', 3),
(3, 'Mondadori', 'Via Roma', '65', '20090', 4),
(4, 'Edizioni e/o', 'Via Gabriele Camozzi', '1', '00195', 2),
(5, 'Feltrinelli', 'via Tucidide', '56', '20134', 4),
(6, 'Rizzoli', 'via Bianca di Savoia', '12', '20122', 4),
(7, 'Giunti', 'via Bolognese', '165', '50139', 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `genere`
--

CREATE TABLE `genere` (
  `idGenere` int(11) NOT NULL,
  `descrizione` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `genere`
--

INSERT INTO `genere` (`idGenere`, `descrizione`) VALUES
(1, 'fantasy'),
(2, 'classico'),
(3, 'giallo'),
(4, 'contemporary'),
(5, 'storico'),
(6, 'saggio');

-- --------------------------------------------------------

--
-- Struttura della tabella `libro`
--

CREATE TABLE `libro` (
  `idLibro` int(11) NOT NULL,
  `titolo` varchar(100) NOT NULL,
  `lingua` varchar(100) NOT NULL,
  `immagine` varchar(150) DEFAULT NULL,
  `anno` int(11) NOT NULL,
  `numPagine` int(11) NOT NULL,
  `prezzo` decimal(6,2) DEFAULT NULL,
  `ISBN` varchar(13) NOT NULL,
  `fkEditore` int(11) NOT NULL,
  `fkCollocazione` int(11) NOT NULL,
  `fkBiblioteca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `libro`
--

INSERT INTO `libro` (`idLibro`, `titolo`, `lingua`, `immagine`, `anno`, `numPagine`, `prezzo`, `ISBN`, `fkEditore`, `fkCollocazione`, `fkBiblioteca`) VALUES
(1, 'Io non ho paura', 'italiano', './images/iononhopaura.jpg', 2011, 230, '11.00', '9788806207694', 3, 111, 2),
(2, 'Aristotele e Dante scoprono i segreti dell\'universo ', 'inglese', './images/aristoteleedante.jpg', 2012, 358, '10.00', '9781442408937', 7, 222, 2),
(3, 'La canzone di Achille', 'italiano', './images/canzonediachille.jpg', 2013, 379, '12.00', '9788807893469', 5, 222, 2),
(4, 'Colpa delle Stelle', 'italiano', './images/colpadellestelle.jpg', 2015, 347, '13.00', '9788817081566', 6, 333, 2),
(5, 'La guerra degli Elfi', 'inglese', './images/guerradeglielfi.jpg', 2013, 315, '10.00', '9788804530268', 3, 222, 2),
(6, 'The hate you give', 'inglese', './images/hateyougive.jpg', 2017, 410, '14.00', '9788809836402', 7, 222, 2),
(7, 'Il fu Mattia Pascal', 'italiano', './images/mattiapascal.jpg', 2014, 302, '9.00', '9788806219116', 2, 111, 1),
(8, 'La coscienza di Zeno', 'italiano', './images/coscienzazeno.jpg', 2014, 364, '13.00', '9788806222444', 2, 111, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `prestito`
--

CREATE TABLE `prestito` (
  `idPrestito` int(11) NOT NULL,
  `dataInizio` datetime NOT NULL DEFAULT current_timestamp(),
  `dataFine` datetime NOT NULL,
  `rientrato` tinyint(1) NOT NULL DEFAULT 0,
  `prorogato` tinyint(1) NOT NULL DEFAULT 0,
  `fkLibro` int(11) NOT NULL,
  `fkUtente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `prestito`
--

INSERT INTO `prestito` (`idPrestito`, `dataInizio`, `dataFine`, `rientrato`, `prorogato`, `fkLibro`, `fkUtente`) VALUES
(31, '2021-05-23 11:15:09', '2022-08-16 11:15:09', 1, 0, 1, 1),
(32, '2021-05-25 17:05:11', '2021-06-09 17:05:11', 0, 0, 4, 1),
(41, '2021-05-27 17:39:57', '2021-07-11 17:39:57', 0, 1, 5, 1),
(42, '2021-05-30 13:17:55', '2021-06-29 13:17:55', 0, 0, 8, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `scrivere`
--

CREATE TABLE `scrivere` (
  `fkAutore` int(11) NOT NULL,
  `fkLibro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `scrivere`
--

INSERT INTO `scrivere` (`fkAutore`, `fkLibro`) VALUES
(1, 3),
(2, 7),
(4, 4),
(5, 1),
(6, 6),
(7, 5),
(8, 2),
(9, 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `idUtente` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `dataNascita` date NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `via` varchar(50) NOT NULL,
  `numCivico` varchar(4) NOT NULL,
  `cap` varchar(5) NOT NULL,
  `ruolo` varchar(20) NOT NULL DEFAULT 'user',
  `fkComune` int(11) NOT NULL,
  `fkBiblioteca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`idUtente`, `username`, `password`, `email`, `nome`, `cognome`, `dataNascita`, `telefono`, `via`, `numCivico`, `cap`, `ruolo`, `fkComune`, `fkBiblioteca`) VALUES
(1, 'gusattoderek', 'e981335aba70fec46acb8b5df3f0b4e91d4ea589', 'gusattoderek@gmail.com', 'Derek', 'Gusatto', '2002-06-06', '3314996861', 'via Cunial', '63', '31054', 'bibliotecario', 6, 2),
(4, 'pandolfoenrico', 'a83c59fdc1868bf9c49ac1f62b1aa388797e8998', 'enrico.pandolfo02@gmail.com', 'Enrico', 'Pandolfo', '2002-12-26', '3200767272', 'via Chiesa Castelli', '7', '31010', 'user', 10, 2),
(5, 'bandieramattia', '6cac480c2985025f80e437975093ec05de7f845a', 'mattia.bandiera10@gmail.com', 'Mattia', 'Bandiera', '2002-05-10', '3405190023', 'via della Salute', '8', '31011', 'user', 9, 1),
(6, 'zanattalorenzo', 'b365c51956790d0b1c3f5fde614a676630e1e55b', 'zanataalorenzo@gmail.com', 'Lorenzo', 'Zanatta', '2001-06-10', '3454952060', 'via dei martiri', '22', '31044', 'user', 5, 1),
(7, 'montagnermattia', '3e44b941f0004290a9683ebb1d6ce3eba3c647d7', 'mattiamontagner2002@gmail.com', 'Mattia', 'Montagner', '2002-09-28', '3474307246', 'via Martinella', '26', '31044', 'bibliotecario', 5, 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `autore`
--
ALTER TABLE `autore`
  ADD PRIMARY KEY (`idAutore`);

--
-- Indici per le tabelle `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD PRIMARY KEY (`idBiblioteca`),
  ADD KEY `fkComune` (`fkComune`);

--
-- Indici per le tabelle `collocazione`
--
ALTER TABLE `collocazione`
  ADD PRIMARY KEY (`codice`);

--
-- Indici per le tabelle `comprendere`
--
ALTER TABLE `comprendere`
  ADD PRIMARY KEY (`fkGenere`,`fkLibro`),
  ADD KEY `fkLibro` (`fkLibro`);

--
-- Indici per le tabelle `comune`
--
ALTER TABLE `comune`
  ADD PRIMARY KEY (`idComune`);

--
-- Indici per le tabelle `editore`
--
ALTER TABLE `editore`
  ADD PRIMARY KEY (`idEditore`),
  ADD KEY `fkComune` (`fkComune`);

--
-- Indici per le tabelle `genere`
--
ALTER TABLE `genere`
  ADD PRIMARY KEY (`idGenere`);

--
-- Indici per le tabelle `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`idLibro`),
  ADD KEY `fkBiblioteca` (`fkBiblioteca`),
  ADD KEY `fkCollozazione` (`fkCollocazione`),
  ADD KEY `fkEditore` (`fkEditore`);

--
-- Indici per le tabelle `prestito`
--
ALTER TABLE `prestito`
  ADD PRIMARY KEY (`idPrestito`),
  ADD KEY `fkLibro` (`fkLibro`),
  ADD KEY `fkUtente` (`fkUtente`);

--
-- Indici per le tabelle `scrivere`
--
ALTER TABLE `scrivere`
  ADD PRIMARY KEY (`fkAutore`,`fkLibro`),
  ADD KEY `fkLibro` (`fkLibro`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`idUtente`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fkComune` (`fkComune`),
  ADD KEY `fkBiblioteca` (`fkBiblioteca`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `autore`
--
ALTER TABLE `autore`
  MODIFY `idAutore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `biblioteca`
--
ALTER TABLE `biblioteca`
  MODIFY `idBiblioteca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `comune`
--
ALTER TABLE `comune`
  MODIFY `idComune` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `editore`
--
ALTER TABLE `editore`
  MODIFY `idEditore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `genere`
--
ALTER TABLE `genere`
  MODIFY `idGenere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `libro`
--
ALTER TABLE `libro`
  MODIFY `idLibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `prestito`
--
ALTER TABLE `prestito`
  MODIFY `idPrestito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `idUtente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD CONSTRAINT `biblioteca_ibfk_1` FOREIGN KEY (`fkComune`) REFERENCES `comune` (`idComune`);

--
-- Limiti per la tabella `comprendere`
--
ALTER TABLE `comprendere`
  ADD CONSTRAINT `comprendere_ibfk_1` FOREIGN KEY (`fkGenere`) REFERENCES `genere` (`idGenere`),
  ADD CONSTRAINT `comprendere_ibfk_2` FOREIGN KEY (`fkLibro`) REFERENCES `libro` (`idLibro`);

--
-- Limiti per la tabella `editore`
--
ALTER TABLE `editore`
  ADD CONSTRAINT `editore_ibfk_1` FOREIGN KEY (`fkComune`) REFERENCES `comune` (`idComune`);

--
-- Limiti per la tabella `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`fkBiblioteca`) REFERENCES `biblioteca` (`idBiblioteca`),
  ADD CONSTRAINT `libro_ibfk_3` FOREIGN KEY (`fkEditore`) REFERENCES `editore` (`idEditore`),
  ADD CONSTRAINT `libro_ibfk_4` FOREIGN KEY (`fkCollocazione`) REFERENCES `collocazione` (`codice`);

--
-- Limiti per la tabella `prestito`
--
ALTER TABLE `prestito`
  ADD CONSTRAINT `prestito_ibfk_1` FOREIGN KEY (`fkLibro`) REFERENCES `libro` (`idLibro`),
  ADD CONSTRAINT `prestito_ibfk_2` FOREIGN KEY (`fkUtente`) REFERENCES `utente` (`idUtente`);

--
-- Limiti per la tabella `scrivere`
--
ALTER TABLE `scrivere`
  ADD CONSTRAINT `scrivere_ibfk_1` FOREIGN KEY (`fkAutore`) REFERENCES `autore` (`idAutore`),
  ADD CONSTRAINT `scrivere_ibfk_2` FOREIGN KEY (`fkLibro`) REFERENCES `libro` (`idLibro`);

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`fkComune`) REFERENCES `comune` (`idComune`),
  ADD CONSTRAINT `utente_ibfk_2` FOREIGN KEY (`fkBiblioteca`) REFERENCES `biblioteca` (`idBiblioteca`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
