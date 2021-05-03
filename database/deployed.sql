-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 03, 2021 at 09:49 AM
-- Server version: 10.0.38-MariaDB-cll-lve
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cpsc455spring2021`
--

-- --------------------------------------------------------

--
-- Drop old tables if they exist
--

DROP TABLE IF EXISTS usersitemappings;
DROP TABLE IF EXISTS fieldsubmissions;
DROP TABLE IF EXISTS formsubmissions;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS formfields;
DROP TABLE IF EXISTS forms;
DROP TABLE IF EXISTS formfieldtypes;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS fieldworksites;

--
-- Table structure for table `fieldsubmissions`
--

CREATE TABLE `fieldsubmissions` (
  `id` int(11) NOT NULL,
  `formsubmissionid` int(11) NOT NULL,
  `value` mediumtext,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` longblob,
  `content_type` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fieldsubmissions`
--

INSERT INTO `fieldsubmissions` (`id`, `formsubmissionid`, `value`, `type`, `name`, `file`, `content_type`, `size`) VALUES
(74, 9, 'Don', 1, 'Name', NULL, NULL, NULL),
(75, 9, 'don@gmail.com', 1, 'Email', NULL, NULL, NULL),
(76, 10, 'Frank', 1, 'FirstName', NULL, NULL, NULL),
(77, 10, '', 1, 'MiddleInitial', NULL, NULL, NULL),
(78, 10, 'No', 1, 'LastName', NULL, NULL, NULL),
(79, 10, '2021-05-03', 3, 'Date', NULL, NULL, NULL),
(80, 10, '1', 2, 'Male', NULL, NULL, NULL),
(81, 10, '0', 2, 'Female', NULL, NULL, NULL),
(82, 10, '1998-07-26', 3, 'DOB', NULL, NULL, NULL),
(83, 10, '1', 4, 'Immunization', NULL, NULL, NULL),
(84, 3, 'Student', 1, 'FirstName', NULL, NULL, NULL),
(85, 3, '', 1, 'MiddleInitial', NULL, NULL, NULL),
(86, 3, 'Two', 1, 'LastName', NULL, NULL, NULL),
(87, 3, '2021-05-03', 3, 'Date', NULL, NULL, NULL),
(88, 3, '1', 2, 'Male', NULL, NULL, NULL),
(89, 3, '0', 2, 'Female', NULL, NULL, NULL),
(90, 3, '2000-04-19', 3, 'DOB', NULL, NULL, NULL),
(91, 3, '1', 4, 'Immunization', NULL, NULL, NULL),
(92, 4, 'Student', 1, 'FirstName', NULL, NULL, NULL),
(93, 4, '', 1, 'MiddleInitial', NULL, NULL, NULL),
(94, 4, 'Two', 1, 'LastName', NULL, NULL, NULL),
(95, 4, '111 Cat Ave', 1, 'Address', NULL, NULL, NULL),
(96, 4, '7402222222', 1, 'Phone', NULL, NULL, NULL),
(97, 4, '2000-04-19', 3, 'DOB', NULL, NULL, NULL),
(98, 4, '1', 2, 'Male', NULL, NULL, NULL),
(99, 4, '0', 2, 'Female', NULL, NULL, NULL),
(100, 5, 'Student', 1, 'FirstName', NULL, NULL, NULL),
(101, 5, '', 1, 'MiddleInitial', NULL, NULL, NULL),
(102, 5, 'Three', 1, 'LastName', NULL, NULL, NULL),
(103, 5, '2021-05-03', 3, 'Date', NULL, NULL, NULL),
(104, 5, '0', 2, 'Male', NULL, NULL, NULL),
(105, 5, '1', 2, 'Female', NULL, NULL, NULL),
(106, 5, '1998-07-26', 3, 'DOB', NULL, NULL, NULL),
(107, 5, '1', 4, 'Immunization', NULL, NULL, NULL),
(108, 6, 'Student', 1, 'FirstName', NULL, NULL, NULL),
(109, 6, '', 1, 'MiddleInitial', NULL, NULL, NULL),
(110, 6, 'Three', 1, 'LastName', NULL, NULL, NULL),
(111, 6, '113 Cat Ave', 1, 'Address', NULL, NULL, NULL),
(112, 6, '7403333333', 1, 'Phone', NULL, NULL, NULL),
(113, 6, '1998-07-26', 3, 'DOB', NULL, NULL, NULL),
(114, 6, '0', 2, 'Male', NULL, NULL, NULL),
(115, 6, '1', 2, 'Female', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fieldworksites`
--

CREATE TABLE `fieldworksites` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fieldworksites`
--

INSERT INTO `fieldworksites` (`id`, `name`) VALUES
(1, 'Test Site 1'),
(4, 'Test site 3');

-- --------------------------------------------------------

--
-- Table structure for table `formfields`
--

CREATE TABLE `formfields` (
  `id` int(11) NOT NULL,
  `form` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `default` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `fieldname` varchar(255) NOT NULL,
  `eol` tinyint(1) NOT NULL DEFAULT '1',
  `size` int(11) NOT NULL DEFAULT '20',
  `required` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formfields`
--

INSERT INTO `formfields` (`id`, `form`, `type`, `label`, `default`, `order`, `fieldname`, `eol`, `size`, `required`) VALUES
(9, 2, 1, 'First Name', NULL, 1, 'FirstName', 0, 10, 1),
(10, 2, 3, 'Date', NULL, 4, 'Date', 1, 20, 1),
(12, 2, 1, 'MI', NULL, 2, 'MiddleInitial', 0, 1, 0),
(13, 2, 1, 'Last Name', NULL, 3, 'LastName', 1, 10, 1),
(14, 2, 2, 'Male', NULL, 5, 'Male', 0, 20, 0),
(15, 2, 2, 'Female', NULL, 6, 'Female', 1, 20, 0),
(17, 3, 1, 'Site Name', NULL, 1, 'SiteName', 0, 15, 1),
(18, 3, 3, 'Date', NULL, 4, 'Date', 0, 20, 1),
(19, 3, 1, 'Location', NULL, 5, 'Location', 1, 50, 1),
(20, 3, 1, 'Fieldwork Supervisor', NULL, 2, 'Supervisor', 0, 15, 1),
(21, 3, 1, 'Email', NULL, 3, 'Email', 1, 25, 1),
(22, 5, 1, 'First Name', NULL, 1, 'FirstName', 0, 15, 1),
(23, 5, 1, 'MI', NULL, 2, 'MiddleInitial', 0, 1, 0),
(24, 5, 1, 'Last Name', NULL, 3, 'LastName', 1, 15, 1),
(25, 5, 3, 'Date', NULL, 4, 'Date', 0, 20, 1),
(26, 5, 2, 'Male', NULL, 5, 'Male', 0, 20, 0),
(27, 5, 2, 'Female', NULL, 6, 'Female', 1, 20, 0),
(28, 5, 3, 'DOB', NULL, 7, 'DOB', 0, 20, 1),
(29, 5, 4, 'Immunization Record', NULL, 8, 'Immunization', 1, 20, 0),
(30, 6, 1, 'First Name', NULL, 1, 'FirstName', 0, 15, 1),
(31, 6, 1, 'MI', NULL, 2, 'MiddleInitial', 0, 1, 0),
(32, 6, 1, 'Last Name', NULL, 3, 'LastName', 1, 15, 1),
(33, 6, 3, 'DOB', NULL, 6, 'DOB', 1, 20, 1),
(34, 6, 1, 'Address', NULL, 4, 'Address', 1, 50, 1),
(35, 6, 1, 'Phone', NULL, 5, 'Phone', 0, 15, 1),
(36, 6, 2, 'Male', NULL, 7, 'Male', 0, 20, 0),
(37, 6, 2, 'Female', NULL, 8, 'Female', 1, 20, 0),
(50, 13, 1, 'First name 2', NULL, 1, 'First name 2', 1, 10, 1),
(51, 13, 1, 'Middle initial', NULL, 2, 'Middle inital', 0, 1, 0),
(52, 13, 1, 'Last name', NULL, 3, 'Last name', 1, 15, 1),
(53, 13, 3, 'date', NULL, 4, 'date', 0, 20, 0),
(54, 14, 1, 'Name', NULL, 1, 'Name', 0, 10, 1),
(55, 14, 1, 'Email', NULL, 2, 'Email', 1, 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `formfieldtypes`
--

CREATE TABLE `formfieldtypes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formfieldtypes`
--

INSERT INTO `formfieldtypes` (`id`, `name`) VALUES
(1, 'Edit Field'),
(2, 'Checkbox'),
(3, 'Date'),
(4, 'File Upload');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `roleid` int(11) NOT NULL,
  `student` tinyint(1) NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `sitevisible` tinyint(1) NOT NULL DEFAULT '0',
  `siteid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`, `roleid`, `student`, `archived`, `sitevisible`, `siteid`) VALUES
(2, 'Site Form 1', 3, 1, 0, 0, NULL),
(3, 'Site Form 2', 3, 0, 0, 0, 1),
(5, 'Student Form 1', 2, 0, 0, 1, 1),
(6, 'Student Form 2', 2, 0, 0, 0, NULL),
(13, 'New Form', 2, 0, 1, 0, NULL),
(14, 'Admin Form', 1, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `formsubmissions`
--

CREATE TABLE `formsubmissions` (
  `id` int(11) NOT NULL,
  `formid` int(11) NOT NULL,
  `when` datetime DEFAULT CURRENT_TIMESTAMP,
  `user` int(11) NOT NULL,
  `siteid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formsubmissions`
--

INSERT INTO `formsubmissions` (`id`, `formid`, `when`, `user`, `siteid`) VALUES
(3, 5, '2021-05-03 09:45:07', 4, NULL),
(4, 6, '2021-05-03 09:45:42', 4, NULL),
(5, 5, '2021-05-03 09:48:43', 5, NULL),
(6, 6, '2021-05-03 09:49:12', 5, NULL),
(9, 14, '2021-05-03 09:17:19', 1, NULL),
(10, 5, '2021-05-03 09:23:59', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Student'),
(3, 'Fieldwork Site');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_issued` datetime DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `role`, `token`, `token_issued`, `disabled`) VALUES
(1, 'admin@muskingum.edu', 'Test Admin', '$2y$10$BAR09FRDyy66TgVb9BRpWOdLrAaLVnihDYS/OO9fkkqdUjdRPdRAG', 1, NULL, NULL, 0),
(2, 'student@muskingum.edu', 'Test Student', '$2y$10$BAR09FRDyy66TgVb9BRpWOdLrAaLVnihDYS/OO9fkkqdUjdRPdRAG', 2, NULL, NULL, 0),
(3, 'site@muskingum.edu', 'Site User One', '$2y$10$BAR09FRDyy66TgVb9BRpWOdLrAaLVnihDYS/OO9fkkqdUjdRPdRAG', 3, NULL, NULL, 0),
(4, 'student2@muskingum.edu', 'Student Two', '$2y$10$BAR09FRDyy66TgVb9BRpWOdLrAaLVnihDYS/OO9fkkqdUjdRPdRAG', 2, NULL, NULL, 0),
(5, 'student3@muskingum.edu', 'Student Three', '$2y$10$BAR09FRDyy66TgVb9BRpWOdLrAaLVnihDYS/OO9fkkqdUjdRPdRAG', 2, NULL, NULL, 0),
(6, 'site2@muskingum.edu', 'Site User Two', '$2y$10$BAR09FRDyy66TgVb9BRpWOdLrAaLVnihDYS/OO9fkkqdUjdRPdRAG', 3, NULL, NULL, 0),
(7, 'site3@muskingum.edu', 'Site User Three', '$2y$10$BAR09FRDyy66TgVb9BRpWOdLrAaLVnihDYS/OO9fkkqdUjdRPdRAG', 3, NULL, NULL, 0),
(9, 'site@test.com', 'Site Test', NULL, 3, 'c94171306f75db', '2021-05-03 07:35:47', 0),
(10, 'frank@gmail.com', 'Frank', NULL, 2, 'c2943122441e97', '2021-05-03 09:03:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usersitemappings`
--

CREATE TABLE `usersitemappings` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `siteid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usersitemappings`
--

INSERT INTO `usersitemappings` (`userid`, `siteid`) VALUES
(4, 1),
(3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fieldsubmissions`
--
ALTER TABLE `fieldsubmissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formsubmissionid` (`formsubmissionid`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `fieldworksites`
--
ALTER TABLE `fieldworksites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formfields`
--
ALTER TABLE `formfields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `form` (`form`);

--
-- Indexes for table `formfieldtypes`
--
ALTER TABLE `formfieldtypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forms_ibfk_1` (`roleid`),
  ADD KEY `forms_ibfk_2` (`siteid`);

--
-- Indexes for table `formsubmissions`
--
ALTER TABLE `formsubmissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formid` (`formid`),
  ADD KEY `user` (`user`),
  ADD KEY `formsubmissions_ibfk_3` (`siteid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `usersitemappings`
--
ALTER TABLE `usersitemappings`
  ADD KEY `usersitemappings_ibfk_1` (`userid`),
  ADD KEY `usersitemappings_ibfk_2` (`siteid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fieldsubmissions`
--
ALTER TABLE `fieldsubmissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `fieldworksites`
--
ALTER TABLE `fieldworksites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `formfields`
--
ALTER TABLE `formfields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `formfieldtypes`
--
ALTER TABLE `formfieldtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `formsubmissions`
--
ALTER TABLE `formsubmissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fieldsubmissions`
--
ALTER TABLE `fieldsubmissions`
  ADD CONSTRAINT `fieldsubmissions_ibfk_1` FOREIGN KEY (`formsubmissionid`) REFERENCES `formsubmissions` (`id`),
  ADD CONSTRAINT `fieldsubmissions_ibfk_2` FOREIGN KEY (`type`) REFERENCES `formfieldtypes` (`id`);

--
-- Constraints for table `formfields`
--
ALTER TABLE `formfields`
  ADD CONSTRAINT `formfields_ibfk_1` FOREIGN KEY (`type`) REFERENCES `formfieldtypes` (`id`),
  ADD CONSTRAINT `formfields_ibfk_2` FOREIGN KEY (`form`) REFERENCES `forms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `forms_ibfk_2` FOREIGN KEY (`siteid`) REFERENCES `fieldworksites` (`id`);

--
-- Constraints for table `formsubmissions`
--
ALTER TABLE `formsubmissions`
  ADD CONSTRAINT `formsubmissions_ibfk_1` FOREIGN KEY (`formid`) REFERENCES `forms` (`id`),
  ADD CONSTRAINT `formsubmissions_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `formsubmissions_ibfk_3` FOREIGN KEY (`siteid`) REFERENCES `fieldworksites` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);

--
-- Constraints for table `usersitemappings`
--
ALTER TABLE `usersitemappings`
  ADD CONSTRAINT `usersitemappings_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `usersitemappings_ibfk_2` FOREIGN KEY (`siteid`) REFERENCES `fieldworksites` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
