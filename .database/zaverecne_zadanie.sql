-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: May 15, 2024 at 09:15 AM
-- Server version: 8.0.32
-- PHP Version: 8.2.8

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
  `count` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_code`, `answer`, `is_correct`, `count`) VALUES
(1, 12345, '[value-2]', 0, 0),
(2, 12345, 'answer baby', NULL, 0),
(3, 54321, 'answer baby 2', 0, 1),
(4, 10000, 'answer baby 2', 0, 1),
(9, 28081, 'test answer1', 0, 0),
(10, 13717, 'test answer1', 0, 0),
(11, 13717, 'test answer2', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `id` int UNSIGNED NOT NULL,
  `question_code` int NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `archive_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `archive`
--

INSERT INTO `archive` (`id`, `question_code`, `notes`, `archive_time`) VALUES
(1, 12345, 'Archived answers for question code 12345', '2024-05-14 19:49:34'),
(2, 49490, 'Archived answers for question code 49490', '2024-05-14 19:50:35'),
(3, 49490, 'my noteeee n', '2024-05-14 19:55:08'),
(4, 12345, 'my noteee is', '2024-05-14 21:21:33'),
(7, 49490, 'maybe my final test?', '2024-05-15 11:01:03'),
(8, 52220, 'last test answer noteee', '2024-05-15 11:12:41');

-- --------------------------------------------------------

--
-- Table structure for table `archived_answers`
--

CREATE TABLE `archived_answers` (
  `id` int UNSIGNED NOT NULL,
  `archive_id` int UNSIGNED NOT NULL,
  `answer` varchar(255) NOT NULL,
  `count` int NOT NULL,
  `is_correct` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `archived_answers`
--

INSERT INTO `archived_answers` (`id`, `archive_id`, `answer`, `count`, `is_correct`) VALUES
(1, 1, '[value-2]', 1, 0),
(2, 1, 'answer baby', 1, NULL),
(4, 2, 'this is my answer', 2, 0),
(5, 2, 'this is my answerr', 2, 0),
(6, 2, 'this is my answerrr', 1, 0),
(7, 2, 'this is my answerrrr', 2, 0),
(11, 3, 'this is my answer', 0, 0),
(12, 3, 'this is my answerr', 0, 0),
(13, 3, 'this is my answerrr', 0, 0),
(14, 3, 'this is my answerrrr', 0, 0),
(18, 4, '[value-2]', 0, 0),
(19, 4, 'answer baby', 0, NULL),
(22, 7, 'this is my answer', 0, 0),
(23, 7, 'this is my answerr', 0, 0),
(24, 7, 'this is my answerrr', 0, 0),
(25, 7, 'this is my answerrrr', 0, 0),
(29, 8, 'last test answer', 2, NULL);

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
(13717, 3, 5, 'string??', '2024-05-14 22:50:31', 0),
(27791, 2, 5, 'testOtazka?', '2024-05-14 22:44:58', 0),
(28081, 2, 5, 'testOtazka?', '2024-05-14 22:49:51', 0),
(49490, 4, 5, 'Correct q 2', '2024-05-14 17:39:10', 1),
(52220, 1, 5, 'posledna test otazka?', '2024-05-15 11:04:29', 1),
(54321, 2, 3, 'preco ja?', '2024-05-05 15:21:43', 0),
(81049, 2, 5, 'testOtazka?', '2024-05-14 22:42:09', 0);

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
(4, 'example@example.com', 'John', 'Doe', '', 0),
(5, 'flori@flo.com', 'flori', 'jurik', '$argon2id$v=19$m=65536,t=4,p=1$Nm1BU05CWXc2b3pFZ09VaA$t7igzxrF2Ss9LyPaUt0xFYvH0kZZkDX6Dcj2GfiYmns', 0),
(6, 'xjanosa@stuba.sk', 'Adam', 'Jánoš', '$argon2id$v=19$m=65536,t=4,p=1$YjVFQ2d2VXN3enBJT0swdA$MDegF/yfHOs9ow/ck6moYSWE8JY95kcrjL3qXCOia/I', 1),
(7, 'root@example.com', 'Root', 'Root', '$argon2id$v=19$m=65536,t=4,p=1$NDNMMDhJZnRsQXFJN0czaQ$G/ZgBi6V+Z/jEtzTriiFxKx8/35e/ToGVqD+IM+H+cM', 1);

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
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_code` (`question_code`);

--
-- Indexes for table `archived_answers`
--
ALTER TABLE `archived_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `archive_id` (`archive_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `archived_answers`
--
ALTER TABLE `archived_answers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `code` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87567;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_code`) REFERENCES `questions` (`code`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `archive`
--
ALTER TABLE `archive`
  ADD CONSTRAINT `archive_ibfk_1` FOREIGN KEY (`question_code`) REFERENCES `questions` (`code`) ON DELETE CASCADE;

--
-- Constraints for table `archived_answers`
--
ALTER TABLE `archived_answers`
  ADD CONSTRAINT `archived_answers_ibfk_1` FOREIGN KEY (`archive_id`) REFERENCES `archive` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

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
