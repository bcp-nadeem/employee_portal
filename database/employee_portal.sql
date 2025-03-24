-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2025 at 01:38 PM
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
-- Database: `employee_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `my_key` varchar(50) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(4) NOT NULL,
  `is_private_key` tinyint(4) NOT NULL,
  `ip_addresses` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `user_id`, `my_key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 0, 'bimcap123', 0, 0, 0, NULL, '2025-03-03 06:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `country_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `country_code`) VALUES
(1, 'Afghanistan', 0),
(2, 'Albania', 0),
(3, 'Algeria', 0),
(4, 'American Samoa', 0),
(5, 'Andorra', 0),
(6, 'Angola', 0),
(7, 'Anguilla', 0),
(8, 'Antarctica', 0),
(9, 'Antigua and Barbuda', 0),
(10, 'Argentina', 0),
(11, 'Armenia', 0),
(12, 'Aruba', 0),
(13, 'Australia', 0),
(14, 'Austria', 0),
(15, 'Azerbaijan', 0),
(16, 'Bahamas', 0),
(17, 'Bahrain', 0),
(18, 'Bangladesh', 0),
(19, 'Barbados', 0),
(20, 'Belarus', 0),
(21, 'Belgium', 0),
(22, 'Belize', 0),
(23, 'Benin', 0),
(24, 'Bermuda', 0),
(25, 'Bhutan', 0),
(26, 'Bolivia', 0),
(27, 'Bosnia and Herzegovina', 0),
(28, 'Botswana', 0),
(29, 'Bouvet Island', 0),
(30, 'Brazil', 0),
(31, 'British Indian Ocean Territory', 0),
(32, 'Brunei Darussalam', 0),
(33, 'Bulgaria', 0),
(34, 'Burkina Faso', 0),
(35, 'Burundi', 0),
(36, 'Cambodia', 0),
(37, 'Cameroon', 0),
(38, 'Canada', 0),
(39, 'Cape Verde', 0),
(40, 'Cayman Islands', 0),
(41, 'Central African Republic', 0),
(42, 'Chad', 0),
(43, 'Chile', 0),
(44, 'China', 0),
(45, 'Christmas Island', 0),
(46, 'Cocos (Keeling) Islands', 0),
(47, 'Colombia', 0),
(48, 'Comoros', 0),
(49, 'Congo', 0),
(50, 'Congo, Democratic Republic of the', 0),
(51, 'Cook Islands', 0),
(52, 'Costa Rica', 0),
(53, 'Cote d\'Ivoire', 0),
(54, 'Croatia', 0),
(55, 'Cuba', 0),
(56, 'Cyprus', 0),
(57, 'Czech Republic', 0),
(58, 'Denmark', 0),
(59, 'Djibouti', 0),
(60, 'Dominica', 0),
(61, 'Dominican Republic', 0),
(62, 'East Timor', 0),
(63, 'Ecuador', 0),
(64, 'Egypt', 0),
(65, 'El Salvador', 0),
(66, 'Equatorial Guinea', 0),
(67, 'Eritrea', 0),
(68, 'Estonia', 0),
(69, 'Ethiopia', 0),
(70, 'Falkland Islands', 0),
(71, 'Faroe Islands', 0),
(72, 'Fiji', 0),
(73, 'Finland', 0),
(74, 'France', 0),
(75, 'French Guiana', 0),
(76, 'French Polynesia', 0),
(77, 'French Southern Territories', 0),
(78, 'Gabon', 0),
(79, 'Gambia', 0),
(80, 'Georgia', 0),
(81, 'Germany', 0),
(82, 'Ghana', 0),
(83, 'Gibraltar', 0),
(84, 'Greece', 0),
(85, 'Greenland', 0),
(86, 'Grenada', 0),
(87, 'Guadeloupe', 0),
(88, 'Guam', 0),
(89, 'Guatemala', 0),
(90, 'Guinea', 0),
(91, 'Guinea-Bissau', 0),
(92, 'Guyana', 0),
(93, 'Haiti', 0),
(94, 'Heard and McDonald Islands', 0),
(95, 'Honduras', 0),
(96, 'Hong Kong', 0),
(97, 'Hungary', 0),
(98, 'Iceland', 0),
(99, 'India', 0),
(100, 'Indonesia', 0),
(101, 'Iran', 0),
(102, 'Iraq', 0),
(103, 'Ireland', 0),
(104, 'Israel', 0),
(105, 'Italy', 0),
(106, 'Jamaica', 0),
(107, 'Japan', 0),
(108, 'Jordan', 0),
(109, 'Kazakhstan', 0),
(110, 'Kenya', 0),
(111, 'Kiribati', 0),
(112, 'Korea, Democratic People\'s Republic of', 0),
(113, 'Korea, Republic of', 0),
(114, 'Kuwait', 0),
(115, 'Kyrgyzstan', 0),
(116, 'Lao People\'s Democratic Republic', 0),
(117, 'Latvia', 0),
(118, 'Lebanon', 0),
(119, 'Lesotho', 0),
(120, 'Liberia', 0),
(121, 'Libya', 0),
(122, 'Liechtenstein', 0),
(123, 'Lithuania', 0),
(124, 'Luxembourg', 0),
(125, 'Macau', 0),
(126, 'Macedonia', 0),
(127, 'Madagascar', 0),
(128, 'Malawi', 0),
(129, 'Malaysia', 0),
(130, 'Maldives', 0),
(131, 'Mali', 0),
(132, 'Malta', 0),
(133, 'Marshall Islands', 0),
(134, 'Martinique', 0),
(135, 'Mauritania', 0),
(136, 'Mauritius', 0),
(137, 'Mayotte', 0),
(138, 'Mexico', 0),
(139, 'Micronesia', 0),
(140, 'Moldova', 0),
(141, 'Monaco', 0),
(142, 'Mongolia', 0),
(143, 'Montenegro', 0),
(144, 'Montserrat', 0),
(145, 'Morocco', 0),
(146, 'Mozambique', 0),
(147, 'Myanmar', 0),
(148, 'Namibia', 0),
(149, 'Nauru', 0),
(150, 'Nepal', 0),
(151, 'Netherlands', 0),
(152, 'Netherlands Antilles', 0),
(153, 'New Caledonia', 0),
(154, 'New Zealand', 0),
(155, 'Nicaragua', 0),
(156, 'Niger', 0),
(157, 'Nigeria', 0),
(158, 'Niue', 0),
(159, 'Norfolk Island', 0),
(160, 'Northern Mariana Islands', 0),
(161, 'Norway', 0),
(162, 'Oman', 0),
(163, 'Pakistan', 0),
(164, 'Palau', 0),
(165, 'Palestine', 0),
(166, 'Panama', 0),
(167, 'Papua New Guinea', 0),
(168, 'Paraguay', 0),
(169, 'Peru', 0),
(170, 'Philippines', 0),
(171, 'Pitcairn', 0),
(172, 'Poland', 0),
(173, 'Portugal', 0),
(174, 'Puerto Rico', 0),
(175, 'Qatar', 0),
(176, 'Reunion', 0),
(177, 'Romania', 0),
(178, 'Russian Federation', 0),
(179, 'Rwanda', 0),
(180, 'Saint Kitts and Nevis', 0),
(181, 'Saint Lucia', 0),
(182, 'Saint Vincent and the Grenadines', 0),
(183, 'Samoa', 0),
(184, 'San Marino', 0),
(185, 'Sao Tome and Principe', 0),
(186, 'Saudi Arabia', 0),
(187, 'Senegal', 0),
(188, 'Serbia', 0),
(189, 'Seychelles', 0),
(190, 'Sierra Leone', 0),
(191, 'Singapore', 0),
(192, 'Slovakia', 0),
(193, 'Slovenia', 0),
(194, 'Solomon Islands', 0),
(195, 'Somalia', 0),
(196, 'South Africa', 0),
(197, 'South Georgia and South Sandwich Islands', 0),
(198, 'Spain', 0),
(199, 'Sri Lanka', 0),
(200, 'Sudan', 0),
(201, 'Suriname', 0),
(202, 'Svalbard and Jan Mayen Islands', 0),
(203, 'Swaziland', 0),
(204, 'Sweden', 0),
(205, 'Switzerland', 0),
(206, 'Syrian Arab Republic', 0),
(207, 'Taiwan', 0),
(208, 'Tajikistan', 0),
(209, 'Tanzania', 0),
(210, 'Thailand', 0),
(211, 'Togo', 0),
(212, 'Tokelau', 0),
(213, 'Tonga', 0),
(214, 'Trinidad and Tobago', 0),
(215, 'Tunisia', 0),
(216, 'Turkey', 0),
(217, 'Turkmenistan', 0),
(218, 'Turks and Caicos Islands', 0),
(219, 'Tuvalu', 0),
(220, 'Uganda', 0),
(221, 'Ukraine', 0),
(222, 'United Arab Emirates', 0),
(223, 'United Kingdom', 0),
(224, 'United States', 0),
(225, 'United States Minor Outlying Islands', 0),
(226, 'Uruguay', 0),
(227, 'Uzbekistan', 0),
(228, 'Vanuatu', 0),
(229, 'Vatican City State', 0),
(230, 'Venezuela', 0),
(231, 'Vietnam', 0),
(232, 'Virgin Islands (British)', 0),
(233, 'Virgin Islands (U.S.)', 0),
(234, 'Wallis and Futuna Islands', 0),
(235, 'Western Sahara', 0),
(236, 'Yemen', 0),
(237, 'Zambia', 0),
(238, 'Zimbabwe', 0),
(239, 'Åland Islands', 0);

-- --------------------------------------------------------

--
-- Table structure for table `country_table`
--

CREATE TABLE `country_table` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modification_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `department_status` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `department_status`, `date_created`) VALUES
(2, 'BIMCAP Philippines- Marketing', 1, '2025-03-04 07:47:26'),
(3, 'BIMCAP- Phillippines- Administrator', 1, '2025-03-04 07:47:26'),
(4, 'BIMCAP- India- Human Resources', 1, '2025-03-04 07:47:43'),
(5, 'Innovation Hub', 0, '2025-03-06 04:44:53'),
(6, 'Management', 0, '2025-03-06 06:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `designation_id` int(11) NOT NULL,
  `designation_name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `designation_status` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`designation_id`, `designation_name`, `department_id`, `designation_status`, `date_created`) VALUES
(2, 'Software Developer', 2, 1, '2025-03-03 16:00:00'),
(3, 'Software', 5, 1, '2025-03-06 05:13:00'),
(4, 'BIM Management', 6, 1, '2025-03-06 06:52:42');

-- --------------------------------------------------------

--
-- Table structure for table `employee_history`
--

CREATE TABLE `employee_history` (
  `history_employee_id` int(11) NOT NULL,
  `history_department_id` int(11) DEFAULT NULL,
  `history_designation_name` varchar(50) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `history_spectrum_id` int(11) DEFAULT NULL,
  `history_joining_date` timestamp NULL DEFAULT NULL,
  `history_office_location` varchar(100) DEFAULT NULL,
  `history_emp_level` int(11) DEFAULT NULL,
  `history_emp_sub_level` int(11) DEFAULT NULL,
  `history_Increment_date` timestamp NULL DEFAULT NULL,
  `history_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_history`
--

INSERT INTO `employee_history` (`history_employee_id`, `history_department_id`, `history_designation_name`, `employee_id`, `history_spectrum_id`, `history_joining_date`, `history_office_location`, `history_emp_level`, `history_emp_sub_level`, `history_Increment_date`, `history_status`) VALUES
(1, 6, 'BIM Management', 4, 2, '2025-03-06 18:30:00', NULL, 4, 5, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_leaves`
--

CREATE TABLE `employee_leaves` (
  `leaves_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `leave_url` varchar(100) NOT NULL,
  `leave_status` int(11) NOT NULL DEFAULT 1,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_level`
--

CREATE TABLE `employee_level` (
  `employee_level_id` int(11) NOT NULL,
  `employee_level_name` varchar(50) NOT NULL,
  `employee_level_value` int(11) NOT NULL,
  `employee_level_status` int(11) NOT NULL DEFAULT 1,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modification_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee_level`
--

INSERT INTO `employee_level` (`employee_level_id`, `employee_level_name`, `employee_level_value`, `employee_level_status`, `date_created`, `modification_date`) VALUES
(1, 'Testing', 1, 1, '2025-03-04 16:00:00', NULL),
(2, 'Testing 2', 2, 1, '2025-03-04 16:00:00', NULL),
(3, 'Support', 1, 1, '2025-03-04 16:00:00', NULL),
(4, 'Support', 1, 1, '2025-03-04 16:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_sub_level`
--

CREATE TABLE `employee_sub_level` (
  `employee_sub_level_id` int(11) NOT NULL,
  `employee_sub_level_name` varchar(100) NOT NULL,
  `level_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee_sub_level`
--

INSERT INTO `employee_sub_level` (`employee_sub_level_id`, `employee_sub_level_name`, `level_id`, `date_created`) VALUES
(1, 'Check 1', 2, '2025-03-04 16:00:00'),
(2, '', 0, '2025-03-05 08:54:53'),
(3, '', 0, '2025-03-05 08:54:53'),
(4, '', 0, '2025-03-05 08:54:53'),
(5, 'Automation', 4, '2025-03-05 01:58:55'),
(6, 'HR', 4, '2025-03-05 01:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `employee_table`
--

CREATE TABLE `employee_table` (
  `main_employee_id` int(11) NOT NULL,
  `employee_first_name` varchar(50) NOT NULL,
  `employee_last_name` varchar(50) NOT NULL,
  `employee_email` varchar(50) NOT NULL,
  `employee_number` varchar(20) NOT NULL,
  `employee_address` text NOT NULL,
  `employee_city` varchar(50) NOT NULL,
  `employee_country_id` int(11) NOT NULL,
  `employee_department` varchar(100) NOT NULL,
  `employee_designation` varchar(100) NOT NULL,
  `employee_image` text NOT NULL,
  `employee_doj` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `employee_dot` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `emp_password` varchar(100) NOT NULL,
  `emp_level` int(11) NOT NULL,
  `emp_sub_level` int(11) NOT NULL DEFAULT 0,
  `employee_status` int(11) NOT NULL DEFAULT 1,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee_table`
--

INSERT INTO `employee_table` (`main_employee_id`, `employee_first_name`, `employee_last_name`, `employee_email`, `employee_number`, `employee_address`, `employee_city`, `employee_country_id`, `employee_department`, `employee_designation`, `employee_image`, `employee_doj`, `employee_dot`, `emp_password`, `emp_level`, `emp_sub_level`, `employee_status`, `date_created`) VALUES
(1, 'Nadeem', 'Qureshi', 'nadeem.qureshi@bimcap.com', '1234567890', 'Bhilai', 'Bhilai', 1, '7', 'Full-Stack Developer', 'upload/2024/jun/20/FjU2lkcWYAgNG6d.jpg', '2025-03-03 07:59:45', '0000-00-00 00:00:00', '$2y$10$G9WcxQ/ulU2ugqGcz.rRDuJCJb3beEsE23mqY87dph/USWseQW0hO', 3, 0, 1, '2025-03-03 07:59:45'),
(2, 'Yogesh', 'Sen', 'yogesh@bimcap.com', '1234567891', 'Bhilai', 'Bhilai', 2, '2', 'Software Developer', 'upload/2025/feb/27/Yogesh_BCP-Grey.png', '2025-03-03 10:41:02', '0000-00-00 00:00:00', '$2y$10$66DasEMrCZy0XhqdCC2Hcu1ft96P5UnW0B9iw1XMI5iXNQfwz3VkG', 1, 0, 1, '2025-03-03 10:41:02'),
(3, 'ghjgh', 'ghgfh', 'test@bimcap.com', '1234567890', 'gfnfgn', 'bvnvbn', 96, '6', 'BIM Management', 'upload/2025/mar/06/Micko Fernando_BCP_Yellow.png', '2025-03-06 18:30:00', '0000-00-00 00:00:00', '$2y$10$ldyFX8dua20uY5TGw9qoJ.cdoJaLtu7.M/.LkQcaCL0n5BIxAVFiS', 4, 5, 1, '0000-00-00 00:00:00'),
(4, 'ghjgh', 'ghgfh', 'test@bimcap.com', '1234567890', 'gfnfgn', 'bvnvbn', 96, '6', 'BIM Management', 'upload/2025/mar/06/Micko Fernando_BCP_Yellow.png', '2025-03-06 18:30:00', '0000-00-00 00:00:00', '$2y$10$DP2CnFDC/sSadL.LMGocIOLAdGk1FCbgvi8WaDwjGivQKojVp.4oe', 4, 5, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pe_assign_employee`
--

CREATE TABLE `pe_assign_employee` (
  `assign_id` int(11) NOT NULL,
  `assign_supervisor_id` int(11) NOT NULL,
  `assign_employee_id` int(11) NOT NULL,
  `assign_status` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modification_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pe_evaluation_history_id`
--

CREATE TABLE `pe_evaluation_history_id` (
  `evaluation_history_id` int(11) NOT NULL,
  `performance_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `emp_level` int(11) NOT NULL,
  `emp_sub_level` int(11) NOT NULL,
  `spectrum_id` int(11) NOT NULL,
  `goals_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modification_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pe_evaluation_table`
--

CREATE TABLE `pe_evaluation_table` (
  `employee_evaluation_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `evaluation_period` varchar(50) NOT NULL,
  `evaluation_start_date` varchar(50) NOT NULL,
  `evaluation_end_date` varchar(50) NOT NULL,
  `evaluation_status` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modification_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pe_goals_table`
--

CREATE TABLE `pe_goals_table` (
  `go﻿als_id` int(11) NOT NULL,
  `employee_evaluation_id` int(11) NOT NULL,
  `six_month_goal` text NOT NULL,
  `supervisor_six_month_goal` text NOT NULL,
  `twelve_month_goal` text NOT NULL,
  `supervisor_twelve_month_goal` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modification_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pe_marks_category_table`
--

CREATE TABLE `pe_marks_category_table` (
  `marks_category_id` int(11) NOT NULL,
  `marks_name` varchar(50) NOT NULL,
  `marks_value` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modification_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pe_question_table`
--

CREATE TABLE `pe_question_table` (
  `question_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `spectrum_id` int(11) NOT NULL,
  `question_weight_id` int(11) NOT NULL,
  `question_value` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modification_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pe_question_weight_table`
--

CREATE TABLE `pe_question_weight_table` (
  `question_weight_id` int(11) NOT NULL,
  `question_weig﻿ht_name` varchar(50) NOT NULL,
  `question_weight_value` float NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modification_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pe_section_table`
--

CREATE TABLE `pe_section_table` (
  `section_id` int(11) NOT NULL,
  `section_name` varchar(50) NOT NULL,
  `spectrum_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modification_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `salary_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary_currency` varchar(50) NOT NULL,
  `salary_reason` text NOT NULL,
  `salary_type` varchar(50) NOT NULL,
  `salary_amount` varchar(50) NOT NULL,
  `salary_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `salary_status` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spectrum_table`
--

CREATE TABLE `spectrum_table` (
  `spectrum_id` int(11) NOT NULL,
  `spectrum_color_code` varchar(50) NOT NULL,
  `spectrum_color_name` varchar(50) NOT NULL,
  `employee_level` varchar(50) NOT NULL,
  `employee_sub_level` varchar(50) NOT NULL,
  `spectrum_status` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `spectrum_table`
--

INSERT INTO `spectrum_table` (`spectrum_id`, `spectrum_color_code`, `spectrum_color_name`, `employee_level`, `employee_sub_level`, `spectrum_status`, `date_created`) VALUES
(1, 'FFFFFF', 'White', '2', '0', 0, '2025-03-05 06:39:00'),
(2, 'FFFF00', 'Yellow', '4', '5', 0, '2025-03-06 06:44:38'),
(3, '808080', 'Grey', '4', '5', 0, '2025-03-06 07:34:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `country_table`
--
ALTER TABLE `country_table`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `employee_history`
--
ALTER TABLE `employee_history`
  ADD PRIMARY KEY (`history_employee_id`);

--
-- Indexes for table `employee_leaves`
--
ALTER TABLE `employee_leaves`
  ADD PRIMARY KEY (`leaves_id`);

--
-- Indexes for table `employee_level`
--
ALTER TABLE `employee_level`
  ADD PRIMARY KEY (`employee_level_id`);

--
-- Indexes for table `employee_sub_level`
--
ALTER TABLE `employee_sub_level`
  ADD PRIMARY KEY (`employee_sub_level_id`);

--
-- Indexes for table `employee_table`
--
ALTER TABLE `employee_table`
  ADD PRIMARY KEY (`main_employee_id`);

--
-- Indexes for table `pe_assign_employee`
--
ALTER TABLE `pe_assign_employee`
  ADD PRIMARY KEY (`assign_id`);

--
-- Indexes for table `pe_evaluation_history_id`
--
ALTER TABLE `pe_evaluation_history_id`
  ADD PRIMARY KEY (`evaluation_history_id`);

--
-- Indexes for table `pe_evaluation_table`
--
ALTER TABLE `pe_evaluation_table`
  ADD PRIMARY KEY (`employee_evaluation_id`);

--
-- Indexes for table `pe_goals_table`
--
ALTER TABLE `pe_goals_table`
  ADD PRIMARY KEY (`go﻿als_id`);

--
-- Indexes for table `pe_marks_category_table`
--
ALTER TABLE `pe_marks_category_table`
  ADD PRIMARY KEY (`marks_category_id`);

--
-- Indexes for table `pe_question_table`
--
ALTER TABLE `pe_question_table`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `pe_question_weight_table`
--
ALTER TABLE `pe_question_weight_table`
  ADD PRIMARY KEY (`question_weight_id`);

--
-- Indexes for table `pe_section_table`
--
ALTER TABLE `pe_section_table`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`salary_id`);

--
-- Indexes for table `spectrum_table`
--
ALTER TABLE `spectrum_table`
  ADD PRIMARY KEY (`spectrum_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `country_table`
--
ALTER TABLE `country_table`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_history`
--
ALTER TABLE `employee_history`
  MODIFY `history_employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_leaves`
--
ALTER TABLE `employee_leaves`
  MODIFY `leaves_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_level`
--
ALTER TABLE `employee_level`
  MODIFY `employee_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employee_sub_level`
--
ALTER TABLE `employee_sub_level`
  MODIFY `employee_sub_level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee_table`
--
ALTER TABLE `employee_table`
  MODIFY `main_employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pe_assign_employee`
--
ALTER TABLE `pe_assign_employee`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pe_evaluation_history_id`
--
ALTER TABLE `pe_evaluation_history_id`
  MODIFY `evaluation_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pe_evaluation_table`
--
ALTER TABLE `pe_evaluation_table`
  MODIFY `employee_evaluation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pe_goals_table`
--
ALTER TABLE `pe_goals_table`
  MODIFY `go﻿als_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pe_marks_category_table`
--
ALTER TABLE `pe_marks_category_table`
  MODIFY `marks_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pe_question_table`
--
ALTER TABLE `pe_question_table`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pe_question_weight_table`
--
ALTER TABLE `pe_question_weight_table`
  MODIFY `question_weight_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pe_section_table`
--
ALTER TABLE `pe_section_table`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spectrum_table`
--
ALTER TABLE `spectrum_table`
  MODIFY `spectrum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
