-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2019 at 10:38 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teltonika`
--

-- --------------------------------------------------------

--
-- Table structure for table `miestai`
--

CREATE TABLE `miestai` (
  `id` int(11) NOT NULL,
  `Pavadinimas` varchar(255) NOT NULL,
  `Užimamas plotas` int(11) NOT NULL,
  `Gyventoju skaičius` int(11) NOT NULL,
  `Miesto pašto kodas` int(11) NOT NULL,
  `fk_Pavadinimas` varchar(255) NOT NULL,
  `Data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `miestai`
--

INSERT INTO `miestai` (`id`, `Pavadinimas`, `Užimamas plotas`, `Gyventoju skaičius`, `Miesto pašto kodas`, `fk_Pavadinimas`, `Data`) VALUES
(1, 'Anykščiai', 100, 10000, 29182, 'Lietuva', '2019-07-01 00:00:00'),
(3, 'Vilnius', 401, 549389, 29123, 'Lietuva', '2019-07-10 00:00:00'),
(4, 'Radviliškis', 124, 45123, 45632, 'Lietuva', '2019-07-06 00:00:00'),
(5, 'Kaunas', 356, 456327, 28465, 'Lietuva', '2019-07-10 00:00:00'),
(6, 'Vilkaviškis', 150, 45545, 24157, 'Lietuva', '2019-07-26 19:21:44'),
(8, 'Tauragė', 142, 47892, 24578, 'Lietuva', '2019-07-28 20:16:48'),
(9, 'Panevežys', 225, 347000, 22793, 'Lietuva', '2019-07-28 20:17:24'),
(10, 'Klaipėda', 301, 225789, 74582, 'Lietuva', '2019-07-28 20:17:50'),
(11, 'Trakai', 99, 12878, 54786, 'Lietuva', '2019-07-28 20:19:10'),
(12, 'Šiauliai', 224, 245125, 44488, 'Lietuva', '2019-07-28 20:20:27'),
(14, 'Alytus', 112, 12214, 14278, 'Lietuva', '2019-07-28 21:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `šalys`
--

CREATE TABLE `šalys` (
  `id` int(11) NOT NULL,
  `Pavadinimas` varchar(25) NOT NULL,
  `Užimamas plotas` int(11) NOT NULL,
  `Gyventoju skaičius` int(11) NOT NULL,
  `Telefono kodas` int(11) NOT NULL,
  `Data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `šalys`
--

INSERT INTO `šalys` (`id`, `Pavadinimas`, `Užimamas plotas`, `Gyventoju skaičius`, `Telefono kodas`, `Data`) VALUES
(1, 'Lietuva', 65300, 2793956, 370, '2019-07-09 00:00:00'),
(18, 'a', 0, 0, 0, '2019-07-28 20:47:18'),
(19, 'z', 4, 4, 4, '2019-07-28 20:47:21'),
(20, 'c', 4, 4, 4, '2019-07-28 20:57:12'),
(21, 'l', 0, 0, 0, '2019-07-28 20:57:15'),
(22, 'e', 0, 0, 0, '2019-07-28 20:57:17'),
(23, 'f', 0, 0, 0, '2019-07-28 20:57:18'),
(24, 'g', 0, 0, 0, '2019-07-28 20:57:20'),
(25, 'h', 0, 0, 0, '2019-07-28 20:57:22'),
(27, 'r', 0, 0, 52, '2019-07-28 20:57:41'),
(29, 'ad', 87, 78, 78, '2019-07-28 23:16:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `miestai`
--
ALTER TABLE `miestai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Pavadinimas` (`Pavadinimas`);

--
-- Indexes for table `šalys`
--
ALTER TABLE `šalys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Pavadinimas` (`Pavadinimas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `miestai`
--
ALTER TABLE `miestai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `šalys`
--
ALTER TABLE `šalys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
