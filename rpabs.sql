-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2023 at 04:19 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpabs`
--

-- --------------------------------------------------------

--
-- Table structure for table `complete`
--

CREATE TABLE `complete` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dateModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ongoing`
--

CREATE TABLE `ongoing` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dateModified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ongoing`
--

INSERT INTO `ongoing` (`id`, `fName`, `lName`, `email`, `password`, `dateModified`) VALUES
(50, 'Ariel', 'Nazareno', 'arielnazareno@gmail.com', 'arielnazareno16', '2023-07-10 02:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `pfPicture` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cPassword` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `fName`, `lName`, `pfPicture`, `email`, `password`, `cPassword`, `timestamp`) VALUES
(1, 'admin', '123', '', 'admin@gmail.com', 'admin123456789', 'admin123456789', '2023-07-08 15:04:00'),
(26, 'Miko', 'Yae', 'uploads/GenshinImpact_YaeMikoWallpaper4.jpg', 'miko@gmail.com', 'yaeyaemiko12345', 'yaeyaemiko12345', '2023-07-09 13:25:30'),
(28, 'AlHaitham', 'Abu', 'uploads/alhaitham-birthday-art-genshinimpact.jpg', 'haitham@gmail.com', 'onlyforkavehveh23', 'onlyforkavehveh23', '2023-07-09 04:13:24'),
(30, 'Kaveh', 'Nannn', 'uploads/kaveh-kit-genshin-impact.jpeg', 'kavskibebe@gmail.com', 'alhaithambentetres', 'alhaithambentetres', '2023-07-09 13:22:19'),
(49, 'Genesis', 'Medina', 'uploads/Yae-Miko-birthday-art-2022-genshinimpact.jpg', 'c@g.com', 'genesis123456789', 'genesis123456789', '2023-07-09 13:27:51'),
(50, 'Ariel', 'Nazareno', 'uploads/official-raiden-shogun-birthday-art-from-genshin-twitter-v0-b364b3byga8b1 .jpeg', 'arielnazareno@gmail.com', 'arielnazareno16', 'arielnazareno16', '2023-07-10 01:20:11'),
(51, 'Wilmer', 'Abiera', 'uploads/kaveh-kit-genshin-impact.jpeg', 'john@gmail.com', 'wilmer123456789', 'wilmer123456789', '2023-07-10 01:42:15'),
(52, 'Yel', 'Nazareno', 'uploads/kaveh-kit-genshin-impact.jpeg', 'arielnazareno@yahoo.com', 'arielnazareno16', 'arielnazareno16', '2023-07-10 02:00:27');

--
-- Triggers `userinfo`
--
DELIMITER $$
CREATE TRIGGER `copy_userInfo_trigger` AFTER INSERT ON `userinfo` FOR EACH ROW BEGIN
    INSERT INTO userInfoCopy (id, fName, lName, email, password, pfPicture, cPassword, timestamp)
    VALUES (NEW.id, NEW.fName, NEW.lName, NEW.email, NEW.password, NEW.pfPicture, NEW.cPassword, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `userinfocopy`
--

CREATE TABLE `userinfocopy` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) DEFAULT NULL,
  `lName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pfPicture` varchar(255) DEFAULT NULL,
  `cPassword` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfocopy`
--

INSERT INTO `userinfocopy` (`id`, `fName`, `lName`, `email`, `password`, `pfPicture`, `cPassword`, `timestamp`) VALUES
(51, 'Wilmer', 'Abiera', 'john@gmail.com', 'wilmer123456789', 'uploads/official-raiden-shogun-birthday-art-from-genshin-twitter-v0-b364b3byga8b1 .jpeg', 'wilmer123456789', '2023-07-10 01:41:43'),
(52, 'Yel', 'Nazareno', 'arielnazareno@yahoo.com', 'arielnazareno16', 'uploads/kaveh-kit-genshin-impact.jpeg', 'arielnazareno16', '2023-07-10 02:00:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complete`
--
ALTER TABLE `complete`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ongoing`
--
ALTER TABLE `ongoing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinfocopy`
--
ALTER TABLE `userinfocopy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complete`
--
ALTER TABLE `complete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `ongoing`
--
ALTER TABLE `ongoing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
