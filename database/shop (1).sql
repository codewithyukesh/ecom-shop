-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2023 at 04:12 PM
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
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `heading1` varchar(255) NOT NULL,
  `heading2` varchar(255) NOT NULL,
  `btn_txt` varchar(55) DEFAULT NULL,
  `btn_link` varchar(100) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `order_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `heading1`, `heading2`, `btn_txt`, `btn_link`, `image`, `status`, `order_no`) VALUES
(1, 'top heading', 'heading2', 'buy now', 'cart.php', '157146884_2.jpg', 1, 2),
(2, 'Use coupon code and grab discount', 'Winter sale', 'shop now', '', '980329326_dgd.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categories`, `status`) VALUES
(10, 'Men', 1),
(14, 'Women', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(75) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `comment` text NOT NULL,
  `addedon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `mobile`, `comment`, `addedon`) VALUES
(4, 'Gautam', 'jakajbaka@gmail.com', '12486464494949', 'Hjddishsjsjsi', '2023-01-11 10:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `coupon_value` int(11) NOT NULL,
  `coupon_type` varchar(10) NOT NULL,
  `cart_min_value` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `coupon_value`, `coupon_type`, `cart_min_value`, `status`) VALUES
(2, '20off', 20, 'Rupee', 100, 1),
(3, 'alloff', 100, 'Percentage', 500, 1),
(4, '50poff', 50, 'Percentage', 500, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` int(11) NOT NULL,
  `payment_type` varchar(250) NOT NULL,
  `total_price` float NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_value` int(50) DEFAULT NULL,
  `coupon_code` varchar(100) NOT NULL,
  `order_status` int(2) NOT NULL,
  `payment_status` varchar(30) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `user_id`, `address`, `city`, `pincode`, `payment_type`, `total_price`, `coupon_id`, `coupon_value`, `coupon_code`, `order_status`, `payment_status`, `added_on`) VALUES
(45, 40, 'Gautam Tiwari', 'sunwal', 6, 'COD', 1480, 2, 20, '20off', 5, 'Success', '2023-01-11 10:42:35'),
(46, 40, 'Tilak kafle', 'sujnwal', 6, 'COD', 675, 4, 675, '50poff', 1, 'pending', '2023-01-11 12:02:10'),
(47, 40, 'Gautam', 'butwal', 6, 'COD', 2480, 2, 20, '20off', 1, 'pending', '2023-01-12 04:39:22'),
(48, 109, 'Tilak', 'Sunwal', 6, 'COD', 750, 4, 750, '50poff', 1, 'pending', '2023-01-15 07:15:55');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(7, 8, 11, 1, 1499),
(51, 45, 25, 1, 1500),
(52, 46, 19, 1, 1350),
(53, 47, 24, 1, 2500),
(54, 48, 21, 1, 1500);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Processing'),
(3, 'Shipped'),
(4, 'Canceled'),
(5, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_categories_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mrp` float NOT NULL,
  `price` float NOT NULL,
  `qty` int(11) NOT NULL,
  `size` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `short_desc` varchar(2000) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(2000) NOT NULL,
  `meta_desc` varchar(2000) NOT NULL,
  `best_seller` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `meta_keyword` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `categories_id`, `sub_categories_id`, `name`, `mrp`, `price`, `qty`, `size`, `image`, `short_desc`, `description`, `meta_title`, `meta_desc`, `best_seller`, `status`, `meta_keyword`) VALUES
(19, 10, 43, 'Rolex watch ', 0, 1350, 5, 'Large', '718069998_407327885_Screenshot_1.jpg', 'M,L, XL, XLL, XXL', '<p>Rolex SA is a British-founded Swiss watch designer and manufacturer based in Geneva, Switzerland. Founded in 1905 as Wilsdorf and Davis by Hans Wilsdorf and Alfred Davis in London, the company registered Rolex as the brand name of its watches in 1908 and became Rolex Watch Co. Ltd. in 1915.</p>\r\n', '', '', 0, 1, ''),
(21, 10, 41, 'Shirt ', 0, 1500, 1, 'Large', '538771213_SAM_3107g - Copy.jpg', 'Check shirt', '', '', '', 1, 1, ''),
(22, 14, 46, 'kurta ', 0, 750, 1, 'Medium ', '727813136_971169040_c3.jpg', 'Best kurta for womens', '', 'women kurta', 'cotton Kurta of women ', 1, 1, 'kurta'),
(24, 10, 41, 'Cotton pant', 3000, 2500, 2, 'XL', '570247902_268112545_a1.jpg', 'Pants for Men can be styled for any event under the sun the way we have described in the answer above.', '<p>Cotton pants can be worn at any occasions, right from an official meeting to beach parties, to weddings to date nights - you name it and the French Crown Cotton Pants for Men can be styled for any event under the sun the way we have described in the answer above.</p>\r\n', 'Cotton pant', 'Pants for Men can be styled for any event under the sun the way we have described in the answer above.', 1, 1, ''),
(25, 10, 41, 'Full Maroon Tshirt ', 1700, 1500, 1, 'XL', '572159220_162551127_a1.jpg', 'Find something memorable, join a community doing good.', '', 'Maroon Tshirt ', 'Find something memorable, join a community doing good.', 0, 0, ''),
(26, 10, 43, 'watch', 2500, 2000, 5, '', '390473835_605424751_Screenshot_3.jpg', 'watch for all ', '', '', '', 0, 0, ''),
(27, 14, 46, 'Red top', 2500, 1500, 5, '', '984461245_981264949_c1.jpg', 'asfsdfgdsg', '<p>sdfgsdfsdfg</p>\r\n', '', '', 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `sub_categories` varchar(100) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `categories_id`, `sub_categories`, `status`) VALUES
(40, 11, 'watches', 1),
(41, 10, 'clothes', 1),
(42, 10, 'shoes', 1),
(43, 10, 'watches', 1),
(44, 11, 'shoes', 1),
(46, 14, 'Cloths', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `added_on` datetime NOT NULL,
  `password` varchar(50) NOT NULL,
  `referral_code` varchar(200) NOT NULL,
  `points` int(200) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `mobile`, `added_on`, `password`, `referral_code`, `points`) VALUES
(40, 'Gautam Tiwari', 'gautamtiwari504@gmail.com', '9816465902', '2023-01-03 12:24:47', 'Gautam@12', 'BX2VC6', 10),
(110, 'Ganesh', 'Ganesh@gmail.com', '1234567890', '2023-01-15 07:54:15', 'Ganesh@12', '65084C', 0),
(118, 'RAmm', 'RAmm@gmail.com', '1232123121', '2023-01-15 03:34:11', 'RAmm@123', '5D7D50', 5),
(119, 'Aalu', 'Aalu@gmail.com', '1234567890', '2023-01-17 09:13:18', 'Aalu@123', '6939BB', 5),
(120, 'Kamal', 'Kamal@gmail.com', '1234567890', '2023-01-17 09:30:19', 'Kamal@123', 'AE0270', 5),
(121, 'Bimal', 'Bimal@gmail.com', '1234567890', '2023-01-17 09:30:58', 'Bimal@123', '5700FD', 5);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `added_on`) VALUES
(10, 3, 17, '2022-04-18 04:09:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
