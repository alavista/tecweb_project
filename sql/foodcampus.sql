-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 21, 2019 alle 00:53
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
(5, 'Dolce'),
(7, 'Panino'),
(2, 'Piada'),
(1, 'Pizza'),
(3, 'Primo'),
(4, 'Secondo'),
(6, 'Sushi');

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
(1, 'Andrea', 'Lavista', 'andrea.lavista@foodcampus.it', NULL, 'b324e6e0c6ad7faa1a9a282c05337173564ac26441f6686ff96e9a5b4bc356303c684a3cda277f81de2ed7144c91264a711d92a0a64e9f55b26eb039d10af932', '10598d7e0f3313f4543265e2947a72eda3a876d3a1f8dde55338c8b5e79669dbecbe8763a45df83ed2e6a05977cd5fac62900aba317a3f588bc2580faa31a5be', b'0'),
(2, 'Ivan', 'Mazzanti', 'ivan.mazzantix@gmail.com', NULL, '01803711b7517a3d4f0d3a5c0cd80fd3b78638daea271862f9f5d1b838991ece73e6f67694c9b29ae7b735f310fa64844a296c806f0f7e5a7e9fa6c753f2f296', '95d798847370cd5aa834e12c777bb66d004fb3403414c85c91ce0ab1dfa74283ff4d1afa48b12e8423a36fcd849cf13f9e187e59dd6046cc74c326f040dc7377', b'0'),
(3, 'Davide', 'Conti', 'davide.conti@foodcampus.it', NULL, 'b6b0961c00ab90e110b032b2ae5fee1201e15bab1c1d966c71e9bfe6f314b49bbb8fa471c621dec8b6af403a35307fc29baf4f0a44b8bf2c8d8e94564582aa1a', 'd56fd21aa39d58f9903f2acb37db2bfb33500ca5d8a1b7db980b3e7f0f94bcb4ee9676b106717e049c9144d775f92702064c8a2da7591b495119a935c7333a44', b'0'),
(8, 'asd', 'asd', 'asd@asd.it', 'Immagine.png', '66c510a986c893407187b7317f0a2552509c5862d3d4958ad57183e269526afdf482f767fd5767057e0c6f28f58179f482095fafb003a3119f1f0ac72722ac3c', '0ca700f882737a9057cbf059c2a1631093b6895b066dc2f4984080315af3a99ebd24d70911b5213a23aac1caaf037982153364219140671cdf4c934ce8bb9080', b'1'),
(9, 'Andrea', 'Lavista', 'andrealavista@gmail.com', NULL, 'de8176cd2c0a0f678b45b050345fc6afc80cc405f99cf877bed89c7d2ada6a5eb0e2a689bb3c79c9bbd2c194970035adb9fc6fcf4772cb16ce8a55797b9628e0', '0d1bc84a268671b397775102a0f549376fd1a43236cf8f6acc8d1b6105f28a8898fdf82e2d9e1f6e86b574f9799cff6d53aac62d5268599a1f483a8950cb8498', b'0');

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
  `partita_iva` bigint(11) NOT NULL,
  `immagine` varchar(128) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `bloccato` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `fornitore`
--

INSERT INTO `fornitore` (`IDFornitore`, `nome`, `citta`, `indirizzo_via`, `indirizzo_numero_civico`, `costi_spedizione`, `soglia_spedizione_gratuita`, `abilitato`, `email`, `sito_web`, `partita_iva`, `immagine`, `password`, `salt`, `bloccato`) VALUES
(1, 'La Malaghiotta', 'Cesena', 'piazza Fabbri', '5', '0.99', '0.00', 1, 'lamalaghiotta@gmail.com', 'www.lamaghiotta.it', 1786610897, 'Immagine.png', '8af51af82522ad632d7e1f0f638f4219b6e6379f3a3dbb08b7cbdae8b443d90b942ca644c7dd86140972ca24db019d4fd0cbfe3a737f00d95819eb74963fb5b5', '6dbe889c9f4c64b462252621f66aaa589ee26cc7321cc748da7770dd20feda5dd1fb748addf51776f2bf06964b904d81793493587e6d9684ab6ee1b080d6d07f', b'0'),
(2, 'C\'entro', 'Cesena', 'contrada Uberti', '3', '0.99', '0.99', 1, 'centro@gmail.com', 'www.centro-cesena.it', 1993190741, NULL, '9b3634a5368b48ff6bacb473d169cfc07265cedd041cb80f332823d1908ce86c4db4c221870cbf6409669daebf569d6e2633d93c78d14582f8dd9e0a265b0397', 'a9dcc91bc4d2e60237f163c83612a74ac5d7c2a9903f801e03c1f26dd8d399ed1aafdfbfcd99e98e0610ca85f26f8b2acdd7f1e567021c49a717b1cfb90c08f3', b'0'),
(3, 'Buttterfly', 'Cesena', 'via Cesare Battisti', '185', '0.99', '0.99', 1, 'butterfly@gmail.com', 'http://www.japaneserestaurantbutterfly.it', 2147483647, NULL, '9b3634a5368b48ff6bacb473d169cfc07265cedd041cb80f332823d1908ce86c4db4c221870cbf6409669daebf569d6e2633d93c78d14582f8dd9e0a265b0397', 'a9dcc91bc4d2e60237f163c83612a74ac5d7c2a9903f801e03c1f26dd8d399ed1aafdfbfcd99e98e0610ca85f26f8b2acdd7f1e567021c49a717b1cfb90c08f3', b'0'),
(7, 'asd', 'asd', 'asd', 'asd', '8.00', '10.00', 0, 'asd@asd.com', 'asdasda', 0, NULL, '9b3634a5368b48ff6bacb473d169cfc07265cedd041cb80f332823d1908ce86c4db4c221870cbf6409669daebf569d6e2633d93c78d14582f8dd9e0a265b0397', 'a9dcc91bc4d2e60237f163c83612a74ac5d7c2a9903f801e03c1f26dd8d399ed1aafdfbfcd99e98e0610ca85f26f8b2acdd7f1e567021c49a717b1cfb90c08f3', b'0'),
(8, 'DAVIDE33', 'Misano Adriatico', 'via po 3', '12345', '0.00', '0.00', 0, 'suppliertest@test.it', NULL, 12345678335, NULL, '30125410d38ca3cecd0241e22f0c95c53d04aa20f51de01d03648c88c07e2fee10260155b6e68a3ed8dc6716309745ffd7e648af7d2107c3436b2e6c77fc85a8', '6f3861a59e7a7163e4dd7c92e5b0fa9fa8272aaf132dbaa928ce088135c53458fc85f345f35c40153550b031bc13ed985e61d4e01796ce73dda600cf4ae70ac4', b'0');

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
(2, 'centro@gmail.com', '1545934478'),
(3, 'asd@asd.com', '1546626419'),
(4, 'davide.conti@foodcampus.it', '1547652697'),
(5, 'davide.conti@foodcampus.it', '1547652699'),
(6, 'davide.conti@foodcampus.it', '1547652703'),
(7, 'davide.conti@foodcampus.it', '1547652706'),
(8, 'davide.conti@foodcampus.it', '1547652711'),
(9, 'davide.conti@foodcampus.it', '1547652732'),
(10, 'davide.conti@foodcampus.it', '1547653041'),
(11, 'ivan.mazzantix@gmail.com', '1547687184'),
(12, 'lamalaghiotta@gmail.com', '1547997901'),
(13, 'andrealavista97@gmail.com', '1548001182'),
(14, 'andrealavista97@gmail.com', '1548001208'),
(15, 'andrealavista97@gmail.com', '1548001230'),
(16, 'andrealavista97@gmail.com', '1548001250'),
(17, 'andrea.lavista@foodcampus.it', '1548001390'),
(18, 'andrea.lavista@foodcampus.it', '1548002267');

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica`
--

CREATE TABLE `notifica` (
  `IDNotifica` int(11) NOT NULL,
  `testo` char(100) NOT NULL,
  `visualizzata` tinyint(1) NOT NULL DEFAULT '0',
  `IDCliente` int(11) DEFAULT NULL,
  `IDFornitore` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `notifica`
--

INSERT INTO `notifica` (`IDNotifica`, `testo`, `visualizzata`, `IDCliente`, `IDFornitore`) VALUES
(63, 'Hai ricevuto un nuovo ordine (9.50 â‚¬)', 0, NULL, 3),
(64, 'Hai ricevuto un nuovo ordine (3.50 â‚¬)', 0, NULL, 2),
(65, 'Hai ricevuto un nuovo ordine (3.50 â‚¬)', 1, NULL, 1),
(66, 'Hai ricevuto un nuovo ordine (9.50 â‚¬)', 0, NULL, 3),
(67, 'Hai ricevuto un nuovo ordine (3.50 â‚¬)', 0, NULL, 2),
(68, 'Hai ricevuto un nuovo ordine (3.50 â‚¬)', 1, NULL, 1),
(69, 'Hai ricevuto un nuovo ordine (3.50 â‚¬)', 0, NULL, 3),
(70, 'Hai ricevuto un nuovo ordine (3.50 â‚¬)', 1, NULL, 1),
(71, 'ciao', 0, 1, NULL),
(72, 'ciao', 0, 1, NULL),
(73, 'Hai ricevuto un nuovo ordine (4.50 â‚¬)', 0, NULL, 3),
(74, 'Hai ricevuto un nuovo ordine (4.50 â‚¬)', 0, NULL, 3),
(75, 'Hai ricevuto un nuovo ordine (5.00 â‚¬)', 0, NULL, 3),
(76, 'Hai ricevuto un nuovo ordine (7.50 â‚¬)', 0, NULL, 3),
(77, 'Hai ricevuto un nuovo ordine (2.50 â‚¬)', 0, NULL, 3),
(86, 'Hai ricevuto un nuovo ordine (22.50 â‚¬)', 0, NULL, 3);

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
  `IDCliente` int(11) NOT NULL,
  `consegnato` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`IDOrdine`, `prezzo`, `tipo_pagamento`, `orario_consegna_ora`, `orario_consegna_minuti`, `IDCliente`, `consegnato`) VALUES
(73, '9.50', 'Contrassegno', 14, 0, 1, 0),
(74, '3.50', 'Contrassegno', 14, 0, 1, 0),
(75, '3.50', 'Contrassegno', 14, 0, 1, 1),
(76, '9.50', 'Contrassegno', 15, 0, 1, 0),
(77, '3.50', 'Contrassegno', 15, 0, 1, 0),
(78, '3.50', 'Contrassegno', 15, 0, 1, 1),
(79, '3.50', 'Contrassegno', 13, 0, 1, 0),
(80, '3.50', 'Contrassegno', 13, 0, 1, 1),
(81, '4.50', 'Carta di credito', 14, 0, 1, 0),
(82, '4.50', 'Carta di credito', 13, 30, 1, 0),
(83, '5.00', 'Contrassegno', 15, 30, 1, 0),
(84, '7.50', 'Contrassegno', 12, 30, 1, 0),
(85, '2.50', 'Contrassegno', 15, 0, 1, 0),
(86, '22.50', 'Contrassegno', 14, 0, 1, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE `prodotto` (
  `IDProdotto` int(11) NOT NULL,
  `nome` char(50) NOT NULL,
  `costo` decimal(6,2) NOT NULL,
  `IDCategoria` int(11) NOT NULL,
  `IDFornitore` int(11) NOT NULL,
  `vegano` tinyint(1) NOT NULL,
  `celiaco` tinyint(1) NOT NULL,
  `surgelato` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`IDProdotto`, `nome`, `costo`, `IDCategoria`, `IDFornitore`, `vegano`, `celiaco`, `surgelato`) VALUES
(1, 'Crescione erbe e salsiccia', '3.50', 2, 3, 0, 0, 0),
(2, 'Crescione vegetariano', '3.50', 2, 3, 1, 1, 0),
(3, 'Piada crudo squacquerone e rucola', '4.50', 2, 3, 0, 0, 0),
(4, 'Crescione erbe e salsiccia', '3.50', 2, 1, 0, 0, 0),
(5, 'Crescione erbe e salsiccia', '3.50', 2, 2, 0, 0, 0),
(6, 'Spaghetti alla carbonara', '4.50', 3, 3, 0, 0, 0),
(7, 'Pollo al curry', '5.00', 4, 3, 0, 0, 1),
(8, 'Zuppa inglese', '2.50', 5, 3, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto_in_carrello`
--

CREATE TABLE `prodotto_in_carrello` (
  `IDProdottoInCarrello` int(11) NOT NULL,
  `IDProdotto` int(11) NOT NULL,
  `IDCliente` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto_in_ordine`
--

CREATE TABLE `prodotto_in_ordine` (
  `IDProdottoInOrdine` int(11) NOT NULL,
  `IDProdotto` int(11) NOT NULL,
  `IDOrdine` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `prodotto_in_ordine`
--

INSERT INTO `prodotto_in_ordine` (`IDProdottoInOrdine`, `IDProdotto`, `IDOrdine`, `quantita`) VALUES
(80, 3, 73, 1),
(81, 7, 73, 1),
(82, 5, 74, 1),
(83, 4, 75, 1),
(84, 3, 76, 1),
(85, 7, 76, 1),
(86, 5, 77, 1),
(87, 4, 78, 1),
(88, 2, 79, 1),
(89, 4, 80, 1),
(90, 3, 81, 1),
(91, 6, 82, 1),
(92, 8, 83, 2),
(93, 8, 84, 3),
(94, 8, 85, 1),
(95, 7, 86, 4),
(96, 8, 86, 1);

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

-- --------------------------------------------------------

--
-- Struttura della tabella `richieste_cambio_password`
--

CREATE TABLE `richieste_cambio_password` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `code` varchar(128) NOT NULL,
  `timestamp` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `tentativi_inserimento_codice`
--

CREATE TABLE `tentativi_inserimento_codice` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `timestamp` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indici per le tabelle `richieste_cambio_password`
--
ALTER TABLE `richieste_cambio_password`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tentativi_inserimento_codice`
--
ALTER TABLE `tentativi_inserimento_codice`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `IDCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `cliente`
--
ALTER TABLE `cliente`
  MODIFY `IDCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `fornitore`
--
ALTER TABLE `fornitore`
  MODIFY `IDFornitore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `IDNotifica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `IDOrdine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

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
  MODIFY `IDProdottoInOrdine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `IDRecensione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `richieste_cambio_password`
--
ALTER TABLE `richieste_cambio_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `tentativi_inserimento_codice`
--
ALTER TABLE `tentativi_inserimento_codice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
