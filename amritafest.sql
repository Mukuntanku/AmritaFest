-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2023 at 07:59 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amritafest`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_details`
--

CREATE TABLE `account_details` (
  `account_id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `account_type` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_details`
--

INSERT INTO `account_details` (`account_id`, `email`, `fname`, `lname`, `account_type`, `password`, `created_at`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2023-02-06 22:08:20'),
(2, 'mukuntan23@gmail.com', 'mukuntan', 'k', 'reguser', '202cb962ac59075b964b07152d234b70', '2023-02-06 22:09:04'),
(3, 'pradeep@gmail.com', 'pradeep', 'P', 'reguser', '202cb962ac59075b964b07152d234b70', '2023-02-06 22:09:24'),
(4, 'naren@gmail.com', 'naren', 'P', 'reguser', '202cb962ac59075b964b07152d234b70', '2023-02-06 22:09:34'),
(5, 'mithun@gmail.com', 'mithun', 'r', 'reguser', '202cb962ac59075b964b07152d234b70', '2023-02-07 05:06:48'),
(6, 'harsha@gmail.com', 'harsha', 'P', 'reguser', '202cb962ac59075b964b07152d234b70', '2023-02-07 05:21:16');

--
-- Triggers `account_details`
--
DELIMITER $$
CREATE TRIGGER `admin_insert` AFTER INSERT ON `account_details` FOR EACH ROW BEGIN
DECLARE temp_acc_id integer;
 IF new.account_type='admin'
 THEN
    SELECT
      account_id
    INTO
      temp_acc_id
    FROM
      account_details where account_type='admin' and account_id=new.account_id;
    insert into admin (account_id,admin_total_uploads) values (new.account_id,0);
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `upload_rights_insert_admin` AFTER INSERT ON `account_details` FOR EACH ROW BEGIN
DECLARE temp_acc_id integer;
 IF new.account_type='admin'
 THEN
    SELECT
      account_id
    INTO
      temp_acc_id
    FROM
      account_details where account_type='admin' and account_id=new.account_id;
    insert into upload_rights (account_id) values (new.account_id);
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `upload_rights_insert_reg` AFTER UPDATE ON `account_details` FOR EACH ROW BEGIN
DECLARE temp_acc_id integer;
 IF new.account_type='reguser'
 THEN
 IF old.account_type='user'
 THEN
    SELECT
      account_id
    INTO
      temp_acc_id
    FROM
      account_details where account_type='reg_user' and account_id=new.account_id;
    insert into upload_rights (account_id) values (new.account_id);
  END IF;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `event_details`
--

CREATE TABLE `event_details` (
  `name` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `max` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_details`
--

INSERT INTO `event_details` (`name`, `start`, `end`, `lat`, `lon`, `capacity`, `max`) VALUES
('Codeathon', '2023-02-08 10:30:00', '2023-02-08 14:00:00', 11.0168, 76.9558, 18, 20),
('Hackathon', '2023-02-08 13:30:00', '2023-02-09 12:00:00', 12.9716, 77.5946, 50, 50),
('painting', '2023-02-08 16:25:00', '2023-02-08 18:00:00', 11.341, 77.7172, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `registered_events`
--

CREATE TABLE `registered_events` (
  `uname` varchar(255) NOT NULL,
  `ename` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `code` int(4) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_events`
--

INSERT INTO `registered_events` (`uname`, `ename`, `start`, `end`, `code`, `status`) VALUES
('naren@gmail.com', 'painting', '2023-02-08 16:25:00', '2023-02-08 18:00:00', 3270, 'in'),
('harsha@gmail.com', 'Codeathon', '2023-02-08 10:30:00', '2023-02-08 14:00:00', 5631, 'out'),
('mukuntan23@gmail.com', 'Codeathon', '2023-02-08 10:30:00', '2023-02-08 14:00:00', 9154, 'out'),
('mithun@gmail.com', 'painting', '2023-02-08 16:25:00', '2023-02-08 18:00:00', 9945, 'out');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_details`
--
ALTER TABLE `account_details`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `event_details`
--
ALTER TABLE `event_details`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `registered_events`
--
ALTER TABLE `registered_events`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_details`
--
ALTER TABLE `account_details`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
