-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 01:36 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paper_nest`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `rating`, `price`, `image`) VALUES
(1, 'The Seven Husbands Of Evelyn Hugo', 'Taylor Jenkins Reid', 4.8, 85000.00, 'seven.jpg'),
(2, 'Beneath the Surface', 'Kaira Rouda', 3.9, 65000.00, 'beneath.jpg'),
(3, 'The Strength in Our Scars', 'Bianca Sparacino', 4.5, 99000.00, 'thestrength.jpg'),
(4, 'The Psychology of Money', 'Morgan Housel', 5.0, 90000.00, 'psychology.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `username`, `password`, `user_type`) VALUES
(1, 'abcdf', 'rtyui@gmail.com', 'Revania Amelia P', '$2y$10$2fmhodChnKh6PNNpkZI38ujIXmZeneBhBUUbnONnyg150w6yWsfQW', 'admin'),
(2, 'amelia putri', 'wertyu@gmail.com', 'hello', '$2y$10$wMM2ygRmAqKzXzlx645Nh.S7GVaGthe/W6fkWWK1WG19WXB9NUGb2', 'admin'),
(3, 'Revania Amelia Putri', '2373028@maranatha.ac.id', 'revaniaapp', '$2y$10$kiXyyM.aSBm9RGhcyTWKXu8QvKaLPOjxhe.8YifROlFDTXniZKo4i', 'admin'),
(4, 'iniadmin', 'admin123@gmail.com', 'admin1', '$2y$10$rNzOd3TXgwZDcLEspMfWSOh2Lw9ur94Xg.FaEwTv8hMCx3GMLWLe6', 'user'),
(5, 'ini user 1', 'user1@gmail.com', 'user1', '$2y$10$8WyRGhcyhrVsA.yxIscXvuoL3g2qdopx4ctYoWfZXLWJ7RSowDiVC', 'user'),
(6, 'ini admin2', 'admin2@gmail.com', 'admin2', '$2y$10$CBacxppdDxwXqa8awBpU2u4EE27woDWOvebPrWK6hX7gwk1IW.U.2', 'admin'),
(7, 'q23456789', '2345678@gmail.com', 'admin123', '$2y$10$qoLAOR7UCovoMBTJ8GYeC.9iqQ4NIJvU.IRScis0Rq7.X.U3PSeNS', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
