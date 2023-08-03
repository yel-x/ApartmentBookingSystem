-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2023 at 05:58 AM
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
  `description` longtext NOT NULL,
  `price` bigint(255) NOT NULL,
  `availability` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addson`
--

INSERT INTO `addson` (`id`, `title`, `picture`, `description`, `price`, `availability`) VALUES
(9, 'Frig', 'uploads/Screenshot 2022-12-10 192218.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt facilisis pretium. Morbi vel ipsum porttitor, tempus purus consectetur, maximus mauris. Vestibulum blandit augue ac orci scelerisque tincidunt. Vestibulum vel metus ut nisi egestas placerat. Nulla posuere rutrum bibendum. Integer.', 2000, 'In-Stock'),
(15, 'Fan', 'uploads/kaveh-kit-genshin-impact.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt facilisis pretium. Morbi vel ipsum porttitor, tempus purus consectetur, maximus mauris. Vestibulum blandit augue ac orci scelerisque tincidunt. Vestibulum vel metus ut nisi egestas placerat. Nulla posuere rutrum bibendum. Integer.', 666, 'In-Stock'),
(16, 'Pool', 'uploads/GenshinImpact_YaeMikoWallpaper4.jpg', 'Lorem 1234', 222, 'Available'),
(18, 'AC', 'uploads/official-raiden-shogun-birthday-art-from-genshin-twitter-v0-b364b3byga8b1 .jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt facilisis pretium. Morbi vel ipsum porttitor, tempus purus consectetur, maximus mauris. Vestibulum blandit augue ac orci scelerisque tincidunt. Vestibulum vel metus ut nisi egestas placerat. Nulla posuere rutrum bibendum. Integer.', 444, 'Available'),
(19, 'TR', 'uploads/Yae-Miko-birthday-art-2022-genshinimpact.jpg', 'lorem 12345678', 555, 'Sold'),
(21, 'AC', 'uploads/Yae-Miko-birthday-art-2022-genshinimpact.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt facilisis pretium. Morbi vel ipsum porttitor, tempus purus consectetur, maximus mauris. Vestibulum blandit augue ac orci scelerisque tincidunt. Vestibulum vel metus ut nisi egestas placerat. Nulla posuere rutrum bibendum. Integer.', 900, 'Available');

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
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`aID`, `title`, `fName`, `lName`, `email`, `date`, `addOn`, `timestamp`) VALUES
(369, 'Room 202', 'Raiden', 'Shogun', 'miko@gmail.com', '2023-08-19', 'Frig, Fan', '2023-08-03 03:05:12');

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
  `addOn` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `addOn` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rented`
--

CREATE TABLE `rented` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `pfPicture` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cPassword` varchar(255) NOT NULL,
  `addOn` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timeRented` timestamp NOT NULL DEFAULT current_timestamp(),
  `advancePayment` bigint(255) NOT NULL,
  `dateMoved` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rented`
--

INSERT INTO `rented` (`id`, `title`, `fName`, `lName`, `pfPicture`, `email`, `password`, `cPassword`, `addOn`, `timestamp`, `timeRented`, `advancePayment`, `dateMoved`) VALUES
(28, 'Room 202', 'AlHaitham', 'Kaveh', 'uploads/alhaitham-birthday-art-genshinimpact.jpg', 'al@gmail.com', '$2y$10$ICFiBT5y21/i.lACaCqg7eyd4q4Pi6thcVB.EN4zQJt35WXECCgAG', '$2y$10$ICFiBT5y21/i.lACaCqg7eyd4q4Pi6thcVB.EN4zQJt35WXECCgAG', 'Fan, Pool, AC', '2023-08-02 17:47:41', '2023-08-02 15:10:52', 85288, '2023-08-03');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `lName` varchar(255) NOT NULL,
  `star` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `fName`, `lName`, `star`, `content`) VALUES
(18, 'Raiden', 'Shogun', '3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nulla leo, elementum ac purus eu, mollis interdum diam. Praesent quis.');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `rID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `picture` longtext NOT NULL,
  `description` longtext NOT NULL,
  `status` varchar(255) NOT NULL,
  `price` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`rID`, `title`, `picture`, `description`, `status`, `price`) VALUES
(36, 'Room 777', 'uploads/kaveh-kit-genshin-impact.jpeg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt facilisis pretium. Morbi vel ipsum porttitor, tempus purus consectetur, maximus mauris. Vestibulum blandit augue ac orci scelerisque tincidunt. Vestibulum vel metus ut nisi egestas placerat. Nulla posuere rutrum bibendum. Integer.', 'Reserved', 900),
(37, 'Room 202', 'uploads/alhaitham-birthday-art-genshinimpact.jpg\nuploads/Eqic6LpUcAAQn0J.jpg\nuploads/F0kQliLXsAEi8ic.jpg\nuploads/GenshinImpact_YaeMikoWallpaper4.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt facilisis pretium. Morbi vel ipsum porttitor, tempus purus consectetur, maximus mauris. Vestibulum blandit augue ac orci scelerisque tincidunt. Vestibulum vel metus ut nisi egestas placerat. Nulla posuere rutrum bibendum. Integer.', 'Available', 900);

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
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rentedtime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `fName`, `lName`, `pfPicture`, `email`, `password`, `cPassword`, `timestamp`, `rentedtime`) VALUES
(1, 'admin', '123', '', 'admin@gmail.com', '$2y$10$FTeuA2tH76ozYNpE4DJtl.YODjxeG8T.jokxocpY7.aGnD/1wX2G2', '$2y$10$FTeuA2tH76ozYNpE4DJtl.YODjxeG8T.jokxocpY7.aGnD/1wX2G2', '2023-08-02 08:42:18', NULL),
(90, 'Raiden', 'Shogun', 'uploads/GenshinImpact_YaeMikoWallpaper4.jpg', 'miko@gmail.com', '$2y$10$amwGrkRk8IAcU3Kr2AugUuw0BYNmSsNbMtUQPbWDB0xdsIPCc70S2', '$2y$10$amwGrkRk8IAcU3Kr2AugUuw0BYNmSsNbMtUQPbWDB0xdsIPCc70S2', '2023-08-03 03:39:55', NULL);

--
-- Triggers `userinfo`
--
DELIMITER $$
CREATE TRIGGER `after_userinfo_delete` AFTER DELETE ON `userinfo` FOR EACH ROW BEGIN
    -- Delete the corresponding record from userinfocopy based on email
    DELETE FROM userinfocopy WHERE email = OLD.email;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `userinfo_after_insert` AFTER INSERT ON `userinfo` FOR EACH ROW BEGIN
    INSERT INTO userinfocopy (fName, lName, email, password, pfPicture, cPassword, timestamp)
    VALUES (NEW.fName, NEW.lName, NEW.email, NEW.password, NEW.pfPicture, NEW.cPassword, NEW.timestamp);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `userinfo_after_update` AFTER UPDATE ON `userinfo` FOR EACH ROW BEGIN
    -- Check if the password column has been updated
    IF NEW.password <> OLD.password THEN
        UPDATE userinfocopy
        SET password = NEW.password
        WHERE email = NEW.email;
    END IF;

    -- Check if any other columns (except id and password) have been updated
    IF NEW.fName <> OLD.fName OR
       NEW.lName <> OLD.lName OR
       NEW.email <> OLD.email OR
       NEW.pfPicture <> OLD.pfPicture OR
       NEW.cPassword <> OLD.cPassword OR
       NEW.timestamp <> OLD.timestamp THEN

        -- Update the other columns
        UPDATE userinfocopy
        SET
            fName = NEW.fName,
            lName = NEW.lName,
            email = NEW.email,
            pfPicture = NEW.pfPicture,
            cPassword = NEW.cPassword,
            timestamp = NEW.timestamp
        WHERE email = NEW.email;
    END IF;
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
(31, 'Raiden', 'Shogun', 'miko@gmail.com', '$2y$10$amwGrkRk8IAcU3Kr2AugUuw0BYNmSsNbMtUQPbWDB0xdsIPCc70S2', 'uploads/GenshinImpact_YaeMikoWallpaper4.jpg', '$2y$10$amwGrkRk8IAcU3Kr2AugUuw0BYNmSsNbMtUQPbWDB0xdsIPCc70S2', '2023-08-03 03:47:38');

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
-- Indexes for table `rented`
--
ALTER TABLE `rented`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `aID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=370;

--
-- AUTO_INCREMENT for table `complete`
--
ALTER TABLE `complete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=362;

--
-- AUTO_INCREMENT for table `ongoing`
--
ALTER TABLE `ongoing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=362;

--
-- AUTO_INCREMENT for table `rented`
--
ALTER TABLE `rented`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `rID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `toastnotif`
--
ALTER TABLE `toastnotif`
  MODIFY `toastID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `userinfocopy`
--
ALTER TABLE `userinfocopy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
