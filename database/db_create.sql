-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 27, 2021 at 07:48 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

DROP TABLE IF EXISTS fieldsubmissions;
DROP TABLE IF EXISTS formsubmissions;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS formfields;
DROP TABLE IF EXISTS formtypemappings;
DROP TABLE IF EXISTS formtypes;
DROP TABLE IF EXISTS forms;
DROP TABLE IF EXISTS formfieldtypes;
DROP TABLE IF EXISTS roles;

--
-- Table structure for table `fieldsubmissions`
--

CREATE TABLE `fieldsubmissions` (
  `id` int(11) NOT NULL,
  `formsubmissionid` int(11) NOT NULL,
  `value` mediumtext,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `size` int(11) NOT NULL DEFAULT '20'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(2, 'Checkbox');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`) VALUES
(2, 'Test Form'),
(3, 'Another Test Form');

-- --------------------------------------------------------

--
-- Table structure for table `formsubmissions`
--

CREATE TABLE `formsubmissions` (
  `id` int(11) NOT NULL,
  `formid` int(11) NOT NULL,
  `when` datetime DEFAULT CURRENT_TIMESTAMP,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `formtypemappings`
--

CREATE TABLE `formtypemappings` (
  `formid` int(11) NOT NULL DEFAULT '0',
  `typeid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formtypemappings`
--

INSERT INTO `formtypemappings` (`formid`, `typeid`) VALUES
(3, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `formtypes`
--

CREATE TABLE `formtypes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formtypes`
--

INSERT INTO `formtypes` (`id`, `name`) VALUES
(1, 'Student Profile'),
(2, 'Fieldwork Site Profile'),
(3, 'Test Type');

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
(3, 'site@muskingum.edu', 'Test Site', '$2y$10$BAR09FRDyy66TgVb9BRpWOdLrAaLVnihDYS/OO9fkkqdUjdRPdRAG', 3, NULL, NULL, 1);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formsubmissions`
--
ALTER TABLE `formsubmissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formid` (`formid`),
  ADD KEY `user` (`user`);

--
-- Indexes for table `formtypemappings`
--
ALTER TABLE `formtypemappings`
  ADD PRIMARY KEY (`formid`,`typeid`),
  ADD KEY `typeid` (`typeid`);

--
-- Indexes for table `formtypes`
--
ALTER TABLE `formtypes`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fieldsubmissions`
--
ALTER TABLE `fieldsubmissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `formfields`
--
ALTER TABLE `formfields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `formfieldtypes`
--
ALTER TABLE `formfieldtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `formsubmissions`
--
ALTER TABLE `formsubmissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `formtypes`
--
ALTER TABLE `formtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
  ADD CONSTRAINT `formfields_ibfk_2` FOREIGN KEY (`form`) REFERENCES `forms` (`id`);

--
-- Constraints for table `formsubmissions`
--
ALTER TABLE `formsubmissions`
  ADD CONSTRAINT `formsubmissions_ibfk_1` FOREIGN KEY (`formid`) REFERENCES `forms` (`id`),
  ADD CONSTRAINT `formsubmissions_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `formtypemappings`
--
ALTER TABLE `formtypemappings`
  ADD CONSTRAINT `formtypemappings_ibfk_1` FOREIGN KEY (`formid`) REFERENCES `forms` (`id`),
  ADD CONSTRAINT `formtypemappings_ibfk_2` FOREIGN KEY (`typeid`) REFERENCES `formtypes` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
