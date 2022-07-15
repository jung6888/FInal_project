-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 15, 2022 at 07:02 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `count_invoice` (OUT `num` INT)  select count(Invoice.Invoice_Id) into num from Invoice$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cus_Level` (IN `name` VARCHAR(100))  select * from Customer where Customer.Customer_Name = name$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cus_select` ()  select * from customer$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_customer` (IN `cus_id` INT)  delete from customer where Customer_id=cus_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `edit_cust` (IN `cus_name` VARCHAR(100), IN `cus_address` VARCHAR(100), IN `cus_phone` VARCHAR(100), IN `cus_id` INT, IN `cus_level` VARCHAR(100))  update Customer set Customer_Name = cus_name, Address = cus_address, Phone_Number = cus_phone, Customer_Id = cus_id, Level = cus_level where Customer_id = cus_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `invoice_in` (IN `dis` FLOAT, IN `grand` FLOAT, IN `id` INT)  insert into Invoice values(NULL, dis, grand, id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `in_customer` (IN `addr` VARCHAR(100), IN `cname` VARCHAR(100), IN `phonenum` VARCHAR(100), IN `inlevel` VARCHAR(100))  insert into Customer(Address, Customer_Name, Phone_Number, Level) values(addr, cname, phonenum, inlevel)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `in_food` (IN `food_name` VARCHAR(100), IN `unit_price` FLOAT, IN `type_id` INT, IN `photo` VARCHAR(100))  insert into Food values(food_name, unit_price, NULL, type_id, photo)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Order` (IN `quantity` INT, IN `food_id` INT, IN `invoice_id` INT)  insert into Order_Detail values(NULL, quantity, food_id, invoice_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `select_food` ()  select * from Food$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calGolddis` (`cost` FLOAT, `price` FLOAT) RETURNS DECIMAL(9,2) BEGIN
	DECLARE profit DECIMAL(9,2);
    SET profit = (cost * 0.2);
    RETURN profit;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `calSildis` (`total` FLOAT, `cost` FLOAT) RETURNS DECIMAL(9,2) BEGIN
	DECLARE profit DECIMAL(9,2);
    SET profit = total*0.1;
    RETURN profit;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `calTotal` (`discount` FLOAT, `price` FLOAT) RETURNS DECIMAL(9,2) BEGIN
	DECLARE profit DECIMAL(9,2);
    SET profit = price - discount;
    RETURN profit;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `count_customer` () RETURNS FLOAT RETURN(select count(*) from Customer)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `count_invoice` () RETURNS INT(11) RETURN(select count(*) from Invoice)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `sum_of_sale` () RETURNS FLOAT RETURN(select sum(Invoice.Grand_Total) from Invoice)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `Address` varchar(100) NOT NULL,
  `Customer_Name` varchar(100) NOT NULL,
  `Customer_Id` int(11) NOT NULL,
  `Phone_Number` varchar(100) NOT NULL,
  `Level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`Address`, `Customer_Name`, `Customer_Id`, `Phone_Number`, `Level`) VALUES
('ផ្លូវលេខ ២១១អាគារ H, Phnom Penh', 'Juden Ung', 1, '087655533', 'BRONZE'),
('ផ្លូវលេខ ២១១អាគារ H, Phnom Penh', 'Mony', 2, '022882222', 'SILVER'),
('ផ្លូវលេខ ២១១អាគារ H, Phnom Penh', 'H578', 4, '098578578', 'BRONZE');

-- --------------------------------------------------------

--
-- Table structure for table `Food`
--

CREATE TABLE `Food` (
  `Food_Name` varchar(100) NOT NULL,
  `Unit_Price` float NOT NULL,
  `Food_Id` int(11) NOT NULL,
  `Type_Id` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Food`
--

INSERT INTO `Food` (`Food_Name`, `Unit_Price`, `Food_Id`, `Type_Id`, `photo`) VALUES
('Lemonate11', 1.7, 5, 1, 'images/drinks/202207150603219606.jpg'),
('Minced_Pork', 2, 6, 1, 'images/foods/202207150613491167.jpg'),
('Lamp', 9.8, 7, 1, 'images/foods/202207150618446724.jpg'),
('Pasta', 2.5, 9, 1, 'images/foods/202207150630117629.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `Food_Type`
--

CREATE TABLE `Food_Type` (
  `Type_Id` int(11) NOT NULL,
  `Type_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Food_Type`
--

INSERT INTO `Food_Type` (`Type_Id`, `Type_Name`) VALUES
(1, 'Foods'),
(2, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `Invoice`
--

CREATE TABLE `Invoice` (
  `Invoice_Id` int(11) NOT NULL,
  `Discount` float NOT NULL,
  `Grand_Total` float NOT NULL,
  `Customer_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Invoice`
--

INSERT INTO `Invoice` (`Invoice_Id`, `Discount`, `Grand_Total`, `Customer_Id`) VALUES
(1, 0, 49, 4),
(2, 0, 65.2, 1);

--
-- Triggers `Invoice`
--
DELIMITER $$
CREATE TRIGGER `new_invoice` AFTER INSERT ON `Invoice` FOR EACH ROW insert into Purchase_Order values(NULL,NOW(),NEW.Grand_Total,NEW.Invoice_Id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Order_Detail`
--

CREATE TABLE `Order_Detail` (
  `Id` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Food_Id` int(11) NOT NULL,
  `Invoice_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Order_Detail`
--

INSERT INTO `Order_Detail` (`Id`, `Quantity`, `Food_Id`, `Invoice_Id`) VALUES
(1, 5, 7, 1),
(2, 6, 5, 2),
(3, 3, 6, 2),
(4, 5, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Purchase_Order`
--

CREATE TABLE `Purchase_Order` (
  `Order_Id` int(11) NOT NULL,
  `Order_Date` date NOT NULL,
  `Sub_Total` float NOT NULL,
  `Invoice_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Purchase_Order`
--

INSERT INTO `Purchase_Order` (`Order_Id`, `Order_Date`, `Sub_Total`, `Invoice_Id`) VALUES
(1, '2022-07-15', 49, 1),
(2, '2022-07-15', 65.2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `table_users`
--

CREATE TABLE `table_users` (
  `user_id` int(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_users`
--

INSERT INTO `table_users` (`user_id`, `password`, `username`) VALUES
(1, '0192023a7bbd73250516f069df18b500', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`Customer_Id`);

--
-- Indexes for table `Food`
--
ALTER TABLE `Food`
  ADD PRIMARY KEY (`Food_Id`),
  ADD KEY `Type_Id` (`Type_Id`);

--
-- Indexes for table `Food_Type`
--
ALTER TABLE `Food_Type`
  ADD PRIMARY KEY (`Type_Id`);

--
-- Indexes for table `Invoice`
--
ALTER TABLE `Invoice`
  ADD PRIMARY KEY (`Invoice_Id`),
  ADD KEY `Customer_Id` (`Customer_Id`);

--
-- Indexes for table `Order_Detail`
--
ALTER TABLE `Order_Detail`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Food_Id` (`Food_Id`),
  ADD KEY `Invoice_Id` (`Invoice_Id`);

--
-- Indexes for table `Purchase_Order`
--
ALTER TABLE `Purchase_Order`
  ADD PRIMARY KEY (`Order_Id`),
  ADD KEY `Invoice_Id` (`Invoice_Id`);

--
-- Indexes for table `table_users`
--
ALTER TABLE `table_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `Customer_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `Food`
--
ALTER TABLE `Food`
  MODIFY `Food_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Food_Type`
--
ALTER TABLE `Food_Type`
  MODIFY `Type_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Invoice`
--
ALTER TABLE `Invoice`
  MODIFY `Invoice_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Order_Detail`
--
ALTER TABLE `Order_Detail`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Purchase_Order`
--
ALTER TABLE `Purchase_Order`
  MODIFY `Order_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_users`
--
ALTER TABLE `table_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Food`
--
ALTER TABLE `Food`
  ADD CONSTRAINT `food_ibfk_1` FOREIGN KEY (`Type_Id`) REFERENCES `Food_Type` (`Type_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Invoice`
--
ALTER TABLE `Invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`Customer_Id`) REFERENCES `Customer` (`Customer_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Order_Detail`
--
ALTER TABLE `Order_Detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`Food_Id`) REFERENCES `Food` (`Food_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`Invoice_Id`) REFERENCES `Invoice` (`Invoice_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Purchase_Order`
--
ALTER TABLE `Purchase_Order`
  ADD CONSTRAINT `purchase_order_ibfk_1` FOREIGN KEY (`Invoice_Id`) REFERENCES `Invoice` (`Invoice_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
