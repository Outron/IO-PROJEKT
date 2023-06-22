-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 22, 2023 at 08:09 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `w4s`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oferty`
--

CREATE TABLE `oferty` (
  `id` int(11) NOT NULL,
  `tytul_oferty` text NOT NULL,
  `autor` text NOT NULL,
  `data` datetime NOT NULL,
  `dyspozycyjnosc` text NOT NULL,
  `tresc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `oferty`
--

INSERT INTO `oferty` (`id`, `tytul_oferty`, `autor`, `data`, `dyspozycyjnosc`, `tresc`) VALUES
(1, 'Kurier InPost', 'pracodawca1', '2023-06-15 21:39:25', 'Caly tydzien,22:00-06:00', 'Zatrudnie do pomocy w rozwozeniu paczek w godzinach nocnych'),
(2, 'Pomocnik woznego/konserwatora POLECAM', 'pracodawca2', '2023-06-15 21:39:25', 'poniedzialek,08:00-10:00;wtorek,08:00-10:00;sroda,08:00-10:00;czwartek,08:00-10:00;piatek,08:00-10:00;sobota,wolne;niedziela,wolne', 'zatrudnie kogos na stanowisko pomoc woznego/konserwatora do SP nr 1, dyspozycyjnosc w godz 8-10');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracodawcy`
--

CREATE TABLE `pracodawcy` (
  `id` int(11) NOT NULL,
  `login` varchar(15) NOT NULL,
  `haslo` varchar(128) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(62) NOT NULL,
  `nrtel` int(9) NOT NULL,
  `NIP` int(10) NOT NULL,
  `REGON` int(9) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `nazwa_firmy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pracodawcy`
--

INSERT INTO `pracodawcy` (`id`, `login`, `haslo`, `imie`, `nazwisko`, `email`, `nrtel`, `NIP`, `REGON`, `adres`, `nazwa_firmy`) VALUES
(1, 'dominIT', 'hejka', 'Dominik', 'Nowak', 'kontakt@dominit.pl', 987654321, 2147483647, 426871395, 'Długosza 15, Kraków', 'dominIT'),
(4, 'koparka', 'kopareczki', 'Mirek', 'Konieczny', 'koparki_kontakt@interia.pl', 67849278, 2147483647, 2147483647, 'Żwirowa 95, Warszawa', 'Koparki u Mirka'),
(5, 'angielski', 'london', 'John', 'Cena', 'johncena@wwe.com', 999999999, 1111111111, 222222222, 'Stadionowa 1, Warszawa', 'WWE'),
(6, 'formula1', 'wysciguwa', 'Robert', 'Kubica', 'kubicarobert@gmail.com', 777777777, 2147483647, 879852413, 'Torowa 2, Wieliczka', 'Kubica COMPANY');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL,
  `user` varchar(15) NOT NULL,
  `haslo` varchar(128) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(62) NOT NULL,
  `nrtel` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pracownicy`
--

INSERT INTO `pracownicy` (`id`, `user`, `haslo`, `imie`, `nazwisko`, `email`, `nrtel`) VALUES
(1, 'admin', 'polsl', 'Andrzej', 'Nowak', 'endrju@polsl.pl', 123123123),
(2, 'test', 'polsl', 'Mateusz', 'Nowak', 'nowakm@polsl.pl', 321321312),
(9, 'marek', 'qwerty', 'Marek', 'Nowak', 'maronowak@gmail.com', 123456789),
(10, 'coolgamer', 'tibia', 'Janusz', 'Walczuk', 'januszelo320@onet.pl', 876953123),
(11, 'kiwajakotako', 'pilkanozna', 'Kiwa', 'Jakotako', 'kiwa43@yahoo.com', 777777777),
(12, 'zbyszek', 'zbysiu5', 'Zbigniew', 'Lepszy', 'zbysiu1999@gmail.com', 789514236),
(13, 'jozek', 'test', 'Józef', 'Kapusta', 'juzekkapusta@spoko.pl', 898989898),
(14, 'ezakolak', 'haluksy', 'Jakub', 'Szopka', 'czkawkamen8@gmail.com', 756985236),
(17, 'dominik', 'qwerty1234', 'Dominik', 'Cement', 'cement@gmail.com', 123456789),
(18, 'testowytomasz', 'testowanie', 'Tomasz', 'Testowy', 'tomasz@testowy.pl', 123123123),
(19, 'dawid', 'io2023', 'Dawid', 'Kawulski', 'dawid@io.pl', 321321321),
(20, 'orangutan', 'malpa', 'Andrzej', 'Wielki', 'orangutan@onet.pl', 111111111),
(21, 'marek22', 'qwerty', 'Marek', 'Test', 'endrju222@polsl.pl', 123123123);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pracodawcy`
--
ALTER TABLE `pracodawcy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pracodawcy`
--
ALTER TABLE `pracodawcy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
