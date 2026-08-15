-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 15, 2026 at 04:41 PM
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
-- Database: `dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `addtocart`
--

CREATE TABLE `addtocart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total_price` decimal(10,2) GENERATED ALWAYS AS (`price` * `quantity`) STORED,
  `status` enum('active','ordered','removed') DEFAULT 'active',
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addtocart`
--

INSERT INTO `addtocart` (`id`, `user_id`, `product_id`, `name`, `image`, `price`, `quantity`, `status`, `added_at`) VALUES
(3, 4, 9, 'Macchiato\n        ', '1779173564_coffee3.jpg\n        ', 170.00, 1, 'active', '2026-05-25 08:53:39'),
(7, 4, 62, 'Rose Gold Cappuccino\n        ', '1779203071_session2.jpg\n        ', 348.00, 1, 'active', '2026-05-25 15:39:35'),
(10, 4, 12, 'French Fries\n        ', '1779173782_snacks2.jpg\n        ', 200.00, 1, 'active', '2026-05-25 20:14:38'),
(16, 4, 11, 'Latte\n        ', '1779173652_coffee5.webp\n        ', 280.00, 1, 'active', '2026-05-25 22:15:53'),
(17, 4, 53, 'Hash Browns\n        ', '1779202279_combo5.jpg\n        ', 380.00, 1, 'active', '2026-05-26 06:45:42'),
(19, 4, 17, 'Iced Latte\n        ', '1779175103_cold1.webp\n        ', 199.00, 1, 'active', '2026-05-26 07:49:25'),
(23, 4, 44, 'Bubble Coffee\n', '1779200965_IMG-20250823-WA0058.jpg\n', 300.00, 1, 'active', '2026-05-26 11:27:13'),
(24, 4, 8, 'Ristretto\n        ', '1779173517_coffee2.jpg\n        ', 280.00, 1, 'active', '2026-05-26 11:29:20'),
(25, 4, 34, 'Ratnagiri Mango\n        ', '1779182192_ice3.jpg\n        ', 300.00, 3, 'active', '2026-05-26 11:29:42'),
(28, 4, 42, 'Brewed Coffee\n        ', '1779200241_gl1.webp\n        ', 400.00, 1, 'active', '2026-05-27 10:52:55'),
(29, 4, 36, 'Amul Gold Magic\n        ', '1779182362_ice5.jpg\n        ', 299.00, 1, 'active', '2026-05-27 11:52:55'),
(30, 4, 4, 'Ssangssangbar\n        ', 'download (2).jpeg\n        ', 350.00, 1, 'active', '2026-05-27 11:53:15'),
(31, 4, 32, 'Vanilla Bean\n        ', '1779182029_ice1.jpg\n        ', 299.00, 1, 'active', '2026-05-27 11:53:43'),
(32, 4, 10, 'Cortado\n        ', '1779173615_coffee4.jpg\n        ', 399.00, 1, 'active', '2026-05-27 11:53:56'),
(33, 4, 21, 'Frappuccino\n        ', '1779175572_cold5.jpg\n        ', 160.00, 1, 'active', '2026-05-29 04:25:49'),
(35, 1, 38, 'Cube Croissant\n        ', '1779182569_crossient2.jpg\n        ', 400.00, 1, 'active', '2026-05-29 04:53:26'),
(37, 1, 37, 'Croissant Burger Bun\n        ', '1779182498_crossient1.jpg\n        ', 400.00, 1, 'active', '2026-05-29 04:56:24'),
(39, 1, 7, 'Espresso\n        ', '1779173463_coffee1.webp\n        ', 150.00, 1, 'active', '2026-05-29 05:01:21'),
(41, 1, 23, 'Nescafe Classic/Gold\n        ', '1779180921_hot2.jpg\n        ', 199.00, 1, 'active', '2026-05-29 08:32:03'),
(42, 1, 24, 'White Hot Chocolate\n        ', '1779181179_hot3.jpg\n        ', 300.00, 1, 'active', '2026-05-29 12:50:21'),
(47, 1, 8, 'Ristretto\n        ', '1779173517_coffee2.jpg\n        ', 280.00, 1, 'active', '2026-05-29 18:21:16'),
(48, 4, 19, 'Cold Brew\n        ', '1779175482_cold3.jpg\n        ', 255.00, 1, 'active', '2026-05-30 05:05:09'),
(49, 4, 24, 'White Hot Chocolate\n        ', '1779181179_hot3.jpg\n        ', 300.00, 1, 'active', '2026-05-30 07:00:18'),
(52, 1, 13, 'Salisbury Steak\n        ', '1779173852_snacks1.jpg\n        ', 350.00, 1, 'active', '2026-05-31 08:39:46'),
(53, 1, 9, 'Macchiato\n        ', '1779173564_coffee3.jpg\n        ', 170.00, 1, 'active', '2026-05-31 16:23:22'),
(56, 4, 7, 'Espresso\n        ', '1779173463_coffee1.webp\n        ', 150.00, 1, 'active', '2026-06-04 12:20:24'),
(63, 4, 1, 'Cappuccino\n        ', 'IMG-20250823-WA0055.jpg\n        ', 199.00, 1, 'active', '2026-08-09 05:18:01');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `booking_table` text DEFAULT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `people` int(11) DEFAULT 1,
  `special_event` enum('None','Birthday','Anniversary','Date','Business Meeting','Family Gathering','Success Celebration','Friend Reunion','Group Study','Other') DEFAULT 'None',
  `special_order` varchar(10) DEFAULT NULL,
  `event_image` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `table_id` varchar(50) DEFAULT NULL,
  `is_paid` int(11) DEFAULT 0,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` varchar(30) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `customer_name`, `customer_phone`, `booking_table`, `booking_date`, `booking_time`, `people`, `special_event`, `special_order`, `event_image`, `message`, `status`, `created_at`, `table_id`, `is_paid`, `amount`, `payment_method`, `payment_status`) VALUES
(4, 4, 'Soham Dey', '6756453423', 'seat2.jpeg', '2026-06-24', '17:03:00', 2, 'Anniversary', NULL, 'seat2.jpeg', '', 'Confirmed', '2026-06-12 06:33:53', '2', 0, 0.00, NULL, 'Pending'),
(5, 4, 'Soham Dey', '6756453423', 'seat2.jpeg', '2026-06-27', '12:19:00', 3, 'Anniversary', 'Yes', 'seat2.jpeg', 'abc', 'Cancelled', '2026-06-12 06:45:23', '2', 0, 0.00, NULL, 'Pending'),
(6, 4, 'Soham Dey', '6756453423', 'seat9.jpeg', '2026-07-11', '13:05:00', 2, '', 'Yes', 'seat9.jpeg', 'best', 'Cancelled', '2026-06-12 07:31:00', '9', 0, 0.00, NULL, 'Pending'),
(7, 7, 'Sussi Roy', '7718445284', 'seat7.jpeg', '2026-06-27', '21:41:00', 3, '', 'Yes', 'seat7.jpeg', 'Want peace', 'Confirmed', '2026-06-14 16:07:33', '7', 0, 0.00, NULL, 'Pending'),
(8, 4, 'Soham Dey', '6756453423', 'seat1.jpeg', '2026-08-26', '20:09:00', 64, '', 'Yes', 'seat1.jpeg', 'peace', 'Pending', '2026-08-10 11:44:08', '1', 0, 0.00, 'Cash On Arrival', 'Pending'),
(9, 4, 'Soham Dey', '6756453423', 'seat7.jpeg', '2026-08-12', '01:31:00', 2, 'Anniversary', 'Yes', 'seat7.jpeg', 'lovable', 'Pending', '2026-08-10 17:58:47', '7', 0, 0.00, 'Cash On Arrival', 'Pending'),
(10, 4, 'Soham Dey', '6756453423', 'seat9.jpeg', '2026-08-15', '05:36:00', 5, '', 'Yes', 'seat9.jpeg', 'family time', 'Pending', '2026-08-10 19:03:26', '9', 0, 0.00, 'Cash On Arrival', 'Pending'),
(11, 4, 'Soham Dey', '6756453425', 'seat4.jpeg', '2026-08-20', '01:46:00', 1, 'None', 'No', 'seat4.jpeg', 'stydy', 'Pending', '2026-08-10 19:16:41', '4', 0, 500.00, 'Cash On Arrival', 'Pending'),
(12, 4, 'Soham Dey', '6756453429', 'seat5.jpeg', '2026-08-16', '05:10:00', 5, 'None', 'No', 'seat5.jpeg', 'success', 'Pending', '2026-08-10 19:40:37', '5', 0, 900.00, 'Cash On Arrival', 'Pending'),
(13, 4, 'Soham Dey', '770005284', 'seat4.jpeg', '2026-08-18', '01:20:00', 5, 'Success Celebration', 'Yes', 'seat4.jpeg', 'success', 'Pending', '2026-08-10 19:46:47', '4', 0, 500.00, 'Cash On Arrival', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `cafe_timetable`
--

CREATE TABLE `cafe_timetable` (
  `id` int(11) NOT NULL,
  `day_name` varchar(20) NOT NULL,
  `day_number` tinyint(4) NOT NULL,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `break_start` time DEFAULT NULL,
  `break_end` time DEFAULT NULL,
  `status` enum('Open','Closed') DEFAULT 'Open',
  `slot_duration` int(11) DEFAULT 60,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cafe_timetable`
--

INSERT INTO `cafe_timetable` (`id`, `day_name`, `day_number`, `opening_time`, `closing_time`, `break_start`, `break_end`, `status`, `slot_duration`, `updated_at`) VALUES
(1, 'Monday', 1, '09:00:00', '22:00:00', '15:00:00', '16:00:00', 'Open', 60, '2026-08-11 16:38:02'),
(2, 'Tuesday', 2, '09:00:00', '22:00:00', '15:00:00', '16:00:00', 'Open', 60, '2026-08-11 16:38:02'),
(3, 'Wednesday', 3, '09:00:00', '22:00:00', '15:00:00', '16:00:00', 'Open', 60, '2026-08-11 16:38:02'),
(4, 'Thursday', 4, '09:00:00', '22:00:00', '15:00:00', '16:00:00', 'Open', 60, '2026-08-11 16:38:02'),
(5, 'Friday', 5, '09:00:00', '23:00:00', '16:00:00', '17:00:00', 'Open', 60, '2026-08-11 16:38:02'),
(6, 'Saturday', 6, '09:00:00', '23:00:00', '16:00:00', '17:00:00', 'Open', 60, '2026-08-11 16:38:02'),
(7, 'Sunday', 7, '10:00:00', '21:00:00', '15:00:00', '16:00:00', 'Open', 60, '2026-08-11 16:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `descri` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `image` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `descri`, `price`, `image`, `status`, `create_at`, `parent_id`) VALUES
(7, 'Coffee', 'Coffee', 'Experience the rich aroma and bold flavor of our premium coffee, crafted from carefully selected high-quality beans. ', 280, 'IMG-20250823-WA0033.jpg', 1, '2026-05-06 01:41:48', 0),
(8, 'Snacks', 'Snacks', 'A selection of freshly made snacks crafted to satisfy your cravings and pair perfectly with every sip of coffee.', 299, 'IMG-20250823-WA0038.jpg', 1, '2026-05-06 01:44:42', 0),
(9, 'Cold Beverages', 'Cold Beverages', 'Indulge in our signature cold beverages, expertly prepared to deliver a refreshing burst of flavor. ', 199, 'gl1.webp', 1, '2026-05-06 08:02:38', 0),
(10, 'Hot Beverages', 'Hot Beverages', 'One of the most widely consumed hot beverages is Tea, prepared by steeping tea leaves in hot water. ', 99, 'IMG-20250823-WA0054.jpg', 1, '2026-05-07 00:12:42', 0),
(11, 'Desserts', 'Desserts', 'Besides satisfying a sweet craving, desserts can also showcase creativity through decoration, textures, and unique flavor combinations.', 300, 'IMG-20250823-WA0047.jpg', 1, '2026-05-07 00:16:56', 0),
(12, 'Icecream', 'Icecream', 'Ice cream is enjoyed worldwide as a refreshing treat, especially during hot weather. ', 199, 'download (3).jpeg', 1, '2026-05-07 00:19:34', 0),
(13, 'Golden-brown Croissant pair with Cappuccino', 'Combo Offers', 'A crisp, golden-baked Croissant served with a smooth, frothy Cappuccino — the perfect blend of comfort and café elegance. Light, buttery layers meet bold espresso flavor for a stylish grab-and-go pairing made for modern coffee lovers.', 699, 'combo1.webp', 1, '2026-05-07 01:18:31', 0),
(14, 'Cool Bean Specials', 'Seasonal Specials', 'Cool Bean Specials – Refresh your coffee moments with bold flavors, chilled vibes, and perfectly crafted brews. From creamy iced lattes to rich café favorites, enjoy modern coffee combos made to energize your day in style.', 399, 'session1.webp', 1, '2026-05-07 01:21:11', 0),
(18, 'Tea & Herbal', 'Tea & Herbal', 'Mint tea is a refreshing and aromatic beverage made by infusing fresh mint leaves in hot water, sometimes blended with green or black tea. Known for its cool, soothing flavor and natural freshness, mint tea is enjoyed both hot and iced.', 99, 'herbal3.webp', 1, '2026-05-07 01:35:16', 0),
(20, 'Special Combo offer', 'Combo offer', 'Grab our Special Combo Offer and enjoy amazing products together at the best price. This combo is specially designed to give you more value, better savings, and a complete shopping experience in one package.', 299, 'combo3.jpeg', 1, '2026-05-11 01:15:17', 0),
(21, 'Pastry', 'Amazing Pastry ', 'Pastry is a versatile, rich dough made from flour, fat (butter), and liquid (water or milk), known for its flaky, tender, or crumbly texture. ', 200, 'IMG-20250823-WA0045.jpg', 1, '2026-05-14 11:14:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `addwithus` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `membership` enum('Gold','Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `mobile`, `password`, `reset_token`, `reset_expiry`, `address`, `image`, `addwithus`, `role`, `membership`) VALUES
(1, 'Tanushree Dey', 'dey.tanushree2006@gmail.com', '8001737625', 'e8d3d3ecac9dd3f1dffd3fc964fb3760', NULL, NULL, 'Ramnagar', 'tes5.jpg', '2026-05-19 07:35:37', 'admin', 'Gold'),
(2, 'Priya Maity', 'priya@gmail.com', '9147483642', '48467d2cc726e8847fbc51f5b0bdc1d1', NULL, NULL, 'Contai', 'tes6.jpg', '2026-05-19 07:35:37', 'user', 'No'),
(3, 'Megha Dey', 'megha@gmail.com', '9147483644', '1cb72e4052037de4352ef9ea7fe834eb', NULL, NULL, 'Jammu', 'tes3.jpg', '2026-05-19 07:35:37', 'user', 'No'),
(4, 'Soham Dey', 'om@gmail.com', '9242483647', '$2y$10$3c.xwaBLbedbxWwjfTDSlu9hbro6NDPDGRIYxbeiKlvKcQiH.OwB.', NULL, NULL, 'Digha', 'tes4.jpeg', '2026-05-19 07:35:37', 'user', 'Gold'),
(5, 'Anusri Dey', 'anusri@gmail.com', '9745483647', '9904fd42e4977d5815b5d5679a935ed5', NULL, NULL, 'Contai', 'tes1.jpg', '2026-05-19 07:35:37', 'user', 'No'),
(6, 'Soniya Mitra', 'Soniya@gmail.com', '9732781855', '239c81f9f49ce3ae4d8d99e508c90abe', NULL, NULL, 'Birbhum', 'tes6.jpg', '2026-05-19 07:35:37', 'user', 'No'),
(7, 'Sussi Roy', 'sussi@gmail.com', '7718445284', '319d3d2ed67fa3e50f5bf220777d6581', NULL, NULL, 'Egra', 'tes1.jpg', '2026-05-19 07:35:37', 'user', 'No'),
(8, 'Rishi Mitra', 'rishi@gmail.com', '8006745234', '9e58d6ab9e42c22ebd5c63e97c36004d', NULL, NULL, 'Durgapur', 'tes2.jpg', '2026-05-19 07:35:37', 'user', 'No'),
(10, 'Saniya Rana', 'saniya@gmail.com', '', '$2y$10$TXi9hFC.NvedZMPLei1n.unigFwh0DtYL7dYbi2uhdwcqAE50g7kW', NULL, NULL, 'Digha', ' tes6.jpg ', '2026-08-09 16:25:02', 'user', 'No'),
(11, 'Ahi', 'ahi@gmail.com', '', '$2y$10$FhmN68XpRO57zc4g1YEpwOx4thJDBbpsP/Zs50.7xGetIYBxlvFnG', NULL, NULL, 'Digha', ' tes5.jpg ', '2026-08-09 16:26:19', 'user', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `item_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `order_status` enum('Pending','Shipped') DEFAULT 'Pending',
  `shipping_add` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `category_name`, `name`, `price`, `stock`, `image`, `status`, `create_at`) VALUES
(1, 7, 'Coffee', 'Cappuccino', 199.00, 99, 'IMG-20250823-WA0055.jpg', 1, '2026-05-07 20:20:13'),
(2, 8, 'Snacks', 'Caprese Grilled Cheese', 200.00, 100, 'IMG-20250823-WA0036.jpg', 1, '2026-05-07 20:26:35'),
(3, 9, 'Cold Beverages', 'Iced Latte', 170.00, 90, 'IMG-20250823-WA0023.jpg', 1, '2026-05-07 20:35:20'),
(4, 12, 'Icecream', 'Ssangssangbar', 350.00, 88, 'download (2).jpeg', 1, '2026-05-07 21:03:24'),
(5, 18, 'Tea & Herbal', 'Mint Tea', 78.00, 99, 'herbal3.webp', 1, '2026-05-07 21:04:54'),
(6, 11, 'Desserts', 'Ultimate Chocolate Sundae', 300.00, 100, 'IMG-20250823-WA0047.jpg', 1, '2026-05-07 21:06:58'),
(7, 7, 'Coffee', 'Espresso', 150.00, 100, '1779173463_coffee1.webp', 1, '2026-05-19 06:51:03'),
(8, 7, 'Coffee', 'Ristretto', 280.00, 98, '1779173517_coffee2.jpg', 1, '2026-05-19 06:51:57'),
(9, 7, 'Coffee', 'Macchiato', 170.00, 0, '1779173564_coffee3.jpg', 0, '2026-05-19 06:52:44'),
(10, 7, 'Coffee', 'Cortado', 399.00, 100, '1779173615_coffee4.jpg', 1, '2026-05-19 06:53:35'),
(11, 7, 'Coffee', 'Latte', 280.00, 100, '1779173652_coffee5.webp', 1, '2026-05-19 06:54:12'),
(12, 8, 'Snacks', 'French Fries', 200.00, 100, '1779173782_snacks2.jpg', 1, '2026-05-19 06:56:22'),
(13, 8, 'Snacks', 'Salisbury Steak', 350.00, 99, '1779173852_snacks1.jpg', 1, '2026-05-19 06:57:32'),
(14, 8, 'Snacks', 'Croissant Sandwich', 500.00, 100, '1779173996_IMG-20250823-WA0038.jpg', 1, '2026-05-19 06:59:56'),
(15, 8, 'Snacks', 'Grilled Club Sandwich', 400.00, 100, 'IMG-20250823-WA0037.jpg', 1, '2026-05-19 07:00:46'),
(16, 8, 'Snacks', 'Hamburger Sandwich', 499.00, 100, '1779174121_IMG-20250823-WA0035.jpg', 1, '2026-05-19 07:02:01'),
(17, 9, 'Cold Beverages', 'Iced Latte', 199.00, 100, '1779175103_cold1.webp', 1, '2026-05-19 07:18:23'),
(18, 9, 'Cold Beverages', 'Iced Americano', 280.00, 100, '1779175422_cold2.jpg', 1, '2026-05-19 07:23:42'),
(19, 9, 'Cold Beverages', 'Cold Brew', 255.00, 89, '1779175482_cold3.jpg', 1, '2026-05-19 07:24:42'),
(20, 9, 'Cold Beverages', 'Nitro Cold Brew', 160.00, 99, '1779175532_cold4.jpg', 1, '2026-05-19 07:25:32'),
(21, 9, 'Cold Beverages', 'Frappuccino', 160.00, 98, '1779175572_cold5.jpg', 1, '2026-05-19 07:26:12'),
(22, 10, 'Hot Beverages', 'Hot Spanish Latte', 99.00, 100, '1779180555_hot1.jpg', 1, '2026-05-19 08:49:15'),
(23, 10, 'Hot Beverages', 'Nescafe Classic/Gold', 199.00, 100, '1779180921_hot2.jpg', 1, '2026-05-19 08:55:21'),
(24, 10, 'Hot Beverages', 'White Hot Chocolate', 300.00, 0, '1779181179_hot3.jpg', 0, '2026-05-19 08:59:39'),
(25, 10, 'Hot Beverages', 'Edible Biscuit Cup', 399.00, 100, '1779181403_hot4.png', 1, '2026-05-19 09:03:23'),
(26, 10, 'Hot Beverages', 'Flat White', 180.00, 100, '1779181535_IMG-20250823-WA0050.jpg', 1, '2026-05-19 09:05:35'),
(27, 11, 'Desserts', 'Chocolate Lava Cake', 299.00, 100, '1779181628_dessert1.jpg', 1, '2026-05-19 09:07:08'),
(28, 11, 'Desserts', 'Rasmalai', 180.00, 100, '1779181707_dessert2.jpg', 1, '2026-05-19 09:08:27'),
(29, 11, 'Desserts', 'Strawberry Tart', 250.00, 100, '1779181784_dessert3.webp', 1, '2026-05-19 09:09:44'),
(30, 11, 'Desserts', 'Blueberry Crisp', 299.00, 100, '1779181857_dessert4.avif', 1, '2026-05-19 09:10:57'),
(31, 11, 'Desserts', 'Strawberries and Cream', 299.00, 100, '1779181926_IMG-20250823-WA0046.jpg', 1, '2026-05-19 09:12:06'),
(32, 12, 'Icecream', 'Vanilla Bean', 299.00, 100, '1779182029_ice1.jpg', 1, '2026-05-19 09:13:49'),
(33, 12, 'Icecream', 'Hocco Belgian Chocolate', 300.00, 100, '1779182119_ice2.jpg', 1, '2026-05-19 09:15:19'),
(34, 12, 'Icecream', 'Ratnagiri Mango', 300.00, 100, '1779182192_ice3.jpg', 1, '2026-05-19 09:16:32'),
(35, 12, 'Icecream', 'Kwality Wall\'s', 290.00, 100, '1779182280_ice4.jpg', 1, '2026-05-19 09:18:00'),
(36, 12, 'Icecream', 'Amul Gold Magic', 299.00, 100, '1779182362_ice5.jpg', 1, '2026-05-19 09:19:22'),
(37, 13, 'Golden-brown Croissant pair with Cappuccino', 'Croissant Burger Bun', 400.00, 100, '1779182498_crossient1.jpg', 1, '2026-05-19 09:21:38'),
(38, 13, 'Golden-brown Croissant pair with Cappuccino', 'Cube Croissant', 400.00, 100, '1779182569_crossient2.jpg', 1, '2026-05-19 09:22:49'),
(39, 13, 'Golden-brown Croissant pair with Cappuccino', 'Flat Croissant', 380.00, 100, '1779182625_crossient3.jpg', 1, '2026-05-19 09:23:45'),
(40, 13, 'Golden-brown Croissant pair with Cappuccino', 'Suprême', 300.00, 100, '1779182666_crossient4.jpg', 1, '2026-05-19 09:24:26'),
(41, 13, 'Golden-brown Croissant pair with Cappuccino', 'Laminated Brioche Bun', 400.00, 99, '1779182738_crossient5.jpg', 1, '2026-05-19 09:25:38'),
(42, 14, 'Cool Bean Specials', 'Brewed Coffee', 400.00, 100, '1779200241_gl1.webp', 1, '2026-05-19 14:17:21'),
(43, 14, 'Cool Bean Specials', 'Lattes', 200.00, 100, '1779200346_IMG-20250823-WA0061.jpg', 1, '2026-05-19 14:19:06'),
(44, 14, 'Cool Bean Specials', 'Bubble Coffee', 300.00, 100, '1779200965_IMG-20250823-WA0058.jpg', 1, '2026-05-19 14:29:25'),
(45, 14, 'Cool Bean Specials', 'Cold Cappuccino', 400.00, 100, '1779201179_IMG-20250823-WA0051.jpg', 1, '2026-05-19 14:32:59'),
(46, 14, 'Cool Bean Specials', 'Mocha', 200.00, 100, '1779201271_gl6.jpg', 1, '2026-05-19 14:34:31'),
(47, 18, 'Tea & Herbal', 'Butterfly Pea Flower', 199.00, 100, '1779201419_herbal1.jpg', 1, '2026-05-19 14:36:59'),
(48, 18, 'Tea & Herbal', 'Echinacea Tea ', 301.00, 100, '1779201537_herbal2.avif', 1, '2026-05-19 14:38:57'),
(49, 18, 'Tea & Herbal', 'Jasmine Herbal Tea', 200.00, 100, '1779201602_herbal4.jpg', 1, '2026-05-19 14:40:02'),
(50, 18, 'Tea & Herbal', 'Lavender Tea An ', 270.00, 100, '1779201652_herbal5.jpg', 1, '2026-05-19 14:40:52'),
(51, 20, 'Special Combo offer', 'The Cafe Pizzeria Combo', 599.00, 100, '1779201793_combo2.jpg', 1, '2026-05-19 14:43:13'),
(52, 20, 'Special Combo offer', 'Sesame Bun', 550.00, 0, '1779201884_combo1.webp', 0, '2026-05-19 14:44:44'),
(53, 20, 'Special Combo offer', 'Hash Browns', 380.00, 100, '1779202279_combo5.jpg', 1, '2026-05-19 14:51:19'),
(54, 20, 'Special Combo offer', 'Samosa  ', 280.00, 100, '1779202356_combo4.jpg', 1, '2026-05-19 14:52:36'),
(55, 20, 'Special Combo offer', 'The Ultimate Trio', 599.00, 100, '1779202446_combo3.jpeg', 1, '2026-05-19 14:54:06'),
(56, 21, 'Pastry', 'Eclair', 99.00, 99, '1779202554_pastry1.jpg', 1, '2026-05-19 14:55:54'),
(57, 21, 'Pastry', 'Pain au Chocolate (Chocolate Croissant)', 299.00, 100, '1779202648_pastry2.jpg', 1, '2026-05-19 14:57:28'),
(58, 21, 'Pastry', 'Raspberry Danish', 250.00, 100, '1779202804_IMG-20250823-WA0041.jpg', 1, '2026-05-19 15:00:04'),
(59, 21, 'Pastry', 'Pineapple Tarte Tatin', 280.00, 100, '1779202860_IMG-20250823-WA0040.jpg', 1, '2026-05-19 15:01:00'),
(60, 21, 'Pastry', 'Double Chocolate Muffin', 299.00, 100, '1779202916_IMG-20250823-WA0042.jpg', 1, '2026-05-19 15:01:56'),
(61, 14, 'Cool Bean Specials', 'Lavender Honey Latte', 299.00, 100, '1779203025_session1.webp', 1, '2026-05-19 15:03:45'),
(62, 14, 'Cool Bean Specials', 'Rose Gold Cappuccino', 348.00, 0, '1779203071_session2.jpg', 0, '2026-05-19 15:04:31'),
(63, 14, 'Cool Bean Specials', 'Peppermint Mocha', 280.00, 100, '1779203134_session3.webp', 1, '2026-05-19 15:05:34'),
(64, 14, 'Cool Bean Specials', 'Chestnut Hot Chocolate Espresso', 499.00, 100, '1779203228_session4.png', 1, '2026-05-19 15:07:08'),
(65, 14, 'Cool Bean Specials', 'Roasted Hazelnut Mocha', 399.00, 100, '1779203274_session5.avif', 1, '2026-05-19 15:07:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_number` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `user_id`, `product_id`, `order_number`, `rating`, `review`, `created_at`) VALUES
(1, 1, 7, 'ORD1780516082891', 3, 'Cool icecream', '2026-06-04 08:58:54'),
(2, 1, 7, 'ORD1780516082891', 3, 'Amazing', '2026-06-04 09:05:20'),
(3, 4, 11, 'ORD1780565228562', 2, 'Tasty', '2026-06-04 09:30:04'),
(4, 4, 7, '', 5, 'I really like it', '2026-06-04 10:17:50'),
(5, 4, 7, '', 5, 'I like it', '2026-06-04 10:18:20'),
(6, 4, 5, '', 5, 'very nice beautiful', '2026-06-04 10:31:37'),
(7, 4, 8, '', 3, 'Satisfied', '2026-06-05 06:20:17'),
(8, 4, 11, '', 4, 'best', '2026-08-09 05:19:52');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `descri` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` int(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `category_name`, `name`, `descri`, `image`, `price`, `status`, `create_at`) VALUES
(27, 7, 'Coffee', 'Cappuccino', 'A rich and creamy Italian coffee made with freshly brewed espresso, steamed milk, and a thick layer of smooth milk foam. ', 'IMG-20250823-WA0055.jpg', 199, 1, '2026-05-07 20:20:13'),
(28, 8, 'Snacks', 'Caprese Grilled Cheese', 'Golden grilled bread filled with mozzarella, tomatoes, and fresh basil.', 'IMG-20250823-WA0036.jpg', 200, 1, '2026-05-07 20:26:35'),
(29, 9, 'Cold Beverages', 'Iced Latte', 'A smooth and refreshing blend of rich espresso, chilled milk, and ice, creating a creamy coffee drink perfect for a cool and energizing experience.', 'IMG-20250823-WA0023.jpg', 170, 1, '2026-05-07 20:35:20'),
(31, 12, 'Icecream', 'Ssangssangbar', 'Mild chocolate flavor that is creamy yet refreshing rather than overly rich.', 'download (2).jpeg', 350, 1, '2026-05-07 21:03:24'),
(32, 18, 'Tea & Herbal', 'Mint Tea', 'Mint tea is a refreshing herbal infusion (or tisane) made by steeping mint leaves in hot water. ', 'herbal3.webp', 78, 1, '2026-05-07 21:04:54'),
(33, 11, 'Desserts', 'Ultimate Chocolate Sundae', ' Multiple scoops of rich chocolate ice cream \"drenched\" in hot fudge sauce, often garnished with chocolate shavings and wafer sticks.', 'IMG-20250823-WA0047.jpg', 300, 1, '2026-05-07 21:06:58'),
(36, 7, 'Coffee', 'Espresso', 'A small, highly concentrated shot of coffee forced through finely-ground beans.', '1779173463_coffee1.webp', 150, 1, '2026-05-19 06:51:03'),
(37, 7, 'Coffee', 'Ristretto', ' A \"short\" shot of espresso made with the same amount of coffee but less water, resulting in a more concentrated, less bitter flavor.', '1779173517_coffee2.jpg', 280, 1, '2026-05-19 06:51:57'),
(38, 7, 'Coffee', 'Macchiato', 'Espresso \"stained\" with a small dollop of steamed milk or foam on top to mellow the intensity.', '1779173564_coffee3.jpg', 170, 1, '2026-05-19 06:52:44'),
(39, 7, 'Coffee', 'Cortado', 'A Spanish-style drink consisting of espresso cut with equal parts warm, steamed milk to reduce acidity.', '1779173615_coffee4.jpg', 399, 1, '2026-05-19 06:53:35'),
(40, 7, 'Coffee', 'Latte', 'A shot of espresso filled with a large amount of steamed milk and a thin layer of foam.', '1779173652_coffee5.webp', 280, 1, '2026-05-19 06:54:12'),
(41, 8, 'Snacks', 'French Fries', 'The traditional British name for thick-cut, deep-fried potatoes.', '1779173782_snacks2.jpg', 200, 1, '2026-05-19 06:56:22'),
(42, 8, 'Snacks', 'Salisbury Steak', 'A historical American variation served with gravy instead of a bun.', '1779173852_snacks1.jpg', 350, 1, '2026-05-19 06:57:32'),
(43, 8, 'Snacks', 'Croissant Sandwich', ' A historical American legal and culinary term for meat between two slices of bread.', '1779173996_IMG-20250823-WA0038.jpg', 500, 1, '2026-05-19 06:59:56'),
(44, 8, 'Snacks', 'Grilled Club Sandwich', 'Classic, centuries-old British slang terms still used for basic sandwiches.', 'IMG-20250823-WA0037.jpg', 400, 1, '2026-05-19 07:00:46'),
(45, 8, 'Snacks', 'Hamburger Sandwich', 'The early American name used when the patty was first placed between bread.', '1779174121_IMG-20250823-WA0035.jpg', 499, 1, '2026-05-19 07:02:01'),
(46, 9, 'Cold Beverages', 'Iced Latte', 'Espresso mixed with cold milk and poured over ice.', '1779175103_cold1.webp', 199, 1, '2026-05-19 07:18:23'),
(47, 9, 'Cold Beverages', 'Iced Americano', 'Espresso shots diluted with cold water and served over ice.', '1779175422_cold2.jpg', 280, 1, '2026-05-19 07:23:42'),
(48, 9, 'Cold Beverages', 'Cold Brew', 'Coffee steeped in cold water for 12–24 hours, delivering a smooth flavor.', '1779175482_cold3.jpg', 255, 1, '2026-05-19 07:24:42'),
(49, 9, 'Cold Beverages', 'Nitro Cold Brew', ' Cold brew infused with nitrogen gas, creating a creamy, beer-like texture.', '1779175532_cold4.jpg', 160, 1, '2026-05-19 07:25:32'),
(50, 9, 'Cold Beverages', 'Frappuccino', ' A blended ice drink made with coffee, milk, syrups, and topped with whipped cream.', '1779175572_cold5.jpg', 160, 1, '2026-05-19 07:26:12'),
(51, 10, 'Hot Beverages', 'Hot Spanish Latte', 'A sweet latte made with condensed milk.', '1779180555_hot1.jpg', 99, 1, '2026-05-19 08:49:15'),
(52, 10, 'Hot Beverages', 'Nescafe Classic/Gold', ' Popular instant granules for a quick, bold cup.', '1779180921_hot2.jpg', 199, 1, '2026-05-19 08:55:21'),
(53, 10, 'Hot Beverages', 'White Hot Chocolate', 'Rich, sweet beverage made with melted white chocolate chips.', '1779181179_hot3.jpg', 300, 1, '2026-05-19 08:59:39'),
(54, 10, 'Hot Beverages', 'Edible Biscuit Cup', 'An edible biscuit cup is a sustainable, zero-waste alternative to single-use plastic or paper cups, designed to hold beverages and be eaten afterward. ', '1779181403_hot4.png', 399, 1, '2026-05-19 09:03:23'),
(55, 10, 'Hot Beverages', 'Flat White', 'A smooth and creamy combination of espresso and velvety milk.', '1779181535_IMG-20250823-WA0050.jpg', 180, 1, '2026-05-19 09:05:35'),
(56, 11, 'Desserts', 'Chocolate Lava Cake', 'Warm cake with a molten chocolate center.', '1779181628_dessert1.jpg', 299, 1, '2026-05-19 09:07:08'),
(57, 11, 'Desserts', 'Rasmalai', 'Soft cottage cheese patties steeped in sweetened saffron milk.', '1779181707_dessert2.jpg', 180, 1, '2026-05-19 09:08:27'),
(58, 11, 'Desserts', 'Strawberry Tart', 'Crisp pastry shell filled with custard and arranged fresh strawberry slices.', '1779181784_dessert3.webp', 250, 1, '2026-05-19 09:09:44'),
(59, 11, 'Desserts', 'Blueberry Crisp', 'A baked berry dessert covered in a crunchy oat and brown sugar crumble.', '1779181857_dessert4.avif', 299, 1, '2026-05-19 09:10:57'),
(60, 11, 'Desserts', 'Strawberries and Cream', 'Fresh, juicy strawberries served simply with sweetened whipped cream.', '1779181926_IMG-20250823-WA0046.jpg', 299, 1, '2026-05-19 09:12:06'),
(61, 12, 'Icecream', 'Vanilla Bean', 'Creamy base speckled with real vanilla orchid seeds.', '1779182029_ice1.jpg', 299, 1, '2026-05-19 09:13:49'),
(62, 12, 'Icecream', 'Hocco Belgian Chocolate', 'Rich, dark cocoa-infused ice cream.', '1779182119_ice2.jpg', 300, 1, '2026-05-19 09:15:19'),
(63, 12, 'Icecream', 'Ratnagiri Mango', 'Family gatherings & regular dessert pairing', '1779182192_ice3.jpg', 300, 1, '2026-05-19 09:16:32'),
(64, 12, 'Icecream', 'Kwality Wall\'s', 'Authentic Oreo cookie flavor', '1779182280_ice4.jpg', 290, 1, '2026-05-19 09:18:00'),
(65, 12, 'Icecream', 'Amul Gold Magic', 'Traditional family dessert scoops', '1779182362_ice5.jpg', 299, 1, '2026-05-19 09:19:22'),
(66, 13, 'Golden-brown Croissant pair with Cappuccino', 'Croissant Burger Bun', 'A savory bakery innovation where flaky croissant dough is tightly rolled into a round burger bun shape. ', '1779182498_crossient1.jpg', 400, 1, '2026-05-19 09:21:38'),
(67, 13, 'Golden-brown Croissant pair with Cappuccino', 'Cube Croissant', 'Laminated pastry dough forced to proof and bake inside a perfectly square metallic cube mold, creating a hollow bread box for heavy cream fillings.', '1779182569_crossient2.jpg', 400, 1, '2026-05-19 09:22:49'),
(68, 13, 'Golden-brown Croissant pair with Cappuccino', 'Flat Croissant', 'A normal baked crescent croissant that is flattened completely under a heavy press and caramelised with sugar for an ultra-crunchy texture.', '1779182625_crossient3.jpg', 380, 1, '2026-05-19 09:23:45'),
(69, 13, 'Golden-brown Croissant pair with Cappuccino', 'Suprême', 'Heavy pastry creams', '1779182666_crossient4.jpg', 300, 1, '2026-05-19 09:24:26'),
(70, 13, 'Golden-brown Croissant pair with Cappuccino', 'Laminated Brioche Bun', ' A premium burger bun hybrid blending the soft egg-and-butter crumb of brioche with the distinct visible outer peeling layers of a croissant.', '1779182738_crossient5.jpg', 400, 1, '2026-05-19 09:25:38'),
(71, 14, 'Cool Bean Specials', 'Brewed Coffee', 'Lattes Lattes is so rich, brewed. Coffee and sweet, fusion and so coffee flavors with the fun.', '1779200241_gl1.webp', 400, 1, '2026-05-19 14:17:21'),
(72, 14, 'Cool Bean Specials', 'Lattes', 'Lattes coffee is a fusion and so rich, brewed. Coffee and sweet, chewy pearls unique texture  with the fun.', '1779200346_IMG-20250823-WA0061.jpg', 200, 1, '2026-05-19 14:19:06'),
(73, 14, 'Cool Bean Specials', 'Bubble Coffee', 'Bubble coffee is a fusion and so rich, brewed. Coffee and sweet.', '1779200965_IMG-20250823-WA0058.jpg', 300, 1, '2026-05-19 14:29:25'),
(74, 14, 'Cool Bean Specials', 'Cappuccino', 'Cappuccino coffee is a fusion and so rich, brewed. Coffee and sweet.', '1779201179_IMG-20250823-WA0051.jpg', 400, 1, '2026-05-19 14:32:59'),
(75, 14, 'Cool Bean Specials', 'Mocha', 'Mocha coffee is a fusion and so rich, brewed. Coffee and sweet.', '1779201271_gl6.jpg', 200, 1, '2026-05-19 14:34:31'),
(76, 18, 'Tea & Herbal', 'Butterfly Pea Flower', 'A vibrant, color-changing blue tea packed with antioxidants.', '1779201419_herbal1.jpg', 199, 1, '2026-05-19 14:36:59'),
(77, 18, 'Tea & Herbal', 'Echinacea Tea ', 'A slightly floral, tongue-tingling herb. It is  stimulate the immune system and drastically shorten the duration of the common cold.', '1779201537_herbal2.avif', 301, 1, '2026-05-19 14:38:57'),
(78, 18, 'Tea & Herbal', 'Jasmine Herbal Tea', 'While often mixed with green tea, pure jasmine tisanes use steeped night-blooming jasmine flowers. ', '1779201602_herbal4.jpg', 200, 1, '2026-05-19 14:40:02'),
(79, 18, 'Tea & Herbal', 'Lavender Tea An ', 'intensely aromatic, soothing brew made from dried purple buds. It is widely used to lower anxiety and improve sleep quality.', '1779201652_herbal5.jpg', 270, 1, '2026-05-19 14:40:52'),
(80, 20, 'Special Combo offer', 'The Cafe Pizzeria Combo', 'Standard industry pairing name.', '1779201793_combo2.jpg', 599, 1, '2026-05-19 14:43:13'),
(81, 20, 'Special Combo offer', 'Sesame Bun', 'Traditional white bread bun topped with crunchy sesame seeds.', '1779201884_combo1.webp', 550, 1, '2026-05-19 14:44:44'),
(82, 20, 'Special Combo offer', 'Hash Browns', ' Crispy, fried shredded potato patties offered as a quick  side.', '1779202279_combo5.jpg', 380, 1, '2026-05-19 14:51:19'),
(83, 20, 'Special Combo offer', 'Samosa  ', 'A triangular fried pastry shell stuffed with a savory, spiced potato-and-pea filling.', '1779202356_combo4.jpg', 280, 1, '2026-05-19 14:52:36'),
(84, 20, 'Special Combo offer', 'The Ultimate Trio', 'The Ultimate Trio: A classic, straightforward name for a complete three-piece meal deal.', '1779202446_combo3.jpeg', 599, 1, '2026-05-19 14:54:06'),
(85, 21, 'Pastry', 'Eclair', 'An oblong choux pastry shell filled with rich custard or cream and topped with chocolate icing.', '1779202554_pastry1.jpg', 99, 1, '2026-05-19 14:55:54'),
(86, 21, 'Pastry', 'Pain au Chocolate (Chocolate Croissant)', 'A classic French yeast-leavened puff pastry rolled with distinct bars of dark chocolate in the center.', '1779202648_pastry2.jpg', 299, 1, '2026-05-19 14:57:28'),
(87, 21, 'Pastry', 'Raspberry Danish', 'Flaky layered pastry featuring a bright pink raspberry fruit center and white icing drizzle.', '1779202804_IMG-20250823-WA0041.jpg', 250, 1, '2026-05-19 15:00:04'),
(88, 21, 'Pastry', 'Pineapple Tarte Tatin', 'An upscale French pastry featuring caramelized pineapples baked upside-down over a buttery puff pastry crust.', '1779202860_IMG-20250823-WA0040.jpg', 280, 1, '2026-05-19 15:01:00'),
(89, 21, 'Pastry', 'Double Chocolate Muffin', ' A moist, cake-like chocolate muffin packed with extra chocolate chips.', '1779202916_IMG-20250823-WA0042.jpg', 299, 1, '2026-05-19 15:01:56'),
(90, 14, 'Cool Bean Specials', 'Lavender Honey Latte', 'Espresso and steamed milk sweetened with natural honey and a touch of aromatic lavender syrup.', '1779203025_session1.webp', 299, 1, '2026-05-19 15:03:45'),
(91, 14, 'Cool Bean Specials', 'Rose Gold Cappuccino', 'A classic cappuccino infused with a subtle hint of rosewater and topped with edible gold dust.', '1779203071_session2.jpg', 348, 1, '2026-05-19 15:04:31'),
(92, 14, 'Cool Bean Specials', 'Peppermint Mocha', 'A rich chocolate cafe mocha infused with refreshing peppermint syrup, topped with crushed candy canes.', '1779203134_session3.webp', 280, 1, '2026-05-19 15:05:34'),
(93, 14, 'Cool Bean Specials', 'Chestnut Hot Chocolate Espresso', 'A decadent fusion of thick chocolate ganache, a shot of bold espresso, and smoky roasted chestnut syrup.', '1779203228_session4.png', 499, 1, '2026-05-19 15:07:08'),
(94, 14, 'Cool Bean Specials', 'Roasted Hazelnut Mocha', 'A rich dark chocolate mocha toasted topped crushed hazelnut bits.', '1779203274_session5.avif', 399, 1, '2026-05-19 15:07:54'),
(95, 21, 'Pastry', 'Chocolate crunch', '	\r\nAn oblong choux pastry shell filled with rich cust...', '1779508286_images.jpeg', 251, 1, '2026-05-23 03:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender` enum('User','Admin') NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `support_type` varchar(100) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `priority` varchar(50) NOT NULL DEFAULT 'Normal',
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `notification` tinyint(1) DEFAULT 1,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_messages`
--

INSERT INTO `support_messages` (`id`, `user_id`, `sender`, `name`, `email`, `phone`, `support_type`, `order_id`, `priority`, `message`, `attachment`, `notification`, `status`, `created_at`) VALUES
(1, 4, 'User', NULL, NULL, NULL, NULL, NULL, 'Normal', 'hello im happy to get that product', NULL, 0, 'Pending', '2026-07-28 03:36:24'),
(2, 4, 'Admin', NULL, NULL, NULL, NULL, NULL, 'Normal', 'thanks', NULL, 0, 'Pending', '2026-07-28 04:09:58'),
(3, 4, 'User', NULL, NULL, NULL, NULL, NULL, 'Normal', 'ok', NULL, 0, 'Pending', '2026-07-28 04:16:47'),
(4, 4, 'User', NULL, NULL, NULL, NULL, NULL, 'Normal', 'hm', NULL, 0, 'Pending', '2026-07-28 14:58:21'),
(5, 1, 'User', NULL, NULL, NULL, NULL, NULL, 'Normal', 'hello', NULL, 0, 'Pending', '2026-08-01 09:57:05'),
(6, 1, 'User', NULL, NULL, NULL, NULL, NULL, 'Normal', 'hiii', NULL, 0, 'Pending', '2026-08-01 09:57:36'),
(7, 1, 'User', NULL, NULL, NULL, NULL, NULL, 'Normal', 'listen', NULL, 0, 'Pending', '2026-08-01 10:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `userorder`
--

CREATE TABLE `userorder` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `order_number` varchar(50) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `customer_number` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL,
  `payment_method` enum('Cash On Delivery','UPI','Card','Net Banking') DEFAULT 'Cash On Delivery',
  `payment_status` enum('Pending','Paid','Failed') DEFAULT 'Pending',
  `order_status` enum('Pending','Confirmed','Processing','Shipped','Out for Delivery','Delivered','Cancelled') DEFAULT 'Pending',
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pin` varchar(20) NOT NULL,
  `delivery_charge` decimal(10,2) DEFAULT 0.00,
  `tracking_number` varchar(100) DEFAULT NULL,
  `estimated_delivery` date DEFAULT NULL,
  `coupon_code` varchar(100) DEFAULT NULL,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `grand_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cancel_reason` varchar(255) DEFAULT NULL,
  `cancel_note` text DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `current_lat` decimal(10,8) DEFAULT NULL,
  `current_lng` decimal(11,8) DEFAULT NULL,
  `delivery_status` enum('Preparing','On the way','Near you','Delivered') DEFAULT 'Preparing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userorder`
--

INSERT INTO `userorder` (`id`, `customer_id`, `customer_name`, `product_id`, `product_name`, `product_image`, `quantity`, `order_number`, `item_price`, `total_amount`, `customer_number`, `shipping_address`, `payment_method`, `payment_status`, `order_status`, `city`, `state`, `pin`, `delivery_charge`, `tracking_number`, `estimated_delivery`, `coupon_code`, `discount_amount`, `grand_total`, `created_at`, `cancel_reason`, `cancel_note`, `cancelled_at`, `is_deleted`, `current_lat`, `current_lng`, `delivery_status`) VALUES
(2, 1, 'Tanushree Dey', 52, 'Sesame Bun\n        ', '1779201884_combo1.webp\n        ', 3, '', 550.00, 1650.00, '', 'Ramnagar', 'Cash On Delivery', 'Pending', 'Cancelled', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 1650.00, '2026-05-29 17:10:46', 'Ordered by mistake', '', '2026-06-04 11:55:09', 1, NULL, NULL, 'Preparing'),
(3, 1, 'Tanushree Dey', 42, 'Brewed Coffee\n        ', '1779200241_gl1.webp\n        ', 1, '', 400.00, 400.00, '3454656565', 'Ramnagar', 'Cash On Delivery', 'Pending', 'Pending', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 400.00, '2026-05-29 17:25:14', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(10, 1, '', 13, 'Salisbury Steak', '1779173852_snacks1.jpg', 1, '', 350.00, 350.00, '', '', '', 'Pending', 'Pending', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 08:02:43', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(11, 1, '', 13, 'Salisbury Steak', '1779173852_snacks1.jpg', 1, '', 350.00, 350.00, '', '', '', 'Pending', 'Pending', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 08:02:53', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(12, 1, '', 24, 'White Hot Chocolate', '1779181179_hot3.jpg', 1, '', 300.00, 300.00, '', '', '', 'Pending', 'Pending', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 09:50:34', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(13, 1, '', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 280.00, 280.00, '', '', '', 'Pending', 'Pending', 'contai', 'west bengal ', '123456', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:07:33', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(14, 1, '', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 280.00, 280.00, '', '', '', 'Pending', 'Pending', 'contai', 'west bengal ', '123456', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:07:44', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(15, 1, '', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 280.00, 280.00, '', '', '', 'Pending', 'Pending', 'contai', 'west bengal ', '123456', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:08:01', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(16, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 280.00, 280.00, '8001737625', '', '', 'Pending', 'Pending', 'contai', 'west bengal ', '123456', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:10:49', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(17, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 280.00, 280.00, '8001737625', '', '', 'Pending', 'Pending', 'contai', 'west bengal ', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:11:25', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(18, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 0.00, 0.00, '8001737625', '', '', 'Pending', 'Pending', 'contai', 'west bengal ', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:12:01', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(19, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 0.00, 0.00, '', '', '', 'Pending', 'Pending', 'contai', 'west bengal ', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:14:58', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(20, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 0.00, 0.00, '', '', '', 'Pending', 'Cancelled', 'contai', 'west bengal ', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:16:58', 'Ordered by mistake', NULL, '2026-06-02 13:04:58', 1, NULL, NULL, 'Preparing'),
(21, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 0.00, 0.00, '', '', '', 'Pending', 'Pending', 'contai', 'west bengal ', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:17:22', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(22, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 0.00, 0.00, '8001737625', 'Ramnagar', '', 'Pending', 'Pending', 'contai', 'west bengal ', '123456', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:30:11', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(23, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 0.00, 0.00, '8001737625', 'Ramnagar', '', 'Pending', 'Pending', 'contai', 'west bengal ', '123456', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:30:18', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(24, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 0.00, 0.00, '8001737625', 'Ramnagar', '', 'Pending', 'Pending', 'contai', 'west bengal ', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:30:51', NULL, NULL, NULL, 1, NULL, NULL, 'Preparing'),
(25, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 0.00, 0.00, '8001737625', 'Ramnagar', '', 'Pending', 'Cancelled', 'contai', 'west bengal ', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:30:58', 'Found cheaper elsewhere', NULL, '2026-06-02 13:05:35', 1, NULL, NULL, 'Preparing'),
(26, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 0.00, 0.00, '8001737625', 'Ramnagar', '', 'Pending', 'Cancelled', 'contai', 'west bengal ', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:31:06', 'Found cheaper elsewhere', NULL, '2026-06-02 13:05:30', 1, NULL, NULL, 'Preparing'),
(27, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 0.00, 0.00, '8001737625', 'Ramnagar', '', 'Pending', 'Cancelled', 'contai', 'west bengal ', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:31:19', 'Changed my mind', NULL, '2026-06-02 13:05:26', 1, NULL, NULL, 'Preparing'),
(28, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 280.00, 280.00, '8001737625', 'Ramnagar', '', 'Pending', 'Cancelled', 'contai', 'west bengal ', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 11:33:18', 'Found cheaper elsewhere', NULL, '2026-06-02 13:05:15', 1, NULL, NULL, 'Preparing'),
(29, 1, 'Tanushree Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, '', 280.00, 280.00, '8001737625', 'Ramnagar', '', 'Pending', 'Cancelled', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 0.00, '2026-06-01 14:54:31', 'Changed my mind', NULL, '2026-06-02 13:05:06', 1, NULL, NULL, 'Preparing'),
(30, 1, 'Tanushree Dey', 4, 'Ssangssangbar', 'download (2).jpeg', 1, 'ORD1780516082891', 350.00, 350.00, '8001737625', 'Ramnagar', 'Cash On Delivery', 'Paid', 'Delivered', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 350.00, '2026-06-03 19:48:02', NULL, NULL, NULL, 0, NULL, NULL, 'Delivered'),
(31, 1, 'Tanushree Dey', 7, 'Espresso', '1779173463_coffee1.webp', 1, 'ORD1780516082891', 150.00, 150.00, '8001737625', 'Ramnagar', '', 'Pending', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 500.00, '2026-06-03 19:48:02', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(32, 1, 'Tanushree Dey', 4, 'Ssangssangbar', 'download (2).jpeg', 1, 'ORD1780516102399', 350.00, 350.00, '8001737625', 'Ramnagar', '', 'Pending', 'Cancelled', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 350.00, '2026-06-03 19:48:22', 'Too expensive', '', '2026-06-04 13:09:10', 1, NULL, NULL, 'Preparing'),
(33, 1, 'Tanushree Dey', 7, 'Espresso', '1779173463_coffee1.webp', 1, 'ORD1780516102399', 150.00, 150.00, '8001737625', 'Ramnagar', '', 'Pending', 'Cancelled', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 500.00, '2026-06-03 19:48:22', 'Too expensive', '', '2026-06-04 13:09:10', 0, NULL, NULL, 'Preparing'),
(34, 1, 'Tanushree Dey', 8, 'Ristretto', '1779173517_coffee2.jpg', 1, 'ORD1780516102399', 280.00, 280.00, '8001737625', 'Ramnagar', '', 'Pending', 'Cancelled', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 780.00, '2026-06-03 19:48:22', 'Too expensive', '', '2026-06-04 13:09:10', 0, NULL, NULL, 'Preparing'),
(35, 1, 'Tanushree Dey', 21, 'Frappuccino', '1779175572_cold5.jpg', 1, 'ORD1780519113652', 160.00, 160.00, '8001737625', 'Ramnagar', '', 'Pending', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 160.00, '2026-06-03 20:38:33', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(36, 4, 'Soham Dey', 19, 'Cold Brew', '1779175482_cold3.jpg', 1, 'ORD1780564810670', 255.00, 255.00, '9242483647', 'Digha', '', 'Pending', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 255.00, '2026-06-04 09:20:10', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(37, 4, 'Soham Dey', 11, 'Latte', '1779173652_coffee5.webp', 1, 'ORD1780565228562', 280.00, 280.00, '9242483647', 'Digha', 'Cash On Delivery', 'Pending', 'Delivered', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 280.00, '2026-06-04 09:27:08', NULL, NULL, NULL, 0, NULL, NULL, 'Delivered'),
(38, 4, 'Soham Dey', 5, 'Mint Tea', 'herbal3.webp', 1, 'ORD1780568826909', 78.00, 78.00, '9242483647', 'Digha', 'Cash On Delivery', 'Paid', 'Delivered', 'Contai', '', '', 0.00, NULL, NULL, NULL, 0.00, 78.00, '2026-06-04 10:27:06', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(39, 1, 'Tanushree Dey', 56, 'Eclair', '1779202554_pastry1.jpg', 1, 'ORD1780646555325', 99.00, 99.00, '8001737625', 'Ramnagar', '', 'Paid', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 99.00, '2026-06-05 08:02:35', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(40, 4, 'Soham Dey', 21, 'Frappuccino', '1779175572_cold5.jpg', 1, 'ORD1780979043497', 160.00, 160.00, '9242483647', 'Digha', 'Cash On Delivery', 'Pending', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 160.00, '2026-06-09 04:24:03', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(41, 1, 'Tanushree Dey', 13, 'Salisbury Steak', '1779173852_snacks1.jpg', 1, 'ORD1781082886604', 350.00, 350.00, '8001737625', 'Ramnagar', 'Cash On Delivery', 'Pending', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 350.00, '2026-06-10 09:14:46', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(42, 1, 'Tanushree Dey', 8, 'Ristretto', '1779173517_coffee2.jpg', 1, 'ORD1781083072782', 280.00, 280.00, '8001737625', 'Ramnagar', 'Cash On Delivery', 'Pending', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 280.00, '2026-06-10 09:17:52', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(43, 1, 'Tanushree Dey', 8, 'Ristretto', '1779173517_coffee2.jpg', 1, 'ORD1781083113711', 280.00, 280.00, '8001737625', 'Ramnagar', 'Cash On Delivery', 'Paid', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 280.00, '2026-06-10 09:18:33', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(44, 4, 'Soham Dey', 41, 'Laminated Brioche Bun', '1779182738_crossient5.jpg', 1, 'ORD1781083871326', 400.00, 400.00, '9242483647', 'Digha', 'Cash On Delivery', 'Pending', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 400.00, '2026-06-10 09:31:11', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(45, 4, 'Soham Dey', 20, 'Nitro Cold Brew', '1779175532_cold4.jpg', 1, 'ORD1781870593739', 160.00, 160.00, '9242483647', 'Digha', 'Cash On Delivery', 'Failed', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 160.00, '2026-06-19 12:03:13', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing'),
(46, 4, 'Soham Dey', 1, 'Cappuccino', 'IMG-20250823-WA0055.jpg', 1, 'ORD1786252760965', 199.00, 199.00, '9242483647', 'Digha', 'Cash On Delivery', 'Pending', 'Processing', '', '', '', 0.00, NULL, NULL, NULL, 0.00, 199.00, '2026-08-09 05:19:20', NULL, NULL, NULL, 0, NULL, NULL, 'Preparing');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('active','moved_to_cart','removed') DEFAULT 'active',
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user_id`, `product_id`, `product_name`, `product_image`, `price`, `status`, `added_at`) VALUES
(1, 4, 17, 'Iced Latte\n        ', '1779175103_cold1.webp\n        ', 199.00, 'active', '2026-05-25 15:35:07'),
(7, 4, 1, 'Cappuccino\n        ', 'IMG-20250823-WA0055.jpg\n        ', 199.00, 'active', '2026-05-25 18:46:38'),
(8, 4, 34, 'Ratnagiri Mango\n        ', '1779182192_ice3.jpg\n        ', 300.00, 'active', '2026-05-25 18:49:16'),
(12, 4, 13, 'Salisbury Steak\n', '1779173852_snacks1.jpg\n', 350.00, 'active', '2026-05-25 20:44:06'),
(18, 4, 20, 'Nitro Cold Brew\n', '1779175532_cold4.jpg\n', 160.00, 'active', '2026-05-27 11:50:41'),
(20, 4, 11, 'Latte\n        ', '1779173652_coffee5.webp\n        ', 280.00, 'active', '2026-05-29 05:19:30'),
(21, 4, 27, 'Chocolate Lava Cake\n        ', '1779181628_dessert1.jpg\n        ', 299.00, 'active', '2026-05-29 05:22:14'),
(22, 4, 28, 'Rasmalai\n        ', '1779181707_dessert2.jpg\n        ', 180.00, 'active', '2026-05-29 05:25:57'),
(28, 4, 42, 'Brewed Coffee\n        ', '1779200241_gl1.webp\n        ', 400.00, 'active', '2026-05-29 06:04:23'),
(36, 4, 22, 'Hot Spanish Latte\n        ', '1779180555_hot1.jpg\n        ', 99.00, 'active', '2026-05-29 06:20:57'),
(37, 4, 25, 'Edible Biscuit Cup\n        ', '1779181403_hot4.png\n        ', 399.00, 'active', '2026-05-29 06:21:40'),
(39, 4, 26, 'Flat White\n        ', '1779181535_IMG-20250823-WA0050.jpg\n        ', 180.00, 'active', '2026-05-29 08:42:27'),
(46, 4, 58, 'Raspberry Danish\n        ', '1779202804_IMG-20250823-WA0041.jpg\n        ', 250.00, 'active', '2026-05-29 12:51:26'),
(64, 4, 10, 'Cortado\n        ', '1779173615_coffee4.jpg\n        ', 399.00, 'active', '2026-05-29 18:14:17'),
(65, 1, 8, 'Ristretto\n        ', '1779173517_coffee2.jpg\n        ', 280.00, 'active', '2026-05-30 03:01:59'),
(67, 1, 1, 'Cappuccino\n        ', 'IMG-20250823-WA0055.jpg\n        ', 199.00, 'active', '2026-05-30 03:02:02'),
(68, 1, 7, 'Espresso\n        ', '1779173463_coffee1.webp\n        ', 150.00, 'active', '2026-05-30 03:02:03'),
(69, 4, 51, 'The Cafe Pizzeria Combo\n        ', '1779201793_combo2.jpg\n        ', 599.00, 'active', '2026-05-30 07:00:56'),
(73, 4, 56, 'Eclair\n        ', '1779202554_pastry1.jpg\n        ', 99.00, 'active', '2026-05-31 06:52:25'),
(75, 4, 15, 'Grilled Club Sandwich\n        ', 'IMG-20250823-WA0037.jpg\n        ', 400.00, 'active', '2026-05-31 08:32:47'),
(76, 1, 13, 'Salisbury Steak\n        ', '1779173852_snacks1.jpg\n        ', 350.00, 'active', '2026-05-31 16:23:35'),
(77, 1, 9, 'Macchiato\n        ', '1779173564_coffee3.jpg\n        ', 170.00, 'active', '2026-06-01 08:05:30'),
(78, 1, 11, 'Latte\n        ', '1779173652_coffee5.webp\n        ', 280.00, 'active', '2026-06-01 09:14:59'),
(79, 1, 18, 'Iced Americano\n        ', '1779175422_cold2.jpg\n        ', 280.00, 'active', '2026-06-01 09:15:09'),
(80, 1, 4, 'Ssangssangbar\n        ', 'download (2).jpeg\n        ', 350.00, 'active', '2026-06-03 19:21:45'),
(81, 1, 21, 'Frappuccino\n        ', '1779175572_cold5.jpg\n        ', 160.00, 'active', '2026-06-03 19:31:19'),
(82, 4, 8, 'Ristretto\n        ', '1779173517_coffee2.jpg\n        ', 280.00, 'active', '2026-06-04 11:24:54'),
(84, 4, 57, 'Pain au Chocolate (Chocolate Croissant)\n        ', '1779202648_pastry2.jpg\n        ', 299.00, 'active', '2026-06-10 05:48:28'),
(85, 4, 59, 'Pineapple Tarte Tatin\n        ', '1779202860_IMG-20250823-WA0040.jpg\n        ', 280.00, 'active', '2026-06-10 05:48:33'),
(86, 4, 14, 'Croissant Sandwich\n        ', '1779173996_IMG-20250823-WA0038.jpg\n        ', 500.00, 'active', '2026-06-10 05:48:42'),
(87, 4, 12, 'French Fries\n        ', '1779173782_snacks2.jpg\n        ', 200.00, 'active', '2026-06-10 05:49:16'),
(92, 4, 38, 'Cube Croissant\n        ', '1779182569_crossient2.jpg\n        ', 400.00, 'active', '2026-06-10 06:20:27'),
(93, 4, 37, 'Croissant Burger Bun\n        ', '1779182498_crossient1.jpg\n        ', 400.00, 'active', '2026-06-10 06:35:59'),
(94, 4, 40, 'Suprême\n        ', '1779182666_crossient4.jpg\n        ', 300.00, 'active', '2026-06-10 06:42:37'),
(95, 4, 39, 'Flat Croissant\n        ', '1779182625_crossient3.jpg\n        ', 380.00, 'active', '2026-06-10 06:56:11'),
(96, 4, 3, 'Iced Latte\n        ', 'IMG-20250823-WA0023.jpg\n        ', 170.00, 'active', '2026-06-10 07:00:14'),
(99, 4, 7, 'Espresso\n        ', '1779173463_coffee1.webp\n        ', 150.00, 'active', '2026-07-11 12:53:31'),
(100, 4, 18, 'Iced Americano\n        ', '1779175422_cold2.jpg\n        ', 280.00, 'active', '2026-07-11 12:53:47'),
(101, 4, 9, 'Macchiato\n        ', '1779173564_coffee3.jpg\n        ', 170.00, 'active', '2026-07-22 14:51:29'),
(103, 7, 48, 'Echinacea Tea \n        ', '1779201537_herbal2.avif\n        ', 301.00, 'active', '2026-07-23 14:52:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addtocart`
--
ALTER TABLE `addtocart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cafe_timetable`
--
ALTER TABLE `cafe_timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_number` (`order_number`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `userorder`
--
ALTER TABLE `userorder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addtocart`
--
ALTER TABLE `addtocart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cafe_timetable`
--
ALTER TABLE `cafe_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `userorder`
--
ALTER TABLE `userorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addtocart`
--
ALTER TABLE `addtocart`
  ADD CONSTRAINT `addtocart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `addtocart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `fk_review_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD CONSTRAINT `support_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `userorder`
--
ALTER TABLE `userorder`
  ADD CONSTRAINT `userorder_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `userorder_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
