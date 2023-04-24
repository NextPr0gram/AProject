-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2023 at 12:57 PM
-- Server version: 8.0.32-0ubuntu0.20.04.2
-- PHP Version: 8.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u_220087405_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `pid` int UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `phase` enum('design','development','testing','deployment','complete') DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `uid` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`pid`, `title`, `start_date`, `end_date`, `phase`, `description`, `uid`) VALUES
(2, 'Online Recipe Sharing Platform', '2023-04-19', '2023-05-06', 'design', 'This project is a web application that allows users to create and share their favorite recipes with others. Users can sign up for an account, browse recipes by category, search for specific recipes, and create and edit their own recipes. ', 1),
(3, 'Cornhub', '2023-04-29', '2023-04-30', 'development', 'Cornhub is a website that showcases different types of corn, including Asian corn, popcorn, and extra-small corn. The website provides information about the history, cultivation, and culinary uses of each variety, along with recipes and cooking tips.', 1),
(4, 'Amazon', '2023-04-21', '2023-04-21', 'design', 'A delivery service where goods are delivered before the customer has ordered Jeff besozs psychic powers are used to read the customers mind He can predict what the customer wants and when they want it', 1),
(5, 'Eco-Friendly Shopping App', '2023-04-29', '2023-05-06', 'development', 'A mobile app that helps users find environmentally-friendly products from local businesses, promoting sustainable shopping and supporting green initiatives.', 1),
(7, 'Eco-Friendly Delivery Service', '2023-04-21', '2023-04-29', 'development', 'A sustainable last-mile delivery solution using electric vehicles and bicycles, promoting eco-friendly transportation and reducing carbon footprint. Biodegradable and reusable packaging materials will also be utilized to minimize environmental impact.', 1),
(9, 'Mind-Reading Microwave Oven', '2023-04-23', '2023-04-30', 'design', 'This project involves designing a microwave oven that can read the users mind to determine what type of food they want to cook The oven will be equipped with sensors that can detect the users brainwaves and translate them into specific cooking instructions The user simply needs to think about the food they want to cook and the oven will do the rest', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `email`) VALUES
(1, 'anaf', '$2y$10$d6DgttZrhvQW.RYqTDPt7ejpQznJwJxrhbYF2WUJIIN2pDkZMonku', 'anaf@email.com'),
(5, 'anaf2', '$2y$10$HBUSAYXHgDijJNLOykOcMuVGDpyNDVWN0ZrGo3VFo4TPt0cjygi2.', 'anaf2@email.com'),
(6, 'kj', '$2y$10$gouYX0T284uF1lvRBe6JUOgh38ztZ6FWBJfV02Lf9EymZNNFFUanC', 'poggers@pogchamp.com'),
(7, 'kj2', '$2y$10$rPsirQrHzEYbFtgyenbEQ.lyIFciTDSvG2/89yBUkjpltIWHxjhba', 'kj123@gmail.com'),
(8, 'Siuuu', '$2y$10$7UTVa5/4ww5G2gud/PLbvegRNaJbJnaWdjaUiGlXIN3xIPFFGfj4G', 'siueue@hfhd'),
(9, 'Lol', '$2y$10$vbFjs2NnALk30vWiUDHYF.0yD9rrcgvO6wMq1CbVcFoPTMEQOuGme', 'sjdjd@jsjsh'),
(10, 'yousaf', '$2y$10$V2Saem42R8IHjzx5hDF5ROgNzNYSb.VOXdPY0VWBzcUyVQ.ijiq4.', 'iwasnothere@hotmail.com'),
(11, 'animeluvr', '$2y$10$VB9AXFCG9g8ribsY9rtWiO2HUWP7vr0993Q9sNcVWZ1aE9HG4VP96', 'animeluvr@gmail.com'),
(12, '1232', '$2y$10$xg/uAXfaGAiIzJcyvfQzk..BAzMdodX339PO0h8/tf1WlxZ543Yha', '1232@email.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `pid` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
