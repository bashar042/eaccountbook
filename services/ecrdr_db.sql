-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2015 at 03:36 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ecrdr_db`
--
CREATE DATABASE IF NOT EXISTS `ecrdr_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ecrdr_db`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account_heads`
--

CREATE TABLE IF NOT EXISTS `tbl_account_heads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `head_type` varchar(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `head_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tbl_account_heads`
--

INSERT INTO `tbl_account_heads` (`id`, `user_id`, `head_type`, `name`, `head_status`) VALUES
(1, 5, 'Dr', 'Family & Bazar', 1),
(2, 5, 'Dr', 'House Rent & other charges', 1),
(3, 5, 'Dr', 'Internet Bill', 1),
(4, 5, 'Dr', 'Dish Bill', 1),
(5, 5, 'Dr', 'Garbase Cleaner Bill', 1),
(6, 5, 'Dr', 'Vehicle Fares', 1),
(7, 5, 'Dr', 'Cost on Parents', 1),
(8, 5, 'Dr', 'Cost on Jakir', 1),
(9, 5, 'Cr', 'Monthly Salary', 1),
(10, 5, 'Cr', 'Outsourcing ', 1),
(11, 5, 'Dr', 'Shopping & Clothing', 1),
(12, 5, 'Cr', 'Get Gift', 1),
(13, 5, 'Cr', 'Borrow', 1),
(14, 5, 'Dr', 'Nasta', 1),
(15, 5, 'Dr', 'Techinical Cost', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donations`
--

CREATE TABLE IF NOT EXISTS `tbl_donations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `send_amount` double(10,2) NOT NULL,
  `sender_no` varchar(12) NOT NULL,
  `tran_id` varchar(15) NOT NULL,
  `email_confirm` tinyint(4) NOT NULL COMMENT '1=yes, 0=no',
  `donation_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=success, 0=pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_donations`
--

INSERT INTO `tbl_donations` (`id`, `user_id`, `send_amount`, `sender_no`, `tran_id`, `email_confirm`, `donation_status`) VALUES
(1, 5, 50.00, '01718792556', '1235468', 0, 0),
(2, 5, 10.00, '01718792556', '123456', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_side_map`
--

CREATE TABLE IF NOT EXISTS `tbl_side_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_title` varchar(50) NOT NULL,
  `module_value` varchar(50) NOT NULL,
  `page_title` varchar(50) NOT NULL,
  `page_value` varchar(50) NOT NULL,
  `path` text NOT NULL,
  `page_status` int(11) NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_side_map`
--

INSERT INTO `tbl_side_map` (`id`, `module_title`, `module_value`, `page_title`, `page_value`, `path`, `page_status`) VALUES
(1, 'System User', 'system_user', 'Profile View', 'profile_view', 'module/system_user/user_profile_view.php', 1),
(2, 'Accounts', 'accounts', 'Add New Heads', 'heads', 'module/accounts/add_new_heads.php', 1),
(3, 'Accounts', 'accounts', 'Create New Voucher', 'voucher', 'module/accounts/add_new_voucher.php', 1),
(4, 'Dashboard', 'dashboard', 'Quick Information', 'system_info', 'module/dashboard/system_information.php', 1),
(5, 'Donation', 'system_user', 'Donate to System', 'donate', 'module/system_user/donation.php', 1),
(6, 'Accounts', 'accounts', 'Dr(Debit) History', 'dr_history', 'module/accounts/dr_history.php', 1),
(7, 'Accounts', 'accounts', 'Cr(Credit) History', 'cr_history', 'module/accounts/cr_history.php', 1),
(8, 'Accounts', 'accounts', 'Voucher Summary', 'voucher_summary', 'module/accounts/voucher_summary.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` tinyint(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `secure_entry` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_mob` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_image` tinytext NOT NULL,
  `com_name` varchar(100) NOT NULL,
  `com_address` text NOT NULL,
  `com_phone` varchar(25) NOT NULL,
  `create_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `user_type`, `user_id`, `password`, `secure_entry`, `name`, `phone_mob`, `email`, `user_image`, `com_name`, `com_address`, `com_phone`, `create_at`, `status`) VALUES
(1, 1, 'admin', 'admin', '', 'Admin#1', '025423652', '', '', '', '', '', '2015-07-21 00:00:00', 1),
(2, 2, '3', '4', '', '1', '5', 'admin@gmail.com', '', '', '', '', '2015-07-21 17:27:15', 1),
(3, 2, '3', '4', '', '1', '5', 'admin@gmail.com', '', '', '', '', '2015-07-21 17:29:52', 1),
(4, 1, 'admin@gmail.com', 'admin', '', 'sdasdas', '0977', 'admin@gmail.com', '', '', '', '', '2015-07-21 17:38:00', 1),
(5, 1, 'admin', '202cb962ac59075b964b07152d234b70', '', 'Bashar', '', '', '', '', '', '', '2015-07-21 18:13:27', 1),
(6, 1, 'bashar042', '202cb962ac59075b964b07152d234b70', '123', 'Bashar', '01718792556', '', '', '', '', '', '2015-08-18 21:00:24', 1),
(7, 1, 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '123456', 'Alamin', '01718792556', 'admin@gmail.com', '', '', '', '', '2015-08-18 21:05:25', 1),
(8, 1, 'admin', '202cb962ac59075b964b07152d234b70', '123', 'Bashar', '01718792556', '', '', '', '', '', '2015-08-20 21:44:18', 1),
(9, 1, 'admin', '202cb962ac59075b964b07152d234b70', '123', 'Bashar', '01718792556', '', '', '', '', '', '2015-08-20 21:44:41', 1),
(10, 1, 'admin.123', 'caf1a3dfb505ffed0d024130f58c5cfa', '321', 'Abul Bashar', '01718792556', 'admin@gmail.com', '', 'Idea It', '744/2@westshewrapara', '01718792556@gp', '2015-08-23 22:00:10', 1),
(11, 0, 'bashar', '202cb962ac59075b964b07152d234b70', '123', '', '', '', '', '', '', '', '2015-09-05 23:23:32', 1),
(12, 0, 'kamal', 'aa63b0d5d950361c05012235ab520512', 'kamal', '', '', '', '', '', '', '', '2015-09-05 23:28:21', 1),
(13, 0, 'shahed', '202cb962ac59075b964b07152d234b70', '123', '', '', '', '', '', '', '', '2015-09-05 23:28:56', 1),
(14, 0, 'abashar', '202cb962ac59075b964b07152d234b70', '123', '', '', '', '', '', '', '', '2015-09-16 22:48:05', 1),
(15, 0, 'aaa', '47bce5c74f589f4867dbd57e9ca9f808', 'aaa', '', '01718792556', '', '', '', '', '', '2015-09-18 19:05:25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voucher_details`
--

CREATE TABLE IF NOT EXISTS `tbl_voucher_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) NOT NULL,
  `head_type` varchar(3) NOT NULL,
  `head_name_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `item_dt` datetime NOT NULL,
  `amount` double(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tbl_voucher_details`
--

INSERT INTO `tbl_voucher_details` (`id`, `voucher_id`, `head_type`, `head_name_id`, `description`, `item_dt`, `amount`, `user_id`) VALUES
(1, 1, 'Cr', 9, '1st step of salary @ Sep-2015', '2015-09-06 19:20:00', 5000.00, 5),
(2, 1, 'Cr', 9, '2nd step of salary @ Sep-2015', '2015-09-10 20:59:00', 20000.00, 5),
(3, 1, 'Dr', 6, 'Rickshaw and Bus fare', '2015-09-10 20:59:00', 55.00, 5),
(4, 1, 'Dr', 1, 'Namaj Cal.(30), Sweet(140), Bread(35), pape(20),Vegitables(10)', '2015-09-10 20:59:00', 235.00, 5),
(5, 1, 'Dr', 11, 'Panjabi''s cloth for me and sami(2080), Ruman''s Hijab cloth(620)', '2015-09-10 20:59:00', 2700.00, 5),
(6, 2, 'Cr', 12, 'Cunnu kara for panjabi', '2015-09-08 21:10:00', 1500.00, 5),
(7, 3, 'Cr', 9, 'Sami''s Milk, Ruman''s dress and others', '2015-09-06 21:50:00', 1600.00, 5),
(8, 4, 'Dr', 1, 'Hen and ploar rice', '2015-09-07 21:55:00', 600.00, 5),
(9, 5, 'Dr', 1, 'Dss family bazar', '2015-09-12 20:00:00', 820.00, 5),
(10, 5, 'Dr', 2, 'House rent', '2015-09-12 20:00:00', 14364.00, 5),
(11, 5, 'Dr', 1, 'Egg + kocu', '2015-09-12 20:00:00', 65.00, 5),
(12, 5, 'Dr', 1, 'Tafseer(50)+Flexi(30)', '2015-09-12 20:00:00', 80.00, 5),
(13, 6, 'Dr', 1, 'Sami''s Milk & others', '2015-09-14 05:25:00', 1000.00, 5),
(14, 6, 'Dr', 1, 'Milk powder, Beena''s salary, others', '2015-09-14 05:25:00', 1200.00, 5),
(15, 7, 'Cr', 9, 'rest of salary', '2015-09-15 18:06:00', 30000.00, 5),
(16, 7, 'Dr', 1, 'bazar', '2015-09-15 18:06:00', 445.00, 5),
(17, 7, 'Dr', 6, 'rickshaw', '2015-09-15 18:06:00', 30.00, 5),
(18, 7, 'Dr', 14, 'singara', '2015-09-15 18:06:00', 20.00, 5),
(19, 8, 'Dr', 15, 'domain+hosting', '2015-09-16 17:03:00', 2000.00, 5),
(20, 8, 'Dr', 1, 'sami''s Hen+butter  bon', '2015-09-16 17:03:00', 430.00, 5),
(21, 8, 'Dr', 6, 'rickshaw+bus', '2015-09-16 17:03:00', 50.00, 5),
(22, 9, 'Dr', 1, 'a', '2015-10-01 04:51:00', 100.00, 5),
(23, 9, 'Dr', 1, 'b', '2015-10-01 04:51:00', 100.00, 5),
(24, 10, 'Dr', 1, 'sami''s milk powder', '2015-10-03 14:54:00', 856.00, 5),
(25, 10, 'Dr', 1, 'Electronics+others', '2015-10-03 14:54:00', 450.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voucher_list`
--

CREATE TABLE IF NOT EXISTS `tbl_voucher_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `voucher_nr` varchar(15) NOT NULL,
  `voucher_dt` datetime NOT NULL,
  `voucher_title` tinytext NOT NULL,
  `total_amout` double(10,2) NOT NULL,
  `voucher_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active, 0=inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbl_voucher_list`
--

INSERT INTO `tbl_voucher_list` (`id`, `user_id`, `voucher_nr`, `voucher_dt`, `voucher_title`, `total_amout`, `voucher_status`) VALUES
(1, 5, '1441911565', '2015-09-10 20:59:00', 'Panjabi from cunni kaka & partial salary:sep-2015', 0.00, 1),
(2, 5, '1441912216', '2015-09-08 20:59:00', 'Cunnu kaka give 1.5k for panjabi', 0.00, 1),
(3, 5, '1441914648', '2015-09-10 21:50:00', 'Get 1st partial salary of Sep-2015', 0.00, 1),
(4, 5, '1441914952', '2015-09-10 21:55:00', 'Hen and ploar rice', 0.00, 1),
(5, 5, '1442080808', '2015-09-12 20:00:00', 'House Rent-Sep 2015 & Dss family bazar', 0.00, 1),
(6, 5, '1442287506', '2015-09-15 05:25:00', 'Cost of Ripon''s Borrowing Money', 0.00, 1),
(7, 5, '1442333202', '2015-09-15 18:06:00', 'salary-sep-2015', 0.00, 1),
(8, 5, '1442415826', '2015-09-16 17:03:00', 'eaccountbook domain', 0.00, 1),
(9, 5, '1443667869', '2015-10-01 04:51:00', 'asdfdaf', 0.00, 1),
(10, 5, '1443876886', '2015-10-03 14:54:00', 'Sami''s milk powder', 0.00, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
