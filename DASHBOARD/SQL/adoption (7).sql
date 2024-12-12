-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 11:18 AM
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
-- Database: `adoption`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption_requests`
--

CREATE TABLE `adoption_requests` (
  `adoption_request_number` varchar(20) NOT NULL,
  `adopter_name` varchar(255) NOT NULL,
  `adopter_email` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `home_address` text NOT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `preferences` text DEFAULT NULL,
  `national_id_number` varchar(50) NOT NULL,
  `annual_income` decimal(15,2) DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `picture` blob DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `code_of_conduct_file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption_requests`
--

INSERT INTO `adoption_requests` (`adoption_request_number`, `adopter_name`, `adopter_email`, `contact_number`, `status`, `home_address`, `occupation`, `marital_status`, `preferences`, `national_id_number`, `annual_income`, `additional_notes`, `picture`, `parent_id`, `code_of_conduct_file_path`, `created_at`) VALUES
('REQ-6746F17F6C2FFDB5', 'David Brown', 'davidjnr@gmail.com', '0765234567', 'accepted', 'Limuru', 'Film director', 'single', 'I prefer a teenager', '7829090289', 400000.00, 'Thank you', 0x75706c6f6164732f61646d696e2e6a7067, 5, 'uploads/Cover letter.docx', '2024-11-27 10:16:31'),
('REQ-6746FCF2516F3E68', 'Sharon Mwingi', 'sharon45@gmail.com', '0712456789', 'accepted', 'Nairobi', 'Doctor', 'married', 'We prefer a toddler', '2056789643', 500000.00, 'Thank you', 0x75706c6f6164732f61646d696e2e6a7067, 6, 'uploads/Cover letter.docx', '2024-11-27 11:05:22');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `child_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `medical_history` text DEFAULT NULL,
  `psychological_history` text DEFAULT NULL,
  `education_level` varchar(50) DEFAULT NULL,
  `current_orphanage_id` int(11) DEFAULT NULL,
  `status` enum('available for adoption','in-process','adopted') NOT NULL,
  `blood_group` varchar(5) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `date_found` date DEFAULT NULL,
  `city_found` varchar(100) DEFAULT NULL,
  `disability` enum('yes','no') DEFAULT NULL,
  `allergies` enum('yes','no') DEFAULT NULL,
  `disability_description` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `social_worker_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`child_id`, `full_name`, `date_of_birth`, `gender`, `medical_history`, `psychological_history`, `education_level`, `current_orphanage_id`, `status`, `blood_group`, `image_path`, `date_found`, `city_found`, `disability`, `allergies`, `disability_description`, `notes`, `social_worker_id`) VALUES
(1, 'John Doe', '2016-12-04', 'male', 'Asthma: Requires inhaler, Regular checkups', 'Mild anxiety: Regular counseling sessions recommended', 'Senior Secondary', 1, 'available for adoption', 'AB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Jane Smith', '2016-12-20', 'female', 'Healthy', 'No psychological issues', 'Primary School', 1, 'in-process', 'O-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Ness Varrly', '2016-04-03', 'female', NULL, NULL, 'high school', 1, 'available for adoption', 'AB-', 'uploads/1730683058_851fd420fc.jpg', '2024-06-11', 'nairobi', 'no', 'no', 'null', 'is good', NULL),
(4, 'Gusto Nikael', '2014-09-08', 'male', NULL, NULL, 'Primary School', 1, 'adopted', 'A-', 'uploads/1730685533_d4802a35eb.jpg', '2021-10-06', 'limuru', 'no', 'no', 'null', '', NULL),
(5, 'John Brave', '2015-05-10', 'male', 'Asthma: Requires inhaler, Regular checkups', 'Mild anxiety: Regular counseling sessions recommended', 'Grade 3', 1, 'adopted', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'henk steve', '2020-09-11', 'male', NULL, NULL, 'Early Childhood Education', 1, 'available for adoption', 'AB+', 'uploads/1731254100_d42d66fa36.jpg', '2024-11-01', 'thika', 'no', 'no', 'null', 'happy child', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `home_study_applications`
--

CREATE TABLE `home_study_applications` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `home_address` text NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `marital_status` varchar(100) NOT NULL,
  `health_status` text DEFAULT NULL,
  `annual_income` decimal(10,2) NOT NULL,
  `references` text NOT NULL,
  `criminal_record` enum('yes','no') NOT NULL,
  `code_of_conduct` varchar(255) NOT NULL,
  `adopt_reason` text NOT NULL,
  `additional_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('pending','accepted','rejected','submitted') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_study_applications`
--

INSERT INTO `home_study_applications` (`id`, `parent_id`, `full_name`, `home_address`, `occupation`, `marital_status`, `health_status`, `annual_income`, `references`, `criminal_record`, `code_of_conduct`, `adopt_reason`, `additional_notes`, `created_at`, `updated_at`, `status`) VALUES
(9, 5, 'David Brown', 'Limuru', 'Film director', 'single', 'I am healthy', 400000.00, 'David Brown -0765342178\r\nMary Wangui -0754321780', '', 'uploads/Cover letter.docx', 'I am impotent', 'heyyy', '2024-12-11 03:39:14', '2024-12-11 17:18:49', 'accepted'),
(10, 6, 'Sharon Mwingi', 'Nairobi', 'Doctor', 'married', 'I am healthy', 400000.00, '', 'no', '0', 'I am barren', '', '2024-12-11 17:06:42', '2024-12-11 17:06:42', 'submitted');

--
-- Triggers `home_study_applications`
--
DELIMITER $$
CREATE TRIGGER `update_status_in_prospective_parents` AFTER UPDATE ON `home_study_applications` FOR EACH ROW BEGIN
    -- Update the status in prospective_parents to match home_study_applications
    UPDATE prospective_parents
    SET status = NEW.status
    WHERE status IS NULL AND parent_id = NEW.parent_id; -- Corrected to use parent_id
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `match_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `date_assigned` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`match_id`, `parent_id`, `child_id`, `date_assigned`) VALUES
(1, 5, 4, '2024-12-12 08:56:06');

-- --------------------------------------------------------

--
-- Table structure for table `orphanages`
--

CREATE TABLE `orphanages` (
  `orphanage_id` int(11) NOT NULL,
  `orphanage_name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `registration_number` varchar(50) DEFAULT NULL,
  `manager_name` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `number_of_children` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orphanages`
--

INSERT INTO `orphanages` (`orphanage_id`, `orphanage_name`, `location`, `contact_info`, `registration_number`, `manager_name`, `capacity`, `number_of_children`) VALUES
(1, 'Happy Homes', '123 Orphanage St.', '555-555-5555', 'REG-001', 'Alice Johnson', 50, 30),
(2, 'Safe Haven', '456 Safe St.', '555-555-5556', 'REG-002', 'Bob Williams', 60, 40);

-- --------------------------------------------------------

--
-- Table structure for table `post_adoption_followup`
--

CREATE TABLE `post_adoption_followup` (
  `followup_id` int(11) NOT NULL,
  `child_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `followup_date` date DEFAULT NULL,
  `followup_status` enum('pending','completed') DEFAULT NULL,
  `followup_notes` text DEFAULT NULL,
  `next_followup_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_adoption_followup`
--

INSERT INTO `post_adoption_followup` (`followup_id`, `child_id`, `parent_id`, `followup_date`, `followup_status`, `followup_notes`, `next_followup_date`) VALUES
(2, 5, 5, '2024-12-11', 'pending', 'Pending', '2024-12-17'),
(4, 3, 7, '2024-12-11', '', 'The kid is settled', '2024-12-29');

-- --------------------------------------------------------

--
-- Table structure for table `prospective_parents`
--

CREATE TABLE `prospective_parents` (
  `parent_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `marital_status` enum('single','married','divorced','widowed') NOT NULL,
  `home_study_status` enum('in-process','approved','rejected') DEFAULT NULL,
  `preferences` text DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `status` enum('pending','accepted','rejected','submitted') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prospective_parents`
--

INSERT INTO `prospective_parents` (`parent_id`, `user_id`, `full_name`, `home_address`, `occupation`, `marital_status`, `home_study_status`, `preferences`, `date_of_birth`, `status`) VALUES
(3, 8, 'ness varrly', 'thika', 'Doctor', 'married', NULL, 'kid from 1 -15', '1970-01-01', NULL),
(4, 9, 'Brian Mwangi', 'Nairobi', 'Nurse', 'married', NULL, 'I prefer a kid who is 10 years', '1970-01-01', NULL),
(5, 15, 'David Brown', 'Limuru', 'Film director', 'single', NULL, 'I prefer a teenager', '1970-01-01', 'accepted'),
(6, 16, 'Sharon Mwingi', 'Nairobi', 'Doctor', 'married', NULL, 'We prefer a toddler', '1970-01-01', 'submitted'),
(7, 17, 'Ashley Kuna', 'Kiambu', 'Business lady', 'married', NULL, 'I prefer a toddler', '0000-00-00', NULL),
(8, 18, 'Anne Chloe', 'Nairobi', 'Nurse', 'single', NULL, 'I prefer a teenager', '1976-06-02', NULL),
(9, 19, 'Kevin Mwangi', 'Limuru', 'Film director', 'single', NULL, 'I prefer a boy', '1975-09-12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`RoleID`, `RoleName`, `Description`, `CreatedAt`) VALUES
(1, 'Admin', 'Administrator with full access to the system', '2024-10-19 15:33:20'),
(2, 'Parent', 'Parent or guardian of a student', '2024-10-19 15:33:20'),
(6, 'user', 'Standard user role', '2024-11-26 16:04:21'),
(7, 'social worker', 'Social worker with restricted access', '2024-12-09 04:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `social_workers`
--

CREATE TABLE `social_workers` (
  `social_worker_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `hire_date` date DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `date_joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phone_number`, `date_joined`, `role`) VALUES
(8, 'vee', '$2y$10$3DzMCqKGq4n/DWSjvMwRlugXpiB6Nwm1NZY4j.ZeUsvUK8ObqQi9G', 'veee3135@gmail.com', NULL, '2024-11-10 13:49:22', 2),
(9, 'Brian', '$2y$10$RcyoXCEDnLeQ4iZaI7lWGeAaDPScQ.Bl13CDnV6.GsiP2o.PtSGji', 'brian24@gmail.com', NULL, '2024-11-12 05:25:55', 2),
(15, 'David', '$2y$10$lzd.Hq1oUII1lQPwpl3AZueUvZQRIHGe7jKnP1jvqCZP07pY80HCi', 'davidjnr23@gmail.com', NULL, '2024-11-26 16:05:40', 2),
(16, 'Sharon', '$2y$10$A7UQLG.n0ZqLLBqfFAUdvOGuEShmIcmXwJGfddLB66Na8D3FlrWYi', 'sharon45@gmail.com', NULL, '2024-11-26 20:28:30', 2),
(17, 'Ashley', '$2y$10$WMPnm2qRYvMULfwkhVQFd.Ma0e5pjOCafjpjDNrAAlONvq19d5WlK', 'ashley2040@gmail.com', NULL, '2024-12-08 04:49:12', 2),
(18, 'Anne', '$2y$10$gZJMPWS7LJcO39k7hVAek.lt.hkTvWpfTXdQiziMUeGaUbYIxqtlm', 'anne30@gmail.com', NULL, '2024-12-08 05:07:55', 2),
(19, 'Kevin Mwangi', '$2y$10$0xTwbE92U4Bdqn7zXStSP.LfmU9/USr2NTWd5lTLvIyo.8iZnSO4W', 'kevinm89@gmail.com', NULL, '2024-12-08 05:24:20', 2),
(23, 'socialworker', '$2y$10$X9qmvkrqqwhFc5TfsmzMlutufE9vfOe0dgSyMlxRW30FwLrxhhMS6', NULL, NULL, '2024-12-09 16:03:25', 7),
(25, 'Sworker', '$2y$10$.rhgdf4ANKy2GkAuoQ5aKOE.viwGdkEKj0R/hOOjDzlQpeAhHXl3i', NULL, NULL, '2024-12-10 05:49:35', 6),
(26, 'dru@gmail.com', '$2y$10$rRw7kCVaaufkiMGBBbj8auqFuDXurRqdph.cHhxkNeQpo1AtYXWHm', NULL, NULL, '2024-12-10 06:28:02', 6),
(27, 'Sue', '$2y$10$jlPPuwb/PoziYUw2BFQqb.CsXB4GGQjoKqQZ.bnndfhOC5ZG3xwnC', NULL, NULL, '2024-12-10 08:50:39', 7),
(28, 'Davis', '$2y$10$61OJ8vQDBFwyk8HSDMYS/.8t36n4zlzI61AM3lu1mJfaweyVwHAPi', 'davis452@gmail.com', NULL, '2024-12-11 05:19:49', 2),
(29, 'admin', '$2y$10$R3QVFcOMYRvIwc8HTZGeTeWqbUaClrxwJtba.du7qVhzdNowv44za', NULL, NULL, '2024-12-11 05:32:00', 1),
(30, 'davidjnr23@gmail.com', '$2y$10$2opXXBt4fdauL8k.HQQfaOyLfYj4mUO4uYaG35FbRaqsODQWIgbb6', NULL, NULL, '2024-12-11 05:33:36', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD PRIMARY KEY (`adoption_request_number`),
  ADD KEY `fk_parent_id` (`parent_id`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`child_id`),
  ADD KEY `current_orphanage_id` (`current_orphanage_id`),
  ADD KEY `social_worker_id` (`social_worker_id`);

--
-- Indexes for table `home_study_applications`
--
ALTER TABLE `home_study_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status` (`status`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `orphanages`
--
ALTER TABLE `orphanages`
  ADD PRIMARY KEY (`orphanage_id`);

--
-- Indexes for table `post_adoption_followup`
--
ALTER TABLE `post_adoption_followup`
  ADD PRIMARY KEY (`followup_id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `prospective_parents`
--
ALTER TABLE `prospective_parents`
  ADD PRIMARY KEY (`parent_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_status` (`status`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `social_workers`
--
ALTER TABLE `social_workers`
  ADD PRIMARY KEY (`social_worker_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `home_study_applications`
--
ALTER TABLE `home_study_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orphanages`
--
ALTER TABLE `orphanages`
  MODIFY `orphanage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `post_adoption_followup`
--
ALTER TABLE `post_adoption_followup`
  MODIFY `followup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prospective_parents`
--
ALTER TABLE `prospective_parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `social_workers`
--
ALTER TABLE `social_workers`
  MODIFY `social_worker_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD CONSTRAINT `fk_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `prospective_parents` (`parent_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_ibfk_1` FOREIGN KEY (`current_orphanage_id`) REFERENCES `orphanages` (`orphanage_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `children_ibfk_2` FOREIGN KEY (`social_worker_id`) REFERENCES `social_workers` (`social_worker_id`);

--
-- Constraints for table `home_study_applications`
--
ALTER TABLE `home_study_applications`
  ADD CONSTRAINT `home_study_applications_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `prospective_parents` (`parent_id`) ON DELETE CASCADE;

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `prospective_parents` (`parent_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`child_id`) REFERENCES `children` (`child_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_adoption_followup`
--
ALTER TABLE `post_adoption_followup`
  ADD CONSTRAINT `post_adoption_followup_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `children` (`child_id`),
  ADD CONSTRAINT `post_adoption_followup_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `prospective_parents` (`parent_id`);

--
-- Constraints for table `prospective_parents`
--
ALTER TABLE `prospective_parents`
  ADD CONSTRAINT `fk_status` FOREIGN KEY (`status`) REFERENCES `home_study_applications` (`status`),
  ADD CONSTRAINT `prospective_parents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `social_workers`
--
ALTER TABLE `social_workers`
  ADD CONSTRAINT `social_workers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role`) REFERENCES `role` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
