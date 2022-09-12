-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2022 at 09:48 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cvmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `cv`
--

CREATE TABLE `cv` (
  `cv_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `position_id` int(5) NOT NULL,
  `cv_file` varchar(255) NOT NULL,
  `review_status` enum('Pending','Rejected','Approved') NOT NULL,
  `applied_at` datetime NOT NULL DEFAULT current_timestamp(),
  `handled_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `interview`
--

CREATE TABLE `interview` (
  `interview_id` int(5) NOT NULL,
  `cv_id` int(5) NOT NULL,
  `interview_date` datetime NOT NULL,
  `interview_status` enum('Pending','Finished','Interrupted') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `interviewinvitation`
--

CREATE TABLE `interviewinvitation` (
  `invitation_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `interview_id` int(5) NOT NULL,
  `invitation_title` varchar(64) NOT NULL,
  `invitation_content` varchar(255) NOT NULL,
  `invitation_status` enum('Pending','Accepted','Declined','Late') NOT NULL DEFAULT 'Pending',
  `sent_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_id` int(5) NOT NULL,
  `position_name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `position_name`) VALUES
(1, 'Backend PHP'),
(2, 'Frontend'),
(3, 'AI');

-- --------------------------------------------------------

--
-- Table structure for table `resetpassword`
--

CREATE TABLE `resetpassword` (
  `reset_id` int(5) NOT NULL,
  `reset_email` varchar(64) NOT NULL,
  `reset_selector` text NOT NULL,
  `reset_token` longtext NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(5) NOT NULL,
  `user_type` enum('admin','user') NOT NULL DEFAULT 'user',
  `username` varchar(30) NOT NULL,
  `password` varchar(128) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `gender` enum('Male','Female','Secret') CHARACTER SET utf8mb4 COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_type`, `username`, `password`, `name`, `email`, `phone_number`, `gender`) VALUES
(1, 'admin', 'admin', '$2y$10$aRRYgE7paroOmakvi6CfMuTtGiMQDyWYxzdoEbDC0lMUvfWwVTppO', 'Admin', 'admin@admin.vn', '0123456789', 'Secret');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`cv_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cv_ibfk_2` (`position_id`);

--
-- Indexes for table `interview`
--
ALTER TABLE `interview`
  ADD PRIMARY KEY (`interview_id`),
  ADD KEY `cv_id` (`cv_id`);

--
-- Indexes for table `interviewinvitation`
--
ALTER TABLE `interviewinvitation`
  ADD PRIMARY KEY (`invitation_id`),
  ADD KEY `interview_id` (`interview_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `resetpassword`
--
ALTER TABLE `resetpassword`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cv`
--
ALTER TABLE `cv`
  MODIFY `cv_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interview`
--
ALTER TABLE `interview`
  MODIFY `interview_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interviewinvitation`
--
ALTER TABLE `interviewinvitation`
  MODIFY `invitation_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `resetpassword`
--
ALTER TABLE `resetpassword`
  MODIFY `reset_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cv`
--
ALTER TABLE `cv`
  ADD CONSTRAINT `cv_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `cv_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `position` (`position_id`);

--
-- Constraints for table `interview`
--
ALTER TABLE `interview`
  ADD CONSTRAINT `interview_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv` (`cv_id`);

--
-- Constraints for table `interviewinvitation`
--
ALTER TABLE `interviewinvitation`
  ADD CONSTRAINT `interviewinvitation_ibfk_1` FOREIGN KEY (`interview_id`) REFERENCES `interview` (`interview_id`),
  ADD CONSTRAINT `interviewinvitation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
