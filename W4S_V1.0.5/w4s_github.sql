-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 15, 2023 at 11:43 PM
-- Server version: 5.7.33-0ubuntu0.16.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `w4s_github`
--

-- --------------------------------------------------------

--
-- Table structure for table `oferty`
--

CREATE TABLE `oferty` (
  `id` int(11) NOT NULL,
  `tytul_oferty` text NOT NULL,
  `autor` text NOT NULL,
  `data` datetime NOT NULL,
  `dyspozycyjnosc` text NOT NULL,
  `tresc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oferty`
--

INSERT INTO `oferty` (`id`, `tytul_oferty`, `autor`, `data`, `dyspozycyjnosc`, `tresc`) VALUES
(1, 'Kurier InPost', 'pracodawca1', '2023-06-15 21:39:25', 'Caly tydzien,22:00-06:00', 'Zatrudnie do pomocy w rozwozeniu paczek w godzinach nocnych'),
(2, 'Pomocnik woznego/konserwatora POLECAM', 'pracodawca2', '2023-06-15 21:39:25', 'poniedzialek,08:00-10:00;wtorek,08:00-10:00;sroda,08:00-10:00;czwartek,08:00-10:00;piatek,08:00-10:00;sobota,wolne;niedziela,wolne', 'zatrudnie kogos na stanowisko pomoc woznego/konserwatora do SP nr 1, dyspozycyjnosc w godz 8-10');

-- --------------------------------------------------------

--
-- Table structure for table `pracodawcy`
--

CREATE TABLE `pracodawcy` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `haslo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pracodawcy`
--

INSERT INTO `pracodawcy` (`id`, `login`, `haslo`) VALUES
(1, 'pracodawca1', 'p1');

-- --------------------------------------------------------

--
-- Table structure for table `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL,
  `user` text NOT NULL,
  `haslo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pracownicy`
--

INSERT INTO `pracownicy` (`id`, `user`, `haslo`) VALUES
(1, 'student123', 'haslo'),
(2, 'p2', 'p2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oferty`
--
ALTER TABLE `oferty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pracodawcy`
--
ALTER TABLE `pracodawcy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
