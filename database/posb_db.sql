-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2024 at 12:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posb_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category_tbl`
--

CREATE TABLE `category_tbl` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_tbl`
--

INSERT INTO `category_tbl` (`category_id`, `category_name`) VALUES
(1, 'machine'),
(2, 'oil'),
(3, 'liquid');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details_tbl`
--

CREATE TABLE `invoice_details_tbl` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `rate` double NOT NULL,
  `saleprice` double NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_details_tbl`
--

INSERT INTO `invoice_details_tbl` (`id`, `invoice_id`, `barcode`, `product_id`, `product_name`, `qty`, `rate`, `saleprice`, `order_date`) VALUES
(1, 1, '2115414', 2, 'Car oil', 1, 320, 320, '2024-12-28');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_tbl`
--

CREATE TABLE `invoice_tbl` (
  `invoice_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `subtotal` double NOT NULL,
  `discount` double NOT NULL,
  `sgst_p` float NOT NULL,
  `cgst_p` float NOT NULL,
  `total` double NOT NULL,
  `payment_type` tinytext NOT NULL,
  `due` double NOT NULL,
  `paid` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_tbl`
--

INSERT INTO `invoice_tbl` (`invoice_id`, `order_date`, `subtotal`, `discount`, `sgst_p`, `cgst_p`, `total`, `payment_type`, `due`, `paid`) VALUES
(1, '2024-12-28', 320, 5, 2.5, 2.5, 319.2, 'Cash', 0, 319.2);

-- --------------------------------------------------------

--
-- Table structure for table `product_tbl`
--

CREATE TABLE `product_tbl` (
  `product_id` int(11) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `purchase` float DEFAULT NULL,
  `sale` float DEFAULT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_tbl`
--

INSERT INTO `product_tbl` (`product_id`, `barcode`, `product_name`, `category`, `description`, `stock`, `purchase`, `sale`, `product_img`, `created_at`) VALUES
(1, '1115259', 'motorcycle ', 'machine', 'CD-70', 500, 80000, 95000, '410_1_53691.jpg', '2024-12-27 22:52:59'),
(2, '2115414', 'Car oil', 'oil', '20/50 car ilo', 199, 260, 320, '61gdV8mmZfL._AC_UF1000,1000_QL80_.jpg', '2024-12-27 22:54:14'),
(3, '3115656', 'Water', 'liquid', '150ml', 400, 20, 45, 'images.jpeg', '2024-12-27 22:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `taxdis_tbl`
--

CREATE TABLE `taxdis_tbl` (
  `taxdis_id` int(11) NOT NULL,
  `sgst` float NOT NULL,
  `cgst` float NOT NULL,
  `discount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taxdis_tbl`
--

INSERT INTO `taxdis_tbl` (`taxdis_id`, `sgst`, `cgst`, `discount`) VALUES
(1, 2.5, 2.5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `img` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `confirm_password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `user_name`, `user_email`, `img`, `user_password`, `confirm_password`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', 'ad.png', 'admin', 'admin', 'admin'),
(2, 'user', 'user@gmail.com', 'download.jpeg', 'user', 'user', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_tbl`
--
ALTER TABLE `category_tbl`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `invoice_details_tbl`
--
ALTER TABLE `invoice_details_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_tbl`
--
ALTER TABLE `invoice_tbl`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `product_tbl`
--
ALTER TABLE `product_tbl`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `taxdis_tbl`
--
ALTER TABLE `taxdis_tbl`
  ADD PRIMARY KEY (`taxdis_id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_password` (`user_password`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_tbl`
--
ALTER TABLE `category_tbl`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_details_tbl`
--
ALTER TABLE `invoice_details_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice_tbl`
--
ALTER TABLE `invoice_tbl`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_tbl`
--
ALTER TABLE `product_tbl`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `taxdis_tbl`
--
ALTER TABLE `taxdis_tbl`
  MODIFY `taxdis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
