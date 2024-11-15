-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 15, 2024 at 01:54 AM
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
-- Database: `eventapp`
--
CREATE DATABASE IF NOT EXISTS `eventapp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `eventapp`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `eventcomments`
--

CREATE TABLE `eventcomments` (
  `comment_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `eventmedia`
--

CREATE TABLE `eventmedia` (
  `media_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `media_url` varchar(255) DEFAULT NULL,
  `media_type` enum('image','video','other') DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eventmedia`
--

INSERT INTO `eventmedia` (`media_id`, `event_id`, `media_url`, `media_type`, `uploaded_at`) VALUES
(1, 2, 'uploads/event_media/1731350547_2be51fef7ecf6efb8ebc.jpg', '', '2024-11-11 18:42:27'),
(3, 5, 'uploads/event_media/1731618350_c1024fdcb3d31fcc6665.jpg', '', '2024-11-14 21:05:50');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `eventratings`
--

CREATE TABLE `eventratings` (
  `rating_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `eventregistrations`
--

CREATE TABLE `eventregistrations` (
  `registration_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eventregistrations`
--

INSERT INTO `eventregistrations` (`registration_id`, `event_id`, `user_id`, `is_anonymous`, `created_at`, `updated_at`) VALUES
(6, 2, 6, 1, '2024-11-11 16:13:15', '2024-11-11 17:13:15'),
(7, 3, 5, 1, '2024-11-13 19:01:08', '2024-11-13 20:01:08'),
(9, 2, 5, 1, '2024-11-14 14:50:06', '2024-11-14 15:50:06'),
(10, 4, 4, 1, '2024-11-14 19:12:20', '2024-11-14 20:12:20'),
(11, 5, 4, 1, '2024-11-14 20:05:52', '2024-11-14 21:05:52');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `max_participants` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by_user_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `name`, `description`, `start_datetime`, `end_datetime`, `location_id`, `max_participants`, `created_at`, `created_by_user_id`, `updated_at`) VALUES
(2, 'awdawd1', 'awdawdawawd1', '2024-11-02 19:40:00', '2024-11-16 19:40:00', 2, 254, '2024-11-09 18:40:34', 4, '2024-11-11 18:26:14'),
(3, 'awdawd', 'awdawdawdawdawdawd', '2024-11-01 16:27:00', '2024-11-23 16:27:00', 3, 213, '2024-11-11 15:27:39', 4, '2024-11-11 15:27:39'),
(4, 'vweqvevQQWDQWD123', 'ACVEQAWDQWAWDAWDQ23Q2AD', '2024-10-23 16:45:00', '2024-11-07 16:45:00', 4, 2314, '2024-11-11 15:45:21', 4, '2024-11-11 15:45:21'),
(5, 'testtest', 'testtesttest', '2024-11-15 22:05:00', '2024-11-22 22:05:00', 5, 15, '2024-11-14 21:05:41', 4, '2024-11-14 21:05:41');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `name`, `address`, `latitude`, `longitude`) VALUES
(2, 'location name1', 'location address1', NULL, NULL),
(3, 'awdawdawdawd', 'aadwawdawd', NULL, NULL),
(4, 'awdawda', 'wdawdawdawdawd', NULL, NULL),
(5, 'location name', 'location address', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `notification_type` enum('email','push') DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `hashed_password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `hashed_password`, `created_at`) VALUES
(1, 'adawdawd', 'awdawd@awdaw.d', '$2y$10$0svu3/JONvAe33..YGvs6.YRWT8XAKQfDW2rDKdHmWSxXdQGdK/oa', '2024-11-03 15:45:33'),
(2, 'adawdawd', 'awdawd@awdaw.dd', '$2y$10$ZdrTXMq.kAHbr29/WRitYO7noSIjXoEWd0seE1OqT7JSH6UTUmKGq', '2024-11-03 15:46:28'),
(3, 'abc', 'awdawd@adw.daw', '$2y$10$DWlw.fht4CnpPes.3yj5p.dWjWRDT3axmwrWlSrqw1Dh9Tv7/5q2y', '2024-11-03 15:47:21'),
(4, 'user3', 'user@user.com', '$2y$10$NeLq4bJJ2y/1/ZQPne./PuUQFNwmHuw3ew3THDgdtwJ4KYa3Qt4tu', '2024-11-03 15:56:58'),
(5, 'userTest1', 'userTest1@user.com', '$2y$10$X3iYMgDO9FpOh5J/RCQTfO2eJXLswLvpFPdzOW.Lw.FnVdja4tsmi', '2024-11-11 17:12:04'),
(6, 'userTest2', 'userTest2@user.com', '$2y$10$bN.s8csSAIsbwgnjcmS9Z..Hwwoq2bf/CeMTahv3H6XsrO7KxJJGO', '2024-11-11 17:12:19'),
(7, 'userTest3', 'userTest3@user.com', '$2y$10$mu5Q3LFAckOl/5lCVnfMi.0hnSO9Cew8K/IydRk6UeUwBCG/czxg.', '2024-11-11 17:12:32');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `eventcomments`
--
ALTER TABLE `eventcomments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `eventmedia`
--
ALTER TABLE `eventmedia`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indeksy dla tabeli `eventratings`
--
ALTER TABLE `eventratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `eventregistrations`
--
ALTER TABLE `eventregistrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indeksy dla tabeli `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indeksy dla tabeli `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indeksy dla tabeli `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eventcomments`
--
ALTER TABLE `eventcomments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eventmedia`
--
ALTER TABLE `eventmedia`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `eventratings`
--
ALTER TABLE `eventratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eventregistrations`
--
ALTER TABLE `eventregistrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `eventcomments`
--
ALTER TABLE `eventcomments`
  ADD CONSTRAINT `eventcomments_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eventcomments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `eventmedia`
--
ALTER TABLE `eventmedia`
  ADD CONSTRAINT `eventmedia_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `eventratings`
--
ALTER TABLE `eventratings`
  ADD CONSTRAINT `eventratings_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eventratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `eventregistrations`
--
ALTER TABLE `eventregistrations`
  ADD CONSTRAINT `eventregistrations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
