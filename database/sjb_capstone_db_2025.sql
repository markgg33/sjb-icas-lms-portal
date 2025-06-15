-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2025 at 08:24 PM
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
(21, 3, 21, 3),
(22, 3, 22, 3),
(24, 1, 23, 1);

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
(26, 1, 22, '3', '2025-2026', '2025-06-15 17:24:22'),
(27, 1, 21, '3', '2025-2026', '2025-06-15 17:25:48'),
(29, 1, 23, '1', '2025-2026', '2025-06-15 18:22:19');

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
(3, 3, 2, '3', '2025-2026', 3, '2025-06-15 12:17:10'),
(4, 3, 20, '3', '2025-2026', 3, '2025-06-15 13:19:09');

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

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `from_user_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_type` enum('student','faculty','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `from_user_id`, `type`, `message`, `url`, `is_read`, `created_at`, `user_type`) VALUES
(1, 2, 1, 'TOR', 'New `TOR` request from student #1', 'adminDashboard.php#requests-page', 0, '2025-06-10 16:28:57', 'student'),
(2, 1, 2, 'TOR', 'Your `TOR` request has been Approved.', 'studentDashboard.php#requests-page', 1, '2025-06-10 16:29:03', 'student'),
(3, 2, 1, 'Good Moral', 'New `Good Moral` request from student #1', 'adminDashboard.php#requests-page', 0, '2025-06-15 07:39:56', 'student'),
(4, 1, 2, 'Good Moral', 'Your `Good Moral` request has been Approved.', 'studentDashboard.php#requests-page', 1, '2025-06-15 07:40:32', 'student'),
(5, 2, 1, 'TOR', 'New `TOR` request from student #1', 'adminDashboard.php#requests-page', 0, '2025-06-15 07:41:05', 'student'),
(6, 1, 2, 'TOR', 'Your `TOR` request has been Rejected.', 'studentDashboard.php#requests-page', 1, '2025-06-15 07:41:17', 'student'),
(7, 2, 1, 'Good Moral', 'New `Good Moral` request from student #1', 'adminDashboard.php#requests-page', 1, '2025-06-15 08:00:09', 'admin'),
(8, 2, 1, 'Good Moral', 'New `Good Moral` request from student #1', 'adminDashboard.php#requests-page', 1, '2025-06-15 08:20:50', 'admin'),
(9, 1, 2, 'Good Moral', 'Your `Good Moral` request has been Approved.', 'studentDashboard.php#requests-page', 1, '2025-06-15 08:21:08', 'student'),
(10, 1, 2, 'Good Moral', 'Your `Good Moral` request has been Approved.', 'studentDashboard.php#requests-page', 1, '2025-06-15 08:21:35', 'student'),
(11, 2, 1, 'TOR', 'New `TOR` request from student #1', 'adminDashboard.php#requests-page', 1, '2025-06-15 08:22:35', 'admin'),
(12, 1, 2, 'TOR', 'Your `TOR` request has been Approved.', 'studentDashboard.php#requests-page', 1, '2025-06-15 08:22:51', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `student_id`, `type`, `description`, `status`, `created_at`, `updated_at`, `admin_id`) VALUES
(1, 1, 'TOR', 'TOR Request sample', 'Approved', '2025-06-10 16:28:57', NULL, NULL),
(2, 1, 'Good Moral', 'Requesting Good Moral Certificate', 'Approved', '2025-06-15 07:39:56', NULL, NULL),
(3, 1, 'TOR', '', 'Rejected', '2025-06-15 07:41:05', NULL, NULL),
(4, 1, 'Good Moral', '', 'Approved', '2025-06-15 08:00:09', NULL, NULL),
(5, 1, 'Good Moral', '', 'Approved', '2025-06-15 08:20:50', NULL, NULL),
(6, 1, 'TOR', '', 'Approved', '2025-06-15 08:22:35', NULL, NULL);

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
(1, 'SJB-2025-0001', 'Mark Francis', 'Perez', 'De Guzman', 'deguzmanmarkfrancisp@gmail.com', '$2y$10$W7ECe9jHimSxPo3jBQY0zO.BLyacinauQQqBOenb9TXm4GhElggvC', 3, 3, '1997-12-10', 'uploads/students/1748892856_student.nef', '2025-05-21 22:57:39', 2560.00),
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
  `semester` int(11) NOT NULL,
  `units` int(11) NOT NULL DEFAULT 9
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `code`, `name`, `semester`, `units`) VALUES
(21, 'CAP102', 'Capstone II', 3, 3),
(22, 'ITPRJMA', 'IT Project Management', 3, 3),
(23, 'PE2', 'Physical Education II', 1, 2);

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
(2, 'deguzmanmarkfrancisp@gmail.com', '$2y$10$IwcgutYYHrqeIGzRhVD1Ze8cN85qUjNieA9vrjUjzLarvNsSD6qiS', 'admin', '2025-05-29 05:21:57', 'Mark Francis', 'Perez', 'De Guzman', 'Male', 'uploads/users/1749564796_user.JPG'),
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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `admin_id` (`admin_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `faculty_subjects`
--
ALTER TABLE `faculty_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
