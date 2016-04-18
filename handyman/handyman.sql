-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2016 at 06:15 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `handyman`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories`
--

DROP TABLE IF EXISTS `accessories`;
CREATE TABLE IF NOT EXISTS `accessories` (
  `Tool_ID` int(11) NOT NULL,
  `Accessories` varchar(50) NOT NULL,
  PRIMARY KEY (`Tool_ID`,`Accessories`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accessories`
--

INSERT INTO `accessories` (`Tool_ID`, `Accessories`) VALUES
(2, '10-inch saw blade'),
(5, 'Drill Bits');

-- --------------------------------------------------------

--
-- Table structure for table `clerk`
--

DROP TABLE IF EXISTS `clerk`;
CREATE TABLE IF NOT EXISTS `clerk` (
  `Username` varchar(16) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Fname` varchar(25) NOT NULL,
  `Lname` varchar(40) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clerk`
--

INSERT INTO `clerk` (`Username`, `Password`, `Fname`, `Lname`) VALUES
('123456789012345a', '123456', 'Mike', 'Jordan'),
('123456789012345b', '567890', 'Kobe', 'Bryant'),
('123456789012345c', '1234', 'Lebron', 'James');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `Username` varchar(36) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Fname` varchar(25) NOT NULL,
  `Lname` varchar(40) NOT NULL,
  `Work_area_code` char(3) DEFAULT NULL,
  `Work_local_number` char(7) DEFAULT NULL,
  `Home_area_code` char(3) DEFAULT NULL,
  `Home_local_number` char(7) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Username`, `Password`, `Fname`, `Lname`, `Work_area_code`, `Work_local_number`, `Home_area_code`, `Home_local_number`, `Address`) VALUES
('bxia33@gatech.edu', '1234', 'Bo', 'Xia', '212', '2357640', '211', '2357640', '123 Main Street, Atlanta, GA, 30001'),
('shang@gatech.edu', 'shang123', 'Linyuan', 'Shang', '212', '2357640', '211', '2357640', '123 Church Street, Atlanta, GA 30002'),
('guo@gatech.edu', 'guo123', 'Hongqiang', 'Guo', '211', '1101080', '222', '1101051', '123 5th Avenue, Atlanta, GA 30003'),
('geller@gmail.com', 'geller123', 'Ross', 'Geller', '212', '1101080', '212', '1101051', '123 Broadway, New York, NY 10006'),
('green@gmail.com', 'green123', 'Rachel', 'Green', '225', '3313677', '226', '2205785', '123 Wall Street, New York, NY 10007'),
('monica@gmail.com', 'monica123', 'Monica', 'Geller', '001', '1111111', '011', '1111110', '653 5th Avenue, New York, NY 10008'),
('bing@gmail.com', 'bing123', 'Chandler', 'Bing', '002', '2222222', '022', '2222220', '434 6th Avenue, New York, NY'),
('tribbiani@gmail.com', '1234', 'Joey', 'Tribbiani', '003', '3333333', '033', '3333330', '676 7th Avenue, New York, NY 10009'),
('buffay@gmail.com', 'buffay123', 'Pheobe', 'Buffay', '004', '4444444', '044', '4444440', '783 18th Avenue, New York, NY 10008'),
('wang@gatech.edu', 'wang123', 'Xiaoxi', 'Wang', '615', '2222222', '615', '1111111', '406 Main Street,\r\nNashville, TN 37203');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `Reservation_Number` int(11) NOT NULL AUTO_INCREMENT,
  `Start_date` date NOT NULL,
  `End_date` date NOT NULL,
  `Request_customer` varchar(36) NOT NULL,
  `Pickup_clerk` varchar(16) NULL,
  `Dropoff_clerk` varchar(16) NULL,
  `Pickup_creditcard_number` char(16) NULL,
  `Pickup_creditcard_expdate` date NULL,
  PRIMARY KEY (`Reservation_Number`),
  KEY `Request_customer` (`Request_customer`),
  KEY `Pickup_clerk` (`Pickup_clerk`),
  KEY `Dropoff_clerk` (`Dropoff_clerk`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`Reservation_Number`, `Start_date`, `End_date`, `Request_customer`, `Pickup_clerk`, `Dropoff_clerk`, `Pickup_creditcard_number`, `Pickup_creditcard_expdate`) VALUES
(1, '2016-03-20', '2016-04-05', 'bxia33@gatech.edu', '123456789012345a', '123456789012345a', '1234567890123456', '2019-01-01'),
(2, '2016-04-20', '2016-05-05', 'shang@gatech.edu', '123456789012345b', '', '4444333355556666', '2018-01-01'),
(3, '2016-04-01', '2016-04-05', 'guo@gatech.edu', '123456789012345a', '123456789012345a', '5555666677778888', '2017-01-01'),
(4, '2016-04-05', '2016-04-09', 'wang@gatech.edu', '123456789012345a', '123456789012345a', '2222333344445555', '2018-01-01'),
(5, '2016-04-12', '2016-04-18', 'bxia33@gatech.edu', '123456789012345b', '123456789012345b', '8888777766665555', '2019-01-01'),
(6, '2016-02-20', '2016-03-05', 'bxia33@gatech.edu', '123456789012345c', '123456789012345c', '8888777755552222', '0000-00-00'),
(7, '2016-05-20', '2016-06-05', 'Geller@gmail.com', '', '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `reserve`
--

DROP TABLE IF EXISTS `reserve`;
CREATE TABLE IF NOT EXISTS `reserve` (
  `Reservation_number` int(11) NOT NULL,
  `Tool_ID` int NOT NULL,
  PRIMARY KEY (`Reservation_number`,`Tool_ID`),
  KEY `Tool_ID` (`Tool_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reserve`
--

INSERT INTO `reserve` (`Reservation_number`, `Tool_ID`) VALUES
(1, 1),
(2, 2),
(3, 5),
(3, 6),
(4, 3),
(5, 1),
(6, 4),
(7, 6);

-- --------------------------------------------------------

--
-- Table structure for table `service_order`
--

DROP TABLE IF EXISTS `service_order`;
CREATE TABLE IF NOT EXISTS `service_order` (
  `Tool_ID` int NOT NULL,
  `Start_date` date NOT NULL,
  `End_date` date NOT NULL,
  `Repair_cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`Tool_ID`,`Start_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_order`
--

INSERT INTO `service_order` (`Tool_ID`, `Start_date`, `End_date`, `Repair_cost`) VALUES
(1, '2016-03-13', '2016-03-18', '3.00'),
(4, '2016-04-16', '2016-04-20', '5.00'),
(5, '2016-04-22', '2016-05-01', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `tool`
--

DROP TABLE IF EXISTS `tool`;
CREATE TABLE IF NOT EXISTS `tool` (
  `Tool_ID` int NOT NULL AUTO_INCREMENT,
  `Abbrdesc` varchar(50) NOT NULL,
  `Fulldesc` varchar(100) NOT NULL,
  `Tool_Type` varchar(50) NOT NULL,
  `Is_sold` char(1) DEFAULT 'N',
  `Purchase_price` decimal(10,2) NOT NULL,
  `Deposit` decimal(10,2) NOT NULL,
  `Rental` decimal(10,2) NOT NULL,
  `Add_clerk` varchar(16) NOT NULL,
  PRIMARY KEY (`Tool_ID`),
  KEY `Add_clerk` (`Add_clerk`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tool`
--

INSERT INTO `tool` (`Tool_ID`, `Abbrdesc`, `Fulldesc`, `Tool_Type`, `Is_sold`, `Purchase_price`, `Deposit`, `Rental`, `Add_clerk`) VALUES
('1', 'Wrench Set', 'Made of strong and durable steel. Comes with 6 different sizes and 4" handles.', 'Hand Tools', 'N', '20.00', '15.00', '5.00', '123456789012345a'),
('2', 'Table Saw', 'Consists of a metal table with adjustable guides and a slot from which a saw blade is enclosed.', 'Power Tools', 'N', '120.00', '100.00', '15.00', '123456789012345b'),
('3', 'Framing Square', 'Steel Rafter Square features easy reading white graduations on a durable epoxy coated black finish. ', 'Construction', 'N', '12.00', '10.00', '2.00', '123456789012345c'),
('4', 'Mechanics Tool Set', 'A 100 piece set which features a slew of wrenches, screwdrivers and pliers. ', 'Hand Tools', 'N', '30.00', '15.00', '5.00', '123456789012345a'),
('5', 'Cordless Drill', 'This cordless drill is powered by a lithium ion battery for convenient portability.', 'Power Tools', 'N', '50.00', '40.00', '10.00', '123456789012345a'),
('6', 'Bolt Cutter', 'Aluminum alloy handles with rubber grips for comfort and a center-cut blade for efficiency. ', 'Hand Tools', 'N', '40.00', '30.00', '6.00', '123456789012345b');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
