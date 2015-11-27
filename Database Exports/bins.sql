-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 27 nov 2015 om 14:11
-- Serverversie: 5.6.20
-- PHP-versie: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `internetfornature`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bins`
--

CREATE TABLE IF NOT EXISTS `bins` (
`id` int(11) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` int(11) NOT NULL,
  `currentWeight` float NOT NULL,
  `lastEmptiedDate` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Gegevens worden geëxporteerd voor tabel `bins`
--

INSERT INTO `bins` (`id`, `ownerId`, `name`, `type`, `currentWeight`, `lastEmptiedDate`) VALUES
(1, 1, 'Boven', 1, 0, '2015-11-25'),
(2, 1, 'achtertuin', 3, 20, '2015-11-05'),
(3, 2, 'Blauwe bak op zolder', 0, 15.4, '2015-11-24'),
(4, 2, 'NIET AANRAKEN', 3, 5, '2001-04-13'),
(5, 2, 'Glasbak buiten', 2, 2, '2015-11-18');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bins`
--
ALTER TABLE `bins`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bins`
--
ALTER TABLE `bins`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
