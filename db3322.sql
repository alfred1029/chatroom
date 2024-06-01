-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mydb:3306
-- Generation Time: Apr 12, 2024 at 04:07 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db3322`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` smallint NOT NULL,
  `useremail` varchar(60) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `useremail`, `password`) VALUES
(1, 'alfred@connect.hku.hk', '1234'),
(2, 'katie@connect.hku.hk', '930623'),
(3, '1234@connect.hku.hk', '1234'),
(4, '1@connect.hku.hk', '1'),
(5, '123@connect.hku.hk', '123');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msgid` int NOT NULL,
  `time` bigint NOT NULL,
  `message` varchar(250) NOT NULL,
  `person` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`msgid`, `time`, `message`, `person`) VALUES
(1, 1712929071, '1234', '1'),
(2, 1712929074, '123456', '1'),
(3, 1712929078, '12345678', '1'),
(4, 1712933865, '123', '1'),
(5, 1712933868, '212345', '1'),
(6, 1712933916, '123123', '1'),
(7, 1712933920, '123122345345', '1'),
(8, 1712933935, '123122345345awefaepf', '1'),
(9, 1712935319, 'afaef', '1'),
(10, 1712935349, '232r23r', '1'),
(11, 1712936507, 'how are you?', 'katie'),
(12, 1712936603, 'nice to meet you <3', 'katie'),
(13, 1712937091, 'wefwfe', 'katie'),
(14, 1712937287, '234234', '1'),
(15, 1712937722, 'w343', '1'),
(16, 1712937727, '1231234', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msgid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` smallint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msgid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
