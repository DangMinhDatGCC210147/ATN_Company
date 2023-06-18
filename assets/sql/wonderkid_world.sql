-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2023 at 10:09 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wonderkid_world`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pro_id` varchar(11) NOT NULL,
  `p_count` int(11) NOT NULL,
  `cart_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `pro_id`, `p_count`, `cart_date`) VALUES
(46, 115, 'P0002', 1, '2023-06-05'),
(47, 115, 'P0005', 1, '2023-06-05');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cate_id` varchar(11) NOT NULL,
  `cate_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cate_id`, `cate_name`) VALUES
('C0001', 'Educational Toys'),
('C0002', 'Art and Craft Toys'),
('C0003', 'Outdoor Play Toys'),
('C0004', 'Electronic Toys');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `fb_id` int(11) NOT NULL,
  `fb_u_id` int(11) NOT NULL,
  `fb_u_email` varchar(255) NOT NULL,
  `fb_content` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `or_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `or_u_address` varchar(255) NOT NULL,
  `or_total` decimal(10,2) NOT NULL,
  `or_date` date NOT NULL,
  `st_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`or_id`, `user_id`, `or_u_address`, `or_total`, `or_date`, `st_id`) VALUES
(149, 113, 'Can Tho', 269.93, '2023-06-08', 1),
(154, 114, 'Vinh Long', 974.86, '2023-06-08', 1),
(155, 113, 'Can Tho', 59.94, '2023-06-08', 1),
(157, 113, 'Can Tho', 129.98, '2023-06-08', 1),
(158, 113, 'Can Tho', 2499.75, '2023-06-08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `or_de_id` int(11) NOT NULL,
  `or_de_pro_id` varchar(11) NOT NULL,
  `or_de_qty` int(11) NOT NULL,
  `or_de_or_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`or_de_id`, `or_de_pro_id`, `or_de_qty`, `or_de_or_id`) VALUES
(2, 'P0004', 4, 149),
(3, 'P0002', 2, 149),
(4, 'P0005', 1, 149),
(7, 'P0002', 5, 154),
(8, 'P0003', 5, 154),
(9, 'P0002', 4, 154),
(10, 'P0004', 6, 155),
(12, 'P0002', 1, 157),
(13, 'P0001', 1, 157),
(14, 'P0002', 25, 158);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pro_id` varchar(11) NOT NULL,
  `pro_name` varchar(255) NOT NULL,
  `pro_price` float(10,2) NOT NULL,
  `pro_des` mediumtext NOT NULL,
  `pro_qty` int(11) NOT NULL,
  `pro_image` varchar(3000) NOT NULL,
  `pro_date` date NOT NULL,
  `pro_cate_id` varchar(11) NOT NULL,
  `pro_st_id` int(11) NOT NULL,
  `sup_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pro_id`, `pro_name`, `pro_price`, `pro_des`, `pro_qty`, `pro_image`, `pro_date`, `pro_cate_id`, `pro_st_id`, `sup_id`) VALUES
('P0001', 'Lego Classic Bricks Set', 29.99, ' Building blocks set with various shapes and colors', 6, '1.jpg', '2023-06-07', 'C0001', 1, 1),
('P0002', 'Barbie Dreamhouse', 99.99, 'Dollhouse with multiple rooms and accessories', 19, '2.jpg', '2023-06-14', 'C0001', 1, 1),
('P0003', 'Nerf N-Strike Elite Disruptor', 14.99, 'Dart blaster with rotating drum and 6 darts', 5, '3.jpg', '2023-06-22', 'C0003', 1, 2),
('P0004', 'Play-Doh Fun Factory', 9.99, 'Creative modeling tool with different shapes', 5, '4.jpg', '2023-06-22', 'C0002', 1, 1),
('P0005', 'Baby Alive Doll', 29.99, 'Interactive doll that eats, drinks, and wets', 6, '5.jpg', '2023-06-14', 'C0001', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `st_id` int(11) NOT NULL,
  `st_name` varchar(255) NOT NULL,
  `st_address` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`st_id`, `st_name`, `st_address`) VALUES
(1, 'Store 1', '55 Tran Hung Dao Street, Hoan Kiem District, Hanoi'),
(2, 'Store 2', '54 Lieu Giai Street, Ba Dinh District, Hanoi'),
(3, 'Store 3', '12 Hoang Dieu Street, Hai Chau District, Danang'),
(4, 'Store 4', ' 30 Bo Bao Tan Thang Street, Son Ky Ward, Tan Phu District, Ho Chi Minh City'),
(5, 'Store 5', '202B Hoang Van Thu Street, Phu Nhuan District, Ho Chi Minh City'),
(6, 'Store 6', '159 Xa Dan 2 Street, Nam Dong Ward, Hai Ba Trung District, Hanoi'),
(7, 'Store 7', '3 Nguyen Luong Bang Street, Tan Phu Ward, District 7, Ho Chi Minh City'),
(8, 'Store 8', '366 Phan Van Tri Street, Ward 11, Binh Thanh District, Ho Chi Minh City'),
(9, 'Store 9', '99 Nguyen Thi Minh Khai Street, Ben Nghe Ward, District 1, Ho Chi Minh City'),
(10, 'Store 10', '72 Le Thanh Ton Street, Ben Nghe Ward, District 1, Ho Chi Minh City');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `sup_id` int(11) NOT NULL,
  `sup_name` varchar(255) NOT NULL,
  `sup_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`sup_id`, `sup_name`, `sup_address`) VALUES
(1, 'ABC Company', '123 Main Street, City A, Country X'),
(2, 'XYZ Corporation', '456 Elm Avenue, City B, Country Y'),
(3, 'Best Electronics Ltd', '789 Oak Road, City C, Country Z'),
(4, 'Global Imports Inc', '321 Maple Lane, City D, Country X'),
(5, 'Reliable Supplies Co', '987 Pine Street, City E, Country Y'),
(6, 'MON company', '156 Bridge Street, City M, Country X'),
(8, 'Magic Toy Emporium', '987 Maple Lane, Wonder City, USA'),
(9, 'Adventure Toys Ltd', '321 Pine Road, Joyville, USA'),
(10, 'WonderLand compary', '836 Elm Avenue, Cityville, USA');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_email` varchar(40) NOT NULL,
  `u_firstName` varchar(40) NOT NULL,
  `u_lastName` varchar(255) NOT NULL,
  `u_address` varchar(200) NOT NULL,
  `u_password` varchar(100) NOT NULL,
  `u_role` tinyint(1) NOT NULL,
  `u_phone` varchar(11) NOT NULL,
  `u_birthday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_email`, `u_firstName`, `u_lastName`, `u_address`, `u_password`, `u_role`, `u_phone`, `u_birthday`) VALUES
(113, 'dangminhdat14@gmail.com', 'Minh Dat', 'Dang', 'Can Tho', '123456789', 0, '0907204306', '2003-10-15'),
(114, 'nguyenhoangkha11@gmail.com', 'Hoang Kha', 'Nguyen', 'Vinh Long', '1', 1, '0932812760', '2003-06-11'),
(115, 'nguyenhuynhngocthi20@gmail.com', 'Ngoc Thi', 'Nguyen Huynh', 'Can Tho', '123456789', 2, '0900786565', '2003-10-23'),
(116, 'trannguyetcan17@gmail.com', 'Nguyet Can', 'Tran', 'An Giang', '123', 2, '0999123145', '2003-07-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cart_user` (`user_id`),
  ADD KEY `cart_pro` (`pro_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cate_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`fb_id`),
  ADD KEY `feedback_user` (`fb_u_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`or_id`,`or_date`) USING BTREE,
  ADD KEY `or_car__userid` (`user_id`),
  ADD KEY `store_order` (`st_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`or_de_id`,`or_de_pro_id`),
  ADD KEY `or_de_or` (`or_de_or_id`),
  ADD KEY `pro_or_de` (`or_de_pro_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`,`pro_st_id`),
  ADD KEY `product_store` (`pro_st_id`),
  ADD KEY `pro_cate` (`pro_cate_id`),
  ADD KEY `product_supplier` (`sup_id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`st_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`sup_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `fb_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `or_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `or_de_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `sup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_pro` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`),
  ADD CONSTRAINT `cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_user` FOREIGN KEY (`fb_u_id`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`),
  ADD CONSTRAINT `store_order` FOREIGN KEY (`st_id`) REFERENCES `store` (`st_id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `or_de_or` FOREIGN KEY (`or_de_or_id`) REFERENCES `order` (`or_id`),
  ADD CONSTRAINT `pro_or_de` FOREIGN KEY (`or_de_pro_id`) REFERENCES `products` (`pro_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `pro_cate` FOREIGN KEY (`pro_cate_id`) REFERENCES `category` (`cate_id`),
  ADD CONSTRAINT `product_store` FOREIGN KEY (`pro_st_id`) REFERENCES `store` (`st_id`),
  ADD CONSTRAINT `product_supplier` FOREIGN KEY (`sup_id`) REFERENCES `supplier` (`sup_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
