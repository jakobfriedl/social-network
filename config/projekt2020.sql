-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Dez 2020 um 18:22
-- Server-Version: 10.4.17-MariaDB
-- PHP-Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `projekt2020`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beitrag`
--

CREATE TABLE `beitrag` (
  `id` int(30) NOT NULL,
  `titel` varchar(50) NOT NULL,
  `inhalt` varchar(500) NOT NULL,
  `timestamp` varchar(30) NOT NULL,
  `freigabestatus` varchar(30) NOT NULL,
  `pfad_original` varchar(100) DEFAULT NULL,
  `pfad_thumbnail` varchar(100) DEFAULT NULL,
  `user_id_fk` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `beitrag`
--

INSERT INTO `beitrag` (`id`, `titel`, `inhalt`, `timestamp`, `freigabestatus`, `pfad_original`, `pfad_thumbnail`, `user_id_fk`) VALUES
(119, 'Der Erste Beitrag dieser Seite', 'Dieser Beitrag wurde öffentlich freigegeben, dieser Status kann aber vom Ersteller des Beitrags mit einem Klick auf den schwarzen Stift geändert werden. Weiters wurden dem Beitrag verschiedene Tags zugewiesen, nach denen man auch filtern kann.', '30.12.2020 - 17:02:15', 'public', NULL, NULL, 24),
(120, 'Hallo Freunde', 'Diesen Beitrag habe ich nur für Freunde geteilt. Andere User müssen bevor ich den Beitrag erstellt habe mit mir befreundet sein. Wenn ich sie dann entfreunde, sehen Sie diesen Beitrag nicht mehr', '30.12.2020 - 17:04:16', 'private', 'pictures/andreas/30.12.2020_17-04-16/schlafzimmer.jpg', NULL, 21),
(121, 'Bilder', 'Wenn ich ein Bild hochlade, so wird ein Ordner mit meinem Benutzernamen erstellt. Darunter gibt es Unterordner, die nach dem Datum des Beitraguploads benannt sind. So kann es keine Überschneidungen geben', '30.12.2020 - 17:07:11', 'public', 'pictures/albert/30.12.2020_17-07-11/küche.jpg', NULL, 23),
(122, 'Tags', 'Hallo, ich bin nur hier, um mal alle verfügbaren Tags zu zeigen :)', '30.12.2020 - 17:10:32', 'public', NULL, NULL, 19),
(124, 'Bilder können auch vergößert werden', '', '30.12.2020 - 17:15:27', 'public', 'pictures/Jakob/30.12.2020_17-15-27/esszimmer.jpg', NULL, 24),
(125, 'Bilder können auch vergößert werden', '', '30.12.2020 - 17:15:40', 'public', 'pictures/Jakob/30.12.2020_17-15-40/aussen.jpg', NULL, 24),
(126, 'Bilder können auch vergößert werden', 'Dazu wurde eine sogenannte FancyBox verwendet', '30.12.2020 - 17:16:13', 'public', 'pictures/Jakob/30.12.2020_17-16-13/smart_home_grafik.jpg', NULL, 24),
(127, 'Likes / Dislikes', 'Wenn man eingeloggt ist kann man Beiträge liken, disliken und kommentieren. Wenn man einen Beitrag mit einem Like markiert, den man bereits geliked oder gedisliked hat, so wird entsprechend der Like oder Dislike entfernt.', '30.12.2020 - 17:18:53', 'public', NULL, NULL, 21),
(128, 'Privat', 'Das hier ist ein privater Beitrag', '30.12.2020 - 17:22:30', 'private', 'pictures/Martina/30.12.2020_17-22-30/küche.jpg', NULL, 20),
(129, 'Löschen', 'Der Ersteller eines Beitrags kann diesen auch einfach mit einem Klick auf den roten Mülleimer löschen', '30.12.2020 - 17:26:43', 'public', 'pictures/DavidAlaba/30.12.2020_17-26-43/loeschen.png', NULL, 26),
(136, 'Das bin ich', '', '30.12.2020 - 18:10:22', 'private', 'pictures/Jakob/30.12.2020_18-10-22/portraet.jpg', NULL, 24);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beitrag_tag`
--

CREATE TABLE `beitrag_tag` (
  `id` int(30) NOT NULL,
  `beitrag_id_fk` int(30) NOT NULL,
  `tag_id_fk` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `beitrag_tag`
--

INSERT INTO `beitrag_tag` (`id`, `beitrag_id_fk`, `tag_id_fk`) VALUES
(49, 119, 19),
(50, 119, 1),
(51, 119, 3),
(52, 119, 5),
(53, 120, 20),
(54, 120, 2),
(55, 120, 4),
(56, 121, 21),
(57, 121, 2),
(58, 122, 22),
(59, 122, 1),
(60, 122, 2),
(61, 122, 3),
(62, 122, 4),
(63, 122, 5),
(65, 124, 21),
(66, 125, 21),
(67, 126, 21),
(68, 127, 1),
(69, 127, 5),
(70, 128, 23),
(71, 128, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chat`
--

CREATE TABLE `chat` (
  `id` int(30) NOT NULL,
  `user_id_fk_1` int(30) NOT NULL,
  `user_id_fk_2` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `chat`
--

INSERT INTO `chat` (`id`, `user_id_fk_1`, `user_id_fk_2`) VALUES
(15, 24, 19),
(16, 24, 22);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dislikes`
--

CREATE TABLE `dislikes` (
  `id` int(30) NOT NULL,
  `user_id_fk` int(30) NOT NULL,
  `beitrag_id_fk` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `dislikes`
--

INSERT INTO `dislikes` (`id`, `user_id_fk`, `beitrag_id_fk`) VALUES
(60, 21, 120),
(61, 19, 120),
(62, 20, 122),
(65, 24, 125),
(66, 21, 127),
(67, 23, 127),
(68, 26, 129);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `freundschaft`
--

CREATE TABLE `freundschaft` (
  `id` int(30) NOT NULL,
  `timestamp` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `user_id_fk_1` int(30) NOT NULL,
  `user_id_fk_2` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `freundschaft`
--

INSERT INTO `freundschaft` (`id`, `timestamp`, `status`, `user_id_fk_1`, `user_id_fk_2`) VALUES
(184, '30.12.2020 - 16:50:51', 'accepted', 21, 19),
(185, '30.12.2020 - 16:51:26', 'accepted', 21, 20),
(186, '30.12.2020 - 16:51:24', 'accepted', 19, 20),
(187, '30.12.2020 - 16:56:17', 'accepted', 24, 19),
(188, '30.12.2020 - 16:56:29', 'accepted', 24, 20),
(190, '30.12.2020 - 16:55:59', 'accepted', 24, 22),
(192, '', 'requested', 21, 24),
(193, '30.12.2020 - 16:58:52', 'accepted', 25, 24),
(194, '30.12.2020 - 17:24:39', 'accepted', 26, 24);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kommentar`
--

CREATE TABLE `kommentar` (
  `id` int(30) NOT NULL,
  `inhalt` varchar(100) NOT NULL,
  `timestamp` varchar(30) NOT NULL,
  `user_id_fk` int(30) NOT NULL,
  `beitrag_id_fk` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `kommentar`
--

INSERT INTO `kommentar` (`id`, `inhalt`, `timestamp`, `user_id_fk`, `beitrag_id_fk`) VALUES
(16, 'Wow, das ist echt interessant!', '30.20.2020  - 17:02:47', 21, 119),
(17, 'Schade, dass nicht alle das sehen können', '30.20.2020  - 17:09:08', 19, 120),
(18, 'Spitze :)', '30.20.2020  - 17:09:26', 19, 119),
(19, 'Da muss ich doch gleich mal die Filterfunktion ausprobieren', '30.20.2020  - 17:11:33', 20, 122),
(20, 'Neben dem Filtern kann man auch nach Begriffen suchen. Wenn man wieder alle Beiträge anzeigen will, ', '30.20.2020  - 17:12:57', 24, 122),
(21, 'Es wird auch markiert, ob man bereits geliked oder gedisliked hat', '30.20.2020  - 17:20:18', 24, 127),
(22, 'Mit einem Klick aufs Kommentarsymbol werden die Kommentare unter dem Beitrag dargestellt', '30.20.2020  - 17:20:52', 23, 127);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `likes`
--

CREATE TABLE `likes` (
  `id` int(30) NOT NULL,
  `user_id_fk` int(30) NOT NULL,
  `beitrag_id_fk` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `likes`
--

INSERT INTO `likes` (`id`, `user_id_fk`, `beitrag_id_fk`) VALUES
(92, 21, 119),
(93, 19, 121),
(95, 19, 119),
(96, 19, 122),
(97, 24, 122),
(98, 24, 119),
(99, 24, 126),
(100, 24, 124),
(101, 24, 127),
(104, 24, 136),
(105, 24, 129);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nachricht`
--

CREATE TABLE `nachricht` (
  `id` int(30) NOT NULL,
  `nachricht` varchar(200) NOT NULL,
  `timestamp` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `user_id_fk` int(30) NOT NULL,
  `chat_id_fk` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `nachricht`
--

INSERT INTO `nachricht` (`id`, `nachricht`, `timestamp`, `status`, `user_id_fk`, `chat_id_fk`) VALUES
(45, 'Hallo Max! Wie geht es dir?', '30.12.2020 - 17:07:51', 'read', 24, 15),
(46, 'Hallo, mir geht es super! Mir wurde gerade angezeigt, dass ich eine neue Nachricht von dir habe!', '30.12.2020 - 17:08:30', 'read', 19, 15),
(47, 'Das ist Toll!', '30.12.2020 - 17:13:40', 'sent', 24, 15),
(48, 'Hallo', '30.12.2020 - 17:37:35', 'read', 24, 16),
(49, 'Hallo', '30.12.2020 - 17:37:54', 'sent', 22, 16);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tag`
--

CREATE TABLE `tag` (
  `id` int(30) NOT NULL,
  `bezeichnung` varchar(50) NOT NULL,
  `farbe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tag`
--

INSERT INTO `tag` (`id`, `bezeichnung`, `farbe`) VALUES
(1, 'Sport', '#FF0000'),
(2, 'Nachrichten', '#00ccff'),
(3, 'Natur', '#33cc33'),
(4, 'Humor', '#FFFF00 '),
(5, 'Politik', '#ff9900'),
(19, 'Informationen', '#ffffff'),
(20, 'Freunde', '#ffffff'),
(21, 'Bilder', '#ffffff'),
(22, '[eigener Tag]', '#ffffff'),
(23, 'Privat', '#ffffff');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(30) NOT NULL,
  `anrede` varchar(20) NOT NULL,
  `vorname` varchar(30) NOT NULL,
  `nachname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `passwort` varchar(250) NOT NULL,
  `farbe` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `anrede`, `vorname`, `nachname`, `email`, `username`, `passwort`, `farbe`) VALUES
(-1, 'Herr', 'Admin ', 'Administrator', 'admin@admin', 'Administrator', '$2y$10$4rvpSaJ7m2wUGlmukKbwKO3LHj2ATaTQ9yUab6.ZWaWDe/1ZD3/wG', ''),
(19, 'Herr', 'Max', 'Mustermann', 'max@mustermann.at', 'Max', '$2y$10$C3cgho2QCISMt/M92FCrXuhe8ZqG16JzCLrL5CLM.bnf9fprfY2RG', '#ff0000'),
(20, 'Frau', 'Martina', 'Musterfrau', 'martina@musterfrau.at', 'Martina', '$2y$10$hp//uwiAZqdhhjMWImm/4evowqlJ4uMOuhuT4gTOlYVqBrl9JnPs2', '#ff80ff'),
(21, 'Herr', 'Andreas', 'Aal', 'a@a', 'Andreas', '$2y$10$LcI1Js0q4a/dGRuRrdjFc./GJ1nceB9qqhrYmUatSk4yJTuPC/RJC', '#8080c0'),
(22, 'Herr', 'Tobias', 'Friedl', 't@f', 'Tobias', '$2y$10$i7Ljw3w/4FtceFo.lGmP0u0CKvl0WMRBZvv34t2diqdTtLNyJG/oO', '#004080'),
(23, 'Herr', 'Albert', 'Einstein', 'a@e', 'Albert', '$2y$10$d2osDCMxdG/lKOPw15ntFO2HGiLoEVuu5Q7y7FOWADLF53KnLXI9C', '#800040'),
(24, 'Herr', 'Jakob', 'Friedl', 'if20b089@technikum-wien.at', 'Jakob', '$2y$10$1yQuNvL77i8k.3g0O4TW5eBNMJTGiPU3L3LvwlgCdOxQQ/hxDnLx2', '#e9be16'),
(25, 'Herr', 'Arnold', 'Schwarzenegger', 'a@s', 'arnold', '$2y$10$Y8EHryamuaunIJiKAoyuzu6QmucvTKCGN9DeoPiT47aGVRz5XZZkO', ''),
(26, 'Herr', 'David', 'Alaba', 'd@a', 'DavidAlaba', '$2y$10$Xt.fjXR85znie2dWouS1wOuzwfyNj7ANuq8ClmKaewnZ5piE6yvru', '#8000ff');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `beitrag`
--
ALTER TABLE `beitrag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_fk` (`user_id_fk`);

--
-- Indizes für die Tabelle `beitrag_tag`
--
ALTER TABLE `beitrag_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beitrag_id_fk` (`beitrag_id_fk`),
  ADD KEY `tag_id_fk` (`tag_id_fk`);

--
-- Indizes für die Tabelle `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_if_fk_1` (`user_id_fk_1`),
  ADD KEY `user_id_fk_2` (`user_id_fk_2`);

--
-- Indizes für die Tabelle `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_fk` (`user_id_fk`),
  ADD KEY `beitrag_id_fk` (`beitrag_id_fk`);

--
-- Indizes für die Tabelle `freundschaft`
--
ALTER TABLE `freundschaft`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_fk_1` (`user_id_fk_1`),
  ADD KEY `user_id_fk_2` (`user_id_fk_2`);

--
-- Indizes für die Tabelle `kommentar`
--
ALTER TABLE `kommentar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_fk` (`user_id_fk`),
  ADD KEY `beitrag_id_fk` (`beitrag_id_fk`);

--
-- Indizes für die Tabelle `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beitrag_id_fk` (`beitrag_id_fk`),
  ADD KEY `user_id_fk` (`user_id_fk`);

--
-- Indizes für die Tabelle `nachricht`
--
ALTER TABLE `nachricht`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id_fk` (`chat_id_fk`),
  ADD KEY `user_id_fk` (`user_id_fk`);

--
-- Indizes für die Tabelle `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `beitrag`
--
ALTER TABLE `beitrag`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT für Tabelle `beitrag_tag`
--
ALTER TABLE `beitrag_tag`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT für Tabelle `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `dislikes`
--
ALTER TABLE `dislikes`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT für Tabelle `freundschaft`
--
ALTER TABLE `freundschaft`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT für Tabelle `kommentar`
--
ALTER TABLE `kommentar`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT für Tabelle `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT für Tabelle `nachricht`
--
ALTER TABLE `nachricht`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT für Tabelle `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `beitrag`
--
ALTER TABLE `beitrag`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id_fk`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `beitrag_tag`
--
ALTER TABLE `beitrag_tag`
  ADD CONSTRAINT `beitrag_id_fk` FOREIGN KEY (`beitrag_id_fk`) REFERENCES `beitrag` (`id`),
  ADD CONSTRAINT `tag_id_fk` FOREIGN KEY (`tag_id_fk`) REFERENCES `tag` (`id`);

--
-- Constraints der Tabelle `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `user_id_fk_2` FOREIGN KEY (`user_id_fk_2`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_if_fk_1` FOREIGN KEY (`user_id_fk_1`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `dislikes`
--
ALTER TABLE `dislikes`
  ADD CONSTRAINT `dislikes_ibfk_1` FOREIGN KEY (`user_id_fk`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `dislikes_ibfk_2` FOREIGN KEY (`beitrag_id_fk`) REFERENCES `beitrag` (`id`);

--
-- Constraints der Tabelle `freundschaft`
--
ALTER TABLE `freundschaft`
  ADD CONSTRAINT `freundschaft_ibfk_1` FOREIGN KEY (`user_id_fk_2`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_id_fk_1` FOREIGN KEY (`user_id_fk_1`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `kommentar`
--
ALTER TABLE `kommentar`
  ADD CONSTRAINT `kommentar_ibfk_1` FOREIGN KEY (`user_id_fk`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `kommentar_ibfk_2` FOREIGN KEY (`beitrag_id_fk`) REFERENCES `beitrag` (`id`);

--
-- Constraints der Tabelle `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`beitrag_id_fk`) REFERENCES `beitrag` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id_fk`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `nachricht`
--
ALTER TABLE `nachricht`
  ADD CONSTRAINT `chat_id_fk` FOREIGN KEY (`chat_id_fk`) REFERENCES `chat` (`id`),
  ADD CONSTRAINT `nachricht_ibfk_1` FOREIGN KEY (`user_id_fk`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
