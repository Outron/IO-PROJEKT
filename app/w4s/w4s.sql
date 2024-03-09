-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 30 Cze 2023, 23:24
-- Wersja serwera: 5.7.33-0ubuntu0.16.04.1
-- Wersja PHP: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `w4s`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `aplikacje`
--

CREATE TABLE `aplikacje` (
  `id_aplikacji` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_oferta` int(11) DEFAULT NULL,
  `kwalifikacje` text NOT NULL,
  `checi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `aplikacje`
--

INSERT INTO `aplikacje` (`id_aplikacji`, `id_user`, `id_oferta`, `kwalifikacje`, `checi`) VALUES
(1, 9, 1, '', ''),
(2, 9, 2, '', ''),
(3, 13, 2, '', ''),
(4, 9, 3, '', ''),
(5, 9, 4, '', ''),
(6, 13, 1, '', ''),
(7, 13, 3, '', ''),
(8, 13, 4, '', ''),
(9, 12, 4, '', ''),
(13, 20, 4, '', ''),
(14, 20, 1, 'Prawo jazdy kat. B od 10 lat', 'Zbieram na chleb, doświadczenie 5 lat'),
(15, 18, 1, 'mgr Historii Współczesnej', 'duże'),
(16, 10, 1, 'Zasadnicza Szkoła Zawodowa ', 'Uwielbiam jeździć autami');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godziny_dostepnosci`
--

CREATE TABLE `godziny_dostepnosci` (
  `id_prac` int(11) NOT NULL,
  `godziny_dostepnosci` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `godziny_dostepnosci`
--

INSERT INTO `godziny_dostepnosci` (`id_prac`, `godziny_dostepnosci`) VALUES
(11, 'Poniedziałek,03:03-05:55;Wtorek,03:03-05:55;Środa,03:33-05:05;Czwartek,03:33-05:55;Piątek,03:33-05:05;Sobota,wolne;Niedziela,wolne'),
(13, 'Cały tydzień,11:01-22:06');

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
  `tresc` text NOT NULL,
  `wymagania` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `oferty`
--

INSERT INTO `oferty` (`id`, `tytul_oferty`, `autor`, `data`, `dyspozycyjnosc`, `tresc`, `wymagania`) VALUES
(1, 'Kurier InPost', 'dominIT', '2023-06-15 21:39:25', 'Cały tydzien,06:00-18:00', 'Zatrudnię do pomocy w rozwożeniu paczek w godzinach nocnych, darmowa kawa, nadgodziny dodatkowo płatne', 'Prawo jazdy kat. B'),
(2, 'Pomocnik woznego/konserwatora POLECAM', 'formula1', '2023-06-15 21:39:25', 'poniedziałek,08:00-10:00;wtorek,08:00-10:00;sroda,08:00-10:00;czwartek,08:00-10:00;piątek,08:00-10:00;sobota,wolne;niedziela,wolne', 'zatrudnie kogoś na stanowisko pomoc woźnego/konserwatora do SP nr 1, dyspozycyjnosc w godz 8-10', '2 sprawne ręce'),
(3, 'Operator koparki spalinowej', 'koparka', '2023-06-20 13:29:51', 'Cały tydzien,06:00-12:00', 'Witam, szukam operatora koparki, który będzie kopał rów wzdłuż nowo powstałej drogi krajowej.', 'Sumienność i staranność w koszeniu trawy.'),
(4, 'Full Stack Developer', 'dominIT', '2023-06-27 21:34:45', 'Cały tydzień, 9:00-17:00', 'Witam, szukam Full Stack Developera.\r\nDobrze płatne.', 'Znajomość HTML 5 + CSS, JavaScript, PHP, React, SQL oraz Python.\r\nMile widziane wykształcenie wyższe.');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `pracodawcy`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `pracownicy`
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
-- Indeksy dla tabeli `aplikacje`
--
ALTER TABLE `aplikacje`
  ADD PRIMARY KEY (`id_aplikacji`);

--
-- Indeksy dla tabeli `godziny_dostepnosci`
--
ALTER TABLE `godziny_dostepnosci`
  ADD UNIQUE KEY `id_prac` (`id_prac`);

--
-- Indeksy dla tabeli `oferty`
--
ALTER TABLE `oferty`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT dla tabeli `aplikacje`
--
ALTER TABLE `aplikacje`
  MODIFY `id_aplikacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `oferty`
--
ALTER TABLE `oferty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `pracodawcy`
--
ALTER TABLE `pracodawcy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
