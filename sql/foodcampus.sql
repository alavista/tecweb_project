-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 29, 2018 alle 00:33
-- Versione del server: 10.1.37-MariaDB
-- Versione PHP: 7.3.0

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
(5, 'dolce'),
(2, 'piada'),
(1, 'pizza'),
(3, 'primo'),
(4, 'secondo'),
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
  `immagine` varchar(128) DEFAULT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `bloccato` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `cliente`
--

INSERT INTO `cliente` (`IDCliente`, `nome`, `cognome`, `email`, `immagine`, `password`, `salt`, `bloccato`) VALUES
(1, 'Andrea', 'Lavista', 'andrea.lavista@foodcampus.it', NULL, '72531aa0b0c1013b040cf3096a6a1fab3871ad7cf056978178c214d526c60ad4a11cf04aef2c3a25d6c8918f0c9826351238022b2aa191e27f8c152cbbfc7443', 'c69d48dcdd2cf8470fe5d591a43de56f83afa8f40a94be3ac4ba56be309374ac7ebb5f55f594e8fb58ac0538f93e4e487db11f07dd8fa66adf834acc1188ab80', b'0'),
(2, 'Ivan', 'Mazzanti', 'ivan.mazzanti@foodcampus.it', NULL, 'dc5cc79d08a9d9a9aff7a8479a369d0d115c0cad60c6e37fc3d09045e149bba2ebaba6634d7138bb078a4c52835259636fa2320bd051200091f2c49afe8184e3', '80244477758499b2f497c27a5230469555cee54485bddd0953a53d01b8a8b19bf678c5eed10860c02870a73e72c4c379d1620ac3f9c2b82960beafa62cb0f9ce', b'0'),
(3, 'Davide', 'Conti', 'davide.conti@foodcampus.it', NULL, 'b6b0961c00ab90e110b032b2ae5fee1201e15bab1c1d966c71e9bfe6f314b49bbb8fa471c621dec8b6af403a35307fc29baf4f0a44b8bf2c8d8e94564582aa1a', 'd56fd21aa39d58f9903f2acb37db2bfb33500ca5d8a1b7db980b3e7f0f94bcb4ee9676b106717e049c9144d775f92702064c8a2da7591b495119a935c7333a44', b'0'),
(8, 'asd', 'asd', 'asd@asd.it', 'Immagine.png', '66c510a986c893407187b7317f0a2552509c5862d3d4958ad57183e269526afdf482f767fd5767057e0c6f28f58179f482095fafb003a3119f1f0ac72722ac3c', '0ca700f882737a9057cbf059c2a1631093b6895b066dc2f4984080315af3a99ebd24d70911b5213a23aac1caaf037982153364219140671cdf4c934ce8bb9080', b'0');

-- --------------------------------------------------------

--
-- Struttura della tabella `fornitore`
--

CREATE TABLE `fornitore` (
  `IDFornitore` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `citta` varchar(30) NOT NULL,
  `indirizzo_via` varchar(30) NOT NULL,
  `indirizzo_numero_civico` varchar(11) NOT NULL,
  `costi_spedizione` decimal(4,2) NOT NULL,
  `soglia_spedizione_gratuita` decimal(4,2) DEFAULT NULL,
  `abilitato` tinyint(1) NOT NULL,
  `email` varchar(30) NOT NULL,
  `sito_web` varchar(60) DEFAULT NULL,
  `partita_iva` varchar(11) NOT NULL,
  `immagine` varchar(128) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `bloccato` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `fornitore`
--

INSERT INTO `fornitore` (`IDFornitore`, `nome`, `citta`, `indirizzo_via`, `indirizzo_numero_civico`, `costi_spedizione`, `soglia_spedizione_gratuita`, `abilitato`, `email`, `sito_web`, `partita_iva`, `immagine`, `password`, `salt`, `bloccato`) VALUES
(1, 'La Malaghiotta', 'Cesena', 'piazza Fabbri', '5', '0.99', NULL, 1, 'lamalaghiotta@gmail.com', 'www.lamaghiotta.it', '01786610897', NULL, '9b3634a5368b48ff6bacb473d169cfc07265cedd041cb80f332823d1908ce86c4db4c221870cbf6409669daebf569d6e2633d93c78d14582f8dd9e0a265b0397', 'a9dcc91bc4d2e60237f163c83612a74ac5d7c2a9903f801e03c1f26dd8d399ed1aafdfbfcd99e98e0610ca85f26f8b2acdd7f1e567021c49a717b1cfb90c08f3', b'0'),
(2, 'C\'entro', 'Cesena', 'contrada Uberti', '3', '0.99', '0.99', 1, 'centro@gmail.com', 'www.centro-cesena.it', '01993190741', NULL, '9b3634a5368b48ff6bacb473d169cfc07265cedd041cb80f332823d1908ce86c4db4c221870cbf6409669daebf569d6e2633d93c78d14582f8dd9e0a265b0397', 'a9dcc91bc4d2e60237f163c83612a74ac5d7c2a9903f801e03c1f26dd8d399ed1aafdfbfcd99e98e0610ca85f26f8b2acdd7f1e567021c49a717b1cfb90c08f3', b'0'),
(3, 'Buttterfly', 'Cesena', 'via Cesare Battisti', '185', '0.99', '0.99', 1, 'butterfly@gmail.com', 'http://www.japaneserestaurantbutterfly.it', '05359681003', '', '9b3634a5368b48ff6bacb473d169cfc07265cedd041cb80f332823d1908ce86c4db4c221870cbf6409669daebf569d6e2633d93c78d14582f8dd9e0a265b0397', 'a9dcc91bc4d2e60237f163c83612a74ac5d7c2a9903f801e03c1f26dd8d399ed1aafdfbfcd99e98e0610ca85f26f8b2acdd7f1e567021c49a717b1cfb90c08f3', b'0'),
(7, 'asd', 'asd', 'asd', 'asd', '8.00', '10.00', 0, 'asd@asd.com', 'asdasda', 'asd', 'Immagine.png', '9b3634a5368b48ff6bacb473d169cfc07265cedd041cb80f332823d1908ce86c4db4c221870cbf6409669daebf569d6e2633d93c78d14582f8dd9e0a265b0397', 'a9dcc91bc4d2e60237f163c83612a74ac5d7c2a9903f801e03c1f26dd8d399ed1aafdfbfcd99e98e0610ca85f26f8b2acdd7f1e567021c49a717b1cfb90c08f3', b'0');

-- --------------------------------------------------------

--
-- Struttura della tabella `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `email`, `time`) VALUES
(1, 'ivan.mazzanti@foodcampus.it', '1545933977'),
(2, 'centro@gmail.com', '1545934478');

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
(1, 'Crescione erbe e salsiccia', '3.50', 2, 3),
(2, 'Crescione vegetariano', '3.50', 2, 3),
(3, 'Piada crudo squacquerone e rucola', '4.50', 2, 3),
(4, 'Crescione erbe e salsiccia', '3.50', 2, 3),
(5, 'Crescione erbe e salsiccia', '3.50', 2, 3),
(6, 'Spaghetti alla carbonara', '4.50', 3, 3),
(7, 'Pollo al curry', '5.00', 4, 3),
(8, 'Zuppa inglese', '2.50', 5, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto_in_carrello`
--

CREATE TABLE `prodotto_in_carrello` (
  `IDProdottoInCarrello` int(11) NOT NULL,
  `IDProdotto` int(11) NOT NULL,
  `IDCliente` int(11) NOT NULL,
  `quantità` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto_in_ordine`
--

CREATE TABLE `prodotto_in_ordine` (
  `IDProdottoInOrdine` int(11) NOT NULL,
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
  `valutazione` float NOT NULL,
  `IDCliente` int(11) NOT NULL,
  `IDFornitore` int(11) NOT NULL,
  `titolo` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `recensione`
--

INSERT INTO `recensione` (`IDRecensione`, `commento`, `valutazione`, `IDCliente`, `IDFornitore`, `titolo`) VALUES
(1, 'Servizio ottimo!', 5, 1, 1, 'Consiglio!'),
(2, 'Buoni i secondi piatti, i primi dipende dai giorni', 4, 3, 2, 'Consiglio per i primi piatti!'),
(3, 'Buon rapporto qualità prezzo, buoni primi e secondi, sconsiglio i dolci', 4, 3, 2, 'Buon rapporto qualità/prezzo');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`IDCategoria`),
  ADD UNIQUE KEY `nome` (`nome`);

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
-- Indici per le tabelle `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`IDProdottoInCarrello`),
  ADD KEY `FKcar_PRO` (`IDProdotto`),
  ADD KEY `FKcar_CLI` (`IDCliente`);

--
-- Indici per le tabelle `prodotto_in_ordine`
--
ALTER TABLE `prodotto_in_ordine`
  ADD PRIMARY KEY (`IDProdottoInOrdine`),
  ADD KEY `FKcon_PRO` (`IDProdotto`),
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
  MODIFY `IDCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `fornitore`
--
ALTER TABLE `fornitore`
  MODIFY `IDFornitore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `IDProdottoInCarrello` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `prodotto_in_ordine`
--
ALTER TABLE `prodotto_in_ordine`
  MODIFY `IDProdottoInOrdine` int(11) NOT NULL AUTO_INCREMENT;

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
