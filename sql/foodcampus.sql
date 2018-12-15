-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 14, 2018 alle 10:36
-- Versione del server: 10.1.36-MariaDB
-- Versione PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodcampus`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `IDCategoria` int(11) NOT NULL,
  `nome` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`IDCategoria`, `nome`) VALUES
(1, 'pizza'),
(2, 'piada'),
(3, 'primo'),
(4, 'secondo'),
(5, 'dolce'),
(6, 'sushi');

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

CREATE TABLE `cliente` (
  `IDCliente` int(11) NOT NULL,
  `nome` char(30) NOT NULL,
  `cognome` char(30) NOT NULL,
  `email` char(30) NOT NULL,
  `password` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `cliente`
--

INSERT INTO `cliente` (`IDCliente`, `nome`, `cognome`, `email`, `password`) VALUES
(1, 'Andrea', 'Lavista', 'andrea.lavista@foodcampus.it', 'andrea'),
(2, 'Ivan', 'Mazzanti', 'ivan.mazzanti@foodcampus.it', 'ivan'),
(3, 'Davide', 'Conti', 'davide.conti@foodcampus.it', 'davide');

-- --------------------------------------------------------

--
-- Struttura della tabella `fornitore`
--

CREATE TABLE `fornitore` (
  `IDFornitore` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `sito_web` varchar(40) NOT NULL,
  `città` char(30) NOT NULL,
  `indirizzo_via` varchar(30) NOT NULL,
  `indirizzo_numero_civico` int(11) NOT NULL,
  `costi_spedizione` decimal(4,2) NOT NULL,
  `soglia_spedizione_gratuita` decimal(4,2) DEFAULT NULL,
  `abilitato` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `fornitore`
--

INSERT INTO `fornitore` (`IDFornitore`, `nome`, `sito_web`, `città`, `indirizzo_via`, `indirizzo_numero_civico`, `costi_spedizione`, `soglia_spedizione_gratuita`, `abilitato`) VALUES
(1, 'La Malaghiotta', 'www.lamalaghiotta.it', 'Cesena', 'piazza Fabbri', 5, '0.99', NULL, 1),
(2, 'C\'entro', 'www.centro-cesena.it', 'Cesena', 'contrada Uberti', 3, '0.99', '0.99', 1),
(3, 'Buttterfly', 'http://www.japaneserestaurantbutterfly.i', 'Cesena', 'via Cesare Battisti', 185, '0.99', '0.99', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica`
--

CREATE TABLE `notifica` (
  `IDNotifica` int(11) NOT NULL,
  `testo` char(100) NOT NULL,
  `visualizzata` tinyint(1) NOT NULL,
  `IDCliente` int(11) DEFAULT NULL,
  `IDFornitore` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `IDOrdine` int(11) NOT NULL,
  `prezzo` decimal(5,2) NOT NULL,
  `tipo_pagamento` char(20) NOT NULL,
  `orario_consegna_ora` int(11) NOT NULL,
  `orario_consegna_minuti` int(11) NOT NULL,
  `IDCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE `prodotto` (
  `IDProdotto` int(11) NOT NULL,
  `nome` char(50) NOT NULL,
  `costo` decimal(4,2) NOT NULL,
  `IDCategoria` int(11) NOT NULL,
  `IDFornitore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`IDProdotto`, `nome`, `costo`, `IDCategoria`, `IDFornitore`) VALUES
(1, 'Crescione erbe e salsiccia', '3.50', 2, 1),
(2, 'Crescione vegetariano', '3.50', 2, 1),
(3, 'Piada crudo squacquerone e rucola', '4.50', 2, 1),
(4, 'Crescione erbe e salsiccia', '3.50', 2, 1),
(5, 'Crescione erbe e salsiccia', '3.50', 2, 1),
(6, 'Spaghetti alla carbonara', '4.50', 3, 1),
(7, 'Pollo al curry', '5.00', 4, 1),
(8, 'Zuppa inglese', '2.50', 5, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto_in_carrello`
--

CREATE TABLE `prodotto_in_carrello` (
  `IDProdotto` int(11) NOT NULL,
  `IDCliente` int(11) NOT NULL,
  `quantità` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto_in_ordine`
--

CREATE TABLE `prodotto_in_ordine` (
  `IDProdotto` int(11) NOT NULL,
  `IDOrdine` int(11) NOT NULL,
  `quantità` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `recensione`
--

CREATE TABLE `recensione` (
  `IDRecensione` int(11) NOT NULL,
  `commento` char(100) NOT NULL,
  `valutazione` int(11) NOT NULL,
  `IDCliente` int(11) NOT NULL,
  `IDFornitore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `recensione`
--

INSERT INTO `recensione` (`IDRecensione`, `commento`, `valutazione`, `IDCliente`, `IDFornitore`) VALUES
(1, 'Servizio ottimo!', 5, 1, 1),
(2, 'Buoni i secondi piatti, i primi dipende dai giorni', 4, 1, 2),
(3, 'Buon rapporto qualità prezzo, buoni primi e secondi, sconsiglio i dolci', 4, 3, 2);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`IDCategoria`);

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`IDCliente`);

--
-- Indici per le tabelle `fornitore`
--
ALTER TABLE `fornitore`
  ADD PRIMARY KEY (`IDFornitore`);

--
-- Indici per le tabelle `notifica`
--
ALTER TABLE `notifica`
  ADD PRIMARY KEY (`IDNotifica`);

--
-- Indici per le tabelle `ordine`
--
ALTER TABLE `ordine`
  ADD PRIMARY KEY (`IDOrdine`),
  ADD KEY `FKeffettua` (`IDCliente`);

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`IDProdotto`),
  ADD KEY `FKafferisce` (`IDCategoria`),
  ADD KEY `FKinserisce` (`IDFornitore`);

--
-- Indici per le tabelle `prodotto_in_carrello`
--
ALTER TABLE `prodotto_in_carrello`
  ADD PRIMARY KEY (`IDProdotto`),
  ADD KEY `FKcar_PRO` (`IDProdotto`),
  ADD KEY `FKcar_CLI` (`IDCliente`);

--
-- Indici per le tabelle `prodotto_in_ordine`
--
ALTER TABLE `prodotto_in_ordine`
  ADD PRIMARY KEY (`IDProdotto`),
  ADD KEY `FKcon_ORD` (`IDOrdine`);

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`IDRecensione`),
  ADD KEY `FKscrive` (`IDCliente`),
  ADD KEY `FKriceve` (`IDFornitore`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `IDCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IDCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `fornitore`
--
ALTER TABLE `fornitore`
  MODIFY `IDFornitore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `IDNotifica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `IDOrdine` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  MODIFY `IDProdotto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `prodotto_in_carrello`
--
ALTER TABLE `prodotto_in_carrello`
  MODIFY `IDProdotto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `prodotto_in_ordine`
--
ALTER TABLE `prodotto_in_ordine`
  MODIFY `IDProdotto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `IDRecensione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `ordine`
--
ALTER TABLE `ordine`
  ADD CONSTRAINT `FKeffettua` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`);

--
-- Limiti per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  ADD CONSTRAINT `FKafferisce` FOREIGN KEY (`IDCategoria`) REFERENCES `categoria` (`IDCategoria`),
  ADD CONSTRAINT `FKinserisce` FOREIGN KEY (`IDFornitore`) REFERENCES `fornitore` (`IDFornitore`);

--
-- Limiti per la tabella `prodotto_in_carrello`
--
ALTER TABLE `prodotto_in_carrello`
  ADD CONSTRAINT `FKcar_CLI` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`),
  ADD CONSTRAINT `FKcar_PRO` FOREIGN KEY (`IDProdotto`) REFERENCES `prodotto` (`IDProdotto`);

--
-- Limiti per la tabella `prodotto_in_ordine`
--
ALTER TABLE `prodotto_in_ordine`
  ADD CONSTRAINT `FKcon_ORD` FOREIGN KEY (`IDOrdine`) REFERENCES `ordine` (`IDOrdine`),
  ADD CONSTRAINT `FKcon_PRO` FOREIGN KEY (`IDProdotto`) REFERENCES `prodotto` (`IDProdotto`);

--
-- Limiti per la tabella `recensione`
--
ALTER TABLE `recensione`
  ADD CONSTRAINT `FKriceve` FOREIGN KEY (`IDFornitore`) REFERENCES `fornitore` (`IDFornitore`),
  ADD CONSTRAINT `FKscrive` FOREIGN KEY (`IDCliente`) REFERENCES `cliente` (`IDCliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
