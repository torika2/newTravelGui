-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 03, 2020 at 09:08 PM
-- Server version: 10.2.31-MariaDB
-- PHP Version: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bg_images`
--

CREATE TABLE `bg_images` (
  `bg_id` bigint(20) UNSIGNED NOT NULL,
  `params` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `equiped` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bg_images`
--

INSERT INTO `bg_images` (`bg_id`, `params`, `link`, `image_name`, `equiped`, `created_at`, `updated_at`) VALUES
(13, 'get_first_frame', 'pageImages/1582876739.jpg', '1582876739.jpg', 0, '2020-02-28 03:58:59', '2020-02-28 04:56:57'),
(14, 'get_first_frame', 'pageImages/1582880217.jpg', '1582880217.jpg', 0, '2020-02-28 04:56:57', '2020-03-02 11:50:42'),
(15, 'get_first_frame', 'pageImages/1583164237.jpg', '1583164237.jpg', 0, '2020-03-02 11:50:42', '2020-03-03 12:32:09'),
(16, 'get_first_frame', 'pageImages/1583253129.png', '1583253129.png', 1, '2020-03-03 12:32:09', '2020-03-03 12:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`color_id`, `color`, `params`, `created_at`, `updated_at`) VALUES
(1, '#00ff00', 'get_first_frame', NULL, '2020-02-26 07:19:30');

-- --------------------------------------------------------

--
-- Table structure for table `image_crops`
--

CREATE TABLE `image_crops` (
  `crop_image_id` bigint(20) UNSIGNED NOT NULL,
  `page_image_id` int(11) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `params` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_height` int(11) NOT NULL,
  `image_width` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `image_crops`
--

INSERT INTO `image_crops` (`crop_image_id`, `page_image_id`, `image_url`, `user_id`, `params`, `created_at`, `updated_at`, `image_height`, `image_width`) VALUES
(17, 14, 'croppedImages/15828811911582880217.jpg', 6, 'get_first_frame', '2020-02-28 05:13:11', '2020-02-28 05:13:11', 240, 300),
(18, 14, 'croppedImages/15828935911582880217.jpg', 5, 'get_first_frame', '2020-02-28 08:39:51', '2020-02-28 08:39:51', 100, 100),
(19, 14, 'croppedImages/15828936021582880217.jpg', 5, 'get_first_frame', '2020-02-28 08:40:02', '2020-02-28 08:40:02', 140, 200),
(20, 14, 'croppedImages/15828936321582880217.jpg', 5, 'get_first_frame', '2020-02-28 08:40:32', '2020-02-28 08:40:32', 200, 140),
(21, 16, 'croppedImages/15832531481583253129.png', 9, 'get_first_frame', '2020-03-03 12:32:28', '2020-03-03 12:32:28', 300, 200);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language_name`, `params`, `language_short_name`, `created_at`, `updated_at`) VALUES
(1, 'ქართული', 'get_first_frame', 'ქარ', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logged_users`
--

CREATE TABLE `logged_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loggers`
--

CREATE TABLE `loggers` (
  `logger_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `crud_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info_was` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info_is` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loggers`
--

INSERT INTO `loggers` (`logger_id`, `user_id`, `crud_type`, `info_was`, `info_is`, `created_at`, `updated_at`) VALUES
(1, 5, 'create', 'Exist', 'Event :asdsadasd - 30 - asdsadasdsadsadsadsadasdsad - 5', '2020-02-24 16:02:12', '2020-02-24 16:02:12'),
(5, 5, 'delete', '7', 'empty', '2020-02-24 16:11:41', '2020-02-24 16:11:41'),
(6, 5, 'create', 'Exist', 'pageImages/1582707227.jpg', '2020-02-26 04:53:47', '2020-02-26 04:53:47'),
(7, 5, 'create', 'Exist', 'pageImages/1582707246.jpg', '2020-02-26 04:54:06', '2020-02-26 04:54:06'),
(8, 5, 'create', 'Exist', 'pageImages/1582708052.png', '2020-02-26 05:07:32', '2020-02-26 05:07:32'),
(9, 5, 'create', 'Exist', 'pageImages/1582709170.png', '2020-02-26 05:26:10', '2020-02-26 05:26:10'),
(10, 5, 'update', 'Exist', '#0000ff - get_first_frame', '2020-02-26 06:17:08', '2020-02-26 06:17:08'),
(11, 5, 'update', 'Exist', '#8080ff - get_first_frame', '2020-02-26 06:23:39', '2020-02-26 06:23:39'),
(12, 5, 'update', 'Exist', '#00ff00 - get_first_frame', '2020-02-26 07:19:30', '2020-02-26 07:19:30'),
(13, 5, 'create', 'Exist', 'pageImages/1582807585.jpg', '2020-02-27 08:46:26', '2020-02-27 08:46:26'),
(14, 5, 'create', 'Exist', 'pageImages/1582809609.jpg', '2020-02-27 09:20:09', '2020-02-27 09:20:09'),
(15, 5, 'create', 'Exist', 'pageImages/1582814736.jpg', '2020-02-27 10:45:37', '2020-02-27 10:45:37'),
(16, 5, 'create', 'Exist', 'pageImages/1582814753.jpg', '2020-02-27 10:45:53', '2020-02-27 10:45:53'),
(17, 5, 'create/update', 'Exist', 'C:\\xampp\\htdocs\\TravelGuide\\public\\croppedImages/15828395911582814736.jpg', '2020-02-27 17:39:52', '2020-02-27 17:39:52'),
(18, 5, 'create/update', 'Exist', 'croppedImages/15828397001582814736.jpg', '2020-02-27 17:41:41', '2020-02-27 17:41:41'),
(19, 5, 'create/update', 'Exist', 'croppedImages/15828416841582814736.jpg', '2020-02-27 18:14:44', '2020-02-27 18:14:44'),
(20, 5, 'create/update', 'Exist', 'croppedImages/15828423421582814753.jpg', '2020-02-27 18:25:43', '2020-02-27 18:25:43'),
(21, 5, 'create/update', 'Exist', 'croppedImages/15828425341582814753.jpg', '2020-02-27 18:28:55', '2020-02-27 18:28:55'),
(22, 5, 'create/update', 'Exist', 'croppedImages/15828425441582814753.jpg', '2020-02-27 18:29:04', '2020-02-27 18:29:04'),
(26, 5, 'create/update', 'Exist', 'croppedImages/15828431681582842752.jpg', '2020-02-27 18:39:28', '2020-02-27 18:39:28'),
(27, 5, 'create/update', 'Exist', 'croppedImages/15828431981582842752.jpg', '2020-02-27 18:39:58', '2020-02-27 18:39:58'),
(28, 5, 'create/update', 'Exist', 'croppedImages/15828432781582842752.jpg', '2020-02-27 18:41:18', '2020-02-27 18:41:18'),
(29, 5, 'create/update', 'Exist', 'croppedImages/15828432871582842752.jpg', '2020-02-27 18:41:27', '2020-02-27 18:41:27'),
(30, 5, 'create/update', 'Exist', 'croppedImages/15828433051582842752.jpg', '2020-02-27 18:41:46', '2020-02-27 18:41:46'),
(31, 5, 'create/update', 'Exist', 'croppedImages/15828434241582842752.jpg', '2020-02-27 18:43:44', '2020-02-27 18:43:44'),
(32, 5, 'create/update', 'Exist', 'croppedImages/15828434361582842752.jpg', '2020-02-27 18:43:56', '2020-02-27 18:43:56'),
(33, 5, 'create', 'Exist', 'pageImages/1582876739.jpg', '2020-02-28 03:58:59', '2020-02-28 03:58:59'),
(34, 6, 'create', 'Exist', 'pageImages/1582880217.jpg', '2020-02-28 04:56:58', '2020-02-28 04:56:58'),
(35, 6, 'create/update', 'Exist', 'croppedImages/15828811911582880217.jpg', '2020-02-28 05:13:11', '2020-02-28 05:13:11'),
(36, 5, 'create/update', 'Exist', 'croppedImages/15828935911582880217.jpg', '2020-02-28 08:39:51', '2020-02-28 08:39:51'),
(37, 5, 'create/update', 'Exist', 'croppedImages/15828936021582880217.jpg', '2020-02-28 08:40:02', '2020-02-28 08:40:02'),
(38, 5, 'create/update', 'Exist', 'croppedImages/15828936321582880217.jpg', '2020-02-28 08:40:32', '2020-02-28 08:40:32'),
(39, 6, 'create', 'Exist', 'pageImages/1583164237.jpg', '2020-03-02 11:50:42', '2020-03-02 11:50:42'),
(40, 9, 'შეიქმნა', 'აქტიური', 'pageImages/1583253129.png: color-default(#ffffff)', '2020-03-03 12:32:09', '2020-03-03 12:32:09'),
(41, 9, 'შეიქმნა/განახლდა', 'არსებობს', 'croppedImages/15832531481583253129.png', '2020-03-03 12:32:28', '2020-03-03 12:32:28'),
(42, 9, 'შეიქმნა', 'არსებობს', 'Event :ssssss - Price :2000 - Desc :assssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss - Size :10', '2020-03-03 12:34:53', '2020-03-03 12:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `logos`
--

CREATE TABLE `logos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logos`
--

INSERT INTO `logos` (`id`, `logo_path`, `created_at`, `updated_at`) VALUES
(1, 'image/img.gif', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(28, '2014_10_12_000000_create_users_table', 1),
(29, '2014_10_12_100000_create_password_resets_table', 1),
(30, '2020_02_19_225222_create_tours_table', 1),
(31, '2020_02_19_225344_create_tour_viewers_table', 1),
(32, '2020_02_19_225402_create_tour_likes_table', 1),
(33, '2020_02_19_225414_create_tour_reviews_table', 1),
(34, '2020_02_19_225422_create_tour_images_table', 1),
(35, '2020_02_19_225446_create_tour_members_table', 1),
(36, '2020_02_19_225505_create_tour_ratings_table', 1),
(37, '2020_02_19_225530_create_tour_review_likes_table', 1),
(38, '2020_02_19_225600_create_user_tour_bookmarks_table', 1),
(39, '2020_02_19_225632_create_user_rankings_table', 1),
(40, '2020_02_20_140132_create_tour_review_reply_likes_table', 1),
(41, '2020_02_20_140221_create_user_followers_table', 1),
(42, '2020_02_20_214201_create_tour_musics_table', 1),
(43, '2020_02_20_214401_create_user_tour_shares_table', 1),
(44, '2020_02_20_214524_create_user_roles_table', 1),
(45, '2020_02_20_215659_create_tout_image_filters_table', 1),
(46, '2020_02_20_215822_create_logged_users_table', 1),
(47, '2020_02_20_215932_create_logos_table', 1),
(48, '2020_02_20_220022_create_colors_table', 1),
(49, '2020_02_20_220107_create_slogans_table', 1),
(50, '2020_02_20_220145_create_languages_table', 1),
(51, '2020_02_20_220245_create_pages_table', 1),
(52, '2020_02_21_191628_create_versions_table', 1),
(53, '2020_02_21_204702_create_bg_images_table', 1),
(54, '2020_02_21_223317_create_texts_table', 1),
(55, '2020_02_23_160639_create_user_images_table', 2),
(56, '2020_02_24_183807_create_loggers_table', 3),
(57, '2020_02_26_080753_create_pages_table', 4),
(58, '2020_02_26_081405_create_pages_table', 5),
(59, '2020_02_27_120849_create_image_crops_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `params` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `params`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'get_first_frame', 'პირველი გვერდი', 'ეს გვერდი არის განკუთვილი რაღაცისთვის.', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slogans`
--

CREATE TABLE `slogans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slogan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `texts`
--

CREATE TABLE `texts` (
  `text_id` bigint(20) UNSIGNED NOT NULL,
  `params` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_id` int(11) NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `texts`
--

INSERT INTO `texts` (`text_id`, `params`, `lang_id`, `text`, `created_at`, `updated_at`) VALUES
(1, 'get_first_frame_slogan', 1, 'ტექსტი', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `tour_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `tour_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tour_price` int(11) NOT NULL,
  `limited_member` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`tour_id`, `user_id`, `tour_name`, `description`, `tour_price`, `limited_member`, `created_at`, `updated_at`) VALUES
(1, 5, 'Going to racha ,the favourite place at georgia', 'Racha is a highland area in western Georgia,', 20, 5, '2020-02-23 18:28:57', '2020-02-23 18:28:57'),
(8, 9, 'ssssss', 'assssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 2000, 10, '2020-03-03 12:34:53', '2020-03-03 12:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `tour_images`
--

CREATE TABLE `tour_images` (
  `tour_image_id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tour_images`
--

INSERT INTO `tour_images` (`tour_image_id`, `tour_id`, `user_id`, `image_url`, `created_at`, `updated_at`) VALUES
(2, 1, 5, 'eventImages/1582529425.jpg', '2020-02-24 03:30:25', '2020-02-24 03:30:25'),
(3, 1, 5, 'eventImages/1582529529.jpg', '2020-02-24 03:32:09', '2020-02-24 03:32:09'),
(4, 1, 5, 'eventImages/1582530136.PNG', '2020-02-24 03:42:16', '2020-02-24 03:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `tour_likes`
--

CREATE TABLE `tour_likes` (
  `tour_like_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_members`
--

CREATE TABLE `tour_members` (
  `tour_member_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `person_quantity` int(11) NOT NULL DEFAULT 0,
  `child_quantity` int(11) NOT NULL DEFAULT 0,
  `baby_quantity` int(11) NOT NULL DEFAULT 0,
  `accepted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_musics`
--

CREATE TABLE `tour_musics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_ratings`
--

CREATE TABLE `tour_ratings` (
  `tour_rating_id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `star` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_reviews`
--

CREATE TABLE `tour_reviews` (
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_review_likes`
--

CREATE TABLE `tour_review_likes` (
  `review_like_id` bigint(20) UNSIGNED NOT NULL,
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_review_reply_likes`
--

CREATE TABLE `tour_review_reply_likes` (
  `review_reply_id` bigint(20) UNSIGNED NOT NULL,
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour_unlikes`
--

CREATE TABLE `tour_unlikes` (
  `unlike_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tour_viewers`
--

CREATE TABLE `tour_viewers` (
  `viewer_id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tout_image_filters`
--

CREATE TABLE `tout_image_filters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `example_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'saba', 'torikashvili', 'torikabot@gmail.com', 1, NULL, '$2y$10$Cl28vOCvTB6XTvDS82A4IOchQ4ULFgIOTsvges2G6ZNaR6kn/KN8W', NULL, '2020-02-23 09:25:29', '2020-02-23 09:25:29'),
(6, 'ივერი', 'meskhi', 'iveri.mesxi@gmail.com', 1, NULL, '$2y$10$.9r.7txUiPVuB6RTOlOh9OM8g1ZmuIzNNEQrxloRkI1yo5Onh3Toq', NULL, '2020-02-28 01:43:44', '2020-02-28 01:43:44'),
(7, 'Alvina', 'Alvina', 'Alvina83@gmail.com', 1, NULL, '$2y$10$lWvwK8Pb7k6L6XQ8Jtwg0.eYHTUIMJzZpPCCBF4gV/oQfs5T2Am/O', NULL, '2020-02-28 07:35:47', '2020-02-28 07:35:47'),
(8, 'dark', 'dark', 'vako.batiashvili1998@gmail.com', 1, NULL, '$2y$10$VhW0xlIKnzGlYkD02.IqReeAG7TuQT5M0w0toiB1b7zqSHZ9i.fH.', NULL, '2020-03-01 11:47:06', '2020-03-01 11:47:06'),
(9, 'Filip', 'Baravi', 'f.baravi121@gmail.com', 1, NULL, '$2y$10$9a8ML00.6/Reb6g.zVtNsex914IPe4s52zJrY7OYLck.7ou0jkmjS', NULL, '2020-03-03 12:30:05', '2020-03-03 12:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_followers`
--

CREATE TABLE `user_followers` (
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_images`
--

CREATE TABLE `user_images` (
  `user_image_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `equiped` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_images`
--

INSERT INTO `user_images` (`user_image_id`, `image_url`, `user_id`, `equiped`, `created_at`, `updated_at`) VALUES
(28, 'uploadedImage/1582485223.jpg', 5, 0, '2020-02-23 15:13:43', '2020-02-23 15:14:38'),
(29, 'uploadedImage/1582485278.jpg', 5, 0, '2020-02-23 15:14:38', '2020-02-23 15:15:01'),
(30, 'uploadedImage/1582485301.jpg', 5, 1, '2020-02-23 15:15:01', '2020-02-23 15:15:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_rankings`
--

CREATE TABLE `user_rankings` (
  `rank_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `rank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tour_bookmarks`
--

CREATE TABLE `user_tour_bookmarks` (
  `tour_bookmark_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL,
  `marked` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tour_shares`
--

CREATE TABLE `user_tour_shares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tour_id` int(11) NOT NULL,
  `share_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `versions`
--

CREATE TABLE `versions` (
  `version_id` bigint(20) UNSIGNED NOT NULL,
  `version` int(11) NOT NULL,
  `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `versions`
--

INSERT INTO `versions` (`version_id`, `version`, `method`, `created_at`, `updated_at`) VALUES
(1, 1, 'get_first_frame', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bg_images`
--
ALTER TABLE `bg_images`
  ADD PRIMARY KEY (`bg_id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `image_crops`
--
ALTER TABLE `image_crops`
  ADD PRIMARY KEY (`crop_image_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logged_users`
--
ALTER TABLE `logged_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loggers`
--
ALTER TABLE `loggers`
  ADD PRIMARY KEY (`logger_id`);

--
-- Indexes for table `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `slogans`
--
ALTER TABLE `slogans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `texts`
--
ALTER TABLE `texts`
  ADD PRIMARY KEY (`text_id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`tour_id`);

--
-- Indexes for table `tour_images`
--
ALTER TABLE `tour_images`
  ADD PRIMARY KEY (`tour_image_id`);

--
-- Indexes for table `tour_likes`
--
ALTER TABLE `tour_likes`
  ADD PRIMARY KEY (`tour_like_id`);

--
-- Indexes for table `tour_members`
--
ALTER TABLE `tour_members`
  ADD PRIMARY KEY (`tour_member_id`),
  ADD UNIQUE KEY `tour_members_user_id_unique` (`user_id`);

--
-- Indexes for table `tour_musics`
--
ALTER TABLE `tour_musics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tour_ratings`
--
ALTER TABLE `tour_ratings`
  ADD PRIMARY KEY (`tour_rating_id`),
  ADD UNIQUE KEY `tour_ratings_user_id_unique` (`user_id`);

--
-- Indexes for table `tour_reviews`
--
ALTER TABLE `tour_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `tour_review_likes`
--
ALTER TABLE `tour_review_likes`
  ADD PRIMARY KEY (`review_like_id`);

--
-- Indexes for table `tour_review_reply_likes`
--
ALTER TABLE `tour_review_reply_likes`
  ADD PRIMARY KEY (`review_reply_id`);

--
-- Indexes for table `tour_unlikes`
--
ALTER TABLE `tour_unlikes`
  ADD PRIMARY KEY (`unlike_id`);

--
-- Indexes for table `tour_viewers`
--
ALTER TABLE `tour_viewers`
  ADD PRIMARY KEY (`viewer_id`);

--
-- Indexes for table `tout_image_filters`
--
ALTER TABLE `tout_image_filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_followers`
--
ALTER TABLE `user_followers`
  ADD PRIMARY KEY (`follower_id`);

--
-- Indexes for table `user_images`
--
ALTER TABLE `user_images`
  ADD PRIMARY KEY (`user_image_id`);

--
-- Indexes for table `user_rankings`
--
ALTER TABLE `user_rankings`
  ADD PRIMARY KEY (`rank_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tour_bookmarks`
--
ALTER TABLE `user_tour_bookmarks`
  ADD PRIMARY KEY (`tour_bookmark_id`),
  ADD UNIQUE KEY `user_tour_bookmarks_tour_id_unique` (`tour_id`);

--
-- Indexes for table `user_tour_shares`
--
ALTER TABLE `user_tour_shares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `versions`
--
ALTER TABLE `versions`
  ADD PRIMARY KEY (`version_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bg_images`
--
ALTER TABLE `bg_images`
  MODIFY `bg_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `color_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `image_crops`
--
ALTER TABLE `image_crops`
  MODIFY `crop_image_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logged_users`
--
ALTER TABLE `logged_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loggers`
--
ALTER TABLE `loggers`
  MODIFY `logger_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `logos`
--
ALTER TABLE `logos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slogans`
--
ALTER TABLE `slogans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `texts`
--
ALTER TABLE `texts`
  MODIFY `text_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tour_images`
--
ALTER TABLE `tour_images`
  MODIFY `tour_image_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tour_likes`
--
ALTER TABLE `tour_likes`
  MODIFY `tour_like_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_members`
--
ALTER TABLE `tour_members`
  MODIFY `tour_member_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_musics`
--
ALTER TABLE `tour_musics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_ratings`
--
ALTER TABLE `tour_ratings`
  MODIFY `tour_rating_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_reviews`
--
ALTER TABLE `tour_reviews`
  MODIFY `review_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_review_likes`
--
ALTER TABLE `tour_review_likes`
  MODIFY `review_like_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_review_reply_likes`
--
ALTER TABLE `tour_review_reply_likes`
  MODIFY `review_reply_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_unlikes`
--
ALTER TABLE `tour_unlikes`
  MODIFY `unlike_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour_viewers`
--
ALTER TABLE `tour_viewers`
  MODIFY `viewer_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tout_image_filters`
--
ALTER TABLE `tout_image_filters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_followers`
--
ALTER TABLE `user_followers`
  MODIFY `follower_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_images`
--
ALTER TABLE `user_images`
  MODIFY `user_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_rankings`
--
ALTER TABLE `user_rankings`
  MODIFY `rank_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tour_bookmarks`
--
ALTER TABLE `user_tour_bookmarks`
  MODIFY `tour_bookmark_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tour_shares`
--
ALTER TABLE `user_tour_shares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `versions`
--
ALTER TABLE `versions`
  MODIFY `version_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
