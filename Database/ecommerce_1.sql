-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2025 at 10:36 PM
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
-- Database: `ecommerce_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_image` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_name`, `admin_email`, `admin_image`, `admin_password`) VALUES
(6, 'Admin', 'admin@store.com', 'admin.jpg', '$2y$10$QjCP4LEmv.H3nQGM4G7W5Oy0mZlFxtsQCTfxS20CN90ujxdmCQ54G');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'Canon'),
(2, 'Lenovo'),
(3, 'Nike'),
(4, 'Polo'),
(5, 'Hp'),
(6, 'Apple'),
(7, 'Oppo'),
(9, 'Samsung'),
(10, 'Nokia');

-- --------------------------------------------------------

--
-- Table structure for table `card_details`
--

CREATE TABLE `card_details` (
  `product_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(1, 'Mobiles'),
(2, 'Books'),
(3, 'Food'),
(4, 'Clothes'),
(5, 'HeadPhones'),
(6, 'Electronics'),
(7, 'Accessories'),
(8, '-');

-- --------------------------------------------------------

--
-- Table structure for table `orders_pending`
--

CREATE TABLE `orders_pending` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(255) NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_pending`
--

INSERT INTO `orders_pending` (`order_id`, `user_id`, `invoice_number`, `product_id`, `quantity`, `order_status`) VALUES
(1, 1, 312346784, 1, 3, 'pending'),
(2, 1, 312346784, 2, 1, 'pending'),
(3, 1, 312346784, 4, 1, 'pending'),
(4, 1, 1918753782, 3, 2, 'pending'),
(5, 1, 351837813, 1, 2, 'pending'),
(6, 1, 491404838, 2, 1, 'pending'),
(7, 2, 758602482, 4, 1, 'pending'),
(8, 2, 24655953, 142, 1, 'pending'),
(9, 2, 358204410, 110, 1, 'pending'),
(10, 2, 1414669435, 114, 1, 'pending'),
(11, 2, 1878202633, 127, 1, 'pending'),
(12, 2, 2045312980, 111, 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(120) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_image_one` varchar(255) NOT NULL,
  `product_image_two` varchar(255) NOT NULL,
  `product_image_three` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keywords`, `category_id`, `brand_id`, `product_image_one`, `product_image_two`, `product_image_three`, `product_price`, `date`, `status`) VALUES
(107, 'Adidas', 'Adidas branded product', 'adidas, brand, clothing', 4, 8, 'adidas.jpeg', '', '', 100, '2025-11-15 21:39:34', 'active'),
(108, 'Adidas Joggers', 'Comfortable Adidas joggers', 'adidas, joggers', 4, 8, 'adidasjoggers.jpeg', '', '', 120, '2025-11-15 21:39:34', 'active'),
(109, 'Adidas Joggers Men', 'Stylish Adidas joggers for men', 'adidas, joggers, men', 4, 8, 'adidasjoggersmen.jpeg', '', '', 130, '2025-11-15 21:39:34', 'active'),
(110, 'Adidas Samba', 'Classic Adidas Samba shoes', 'adidas, samba, shoes', 4, 8, 'adidassamba.jpeg', '', '', 140, '2025-11-15 21:39:34', 'active'),
(111, 'Apple iPhone 17 Pro Max', 'Latest Apple iPhone 17 Pro Max 5G 256GB', 'apple, iphone, mobile', 1, 6, 'Apple-iPhone-17-Pro-Max-5G-256GB-Silver-1.avif', '', '', 1200, '2025-11-15 21:39:34', 'active'),
(112, 'Book', 'Interesting book to read', 'book, reading, literature', 2, 1, 'book.jpeg', '', '', 25, '2025-11-15 21:39:34', 'active'),
(113, 'The book of lost Name', 'Another interesting book', 'book, reading', 2, 1, 'book1.jpeg', '', '', 20, '2025-11-15 21:39:34', 'active'),
(114, 'Canon Camera', 'High quality Canon camera', 'canon, camera, photography', 6, 1, 'Canoncamera.jpeg', '', '', 500, '2025-11-15 21:39:34', 'active'),
(115, 'Donut', 'Delicious donut', 'donut, food, dessert', 3, 1, 'donut.jpeg', '', '', 5, '2025-11-15 21:39:34', 'active'),
(116, 'Fast Food', 'Tasty fast food meal', 'fastfood, food, meal', 3, 1, 'fastfood.jpeg', '', '', 8, '2025-11-15 21:39:34', 'active'),
(117, 'Healthy Food', 'Nutritious healthy food', 'healthy, food, nutrition', 3, 1, 'healthyfood.jpg', '', '', 10, '2025-11-15 21:39:34', 'active'),
(118, 'HP Laptop', 'Powerful HP laptop', 'hp, laptop, electronics', 6, 5, 'Hplaptop.jpeg', '', '', 800, '2025-11-15 21:39:34', 'active'),
(119, 'iPhone 17 Pro', 'Apple iPhone 17 Pro', 'iphone, apple, mobile', 1, 6, 'iphone17pro.jpeg', '', '', 1000, '2025-11-15 21:39:34', 'active'),
(120, 'iPhone 17 Pro Max', 'Latest iPhone 17 Pro Max', 'iphone, apple, mobile', 1, 6, 'iphone17promax.jpeg', '', '', 1100, '2025-11-15 21:39:34', 'active'),
(121, 'Jeans', 'Casual jeans for everyday wear', 'jeans, clothing, denim', 4, 1, 'jeans.jpg', '', '', 50, '2025-11-15 21:39:34', 'active'),
(122, 'Kids Clothes', 'Clothes for kids', 'kids, clothing, children', 4, 8, 'kidsclothes.jpeg', '', '', 40, '2025-11-15 21:39:34', 'active'),
(123, 'Lenovo Laptop', 'Reliable Lenovo laptop', 'lenovo, laptop, electronics', 6, 2, 'lenovolaptop.jpeg', '', '', 750, '2025-11-15 21:39:34', 'active'),
(124, 'Long Coat Women', 'Elegant long coat for women', 'coat, women, clothing', 4, 1, 'Longcoatwomen.jpg', '', '', 150, '2025-11-15 21:39:34', 'active'),
(125, 'Mens Jeans', 'Stylish men jeans', 'jeans, men, clothing', 4, 1, 'Mensjeans.jpeg', '', '', 55, '2025-11-15 21:39:34', 'active'),
(126, 'Nike Airforce', 'Nike Airforce sneakers', 'nike, shoes, sneakers', 4, 3, 'Nikeairforce.jpeg', '', '', 130, '2025-11-15 21:39:34', 'active'),
(127, 'Nike Airforce1', 'Nike Airforce1 sneakers', 'nike, shoes, sneakers', 4, 3, 'Nikeairforce1.jpeg', '', '', 140, '2025-11-15 21:39:34', 'active'),
(128, 'Nike Air Max', 'Nike Air Max sneakers', 'nike, shoes, sneakers', 4, 3, 'Nikeairmax.jpeg', '', '', 120, '2025-11-15 21:39:34', 'active'),
(129, 'Nike Running', 'Nike running shoes', 'nike, running, shoes', 4, 3, 'Nikerunning.jpg', '', '', 110, '2025-11-15 21:39:34', 'active'),
(130, 'Nokia Phone', 'Reliable Nokia phone', 'nokia, mobile, phone', 1, 10, 'Nokiaphone.jpeg', '', '', 80, '2025-11-15 21:39:34', 'active'),
(131, 'Oppo Phone', 'Latest Oppo smartphone', 'oppo, mobile, phone', 1, 7, 'Oppophone.png', '', '', 300, '2025-11-15 21:39:34', 'active'),
(132, 'Orange Juice', 'Fresh orange juice', 'orange, juice, drink', 3, 1, 'orangejuice.jpeg', '', '', 6, '2025-11-15 21:39:34', 'active'),
(133, 'Polo', 'Stylish Polo product', 'polo, clothing', 4, 4, 'polo.jpeg', '', '', 45, '2025-11-15 21:39:34', 'active'),
(134, 'Samsung Galaxy A55', 'Samsung Galaxy A55 smartphone', 'samsung, mobile, phone', 1, 9, 'samsunggalaxya55.jpeg', '', '', 350, '2025-11-15 21:39:34', 'active'),
(135, 'Samsung Galaxy A56', 'Samsung Galaxy A56 smartphone', 'samsung, mobile, phone', 1, 9, 'samsunggalaxya56.jpeg', '', '', 370, '2025-11-15 21:39:34', 'active'),
(136, 'Samsung Galaxy S24 Ultra', 'Samsung Galaxy S24 Ultra smartphone', 'samsung, mobile, phone', 1, 9, 'samsunggalaxys24ultra.jpeg', '', '', 1200, '2025-11-15 21:39:34', 'active'),
(137, 'Samsung Galaxy S25 Ultra', 'Samsung Galaxy S25 Ultra smartphone', 'samsung, mobile, phone', 1, 9, 'samsunggalaxys25ultra.jpeg', '', '', 1300, '2025-11-15 21:39:34', 'active'),
(138, 'Smart Watch', 'Smart watch with multiple features', 'smartwatch, wearable, fitness', 6, 1, 'smartwatch.jpeg', '', '', 150, '2025-11-15 21:39:34', 'active'),
(139, 'White Dress', 'Elegant white dress for women', 'dress, women, clothing', 4, 8, 'whitedress.jpeg', '', '', 120, '2025-11-15 21:39:34', 'active'),
(140, 'Women Jeans', 'Stylish women jeans', 'jeans, women, clothing', 4, 8, 'womenjeans.jpeg', '', '', 60, '2025-11-15 21:39:34', 'active'),
(141, 'Xiaomi 15 Ultra', 'Xiaomi 15 Ultra smartphone', 'xiaomi, mobile, phone', 1, 7, 'xiaomi15ultra.jpeg', '', '', 700, '2025-11-15 21:39:34', 'active'),
(142, 'Polo Black Tshirt', 'Stylish Polo product', 'Polo, clothing', 4, 4, 'poloblack.jpeg', 'womenjeans.jpeg', 'Mensjeans.jpeg', 45, '2025-11-15 22:39:50', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount_due` int(255) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `total_products` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`order_id`, `user_id`, `amount_due`, `invoice_number`, `total_products`, `order_date`, `order_status`) VALUES
(6, 2, 45, 24655953, 1, '2025-11-15 22:46:17', 'paid'),
(7, 2, 140, 358204410, 1, '2025-11-15 22:44:05', 'pending'),
(8, 2, 500, 1414669435, 1, '2025-11-15 22:47:48', 'pending'),
(9, 2, 140, 1878202633, 1, '2025-11-16 00:54:27', 'pending'),
(10, 2, 1200, 2045312980, 1, '2025-11-16 01:15:53', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `user_payments`
--

CREATE TABLE `user_payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_payments`
--

INSERT INTO `user_payments` (`payment_id`, `order_id`, `invoice_number`, `amount`, `payment_method`, `payment_date`) VALUES
(4, 10, 2045312980, 1200, 'cash_on_delivery', '2025-11-16 01:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_ip` varchar(100) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_mobile` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `username`, `user_email`, `user_password`, `user_image`, `user_ip`, `user_address`, `user_mobile`) VALUES
(2, 'eddy', 'karanveersharma345@gmail.com', '$2y$10$epsJaAQcwidE5cC/xofBOOAoQi1fT3CUFN5Maku.397Y7gLRxzw4a', 'GQWC3119.JPG', '::1', 'Graudu iela 68, Zemgales priekšpilsēta', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `card_details`
--
ALTER TABLE `card_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders_pending`
--
ALTER TABLE `orders_pending`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
