-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2019 at 08:53 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `CN` varchar(10) NOT NULL,
  `OID` int(10) NOT NULL,
  `tip` double(5,2) NOT NULL,
  `sFee` double(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`CN`, `OID`, `tip`, `sFee`) VALUES
('Door Dash', 201, 3.79, 2.96),
('Door Dash', 207, 6.08, 4.75),
('Door Dash', 204, 9.48, 7.40),
('Grub Hub', 202, 1.89, 3.47),
('Grub Hub', 208, 3.99, 3.28),
('Grub Hub', 205, 6.11, 4.93),
('Uber Eats', 209, 0.00, 3.92),
('Uber Eats', 203, 0.00, 4.35),
('Uber Eats', 206, 0.00, 6.03);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ID` int(10) NOT NULL,
  `subTotal` double(5,2) NOT NULL,
  `address` varchar(255) NOT NULL,
  `distance` double NOT NULL,
  `total` double(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `subTotal`, `address`, `distance`, `total`) VALUES
(201, 15.99, '8226 S 77th E Ave, Tulsa, OK, USA', 4.95, 22.74),
(202, 5.99, '8226 S 77th E Ave, Tulsa, OK, USA', 4.95, 11.35),
(203, 9.99, '8226 S 77th E Ave, Tulsa, OK, USA', 4.95, 20.30),
(204, 39.99, '8226 S 77th E Ave, Tulsa, OK, USA', 1.38, 56.87),
(205, 25.62, '8226 S 77th E Ave, Tulsa, OK, USA', 1.38, 36.67),
(206, 25.62, '8226 S 77th E Ave, Tulsa, OK, USA', 1.38, 35.83),
(207, 25.66, '8226 S 77th E Ave, Tulsa, OK, USA', 1.03, 36.49),
(208, 16.66, '8226 S 77th E Ave, Tulsa, OK, USA', 1.03, 23.92),
(209, 16.66, '8226 S 77th E Ave, Tulsa, OK, USA', 1.03, 24.58);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `name` varchar(30) NOT NULL,
  `RA` varchar(255) NOT NULL,
  `OID` int(10) NOT NULL,
  `dFee` double(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`name`, `RA`, `OID`, `dFee`) VALUES
('On The Border Mexican Grill & ', 'East 41st Street, Tulsa, OK, USA', 201, 0.00),
('On The Border Mexican Grill & ', 'East 41st Street, Tulsa, OK, USA', 202, 0.00),
('Cheddars Scratch Kitchen', 'East 71st Street, Tulsa, OK, USA', 204, 0.00),
('Cheddars Scratch Kitchen', 'East 71st Street, Tulsa, OK, USA', 205, 0.00),
('Taco Bueno', '6519 E 91st St Tulsa, OK, USA', 207, 0.00),
('Taco Bueno', '6519 E 91st St Tulsa, OK, USA', 208, 0.00),
('Taco Bueno', '6519 E 91st St Tulsa, OK, USA', 209, 4.00),
('Cheddars Scratch Kitchen', 'East 71st Street, Tulsa, OK, USA', 206, 4.18),
('On The Border Mexican Grill & ', 'East 41st Street, Tulsa, OK, USA', 203, 5.96);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`CN`,`tip`,`sFee`,`OID`) USING BTREE,
  ADD KEY `OID` (`OID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`,`total`,`distance`) USING BTREE;

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`dFee`,`OID`,`RA`) USING BTREE,
  ADD UNIQUE KEY `address` (`RA`,`OID`) USING BTREE,
  ADD KEY `OID` (`OID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`OID`) REFERENCES `orders` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD CONSTRAINT `restaurant_ibfk_1` FOREIGN KEY (`OID`) REFERENCES `orders` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
