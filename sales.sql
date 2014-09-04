-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.8-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.1.0.4545
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for sales_management
CREATE DATABASE IF NOT EXISTS `sales_management` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sales_management`;


-- Dumping structure for table sales_management.ad_data
CREATE TABLE IF NOT EXISTS `ad_data` (
  `ad_data_id` int(10) NOT NULL AUTO_INCREMENT,
  `pub_information_id` int(10) NOT NULL,
  `month` int(10) NOT NULL,
  `year` int(10) NOT NULL,
  `session` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `start_date` varchar(50) DEFAULT NULL,
  `end_date` varchar(50) DEFAULT NULL,
  `publish_date` varchar(250) NOT NULL,
  `publish_type` varchar(250) NOT NULL,
  `offered_rate` varchar(50) NOT NULL,
  `ad_data_status` enum('0','1') NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`ad_data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(250) NOT NULL,
  `category_created_on` datetime NOT NULL,
  `category_is_active` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `city_id` int(10) NOT NULL AUTO_INCREMENT,
  `city` varchar(250) NOT NULL,
  `city_created_on` datetime NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.clients
CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(250) NOT NULL,
  `contact_person` varchar(250) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `alternative_contact_no` varchar(50) DEFAULT NULL,
  `alternative_email_id` varchar(50) DEFAULT NULL,
  `address` text,
  `pincode` int(11) DEFAULT NULL,
  `email_id` varchar(250) DEFAULT NULL,
  `client_created_on` datetime NOT NULL,
  `client_status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.code
CREATE TABLE IF NOT EXISTS `code` (
  `code_id` int(10) NOT NULL AUTO_INCREMENT,
  `form_type_id` int(10) NOT NULL,
  `code_type` varchar(250) NOT NULL,
  `code` varchar(250) NOT NULL,
  `rack_rate` int(11) NOT NULL,
  `code_status` enum('0','1') NOT NULL DEFAULT '1',
  `code_created_on` datetime NOT NULL,
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.form_type
CREATE TABLE IF NOT EXISTS `form_type` (
  `form_type_id` int(10) NOT NULL AUTO_INCREMENT,
  `form_type_code` varchar(50) NOT NULL,
  `form_type` varchar(50) NOT NULL,
  `form_type_created_on` datetime NOT NULL,
  PRIMARY KEY (`form_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.login_log
CREATE TABLE IF NOT EXISTS `login_log` (
  `login_log_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `user_ip` varchar(250) NOT NULL,
  `attempt_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL COMMENT '0 - Attempt Failed, Attempt Success',
  PRIMARY KEY (`login_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.modification
CREATE TABLE IF NOT EXISTS `modification` (
  `modification_id` int(10) NOT NULL AUTO_INCREMENT,
  `previous` varchar(250) NOT NULL,
  `modified_into` varchar(250) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`modification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.product
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(10) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(250) NOT NULL,
  `product_status` enum('0','1') NOT NULL DEFAULT '1',
  `product_created_on` datetime NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.pub_information
CREATE TABLE IF NOT EXISTS `pub_information` (
  `pub_information_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_id` int(10) NOT NULL,
  `ro_number` varchar(100) NOT NULL,
  `modified_from` int(10) DEFAULT NULL,
  `name_estalishment` varchar(250) NOT NULL,
  `form_type` varchar(50) NOT NULL,
  `category` varchar(250) NOT NULL,
  `user_city` varchar(250) NOT NULL,
  `sales_person` varchar(250) NOT NULL,
  `approving_authority` varchar(250) NOT NULL,
  `approve_date` date NOT NULL,
  `net_pay` int(11) NOT NULL,
  `spl_instruction` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `pub_status` enum('0','1') NOT NULL DEFAULT '1' COMMENT ' 0 - Cancelled, 1 - Active',
  PRIMARY KEY (`pub_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_type_id` int(10) NOT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `user_first_name` varchar(250) NOT NULL,
  `user_last_name` varchar(250) DEFAULT NULL,
  `user_password` varchar(250) DEFAULT NULL,
  `user_allowed_ips` varchar(250) DEFAULT NULL,
  `alternative_contact_no` varchar(250) DEFAULT NULL,
  `alternative_email_id` varchar(250) DEFAULT NULL,
  `user_last_logged_in_ip` varchar(50) DEFAULT NULL,
  `user_last_logged_in` datetime DEFAULT NULL,
  `user_last_logged_out` datetime DEFAULT NULL,
  `user_last_modified_on` datetime DEFAULT NULL,
  `user_created_on` datetime NOT NULL,
  `user_is_active` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table sales_management.user_type
CREATE TABLE IF NOT EXISTS `user_type` (
  `user_type_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_type` varchar(250) NOT NULL,
  `user_type_created_on` datetime NOT NULL,
  `user_type_is_active` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
