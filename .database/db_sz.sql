-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+jammy2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 12, 2024 at 02:01 PM
-- Server version: 8.0.36-0ubuntu0.22.04.1
-- PHP Version: 8.3.2-1+ubuntu22.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zaverecne_zadanie`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int NOT NULL,
  `question_code` int NOT NULL,
  `answer` varchar(255) NOT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `count` int NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `date_archived` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_code`, `answer`, `is_correct`, `count`, `date_created`, `date_archived`) VALUES
(1, 12345, '[value-2]', 0, 1, '2024-05-05 00:43:30', NULL),
(2, 12345, 'answer baby', NULL, 1, '2024-05-04 22:49:38', NULL),
(3, 54321, 'answer baby 2', 0, 1, '2024-05-05 00:52:52', NULL),
(4, 10000, 'answer baby 2', 0, 1, '2024-05-05 13:41:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `multi_choice_answer_archives`
--

CREATE TABLE `multi_choice_answer_archives` (
  `id` int NOT NULL,
  `answer_id` int NOT NULL,
  `count` int NOT NULL DEFAULT '0',
  `date_archived` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `code` int NOT NULL,
  `subject_id` int NOT NULL,
  `user_id` int NOT NULL,
  `question` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `is_open_ended` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`code`, `subject_id`, `user_id`, `question`, `date_created`, `is_open_ended`) VALUES
(10000, 1, 1, '[value-4]', '2000-01-01 00:00:00', 0),
(12345, 1, 1, '[value-4]', '2000-01-01 00:00:00', 0),
(54321, 2, 3, 'preco ja?', '2024-05-05 15:21:43', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int NOT NULL,
  `subject` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject`) VALUES
(1, 'WEBTE2'),
(2, 'VSA'),
(3, 'UHD'),
(4, 'AS');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `surname`, `password`, `admin`) VALUES
(1, 'eyo', 'John', 'Doe', '', 1),
(3, '[value-1]', '[value-3]', '[value-4]', '', 0),
(4, 'example@example.com', 'John', 'Doe', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_ibfk_1` (`question_code`);

--
-- Indexes for table `multi_choice_answer_archives`
--
ALTER TABLE `multi_choice_answer_archives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `multi_choice_answer_archives_ibfk_1` (`answer_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`code`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `questions_ibfk_2` (`user_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
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
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `multi_choice_answer_archives`
--
ALTER TABLE `multi_choice_answer_archives`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `code` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54322;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_code`) REFERENCES `questions` (`code`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `multi_choice_answer_archives`
--
ALTER TABLE `multi_choice_answer_archives`
  ADD CONSTRAINT `multi_choice_answer_archives_ibfk_1` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
