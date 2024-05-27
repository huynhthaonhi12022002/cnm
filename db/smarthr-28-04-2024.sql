-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 28, 2024 lúc 05:57 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `smarthr`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `uuid` varchar(200) NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_from` varchar(200) NOT NULL,
  `manufacturer` varchar(200) NOT NULL,
  `model` varchar(200) NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `warranty` varchar(255) NOT NULL,
  `value` double NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `assets`
--

INSERT INTO `assets` (`id`, `name`, `uuid`, `purchase_date`, `purchase_from`, `manufacturer`, `model`, `serial_number`, `status`, `supplier`, `condition`, `warranty`, `value`, `description`, `created_at`) VALUES
(1, 'Macbook Book 1', '#AST-031256', '2020-09-23', 'Amazon', 'Apple Inc.', '2020', '12312312', '1', 'Amazon', 'In good shape', '12 Months', 1900, '', '2020-09-23 16:57:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `certificates`
--

INSERT INTO `certificates` (`id`, `name`, `create_at`) VALUES
(1, 'Bằng cử nhân', '2024-03-24 03:13:00'),
(3, 'Cử nhân khoa học xã hội', '2024-03-24 03:13:38'),
(4, 'Cử nhân khoa học tự nhiên', '2024-03-24 03:13:38'),
(5, 'Cử nhân quản trị kinh doanh', '2024-03-24 03:13:59'),
(6, 'Cử nhân kế toán', '2024-03-24 03:13:59'),
(7, 'Cử nhân luật', '2024-03-24 03:14:31'),
(8, 'Thạc sĩ khoa học xã hội', '2024-03-24 03:14:31'),
(9, 'Thạc sĩ quản trị kinh doanh', '2024-03-24 03:14:54'),
(10, 'Thạc sĩ kế toán', '2024-03-24 03:14:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `company` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `avatar` varchar(225) NOT NULL,
  `create_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `clients`
--

INSERT INTO `clients` (`id`, `firstname`, `lastname`, `email`, `phone`, `company`, `address`, `avatar`, `create_at`) VALUES
(1, 'Yahuza 2 111111', 'Abdul-Hakim 2', 'musheabdulhakim@protonmail.ch2', '233209229025 2', 'Microsoft Inc2', 'Live from home 2', '2b8695d1fd020721521c4e39b4455cce.webp', '2020-09-26'),
(8, 'Trần ứeqweq', 'Thiện', 'tranminhthien0709@gmail.com', '0334502621', 'ƯEQWEQWE', '496/9/19 Dương Quảng Hàm, Phường 6, Gò Vấp, Thành phố Hồ Chí Minh', 'd04ffb3493652b300fa8e17c05ae81bc.png', '2024-03-22'),
(9, 'Trần 123', 'Thiện', 'tranminhthien0709@gmail.com', '0334502621', 'ƯEQWEQWE', '496/9/19 Dương Quảng Hàm, Phường 6, Gò Vấp, Thành phố Hồ Chí Minh', 'd1d700f637d4e6bb165186f47d95dd5a.webp', '2024-03-25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(30, 'Phòng tổ chức - hành chính'),
(32, 'Phòng kinh doanh'),
(33, 'Phòng tài chính - kế toán'),
(34, 'Văn phòng đại diện'),
(35, 'Phòng kinh tế - kỹ thuật'),
(36, 'Phòng kế hoạch - kinh doanh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `designations`
--

CREATE TABLE `designations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `designations`
--

INSERT INTO `designations` (`id`, `name`, `department_id`, `Date`) VALUES
(49, 'Phó giám đốc', 32, '2024-03-22'),
(51, 'Giám đốc', 30, '2024-03-22'),
(52, 'Nhân viên', 30, '2024-03-22'),
(53, 'Trưởng phòng', 30, '2024-03-22'),
(54, 'Phó phòng', 30, '2024-03-22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `designation_id` int(11) NOT NULL,
  `join_date` date NOT NULL DEFAULT current_timestamp(),
  `uuid` varchar(20) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `basic_salary` double NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `employees`
--

INSERT INTO `employees` (`id`, `firstname`, `lastname`, `phone`, `email`, `department_id`, `designation_id`, `join_date`, `uuid`, `avatar`, `basic_salary`, `created_at`) VALUES
(3, 'Goerge ', 'qưeqweqweqww', '123131231', 'george@gmail.com', 30, 49, '2024-03-31', 'EMP_003', 'avatar-25.jpg', 20000, '2020-09-28 23:46:51'),
(4, 'Mushe', 'Jack', '', 'musheabdulhakim@protonmail.ch', 30, 51, '2020-09-29', 'EMP_004', 'avatar-11.jpg', 60000, '2020-09-29 00:04:29'),
(5, 'Yahuza', 'Yuan', '', 'musheabdulhakim@protonmail.ch', 32, 49, '2020-09-29', 'EMP_005', 'avatar-09.jpg', 8000000, '2020-09-29 00:14:44'),
(6, 'Trần', 'Thien', '', 'tranminhthien0709@gmail.com', 32, 49, '2024-03-21', 'EMP_006', '2cda8e4ea822b874b277cfec27258af0.png', 2000, '2024-03-23 20:23:56'),
(9, 'Trần', 'Cuong', '', 'tranminhthien0709@gmail.com', 32, 49, '2024-03-21', 'EMP_006', '2cda8e4ea822b874b277cfec27258af0.png', 2000, '2024-03-23 20:23:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `employee_attendances`
--

CREATE TABLE `employee_attendances` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `checkin` varchar(50) NOT NULL,
  `checkout` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `employee_attendances`
--

INSERT INTO `employee_attendances` (`id`, `employee_id`, `checkin`, `checkout`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, '23:30', '02:38', '', '2024-03-24 03:41:10', '2024-03-24 03:41:10'),
(2, 3, '04:24', '20:22', NULL, '2024-03-24 07:24:24', '2024-03-24 07:24:24'),
(19, 3, '00:42', '00:45', '0', '2024-04-12 17:42:21', '2024-04-12 17:42:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `goals`
--

CREATE TABLE `goals` (
  `id` int(11) NOT NULL,
  `Type` varchar(200) NOT NULL,
  `Subject` varchar(200) NOT NULL,
  `Target` text NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `Description` text NOT NULL,
  `Status` int(11) NOT NULL,
  `Progress` varchar(200) NOT NULL,
  `dateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `goals`
--

INSERT INTO `goals` (`id`, `Type`, `Subject`, `Target`, `StartDate`, `EndDate`, `Description`, `Status`, `Progress`, `dateTime`) VALUES
(1, 'Another One', 'Coding', 'Code till time infinity ', '2020-09-25', '2020-10-10', 'This is the thing i always want to do and am doing it for the rest of my life now friend.', 1, '80', '2020-09-25 00:13:34'),
(2, 'Another One', 'this is a test', 'Code till time infinity ', '2020-09-25', '2020-10-10', 'This is a test', 1, '50', '2020-09-25 00:39:34'),
(3, 'Invoice Goal', 'This is another test', 'Code till thy kingdom come.', '2020-09-25', '2048-09-10', 'this is another one of the wierdest thing that i have ever done. I having alot of the shit not working but i got this.', 0, '0', '2020-09-25 01:08:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `goal_type`
--

CREATE TABLE `goal_type` (
  `id` int(11) NOT NULL,
  `Type` varchar(200) NOT NULL,
  `Description` text NOT NULL,
  `Status` int(100) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `goal_type`
--

INSERT INTO `goal_type` (`id`, `Type`, `Description`, `Status`, `Date`) VALUES
(1, 'Invoice Goal', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti laudantium animi fuga hic nobis culpa, sapiente numquam quaerat quisquam eveniet dolorum soluta harum eligendi praesentium corporis error quo inventore suscipit?', 1, '2020-09-24'),
(3, 'Another One', 'This is another test for the type section. Just testing it and seeing it work makes me smile with joy. Thats the power of programming for humans and especially to me .It makes me more happy to see my code run without troubles or bugs.', 1, '2020-09-24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `holiday_date` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `holidays`
--

INSERT INTO `holidays` (`id`, `name`, `holiday_date`, `created_at`) VALUES
(18, '30/4123123213213121232132312321', '2024-03-14', '2024-03-22 16:08:03'),
(19, 'ádasdadsa', '2024-04-07', '2024-03-22 16:08:10'),
(20, 'ádasd', '2024-03-08', '2024-03-22 16:37:08'),
(24, 'MusicPlayer079', '2024-04-12', '2024-04-06 18:52:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `vacancies` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `salary_from` double NOT NULL,
  `salary_to` double NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `department_id`, `location`, `vacancies`, `experience`, `age`, `salary_from`, `salary_to`, `type`, `status`, `start_date`, `expire_date`, `description`, `created_at`) VALUES
(1, '123123123123123', 30, '1231231231 nguyen van bao', 10, 5, 18, 2000, 3000, 'Full Time', 'Open', '2024-03-23', '2024-04-27', 'asdasdadasdasdasdasdaasdasdsd', '2024-03-23 16:37:46'),
(3, '231231231232 #####', 32, '12 Nguyễn Văn Bảo, phường 4, HCM', 10, 60, 32, 2000, 5000, 'Part Time', 'Open', '2024-03-29', '2024-03-31', 'qweqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqweqwe', '2024-03-23 16:49:10'),
(4, '231231231232 ****', 32, '12 Nguyễn Văn Bảo, phường 4, HCM', 10, 60, 32, 2000, 5000, 'Part Time', 'Cancelled', '2024-03-29', '2024-03-31', 'qweqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqwqweqwe', '2024-03-23 16:49:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_applicants`
--

CREATE TABLE `job_applicants` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cv` varchar(100) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `job_applicants`
--

INSERT INTO `job_applicants` (`id`, `job_id`, `name`, `email`, `cv`, `message`, `status`, `user_id`, `created_at`) VALUES
(6, 1, 'Trần Minh Thiện', 'tranminhthien0709@gmail.com', '263ae3857af8a67adc1c066e973dfcd4.pdf', 'qưeqweqwewe', 'New', 0, '2024-03-25 10:45:30'),
(7, 3, 'Trần Minh Thiện', 'tranminhthien0709@gmail.com', '53eb0d8c2e0a4a07d7f9b84e105a00e9.pdf', '1231231231', 'New', 0, '2024-03-25 10:49:45'),
(8, 4, 'new', '123123', '7eff5c368fe14dca2c313bcaf7d28a5c.pdf', '12312213', 'New', 0, '2024-03-25 10:50:08'),
(9, 3, 'Trần Minh Thiện', 'tranminhthien0709@gmail.com', '53eb0d8c2e0a4a07d7f9b84e105a00e9.pdf', '1231231231', 'New', 0, '2024-03-25 10:49:45'),
(10, 4, 'new', '123123', '7eff5c368fe14dca2c313bcaf7d28a5c.pdf', '12312213', 'New', 0, '2024-03-25 10:50:08'),
(11, 1, 'Trần Minh Thiện', 'tranminhthien0709@gmail.com', '263ae3857af8a67adc1c066e973dfcd4.pdf', 'qưeqweqwewe', 'New', 0, '2024-03-25 10:45:30'),
(12, 3, 'MusicPlayer079', 'tranminhthien0709@gmail.com', '1e81d5e46177df3bb3832102150330c2.pdf', 'qưeqweqweqwewe', 'New', 12, '2024-04-09 05:17:12'),
(13, 3, '1123123123', 'tranminhthien0709@gmail.com', 'a459fdbecc755a06c8d26e6cf186ad2d.pdf', '123123123213', 'New', 12, '2024-04-09 05:20:49'),
(14, 3, '1123123123', 'tranminhthien0709@gmail.com', '6a37de283f1c00fa46a0ac869e859cae.pdf', '123123123213', 'New', 12, '2024-04-09 05:22:14'),
(15, 1, 'MusicPlayer079 11111', 'tranminhthien0709@gmail.com', 'e11915223eee0548f001b2851255c42b.pdf', 'qưeqwqeqweqw', 'New', 12, '2024-04-09 05:22:37'),
(16, 1, '123123123', '12312312312@gmail.com', 'f76dc683710b3e610cd811e4534fdfd4.pdf', '12321321312312', 'New', 12, '2024-04-09 05:23:24'),
(17, 3, 'MusicPlayer079', 'tranminhthien0709@gmail.com', 'e69a2fd8a97080958fc6d1414783a839.pdf', 'qưeqweqeqweqweqwe', 'New', 12, '2024-04-09 05:36:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `status` int(11) DEFAULT 0,
  `reason` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `leaves`
--

INSERT INTO `leaves` (`id`, `employee_id`, `type`, `from`, `to`, `status`, `reason`, `created_at`) VALUES
(1, 4, 'Casual Leave 12 Days', '2020-09-01', '2020-10-01', 1, '1sadddddddddddddddddddddddddd', '2020-10-03 18:50:34'),
(5, 6, 'Casual Leave 12 Days', '2024-03-15', '2024-03-24', 2, '1sadddddddddddddddddddddddddd', '2024-03-22 15:10:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `incoming_msg_id` int(11) NOT NULL,
  `outgoing_msg_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `seen`, `created_at`) VALUES
(1, 2, 3, 'ádasdasdasdasdas', 0, '2024-04-09 16:09:28'),
(2, 6, 17, '12313123', 0, '2024-04-09 16:20:42'),
(3, 12, 17, 'hêlo', 0, '2024-04-09 16:33:12'),
(4, 17, 12, 'chào ', 0, '2024-04-09 16:34:34'),
(5, 12, 17, 'hêlo', 0, '2024-04-09 16:35:02'),
(6, 12, 17, '1', 0, '2024-04-09 16:35:06'),
(7, 12, 17, '12', 0, '2024-04-09 16:35:07'),
(8, 17, 12, 'chào 222', 0, '2024-04-09 16:35:17'),
(9, 12, 17, '1231231231', 0, '2024-04-09 17:11:31'),
(10, 12, 17, '123123123112312313213', 0, '2024-04-09 17:11:33'),
(11, 12, 17, '1231231231123123132131232132131', 0, '2024-04-09 17:11:35'),
(12, 12, 17, 'ádasdasdasds', 0, '2024-04-09 17:12:04'),
(13, 12, 17, 'eqweqweqw', 0, '2024-04-09 17:12:26'),
(14, 12, 17, 'eqweqweqw', 0, '2024-04-09 17:12:28'),
(15, 12, 17, '12312312', 0, '2024-04-09 17:12:41'),
(16, 12, 17, '12312312', 0, '2024-04-09 17:12:43'),
(17, 12, 17, 'zxsdadsdsssssssssssssssssssss chao ưeoavkajk jaksldjakldjakljdklasjdklasjd jedwiwiiwiowowqieowewiqe ưoeqiewoqeqwieoqweqwi qưoeqiweoqweqwieoqweiqweoqwie qưeqwe qưe qưeqweqw', 0, '2024-04-09 17:16:33'),
(18, 17, 12, 'holo\r\n', 0, '2024-04-10 02:32:04'),
(19, 17, 12, 'hehe', 0, '2024-04-10 02:32:20'),
(20, 17, 12, 'hih', 0, '2024-04-10 02:33:48'),
(21, 17, 12, 'qưqweqw', 0, '2024-04-10 02:34:16'),
(22, 17, 12, 'q', 0, '2024-04-10 02:37:46'),
(23, 17, 12, '123123123', 0, '2024-04-10 02:38:47'),
(24, 17, 12, '123123', 0, '2024-04-10 02:40:05'),
(26, 12, 17, 'qweq', 0, '2024-04-10 02:45:56'),
(27, 12, 17, 'qweqwe', 0, '2024-04-10 02:45:59'),
(28, 17, 12, 'qweqwe', 0, '2024-04-10 02:47:52'),
(29, 12, 17, 'qweqweqwe', 0, '2024-04-10 02:47:57'),
(30, 12, 17, 'aaaaa', 0, '2024-04-10 02:49:03'),
(31, 17, 12, '111', 0, '2024-04-10 02:52:37'),
(32, 17, 12, '123123', 0, '2024-04-10 02:53:40'),
(33, 17, 12, '12312312', 0, '2024-04-10 02:53:42'),
(34, 12, 17, '123123', 0, '2024-04-10 02:53:53'),
(35, 12, 17, '123123', 0, '2024-04-10 02:53:56'),
(36, 12, 17, '123123123', 0, '2024-04-10 02:54:02'),
(37, 17, 12, 'hllo\r\n', 0, '2024-04-10 14:53:56'),
(38, 17, 12, 'hello', 0, '2024-04-10 14:54:02'),
(39, 17, 12, 'hello\r\n', 0, '2024-04-10 14:55:33'),
(40, 17, 12, 'hello', 0, '2024-04-10 14:55:40'),
(41, 17, 12, 'hi', 0, '2024-04-10 14:55:45'),
(42, 17, 12, 'xin chao', 0, '2024-04-10 14:55:52'),
(43, 17, 12, 'xin chao', 0, '2024-04-10 14:56:39'),
(46, 12, 17, 'asdasdas', 0, '2024-04-13 03:31:10'),
(47, 13, 17, 'ádasdasdas', 0, '2024-04-18 10:21:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `overtime`
--

CREATE TABLE `overtime` (
  `id` int(11) NOT NULL,
  `Employee` varchar(200) NOT NULL,
  `OverTime_Date` date NOT NULL,
  `Hours` varchar(20) NOT NULL,
  `Type` varchar(200) NOT NULL,
  `Description` text NOT NULL,
  `dateTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `overtime`
--

INSERT INTO `overtime` (`id`, `Employee`, `OverTime_Date`, `Hours`, `Type`, `Description`, `dateTime`) VALUES
(1, 'Mushe Abdul-Hakim', '2020-09-29', '5', '	Normal ex.5', 'This extra minutes are spent on trying to improve my knowledge on programming everyday.', '2020-09-29 00:38:26'),
(2, 'Goerge Merchason', '2020-09-29', '5', '	Normal ex.5', 'This was just to help the ceo with his presentation prep for tomorrow\'s big event.', '2020-09-29 09:20:37'),
(3, 'Yahuza Abdul-Hakim', '2020-09-10', '3', 'Normal ex.5', 'This is another test of the overtime of employees', '2020-09-29 09:28:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payrolls`
--

CREATE TABLE `payrolls` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `work_day` int(11) NOT NULL,
  `allowance` double DEFAULT NULL,
  `month_salary` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `deduction` double DEFAULT NULL,
  `total_salary` double NOT NULL,
  `paid_type` varchar(100) NOT NULL,
  `paid_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payrolls`
--

INSERT INTO `payrolls` (`id`, `employee_id`, `work_day`, `allowance`, `month_salary`, `status`, `deduction`, `total_salary`, `paid_type`, `paid_date`, `created_at`) VALUES
(1, 3, 30, 0, '2024-07', 1, 0, 20000, '1', '2024-03-16', '2024-03-25 15:01:01'),
(3, 6, 30, 2000, '2024-07', 1, 0, 22000, '3', '2024-03-25', '2024-03-25 15:08:18'),
(4, 6, 30, 3000, '2024-07', 1, 0, 23000, '1', '2024-04-06', '2024-04-06 14:56:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `client_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `rate` double NOT NULL,
  `priority` varchar(200) NOT NULL,
  `leader` int(11) NOT NULL,
  `team` longtext NOT NULL,
  `description` longtext NOT NULL,
  `files` longtext DEFAULT NULL,
  `progress` varchar(100) DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `projects`
--

INSERT INTO `projects` (`id`, `name`, `client_id`, `start_date`, `end_date`, `rate`, `priority`, `leader`, `team`, `description`, `files`, `progress`, `status`, `created_at`) VALUES
(5, 'MusicPlayer079', 1, '0000-00-00', '2024-04-09', 5000, 'Medium', 4, '[\"4\",\"5\",\"6\",\"9\"]', 'qweqweqweqwewqewq', '0', '0', 0, '2024-04-05 14:09:17'),
(6, 'qweqweqw', 1, '2024-04-24', '2024-04-20', 5000, 'High', 4, '[\"4\"]', 'qweqweqeqwe', '0', '0', 0, '2024-04-05 14:11:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `start_date`, `end_date`, `status`, `project_id`, `employee_id`, `file`, `created_at`, `updated_at`) VALUES
(1, 'asdasddasda thien dep trai 1111', 'asdasdasdasdasdasdasds', '2024-03-24', '2024-03-28', 1, 5, 4, '', '2024-03-24 09:05:11', '2024-03-24 09:05:11'),
(2, 'adasdasdasd', 'ádasdasdasdasdasda', '2024-03-09', '2024-03-09', 2, 5, 5, '', '2024-03-24 09:18:44', '2024-03-24 09:18:44'),
(3, 'qweqweqweqw', 'qweqweqweqweqw', '2024-04-10', '2024-04-19', 0, 6, 6, '47648c01f0c0ce08e4dcb72030428b25.pdf', '2024-03-24 09:18:54', '2024-03-24 09:18:54'),
(4, 'thien 24/3', 'eqweqweqweqweqweweqweqweqweqw', '2024-03-09', '2024-03-14', 0, 6, 6, '', '2024-03-24 09:19:11', '2024-03-24 09:19:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `role`, `status`, `employee_id`, `created_at`) VALUES
(6, 'Barry', 'barrycuda@example.com', '$2y$10$5Uuf5qWRyaIqn1o45YySBeMKkZmMBNoXBhrMhpARBqHqARLfy95Qe', 'avatar-19.jpg', 1, 1, 0, '2024-03-23 14:43:41'),
(7, 'Yahuza', 'musheabdulhakim@protonmail.ch', '$2y$10$5Uuf5qWRyaIqn1o45YySBeMKkZmMBNoXBhrMhpARBqHqARLfy95Qe', 'my-passport-photo.jpg', 1, 1, 0, '2024-03-23 14:43:41'),
(12, '123123123', '123123123@gmail.com', '$2y$10$yyMqiMCNCTTctAUOyHzA5.8.2FKL3CDyWP0echECK7ie7BruyYUaK', '90ad47e14b8ffc897735a88ae8d51a83.png', 0, 1, 6, '2024-03-23 15:32:27'),
(13, '1231231 thien dep trai', 'dungtanthuy512@gmail.com', '$2y$10$NLeIwkHoCfzj6EhbxftziORKTeocNbyJZAM9A/yPaOFJAf5jOLis2', '1a682c0dc4b3bb2ddec6e3cb57e8a0cf.png', 1, 1, NULL, '2024-03-23 15:33:48'),
(17, 'Thuan Tran', 'dungtanthuy516@gmail.com', '$2y$10$9Z37bBgTcQupsq7/G/rZQ.ViTaRpNyUqzayGtLTxx5ANxvhEk7Xni', 'https://lh3.googleusercontent.com/a/ACg8ocIvkyMJ_xzJvRQWEqpzws3TQArTUZmUzz1gY3wVRNBJ_oJr2w=s96-c', 0, 1, 6, '2024-04-09 04:56:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_role`
--

INSERT INTO `user_role` (`id`, `role`, `date`) VALUES
(1, 'admin\r\n', '2020-09-21'),
(2, 'employee', '2020-09-21');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assetId` (`uuid`),
  ADD UNIQUE KEY `assetId_2` (`uuid`),
  ADD UNIQUE KEY `assetId_3` (`uuid`),
  ADD UNIQUE KEY `assetId_4` (`uuid`);

--
-- Chỉ mục cho bảng `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `employee_attendances`
--
ALTER TABLE `employee_attendances`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `goal_type`
--
ALTER TABLE `goal_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Type` (`Type`);

--
-- Chỉ mục cho bảng `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `job_applicants`
--
ALTER TABLE `job_applicants`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`email`);

--
-- Chỉ mục cho bảng `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `employee_attendances`
--
ALTER TABLE `employee_attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `goals`
--
ALTER TABLE `goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `goal_type`
--
ALTER TABLE `goal_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `job_applicants`
--
ALTER TABLE `job_applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
