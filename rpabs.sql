-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2023 at 12:06 PM
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
-- Table structure for table `addson`
--

CREATE TABLE `addson` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `picture` longtext NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addson`
--

INSERT INTO `addson` (`id`, `title`, `picture`, `description`) VALUES
(1, 'AddsOn 1', 'uploads\\alhaitham-birthday-art-genshinimpact.jpg', 'Lorem'),
(2, 'Adds on 2', 'uploads\\F0kQliLXsAEi8ic.jpg', 'lor'),
(3, 'Adds on 3', 'uploads\\GenshinImpact_YaeMikoWallpaper4.jpg', 'lor'),
(4, 'addson 4', 'uploads\\kaveh-kit-genshin-impact.jpeg', 'lor'),
(5, 'adds on 5', 'uploads\\pexels-thorsten-technoman-338504.jpg', 'lor'),
(6, 'adds on 6', 'uploads\\Screenshot_2022-12-10_192218.jpg', 'lor'),
(7, 'adds on 7', 'uploads\\Yae-Miko-birthday-art-2022-genshinimpact.jpg', 'lor');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `aID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `addOn` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `appointment`
--
DELIMITER $$
CREATE TRIGGER `tr_copy_appointment_to_toastnotif` AFTER INSERT ON `appointment` FOR EACH ROW BEGIN
    INSERT INTO toastnotif (aID, fName, lName, title, email, date, addOn, timestamp)
    VALUES (NEW.aID, NEW.fName, NEW.lName, NEW.title, NEW.email, NEW.date, NEW.addOn, NEW.timestamp);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `complete`
--

CREATE TABLE `complete` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL
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
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `rID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `picture` longtext NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`rID`, `title`, `picture`, `description`) VALUES
(2, 'Room 300', 'uploads\\kaveh-kit-genshin-impact.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed egestas tristique porta. Nulla consectetur nibh libero, quis venenatis libero tristique.'),
(3, 'Room 208', 'uploads/pexels-thorsten-technoman-338504.jpg\r\n', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed egestas tristique porta. Nulla consectetur nibh libero, quis venenatis libero tristique.'),
(4, 'Room 101', 'uploads/pexels-thorsten-technoman-338504.jpg\nuploads/GenshinImpact_YaeMikoWallpaper4.jpg\nuploads/Screenshot 2022-12-10 192218.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed egestas tristique porta. Nulla consectetur nibh libero, quis venenatis libero tristique.'),
(5, 'Room 202', 'uploads\\Screenshot_2022-12-10_192218.jpg', 'lor');

-- --------------------------------------------------------

--
-- Table structure for table `toastnotif`
--

CREATE TABLE `toastnotif` (
  `toastID` int(11) NOT NULL,
  `aID` int(11) DEFAULT NULL,
  `fName` varchar(255) DEFAULT NULL,
  `lName` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `addOn` varchar(255) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'admin', '123', '', 'admin@gmail.com', 'admin123456789', 'admin123456789', '2023-07-08 15:04:00');

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
-- Indexes for dumped tables
--

--
-- Indexes for table `addson`
--
ALTER TABLE `addson`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`aID`);

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
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`rID`);

--
-- Indexes for table `toastnotif`
--
ALTER TABLE `toastnotif`
  ADD PRIMARY KEY (`toastID`);

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
-- AUTO_INCREMENT for table `addson`
--
ALTER TABLE `addson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `aID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT for table `complete`
--
ALTER TABLE `complete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT for table `ongoing`
--
ALTER TABLE `ongoing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `rID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `toastnotif`
--
ALTER TABLE `toastnotif`
  MODIFY `toastID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
