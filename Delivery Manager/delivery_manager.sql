-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2026 at 07:47 PM
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
-- Database: `e-commerce_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `delivery_status` varchar(50) DEFAULT NULL,
  `failed_reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`id`, `order_id`, `agent_id`, `delivery_status`, `failed_reason`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 'assigned', NULL, '2026-05-15 14:19:00', '2026-05-15 14:19:00'),
(2, 1, 3, 'Delivered', NULL, '2026-05-15 19:40:18', '2026-05-15 19:41:10'),
(3, 2, 5, 'Delivered', NULL, '2026-05-15 19:41:36', '2026-05-15 19:42:30'),
(4, 3, 4, 'Failed', 'Customer Did not respoed.', '2026-05-17 17:51:50', '2026-05-17 17:53:55'),
(5, 3, 4, 'In Transit', NULL, '2026-05-17 17:53:09', '2026-05-17 17:56:50');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_agents`
--

CREATE TABLE `delivery_agents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vehicle_type` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_online` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_agents`
--

INSERT INTO `delivery_agents` (`id`, `user_id`, `vehicle_type`, `phone`, `is_active`, `created_at`, `is_online`) VALUES
(1, 1, 'Bike', '01601499905', 1, '2026-05-11 08:09:12', 0),
(3, 5, 'Bike', '1454626598', 1, '2026-05-11 20:12:59', 0),
(4, 6, 'Bike', '01601499909', 1, '2026-05-11 20:20:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_status_logs`
--

CREATE TABLE `delivery_status_logs` (
  `id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_status_logs`
--

INSERT INTO `delivery_status_logs` (`id`, `delivery_id`, `status`, `changed_at`) VALUES
(1, 0, 'assigned', '2026-05-15 14:19:21'),
(2, 2, 'assigned', '2026-05-15 19:40:18'),
(3, 2, 'Delivered', '2026-05-15 19:41:10'),
(4, 3, 'assigned', '2026-05-15 19:41:36'),
(5, 3, 'Delivered', '2026-05-15 19:42:30'),
(6, 5, 'assigned', '2026-05-17 17:53:09'),
(7, 4, 'In Transit', '2026-05-17 17:53:20'),
(8, 4, 'Failed', '2026-05-17 17:53:55'),
(9, 5, 'In Transit', '2026-05-17 17:56:50');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_zones`
--

CREATE TABLE `delivery_zones` (
  `id` int(11) NOT NULL,
  `zone_name` varchar(100) DEFAULT NULL,
  `delivery_fee` decimal(10,2) DEFAULT NULL,
  `estimated_days` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_zones`
--

INSERT INTO `delivery_zones` (`id`, `zone_name`, `delivery_fee`, `estimated_days`) VALUES
(1, 'Dhaka', 70.00, 2),
(2, 'Gazipur', 80.00, 3),
(3, 'Chittagong', 120.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `order_id`, `delivery_id`, `is_read`, `created_at`) VALUES
(1, 6, 'New Delivery Assigned', 'A new order has been assigned.', 3, 5, 0, '2026-05-17 17:53:09');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_zone_id` int(11) DEFAULT NULL,
  `assigned_agent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `shipping_address`, `payment_method`, `subtotal`, `discount_amount`, `total_amount`, `status`, `created_at`, `delivery_zone_id`, `assigned_agent_id`) VALUES
(1, 5, 'Dhaka', 'COD', 1200.00, 0.00, 1200.00, 'confirmed', '2026-05-15 19:39:59', 1, 3),
(2, 5, 'Gazipur', 'COD', 1500.00, 100.00, 1400.00, 'shipped', '2026-05-15 19:39:59', 1, 5),
(3, 5, 'Uttara', 'COD', 2000.00, 0.00, 2000.00, 'confirmed', '2026-05-15 19:39:59', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('customer','seller','delivery_manager','admin') DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `phone`, `role`, `profile_pic`, `is_active`, `created_at`, `profile_image`) VALUES
(1, 'Azmayen Inkiad', 'manager@gmail.com', '123456', '01993001256', 'delivery_manager', NULL, 1, '2026-05-11 08:08:17', '1778936201_download (2).jpg'),
(3, 'Tahsin Hasan', 'tahsinhasanbd2004@gmail.com', '123456', '01601499903', 'delivery_manager', NULL, 1, '2026-05-11 14:16:10', '1778842073_download (1).jpg'),
(5, 'Ranim', 'ranim@gmail.com', '12345', NULL, '', NULL, 1, '2026-05-11 20:12:59', NULL),
(6, 'Ranim hasan', 'ranim@9999gmail.com', '1234', NULL, '', NULL, 1, '2026-05-11 20:20:02', NULL),
(7, 'Zahir', 'zahir5252@gmail.com', '123456', NULL, '', NULL, 1, '2026-05-15 12:14:28', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_agents`
--
ALTER TABLE `delivery_agents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `delivery_status_logs`
--
ALTER TABLE `delivery_status_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_zones`
--
ALTER TABLE `delivery_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_agents`
--
ALTER TABLE `delivery_agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_status_logs`
--
ALTER TABLE `delivery_status_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `delivery_zones`
--
ALTER TABLE `delivery_zones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_agents`
--
ALTER TABLE `delivery_agents`
  ADD CONSTRAINT `delivery_agents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
