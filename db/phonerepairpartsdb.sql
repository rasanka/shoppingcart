-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2018 at 09:55 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phonerepairpartsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brands`
--

DROP TABLE IF EXISTS `tbl_brands`;
CREATE TABLE `tbl_brands` (
  `brand_id` varchar(100) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `cat_id` varchar(100) NOT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

DROP TABLE IF EXISTS `tbl_cart`;
CREATE TABLE `tbl_cart` (
  `cart_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `total_price` decimal(20,2) NOT NULL,
  `ip_addr` varchar(100) NOT NULL,
  `cart_status` varchar(100) NOT NULL,
  `created_datetime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart_items`
--

DROP TABLE IF EXISTS `tbl_cart_items`;
CREATE TABLE `tbl_cart_items` (
  `cart_id` varchar(100) NOT NULL,
  `prod_id` varchar(100) NOT NULL,
  `qty` int(10) NOT NULL,
  `unit_price` decimal(20,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

DROP TABLE IF EXISTS `tbl_categories`;
CREATE TABLE `tbl_categories` (
  `cat_id` varchar(100) NOT NULL,
  `cat_name` varchar(200) NOT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

DROP TABLE IF EXISTS `tbl_items`;
CREATE TABLE `tbl_items` (
  `item_id` varchar(100) NOT NULL,
  `item_name` varchar(500) NOT NULL,
  `short_desc` text,
  `item_desc` text NOT NULL,
  `item_prod` varchar(100) NOT NULL,
  `item_price` decimal(20,2) NOT NULL,
  `item_stock` int(10) NOT NULL,
  `ref_id` varchar(100) NOT NULL,
  `delivery` double(20,2) DEFAULT '0.00',
  `item_keywords` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `rating` int(10) NOT NULL DEFAULT '5',
  `badge` varchar(10) NOT NULL DEFAULT 'NEW',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_images`
--

DROP TABLE IF EXISTS `tbl_item_images`;
CREATE TABLE `tbl_item_images` (
  `item_id` varchar(100) NOT NULL,
  `seq_id` int(100) NOT NULL,
  `image_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_newsletter_signup`
--

DROP TABLE IF EXISTS `tbl_newsletter_signup`;
CREATE TABLE `tbl_newsletter_signup` (
  `email` varchar(200) NOT NULL,
  `added_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

DROP TABLE IF EXISTS `tbl_orders`;
CREATE TABLE `tbl_orders` (
  `order_id` varchar(100) NOT NULL,
  `cart_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `cart_total` decimal(20,2) NOT NULL,
  `delivery_amount` decimal(20,2) NOT NULL,
  `order_total` decimal(20,2) NOT NULL,
  `billing_name` varchar(200) NOT NULL,
  `billing_company` varchar(200) DEFAULT NULL,
  `billing_email` varchar(200) NOT NULL,
  `billing_contact` varchar(20) NOT NULL,
  `billing_address` varchar(500) NOT NULL,
  `delivery_name` varchar(200) NOT NULL,
  `delivery_company` varchar(200) DEFAULT NULL,
  `delivery_email` varchar(200) NOT NULL,
  `delivery_contact` varchar(20) NOT NULL,
  `delivery_address` varchar(500) NOT NULL,
  `delivery_note` varchar(200) DEFAULT NULL,
  `payment_method` varchar(100) NOT NULL,
  `order_datetime` datetime NOT NULL,
  `order_status` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

DROP TABLE IF EXISTS `tbl_products`;
CREATE TABLE `tbl_products` (
  `prod_id` varchar(100) NOT NULL,
  `prod_name` varchar(500) NOT NULL,
  `prod_cat` varchar(100) NOT NULL,
  `prod_brand` varchar(100) NOT NULL,
  `ref_id` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_images`
--

DROP TABLE IF EXISTS `tbl_product_images`;
CREATE TABLE `tbl_product_images` (
  `prod_id` varchar(100) NOT NULL,
  `seq_id` int(100) NOT NULL,
  `image_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_reviews`
--

DROP TABLE IF EXISTS `tbl_product_reviews`;
CREATE TABLE `tbl_product_reviews` (
  `review_id` varchar(100) NOT NULL,
  `prod_id` varchar(100) NOT NULL,
  `rating` int(100) NOT NULL,
  `review` text NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `review_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `user_id` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `billing_house_no` varchar(50) DEFAULT NULL,
  `billing_street` varchar(100) DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_region` varchar(100) DEFAULT NULL,
  `billing_postal_code` varchar(50) DEFAULT NULL,
  `billing_country` text,
  `registered_date` datetime NOT NULL,
  `user_status` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web_inquiry`
--

DROP TABLE IF EXISTS `tbl_web_inquiry`;
CREATE TABLE `tbl_web_inquiry` (
  `inq_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `company` varchar(200) DEFAULT NULL,
  `subject` varchar(500) NOT NULL,
  `message` text NOT NULL,
  `inq_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wishlist`
--

DROP TABLE IF EXISTS `tbl_wishlist`;
CREATE TABLE `tbl_wishlist` (
  `user_id` varchar(100) NOT NULL,
  `prod_id` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_brands`
--
ALTER TABLE `tbl_brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `tbl_newsletter_signup`
--
ALTER TABLE `tbl_newsletter_signup`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_product_reviews`
--
ALTER TABLE `tbl_product_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_web_inquiry`
--
ALTER TABLE `tbl_web_inquiry`
  ADD PRIMARY KEY (`inq_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
