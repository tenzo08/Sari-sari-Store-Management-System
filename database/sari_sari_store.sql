-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 10:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sari_sari_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cashier_status`
--

CREATE TABLE `cashier_status` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cashier_status`
--

INSERT INTO `cashier_status` (`id`, `user_id`, `status`) VALUES
(1, 2, 'rejected'),
(2, 3, 'pending'),
(3, 4, 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL CHECK (`price` >= 0),
  `stock` int(11) NOT NULL CHECK (`stock` >= 0),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `created_at`, `updated_at`) VALUES
(1, 'Coke', 15.00, 21, '2025-04-21 02:23:57', '2025-04-25 12:57:49'),
(2, 'Sprite', 25.00, 18, '2025-04-21 02:23:57', '2025-04-25 12:57:49'),
(3, 'Cracklings', 10.00, 25, '2025-04-21 02:23:57', '2025-04-25 12:54:37'),
(4, 'Mentos', 1.00, 27, '2025-04-21 02:23:57', '2025-04-21 07:12:40'),
(5, 'Mineral Water', 15.00, 29, '2025-04-21 02:23:57', '2025-04-21 07:17:16'),
(6, 'Coke Can', 15.00, 100, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(7, 'Pepsi Bottle', 25.00, 150, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(8, 'Toyo Soy Sauce', 10.00, 120, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(9, 'Patis Fish Sauce', 12.00, 100, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(10, 'Lucky Me Pancit Canton', 7.50, 79, '2025-04-21 06:44:27', '2025-04-21 07:17:18'),
(11, 'Nescafe 3-in-1', 5.00, 130, '2025-04-21 06:44:27', '2025-04-21 06:47:39'),
(12, 'Crispy Fry Breading', 20.00, 70, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(13, 'Chips Ahoy Cookies', 35.00, 109, '2025-04-21 06:44:27', '2025-04-21 07:17:19'),
(14, 'Skyflakes', 8.00, 149, '2025-04-21 06:44:27', '2025-04-21 07:21:41'),
(15, 'Oishi Prawn Crackers', 10.00, 90, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(16, 'Magnum Ice Cream', 45.00, 60, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(17, 'Chocovron', 15.00, 75, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(18, 'Milo 3-in-1', 25.00, 50, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(19, 'Bounty Fresh Chicken Hotdog', 40.00, 80, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(20, 'Jack n Jill Piattos', 12.00, 130, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(21, 'Nissin Cup Noodles', 18.00, 60, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(22, 'Moringa Tea Malunggay', 20.00, 95, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(23, 'Ovaltine', 35.00, 120, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(24, 'Fita Biscuits', 7.50, 150, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(25, 'Toblerone Chocolate', 150.00, 50, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(26, 'Maxx Candy', 3.00, 100, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(27, 'Knorr Sinigang Mix', 25.00, 85, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(28, 'Tuna Flakes in Oil', 35.00, 100, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(29, 'Del Monte Ketchup', 22.00, 60, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(30, 'Tang Orange Drink', 10.00, 120, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(31, 'Sunflower Oil', 40.00, 75, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(32, 'Pancake Mix', 55.00, 50, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(33, 'Bear Brand Powdered Milk', 75.00, 100, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(34, 'Ligo Sardines', 25.00, 95, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(35, 'Uncle John Pancake Syrup', 55.00, 80, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(36, 'P G Tide Detergent', 35.00, 150, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(37, 'Dove Soap', 45.00, 110, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(38, 'Safeguard Soap', 35.00, 130, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(39, 'Shokata Lemon Drink', 15.00, 140, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(40, 'Alaska Condensed Milk', 45.00, 80, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(41, 'Nescafe Coffee Jar', 150.00, 70, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(42, 'Lactum 3 Milk', 100.00, 90, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(43, 'Nescafe Classic', 30.00, 110, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(44, 'Del Monte Spaghetti', 25.00, 120, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(45, 'Clover Chips', 15.00, 60, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(46, 'Fried Garlic', 18.00, 100, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(47, 'Betty Crocker Chocolate Cake Mix', 100.00, 50, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(48, 'Mentos Mint Candy', 10.00, 140, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(49, 'Hersheys Kisses', 80.00, 60, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(50, 'Bounty Fresh Chicken', 150.00, 80, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(51, 'Kerrygold Butter', 250.00, 45, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(52, 'Goldilocks Polvoron', 12.00, 100, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(53, 'Cebuano Lechon Manok', 200.00, 50, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(54, 'Milo Cereal', 35.00, 60, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(55, 'Maggi Seasoning', 20.00, 100, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(56, 'Lipton Yellow Label Tea', 35.00, 120, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(57, 'Pineapple Juice', 15.00, 110, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(58, 'Dole Banana Chips', 45.00, 80, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(59, 'Jackfruit Langka', 50.00, 70, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(60, 'Calamansi Juice', 30.00, 100, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(61, 'Snack Mate', 20.00, 81, '2025-04-21 06:44:27', '2025-04-21 08:15:45'),
(62, 'Coco Mama Coconut Water', 40.00, 60, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(63, 'Tropicana Fruit Juice', 35.00, 110, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(64, 'Instant Pancit Malabon', 30.00, 80, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(65, 'Crispy Chicken Skin', 25.00, 75, '2025-04-21 06:44:27', '2025-04-21 06:44:27'),
(66, 'Spaghetti Sauce', 30.00, 120, '2025-04-21 06:44:27', '2025-04-21 06:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `cashier_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL CHECK (`total_amount` >= 0),
  `amount_received` decimal(10,2) NOT NULL CHECK (`amount_received` >= 0),
  `change_due` decimal(10,2) GENERATED ALWAYS AS (`amount_received` - `total_amount`) STORED,
  `transaction_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_items`
--

CREATE TABLE `transactions_items` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`) VALUES
(1, 'admin', '1234', 'administrator', 'admin@email.com'),
(2, 'cashier', '1234', 'cashier', 'cashier@email.com'),
(3, 'cashier2', '1234', 'cashier', 'cashier2@email.com'),
(4, 'cashier3', '1234', 'cashier', 'cashier3@email.com'),
(5, 'admin2', '1234', 'administrator', 'admin2@gmail.com'),
(6, 'admin3', '1234', 'administrator', 'admin3@email.com'),
(7, 'admin4', '1234', 'administrator', 'admin4@email.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cashier_status`
--
ALTER TABLE `cashier_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_cashier` (`cashier_id`);

--
-- Indexes for table `transactions_items`
--
ALTER TABLE `transactions_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cashier_status`
--
ALTER TABLE `cashier_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_items`
--
ALTER TABLE `transactions_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cashier_status`
--
ALTER TABLE `cashier_status`
  ADD CONSTRAINT `cashier_status_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_cashier` FOREIGN KEY (`cashier_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`cashier_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions_items`
--
ALTER TABLE `transactions_items`
  ADD CONSTRAINT `transactions_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
