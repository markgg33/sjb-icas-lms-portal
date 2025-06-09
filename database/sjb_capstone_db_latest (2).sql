-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 12:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sjb_capstone_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `year_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `year_level`) VALUES
(7, 'Automated Office Management', 1),
(8, 'Automated Office Management', 2),
(4, 'BS Hotel Management', 3),
(3, 'BS Information Technology', 3),
(5, 'Hotel and Restaurant Services', 1),
(6, 'Hotel and Restaurant Services', 2),
(1, 'Information Technology', 1),
(2, 'Information Technology', 2);

-- --------------------------------------------------------

--
-- Table structure for table `course_subjects`
--

CREATE TABLE `course_subjects` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_subjects`
--

INSERT INTO `course_subjects` (`id`, `course_id`, `subject_id`, `semester`) VALUES
(1, 3, 2, 3),
(2, 3, 3, 2),
(3, 3, 4, 1),
(4, 3, 5, 1),
(5, 3, 6, 1),
(6, 3, 7, 1),
(7, 3, 8, 1),
(8, 3, 9, 1),
(10, 3, 10, 2),
(12, 3, 12, 2),
(13, 3, 11, 2),
(17, 3, 20, 3);

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_subjects`
--

CREATE TABLE `enrolled_subjects` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `semester` enum('1','2','3') NOT NULL,
  `school_year` varchar(9) NOT NULL,
  `date_enrolled` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolled_subjects`
--

INSERT INTO `enrolled_subjects` (`id`, `student_id`, `subject_id`, `semester`, `school_year`, `date_enrolled`) VALUES
(4, 1, 4, '1', '2025-2026', '2025-05-25 10:49:21'),
(5, 1, 5, '1', '2025-2026', '2025-05-25 10:49:21'),
(6, 1, 6, '1', '2025-2026', '2025-05-25 10:49:21'),
(7, 1, 7, '1', '2025-2026', '2025-05-25 10:49:21'),
(8, 1, 8, '1', '2025-2026', '2025-05-25 10:49:21'),
(9, 1, 9, '1', '2025-2026', '2025-05-25 10:49:21'),
(11, 1, 10, '2', '2025-2026', '2025-05-27 16:18:31'),
(13, 1, 12, '2', '2025-2026', '2025-05-27 16:18:31'),
(14, 1, 2, '3', '2025-2026', '2025-05-28 16:34:19'),
(16, 1, 11, '2', '2025-2026', '2025-05-30 05:21:16'),
(20, 1, 3, '2', '2025-2026', '2025-05-30 13:10:10'),
(21, 1, 20, '3', '2025-2026', '2025-05-31 20:07:55');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_subjects`
--

CREATE TABLE `faculty_subjects` (
  `id` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `semester` enum('1','2','3') DEFAULT NULL,
  `school_year` varchar(10) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_subjects`
--

INSERT INTO `faculty_subjects` (`id`, `faculty_id`, `subject_id`, `semester`, `school_year`, `course_id`, `assigned_at`) VALUES
(1, 3, 2, '3', '2025-2026', 3, '2025-06-04 04:48:57'),
(2, 3, 20, '3', '2025-2026', 3, '2025-06-04 04:48:57');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `school_year` varchar(20) DEFAULT NULL,
  `date_recorded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `grade`, `semester`, `school_year`, `date_recorded`) VALUES
(1, 1, 20, '1.25', '3', '2025-2026', '2025-06-04 06:29:29'),
(2, 1, 2, '2.00', '3', '2025-2026', '2025-06-05 05:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `school_id` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `school_id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `course_id`, `year_level`, `dob`, `photo`, `created_at`, `balance`) VALUES
(1, 'SJB-2025-0001', 'Mark Francis', 'Perez', 'De Guzman', 'deguzmanmarkfrancisp@gmail.com', '$2y$10$W7ECe9jHimSxPo3jBQY0zO.BLyacinauQQqBOenb9TXm4GhElggvC', 3, 3, '1997-12-10', 'uploads/students/1748892856_student.nef', '2025-05-21 22:57:39', 0.00),
(2, 'SJB-2025-0002', 'Joeanalyn', 'Diaz', 'Grande', 'joeanalyn07@gmail.com', '$2y$10$M0ZYQAzfBwZWkSObL89Ml.WmTHEnQM083i0pcMGS3y4x/WxyjHJQu', 4, 3, '1999-06-12', 'uploads/students/1749104064_student.nef', '2025-05-23 18:55:11', 0.00),
(5, 'SJB-2025-0003', 'Rainn', 'Perez', 'De Guzman', 'rainnrainndg@gmail.com', '$2y$10$DAWpD6YIsyENM6f3LQlzfO0A1rPk1Q2hAHMIS6BGJ3Acno8CEIPXy', 5, 1, '2017-10-02', 'uploads/students/1748186435_SJB_logo.png', '2025-05-25 23:20:35', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`, `semester`) VALUES
(1, 'IT102', 'C Programming', 1),
(2, 'ITPRJMA', 'IT Project Management', 3),
(3, 'CC101', 'Contact Center', 2),
(4, 'SOC102', 'Philippine Government & Constitution', 1),
(5, 'IT205', 'IT Service Management', 1),
(6, 'IT206', 'Integrative Programming Technologies 2', 1),
(7, 'SIT101', 'IT Trips and Seminars', 1),
(8, 'IT207', 'Systems Administration and Maintenance', 1),
(9, 'FELEC102', 'Personality Development', 1),
(10, 'ENTRE 1', 'Entrepreneurship', 2),
(11, 'SOC 101', 'Society and Culture w/ Family Planning', 2),
(12, 'PHILO', 'Philosophy', 2),
(18, 'CAP101', 'Capstone I', 3),
(20, 'CAP102', 'Capstone II', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','faculty') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `created_at`, `first_name`, `middle_name`, `last_name`, `gender`, `photo`) VALUES
(2, 'deguzmanmarkfrancisp@gmail.com', '$2y$10$IwcgutYYHrqeIGzRhVD1Ze8cN85qUjNieA9vrjUjzLarvNsSD6qiS', 'admin', '2025-05-29 05:21:57', 'Mark Francis', 'Perez', 'De Guzman', 'Male', NULL),
(3, 'deguzmanmarkfrancisp@sample.sjb.edu.ph', '$2y$10$mu4PGko5AZppCB5VzknDfO6wXJLUoBoadNZ7xD.geJUidshHtZt2C', 'faculty', '2025-05-31 19:25:35', 'Mark Francis', 'Perez', 'De Guzman', 'Male', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_course_name_year` (`name`,`year_level`);

--
-- Indexes for table `course_subjects`
--
ALTER TABLE `course_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `school_id` (`school_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `unique_subject_code_semester` (`code`,`semester`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `course_subjects`
--
ALTER TABLE `course_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_subjects`
--
ALTER TABLE `course_subjects`
  ADD CONSTRAINT `course_subjects_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  ADD CONSTRAINT `enrolled_subjects_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrolled_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
