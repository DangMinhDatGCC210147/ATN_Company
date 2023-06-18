-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2023 at 01:04 PM
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
(47, 115, 'P0005', 1, '2023-06-05'),
(112, 119, 'P0005', 1, '2023-06-10'),
(144, 113, 'P0005', 10, '2023-06-15');

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
('C0003', 'Outdoor Play Toys');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `or_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `or_u_address` varchar(255) NOT NULL,
  `or_total` decimal(10,2) NOT NULL,
  `or_date` datetime NOT NULL,
  `st_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`or_id`, `user_id`, `or_u_address`, `or_total`, `or_date`, `st_id`) VALUES
(159, 113, 'Can Tho', 44.97, '2023-06-09 00:00:00', 1),
(160, 116, 'An Giang', 129.98, '2023-06-09 00:00:00', 6),
(161, 113, 'Can Tho', 129.93, '2023-06-09 00:00:00', 1),
(162, 118, 'Bac Lieu', 309.92, '2023-06-09 00:00:00', 2),
(163, 113, 'Can Tho', 44.98, '2023-06-09 00:00:00', 1),
(165, 113, 'Can Tho', 29.99, '2023-06-10 18:55:26', 1),
(166, 113, 'Can Tho', 123.94, '2023-06-10 00:00:00', 1),
(167, 120, 'Can Tho', 276.88, '2023-06-10 00:00:00', 1),
(168, 113, 'Can Tho', 466.93, '2023-06-10 00:00:00', 1),
(169, 114, 'Vinh Long', 581.92, '2023-06-10 00:00:00', 1),
(171, 113, 'Can Tho', 541.88, '2023-06-10 00:00:00', 1),
(173, 114, 'Vinh Long', 89.97, '2023-06-10 00:00:00', 1),
(177, 113, 'Can Tho', 188.92, '2023-06-13 09:57:19', 1),
(178, 113, 'Can Tho', 738.78, '2023-06-13 11:59:52', 1);

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
(15, 'P0003', 3, 159),
(16, 'P0002', 1, 160),
(17, 'P0005', 1, 160),
(18, 'P0001', 3, 161),
(19, 'P0004', 4, 161),
(20, 'P0002', 1, 162),
(21, 'P0001', 4, 162),
(22, 'P0005', 3, 162),
(23, 'P0005', 1, 163),
(24, 'P0003', 1, 163),
(27, 'P0005', 1, 165),
(28, 'P0005', 2, 166),
(29, 'P0006', 4, 166),
(30, 'P0010', 7, 167),
(31, 'P0007', 5, 167),
(32, 'P0002', 4, 168),
(33, 'P0005', 1, 168),
(34, 'P0006', 1, 168),
(35, 'P0010', 1, 168),
(36, 'P0008', 2, 169),
(37, 'P0011', 1, 169),
(38, 'P0002', 5, 169),
(40, 'P0005', 7, 171),
(41, 'P0006', 2, 171),
(42, 'P0002', 3, 171),
(45, 'P0005', 3, 173),
(50, 'P0006', 5, 177),
(51, 'P0005', 1, 177),
(52, 'P0008', 1, 177),
(53, 'P0012', 1, 177),
(54, 'P0012', 1, 178),
(55, 'P0008', 21, 178);

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
('P0001', 'Lego Classic Bricks Set', 29.99, ' Building blocks set with various shapes and colors', 93, '1.jpg', '2023-06-07', 'C0001', 1, 8),
('P0002', 'Barbie Dreamhouse', 99.99, 'Dollhouse with multiple rooms and accessories', 86, '2.jpg', '2023-06-14', 'C0001', 1, 1),
('P0003', 'Nerf N-Strike Elite Disruptor', 14.99, 'Dart blaster with rotating drum and 6 darts', 99, '3.jpg', '2023-06-22', 'C0003', 1, 2),
('P0004', 'Play-Doh Fun Factory', 9.99, 'Creative modeling tool with different shapes', 100, '4.jpg', '2023-06-22', 'C0002', 1, 1),
('P0005', 'Baby Alive Doll', 29.99, 'Interactive doll that eats, drinks, and wets', 10, '5.jpg', '2023-06-14', 'C0001', 1, 4),
('P0006', 'Super Space Rocket Adventure', 15.99, 'The Super Space Rocket Adventure Set is an action-packed toy that allows children to embark on exciting intergalactic missions. This set includes a detailed rocket ship, astronauts, and various accessories to create imaginative space exploration scenarios. With lights, sounds, and interactive features, this toy provides hours of fun and encourages creativity and imaginative play. Blast off into a world of adventure with the Super Space Rocket Adventure Set!', 30, '6.jpg', '2023-06-07', 'C0001', 1, 5),
('P0007', 'Lego Technic - Remote-Controlled Stunt Racer', 25.99, 'The Lego Technic Remote-Controlled Stunt Racer is an exciting toy for kids who love building and racing. With its powerful pull-back motor and sturdy construction, this remote-controlled racer can perform amazing stunts, including flips, spins, and wheelies. The set also includes a remote control with a multi-function control pad for easy maneuvering. Kids can enjoy hours of fun designing their own stunt courses and mastering impressive tricks with this high-performance Lego Technic set.', 41, '7.jpg', '2023-06-06', 'C0003', 1, 5),
('P0008', 'Hatchimals', 32.99, 'Hatchimals are interactive toys that combine the excitement of hatching and nurturing. Each Hatchimal comes as an egg and requires kids to care for it until it hatches. Through nurturing, the Hatchimal responds with sounds and movements, building anticipation for the magical hatching moment. Once hatched, kids can interact with their Hatchimal, teaching it to walk, talk, and play games. With different species and personalities to discover, Hatchimals provide a magical and interactive play experience.', 20, '8.jpg', '2023-06-06', 'C0001', 1, 6),
('P0009', 'Hot Wheels Ultimate Garage Playset', 28.99, 'The Hot Wheels Ultimate Garage Playset is a thrilling toy for car enthusiasts. This multi-level garage features parking spaces, ramps, tracks, and interactive elements for endless racing and car-themed adventures. With space to store and showcase Hot Wheels vehicles, kids can create their own car collection and engage in imaginative play. The playset includes features like a working elevator, a gravity-powered launcher, and a shark attack ramp, providing exciting stunts and challenges for the Hot Wheels cars.', 76, '9.jpg', '2023-06-06', 'C0003', 1, 10),
('P0010', 'Barbie Fashionista Doll', 20.99, ' The Barbie Fashionista Doll is a stylish and diverse doll that celebrates individuality and fashion. With a wide range of skin tones, body types, and hairstyles, these dolls promote inclusivity and representation. Each Fashionista Doll comes with trendy outfits, accessories, and unique fashion styles, allowing kids to express their creativity and create fashion-forward looks. The Barbie Fashionista Dolls inspire imaginative storytelling and role-playing in the world of fashion.', 42, '10.jpg', '2023-06-06', 'C0003', 1, 5),
('P0011', 'Transformers Bumblebee Cyberverse Adventures', 15.99, 'The Transformers Bumblebee Cyberverse Adventures Action Figure brings the excitement of the Transformers universe to life. This action figure represents the iconic Autobot Bumblebee and features articulation for dynamic poses and play. With a transformation feature, kids can convert Bumblebee from a robot mode to a vehicle mode and join him in epic battles against the Decepticons. The Cyberverse Adventures Action Figure offers thrilling robot action and storytelling possibilities.', 39, '11.jpg', '2023-06-06', 'C0001', 1, 5),
('P0012', 'Paw Patrol Ultimate Rescue Fire Truck', 45.99, 'The Paw Patrol Ultimate Rescue Fire Truck is an interactive and rescue-themed toy inspired by the popular Paw Patrol TV series. This playset includes a large fire truck equipped with lights, sounds, and a ladder that extends for rescue missions. It also comes with a mini fire cart, a Marshall figure, and accessories. Kids can join the Paw Patrol team and embark on imaginative rescue adventures, saving the day with teamwork and problem-solving skills.', 28, '12.jpg', '2023-06-06', 'C0003', 1, 2);

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
(10, 'WonderLand compary', '836 Elm Avenue, Cityville, USA');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_email` varchar(40) DEFAULT NULL,
  `u_firstName` varchar(40) DEFAULT NULL,
  `u_lastName` varchar(255) DEFAULT NULL,
  `u_address` varchar(200) DEFAULT NULL,
  `u_password` varchar(100) DEFAULT NULL,
  `u_role` tinyint(1) NOT NULL,
  `u_phone` varchar(11) DEFAULT NULL,
  `u_birthday` date DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_email`, `u_firstName`, `u_lastName`, `u_address`, `u_password`, `u_role`, `u_phone`, `u_birthday`, `google_id`) VALUES
(113, 'dangminhdat14@gmail.com', 'Minh Dat', 'Dang', 'Can Tho', '123', 0, '0907204306', '2003-10-15', NULL),
(114, 'nguyenhoangkha11@gmail.com', 'Hoang Kha', 'Nguyen', 'Vinh Long', '1', 1, '0932812760', '2003-06-11', NULL),
(115, 'nguyenhuynhngocthi20@gmail.com', 'Ngoc Thi', 'Nguyen Huynh', 'Can Tho', '123456789', 2, '0900786565', '2003-10-23', NULL),
(116, 'trannguyetcan17@gmail.com', 'Nguyet Can', 'Tran', 'An Giang', '123', 2, '0999123145', '2003-07-26', NULL),
(118, 'nguyenquetran12@gmail.com', 'Que Tran', 'Nguyen', 'Vinh Long', '123456', 2, '0939445381', '2003-10-12', NULL),
(119, 'buinhuttan15@gmail.com', 'Nhut Tan', 'Bui', 'Kien Giang', '12345', 2, '0922131457', '2001-03-26', NULL),
(120, 'phannhubinh16@gmail.com', 'Nhu Binh', 'Phan', 'Can Tho', '12345678', 2, '0956332331', '2002-10-16', NULL);

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `or_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `or_de_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

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
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

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
