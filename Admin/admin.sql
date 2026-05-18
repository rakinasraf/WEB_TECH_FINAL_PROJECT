-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2026 at 05:36 PM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `description`) VALUES
(1, NULL, 'Electronics & Gadgetry', 'Smartphones, microprocessors, smart watches and computer parts.'),
(2, 1, 'Computer Components', 'RAM modules, storage drives, and structural graphics processing setups.'),
(3, NULL, 'Groceries & Fresh Food', 'Daily essentials, rice, organic vegetables, and local cooking goods.'),
(4, 3, 'Spices & Condiments', 'Pure authentic local spices from native regional agricultural plots.');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `discount_pct` decimal(5,2) DEFAULT NULL,
  `max_uses` int(11) DEFAULT NULL,
  `uses_count` int(11) DEFAULT 0,
  `valid_until` date DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `seller_id`, `code`, `discount_pct`, `max_uses`, `uses_count`, `valid_until`, `is_active`) VALUES
(1, 1, 'DHAKATECH5', 5.00, 100, 14, '2026-12-31', 1),
(2, 2, 'EIDFOOD26', 12.00, 50, 0, '2026-06-15', 1),
(3, NULL, 'QURBANI05', 5.00, 400, 0, '2026-05-27', 1);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `shipping_address`, `payment_method`, `subtotal`, `discount_amount`, `total_amount`, `status`, `created_at`) VALUES
(1, 4, 'House 12, Road 4, Sector 3, Uttara, Dhaka', 'bKash Merchant Pay', 5650.00, 160.00, 5490.00, 'delivered', '2026-05-17 13:17:04'),
(2, 5, 'Ananda Villa, Level 2, VIP Road, Kazir Dewri, Chattogram', 'Cash on Delivery', 1000.00, 0.00, 1000.00, 'processing', '2026-05-17 13:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `item_status` enum('pending','confirmed','shipped','delivered') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `seller_id`, `quantity`, `unit_price`, `item_status`) VALUES
(1, 1, 1, 1, 1, 3200.00, 'delivered'),
(2, 1, 2, 1, 1, 2450.00, 'delivered'),
(3, 2, 3, 2, 1, 820.00, 'confirmed'),
(4, 2, 4, 2, 1, 180.00, 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock_qty` int(11) DEFAULT NULL,
  `primary_image_path` varchar(255) DEFAULT NULL,
  `is_available` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `category_id`, `name`, `description`, `price`, `stock_qty`, `primary_image_path`, `is_available`, `created_at`) VALUES
(1, 1, 2, 'Mechanical Gaming Keyboard', 'RGB Backlit tactile blue switch dynamic mechanical typing matrix.', 3200.00, 45, 'products/keyboard.jpg', 1, '2026-05-17 13:17:03'),
(2, 1, 1, 'Smart Fitness Band v5', 'OLED monitor framework containing heart rate tracking elements.', 2450.00, 120, 'products/fitness_band.jpg', 1, '2026-05-17 13:17:03'),
(3, 2, 3, 'Premium Miniket Rice 10KG', 'Refined, clean long grain local standard miniket corporate reserve pack.', 820.00, 300, 'products/rice_10kg.jpg', 1, '2026-05-17 13:17:03'),
(4, 2, 4, 'Pure Radhuni Turmeric Powder', 'Authentic 500g packaged native spice blend containing dynamic aromatic profiles.', 180.00, 150, 'products/turmeric.jpg', 1, '2026-05-17 13:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `display_order`) VALUES
(1, 1, 'products/keyboard_angle1.jpg', 1),
(2, 1, 'products/keyboard_angle2.jpg', 2),
(3, 2, 'products/band_closeups.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `seller_reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `order_id`, `customer_id`, `rating`, `review_text`, `seller_reply`, `created_at`) VALUES
(1, 1, 1, 4, 5, 'Highly responsive keyboard matrix framework! The tactile clicks are exceptional.', 'Thank you for your order! Glad you loved the layout compilation mechanics.', '2026-05-17 13:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_name` varchar(100) DEFAULT NULL,
  `shop_description` text DEFAULT NULL,
  `shop_logo_path` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_approved` tinyint(4) DEFAULT 0,
  `commission_rate` decimal(5,2) DEFAULT 5.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `user_id`, `shop_name`, `shop_description`, `shop_logo_path`, `address`, `is_approved`, `commission_rate`, `created_at`) VALUES
(1, 2, 'Anik Tech Zone BD', 'Your ultimate hub for premium gadget items inside Dhaka City.', 'logos/anik_tech.png', 'Multiplan Center, Level 4, Elephant Road, Dhaka', 1, 7.50, '2026-05-17 13:17:03'),
(2, 3, 'Dhaka Organic Grocery', 'Fresh local produce sourced directly from structural farms in Rajshahi and Sylhet.', 'logos/dhaka_organic.png', 'House 42, Road 11, Banani, Dhaka', 1, 5.00, '2026-05-17 13:17:03'),
(3, 8, 'sdsa', NULL, NULL, 'sdaioh asdjoij aijds o', 1, 5.00, '2026-05-17 19:51:33'),
(4, 9, 'asd ads', NULL, NULL, 'adw  adsf', 1, 5.00, '2026-05-17 20:18:36');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `phone`, `role`, `profile_pic`, `is_active`, `created_at`) VALUES
(1, 'Mohammod Ali Shoheb', 'admin@ecommerce.com', '$2y$10$8K9Vj7vj6LgEwF8yD2eP1OH3YmQ6f5C2z8gB9xX4uU5wV6yK7zM5q', '01711223344', 'admin', NULL, 1, '2026-05-17 13:17:03'),
(2, 'Md Rubayet Morshed Anik', 'anik@daraz-seller.bd', '$2y$10$v7gO0Obe6D/rPq5G1m9vOubI.t1RkKxN5uWfWpC7sO9vR6lK3fQ2.', '01819887766', 'seller', NULL, 1, '2026-05-17 13:17:03'),
(3, 'Tahsin Rahman', 'tahsin@chaldal-store.bd', '$2y$10$v7gO0Obe6D/rPq5G1m9vOubI.t1RkKxN5uWfWpC7sO9vR6lK3fQ2.', '01675443322', 'seller', NULL, 1, '2026-05-17 13:17:03'),
(4, 'Arif Faisal', 'arif.faisal@gmail.com', '$2y$10$v7gO0Obe6D/rPq5G1m9vOubI.t1RkKxN5uWfWpC7sO9vR6lK3fQ2.', '01911556677', 'customer', NULL, 1, '2026-05-17 13:17:03'),
(5, 'Nusrat Jahan', 'nusrat.jahan@yahoo.com', '$2y$10$v7gO0Obe6D/rPq5G1m9vOubI.t1RkKxN5uWfWpC7sO9vR6lK3fQ2.', '01552334455', 'customer', NULL, 1, '2026-05-17 13:17:03'),
(6, 'Biplob Hossain', 'biplob@pathao-delivery.bd', '$2y$10$v7gO0Obe6D/rPq5G1m9vOubI.t1RkKxN5uWfWpC7sO9vR6lK3fQ2.', '01311224466', 'delivery_manager', NULL, 1, '2026-05-17 13:17:03'),
(8, 'ali', 'adsino2ijd@jnasc.com', '$2y$10$E2aCUYJ79QbReSDFpqiaheWu6zx8E0NIwRU493CA4llu9ZfQ3tLFK', '0156160', 'seller', NULL, 0, '2026-05-17 19:51:33'),
(9, 'alllll', 'adkn@aidjs.com', '$2y$10$wsyi30/49NsMtSPcXf7DO.NLqunekB5mW9tg2.UkwfWtl4h3hvIQe', '00168161680', 'seller', NULL, 1, '2026-05-17 20:18:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sellers`
--
ALTER TABLE `sellers`
  ADD CONSTRAINT `sellers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
