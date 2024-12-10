-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 06:15 PM
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
-- Table structure for table `adoption_agencies`
--

CREATE TABLE `adoption_agencies` (
  `agency_id` int(11) NOT NULL,
  `agency_name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `registration_number` varchar(50) DEFAULT NULL,
  `director_name` varchar(100) DEFAULT NULL,
  `number_of_cases_handled` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption_agencies`
--

INSERT INTO `adoption_agencies` (`agency_id`, `agency_name`, `location`, `contact_info`, `registration_number`, `director_name`, `number_of_cases_handled`) VALUES
(1, 'Adoption Care', '789 Agency Blvd.', '555-555-5557', 'REG-003', 'Charlie Brown', 200);

-- --------------------------------------------------------

--
-- Table structure for table `adoption_applications`
--

CREATE TABLE `adoption_applications` (
  `application_id` int(11) NOT NULL,
  `child_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `application_date` date DEFAULT NULL,
  `application_status` enum('pending','under review','approved','rejected') NOT NULL,
  `review_notes` text DEFAULT NULL,
  `final_decision_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption_applications`
--

INSERT INTO `adoption_applications` (`application_id`, `child_id`, `parent_id`, `application_date`, `application_status`, `review_notes`, `final_decision_date`) VALUES
(1, 1, 1, '2023-09-10', 'under review', 'Initial meeting scheduled', '2023-10-15');

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
  `status` enum('available for adoption','in-process','adopted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`child_id`, `full_name`, `date_of_birth`, `gender`, `medical_history`, `psychological_history`, `education_level`, `current_orphanage_id`, `status`) VALUES
(1, 'John Doe', '2015-05-10', 'male', 'Asthma: Requires inhaler, Regular checkups', 'Mild anxiety: Regular counseling sessions recommended', 'Grade 3', 1, 'available for adoption'),
(2, 'Jane Smith', '2016-12-20', 'female', 'Healthy', 'No psychological issues', 'Grade 2', 1, 'in-process');

-- --------------------------------------------------------

--
-- Table structure for table `health_records`
--

CREATE TABLE `health_records` (
  `record_id` int(11) NOT NULL,
  `child_id` int(11) DEFAULT NULL,
  `record_type` enum('medical','psychological') NOT NULL,
  `condition_name` varchar(255) NOT NULL,
  `treatment` text DEFAULT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `psychologist_name` varchar(100) DEFAULT NULL,
  `assessment_date` date DEFAULT NULL,
  `findings` text DEFAULT NULL,
  `recommendations` text DEFAULT NULL,
  `treatment_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `health_records`
--

INSERT INTO `health_records` (`record_id`, `child_id`, `record_type`, `condition_name`, `treatment`, `doctor_name`, `psychologist_name`, `assessment_date`, `findings`, `recommendations`, `treatment_date`, `remarks`) VALUES
(1, 1, 'medical', 'Asthma', 'Prescribed inhaler', 'Dr. Sarah Connor', NULL, '2023-08-01', NULL, NULL, '2023-08-10', 'Regular check-ups needed'),
(2, 2, 'medical', 'Allergy', 'Antihistamines', 'Dr. John Doe', NULL, '2023-06-15', NULL, NULL, '2023-06-20', 'Avoid nuts'),
(3, 1, 'psychological', 'Mild Anxiety', NULL, NULL, 'Dr. Jane Smith', '2023-09-15', 'Shows signs of anxiety in social situations', 'Recommend counseling sessions', NULL, 'Follow-up in 3 months');

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
-- Table structure for table `orphanage_staff`
--

CREATE TABLE `orphanage_staff` (
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `orphanage_id` int(11) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orphanage_staff`
--

INSERT INTO `orphanage_staff` (`staff_id`, `user_id`, `orphanage_id`, `role`) VALUES
(1, 2, 1, 'Caregiver'),
(2, 3, 2, 'Counselor');

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
(1, 1, 1, '2024-01-15', 'pending', 'Check-in with the new family', '2024-03-01');

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
  `status` enum('in-process','approved','rejected') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prospective_parents`
--

INSERT INTO `prospective_parents` (`parent_id`, `user_id`, `full_name`, `home_address`, `occupation`, `marital_status`, `home_study_status`, `preferences`, `status`) VALUES
(1, 4, 'Mary Johnson', '789 Family Lane', 'Teacher', 'married', 'approved', 'Female child, age 5-8', 'in-process');

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
(3, 'Psychologist', 'School psychologist responsible for student mental health', '2024-10-19 15:33:20'),
(4, 'Nurse', 'School nurse responsible for health and medical needs', '2024-10-19 15:33:20'),
(5, 'Teacher', 'Responsible for educating students in a subject area', '2024-10-19 15:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `support_services`
--

CREATE TABLE `support_services` (
  `service_id` int(11) NOT NULL,
  `service_type` enum('counseling','medical','legal') NOT NULL,
  `provided_by` varchar(100) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `availability_schedule` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_services`
--

INSERT INTO `support_services` (`service_id`, `service_type`, `provided_by`, `contact_info`, `availability_schedule`, `notes`) VALUES
(1, 'counseling', 'Healing Hearts', '555-555-5558', 'Mon-Fri, 9AM-5PM', 'Available for trauma counseling');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','orphanage staff','adoption agency','prospective parent') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `date_joined` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `email`, `phone_number`, `date_joined`) VALUES
(1, 'admin1', 'hashed_password1', 'admin', 'admin1@example.com', '1234567890', '2024-10-19 15:33:20'),
(2, 'staff1', 'hashed_password2', 'orphanage staff', 'staff1@example.com', '0987654321', '2024-10-19 15:33:20'),
(3, 'agency1', 'hashed_password3', 'adoption agency', 'agency1@example.com', '1122334455', '2024-10-19 15:33:20'),
(4, 'parent1', 'hashed_password4', 'prospective parent', 'parent1@example.com', '5566778899', '2024-10-19 15:33:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_agencies`
--
ALTER TABLE `adoption_agencies`
  ADD PRIMARY KEY (`agency_id`);

--
-- Indexes for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`child_id`),
  ADD KEY `current_orphanage_id` (`current_orphanage_id`);

--
-- Indexes for table `health_records`
--
ALTER TABLE `health_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `orphanages`
--
ALTER TABLE `orphanages`
  ADD PRIMARY KEY (`orphanage_id`);

--
-- Indexes for table `orphanage_staff`
--
ALTER TABLE `orphanage_staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `orphanage_id` (`orphanage_id`);

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
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `support_services`
--
ALTER TABLE `support_services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption_agencies`
--
ALTER TABLE `adoption_agencies`
  MODIFY `agency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `health_records`
--
ALTER TABLE `health_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orphanages`
--
ALTER TABLE `orphanages`
  MODIFY `orphanage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orphanage_staff`
--
ALTER TABLE `orphanage_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `post_adoption_followup`
--
ALTER TABLE `post_adoption_followup`
  MODIFY `followup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prospective_parents`
--
ALTER TABLE `prospective_parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `support_services`
--
ALTER TABLE `support_services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD CONSTRAINT `adoption_applications_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `children` (`child_id`),
  ADD CONSTRAINT `adoption_applications_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `prospective_parents` (`parent_id`);

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_ibfk_1` FOREIGN KEY (`current_orphanage_id`) REFERENCES `orphanages` (`orphanage_id`) ON DELETE SET NULL;

--
-- Constraints for table `health_records`
--
ALTER TABLE `health_records`
  ADD CONSTRAINT `health_records_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `children` (`child_id`);

--
-- Constraints for table `orphanage_staff`
--
ALTER TABLE `orphanage_staff`
  ADD CONSTRAINT `orphanage_staff_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orphanage_staff_ibfk_2` FOREIGN KEY (`orphanage_id`) REFERENCES `orphanages` (`orphanage_id`);

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
  ADD CONSTRAINT `prospective_parents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
