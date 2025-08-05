-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 10:55 PM
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
-- Database: `usertest`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `chat_id` varchar(64) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `chat_id`, `user_email`, `created_at`) VALUES
(1, 'chat_682ce4b4b7af64.03194177', 'adithyaraj@gmail.com', '2025-05-21 01:53:16'),
(2, 'chat_682ce4d0d898f8.47467841', 'adithyaraj@gmail.com', '2025-05-21 01:53:44'),
(3, 'chat_682ce5c9a64236.14924089', 'adithyaraj@gmail.com', '2025-05-21 01:57:53'),
(4, 'chat_682ce6413a53a6.68555070', 'adithyaraj@gmail.com', '2025-05-21 01:59:53'),
(5, 'chat_682ce671b332b5.40986834', 'adithyaraj@gmail.com', '2025-05-21 02:00:41'),
(6, 'chat_682ce74baaf5b0.87013836', 'adithyaraj@gmail.com', '2025-05-21 02:04:19'),
(7, 'chat_682ce8696d8e35.79147878', 'adithyaraj@gmail.com', '2025-05-21 02:09:05'),
(8, 'chat_682ce86dc1e459.03052993', 'adithyaraj@gmail.com', '2025-05-21 02:09:09'),
(9, 'chat_682cea740db246.81516220', 'adithyaraj@gmail.com', '2025-05-21 02:17:48'),
(10, 'chat_682cea7742de15.28648944', 'adithyaraj@gmail.com', '2025-05-21 02:17:51'),
(11, 'chat_682cebe0713046.87378379', 't@gmail.com', '2025-05-21 02:23:52'),
(12, 'chat_682cec003af289.34789007', 'adithyaraj@gmail.com', '2025-05-21 02:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `chat_id` varchar(50) NOT NULL,
  `role` enum('user','assistant') NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `chat_id`, `role`, `content`, `created_at`) VALUES
(1, 'chat_682ce86dc1e459.03052993', 'user', 'hi', '2025-05-20 20:39:09'),
(2, 'chat_682ce86dc1e459.03052993', 'assistant', 'Hello! 😊 How can I assist you today?', '2025-05-20 20:39:11'),
(3, 'chat_682cec003af289.34789007', 'user', 'how i met your moether', '2025-05-20 20:54:24'),
(4, 'chat_682cec003af289.34789007', 'assistant', 'It looks like you\'re referencing *How I Met Your Mother*, the popular TV sitcom! If you meant to ask something about the show or are looking for information, here are a few possibilities:\n\n1. **Typo?** Did you mean *How I Met Your Mother* (HIMYM)? The show follows Ted Mosby telling his kids the story of how he met their mother, with hilarious and heartfelt moments involving his friends Barney, Marshall, Lily, and Robin.\n\n2. **\"How I Met Your Father\"** – There’s also a spinoff series called *How I Met Your Father* (starring Hilary Duff), which follows a similar format but with a new cast.\n\n3. **The Mother’s Identity**: If you\'re asking about the mother (Tracy McConnell), she’s revealed in Season 9, though the show’s ending is famously divisive among fans.\n\n4. **Theories or Easter Eggs**: The show is packed with running gags (like the Slap Bet), hidden clues about the mother, and callbacks. Let me know if you’d like details!\n\nLet me know how I can help—whether it’s about episodes, characters, or the controversial ending! 😊', '2025-05-20 20:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `session_logs`
--

CREATE TABLE `session_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `distractions` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `badges` text DEFAULT NULL,
  `session_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session_logs`
--

INSERT INTO `session_logs` (`id`, `user_id`, `duration`, `distractions`, `points`, `badges`, `session_date`) VALUES
(1, 1, 3, 0, 0, '', '2025-05-10 17:04:50'),
(2, 1, 2, 0, 0, '', '2025-05-10 17:52:33'),
(3, 1, 8, 1, 0, '', '2025-05-10 17:52:51'),
(4, 1, 13, 1, 0, '', '2025-05-10 17:53:20'),
(5, 1, 2, 0, 0, '', '2025-05-10 17:54:51'),
(6, 1, 28, 1, 0, '', '2025-05-10 17:55:41'),
(7, 1, 33, 0, 0, '', '2025-05-10 17:58:59'),
(8, 1, 10, 0, 0, '', '2025-05-10 18:03:24'),
(9, 1, 24, 0, 0, '', '2025-05-10 18:03:52'),
(10, 1, 28, 0, 0, '', '2025-05-10 18:06:25'),
(11, 1, 7, 0, 0, '', '2025-05-10 18:09:25'),
(12, 1, 4, 0, 0, '', '2025-05-13 14:26:43'),
(13, 1, 9, 0, 0, '', '2025-05-13 14:49:31'),
(14, 1, 20, 0, 0, '', '2025-05-13 15:02:50'),
(15, 1, 9, 2, 0, '', '2025-05-13 15:27:59'),
(16, 1, 7, 0, 0, '', '2025-05-13 15:36:24'),
(17, 1, 5, 1, 0, '', '2025-05-13 15:36:52'),
(18, 1, 8, 1, 0, '', '2025-05-13 15:38:44'),
(19, 1, 5, 0, 0, '', '2025-05-13 15:43:41'),
(20, 1, 32, 1, 0, '', '2025-05-13 15:52:28'),
(21, 1, 4, 0, 0, '', '2025-05-13 16:00:44'),
(22, 1, 58, 1, -1, '', '2025-05-14 10:52:25'),
(23, 5, 1, 0, 0, '', '2025-05-20 22:01:19'),
(24, 1, 2, 0, 0, '', '2025-05-20 22:03:06'),
(25, 1, 2, 0, 0, '', '2025-05-20 22:03:17'),
(26, 1, 13, 0, 0, '', '2025-05-20 22:05:16'),
(27, 1, 24, 0, 0, '', '2025-05-20 22:06:00'),
(28, 1, 25, 0, 0, '', '2025-05-20 22:06:32'),
(29, 1, 12, 0, 0, '', '2025-05-20 22:07:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'adithya raj', '$2y$10$3CrWQgD48C14odioZIj6kOXMFyEMKChjp0cvaL3M1WPWBeDRglLk2', 'adithyaraj@gmail.com', '2025-05-10 19:10:37'),
(5, 'Tanmay', '$2y$10$8cdsl78KVokF8dny65TgDOwdxDig1yv3coVcJPp5P7KVwNp0PV/QC', 't@gmail.com', '2025-05-20 14:19:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chat_id` (`chat_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`);

--
-- Indexes for table `session_logs`
--
ALTER TABLE `session_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `session_logs`
--
ALTER TABLE `session_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`chat_id`) ON DELETE CASCADE;

--
-- Constraints for table `session_logs`
--
ALTER TABLE `session_logs`
  ADD CONSTRAINT `session_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
