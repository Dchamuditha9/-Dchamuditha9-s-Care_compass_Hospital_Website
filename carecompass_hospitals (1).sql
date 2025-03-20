-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 06:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carecompass_hospitals`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(3) NOT NULL,
  `user_name` varchar(225) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `user_name`, `email`, `password`) VALUES
(3, 'admin1', 'admin1@email.com', 'admin1'),
(4, 'admin2', 'admin2@email.com', 'admin2');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `a_id` int(11) NOT NULL,
  `specialization` enum('Cardiologist','Gynecologist','Physician','Pediatrician') NOT NULL,
  `a_date` date NOT NULL,
  `branch` enum('colombo','kandy','kurunagala','') NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `patient_id` int(12) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `allocated_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`a_id`, `specialization`, `a_date`, `branch`, `status`, `patient_id`, `doctor_id`, `allocated_time`) VALUES
(9, 'Pediatrician', '2025-03-19', 'colombo', 'Scheduled', 3, 1, '09:00:00'),
(10, 'Physician', '2025-03-21', 'colombo', 'Scheduled', 3, 2, '10:30:00'),
(11, 'Gynecologist', '2025-03-23', 'colombo', 'Scheduled', 3, 3, '11:00:00'),
(12, 'Cardiologist', '2025-03-25', 'colombo', 'Scheduled', 3, 4, '14:00:00'),
(13, 'Pediatrician', '2025-03-20', 'colombo', 'Scheduled', 3, 5, '16:00:00'),
(14, 'Physician', '2025-03-21', 'kandy', 'Scheduled', 3, 6, '09:30:00'),
(15, 'Gynecologist', '2025-03-21', 'kandy', 'Scheduled', 3, 7, '10:45:00'),
(16, 'Cardiologist', '2025-03-24', 'kandy', 'Scheduled', 3, 8, '12:00:00'),
(17, 'Pediatrician', '2025-03-23', 'kandy', 'Scheduled', 3, 9, '14:30:00'),
(18, 'Physician', '2025-03-16', 'kandy', 'Scheduled', 3, 10, '15:45:00'),
(19, 'Gynecologist', '2025-03-18', '', 'Scheduled', 3, 11, '08:30:00'),
(20, 'Cardiologist', '2025-03-24', '', 'Scheduled', 3, 12, '10:00:00'),
(21, 'Pediatrician', '2025-03-20', '', 'Scheduled', 3, 13, '11:30:00'),
(22, 'Physician', '2025-03-23', '', 'Scheduled', 3, 14, '13:15:00'),
(23, 'Gynecologist', '2025-03-19', '', 'Scheduled', 3, 15, '15:00:00'),
(24, 'Cardiologist', '2025-03-22', 'colombo', 'Scheduled', 3, 16, '09:45:00'),
(25, 'Pediatrician', '2025-03-25', 'kandy', 'Scheduled', 3, 17, '11:15:00'),
(26, 'Physician', '2025-03-16', '', 'Scheduled', 3, 18, '13:30:00'),
(27, 'Gynecologist', '2025-03-19', 'colombo', 'Scheduled', 3, 19, '15:30:00'),
(28, 'Cardiologist', '2025-03-20', 'kandy', 'Scheduled', 3, 20, '08:00:00'),
(29, 'Pediatrician', '2025-03-18', '', 'Scheduled', 3, 21, '10:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `appointments_opd`
--

CREATE TABLE `appointments_opd` (
  `full_name` varchar(225) NOT NULL,
  `age` int(3) NOT NULL,
  `branch` enum('Colombo','Kandy','Kurunagala','') NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_id` int(12) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments_opd`
--

INSERT INTO `appointments_opd` (`full_name`, `age`, `branch`, `appointment_time`, `appointment_id`, `date`) VALUES
('Dushan', 24, 'Colombo', '09:00:00', 6, '2025-04-04'),
('Dushan', 24, 'Colombo', '09:00:00', 7, '2025-04-04'),
('Dushan', 24, 'Colombo', '09:00:00', 8, '2025-04-04');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `specialization` enum('Pediatrician','Physician','Gynecologist','Cardiologist') NOT NULL,
  `available_time` time NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `branch` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `doctor_name`, `specialization`, `available_time`, `phone`, `email`, `password`, `branch`) VALUES
(1, 'Dr. A. Silva', 'Pediatrician', '09:00:00', '0771234567', 'a.silva@hospital.com', 'doctor', 'Colombo'),
(2, 'Dr. B. Perera', 'Physician', '10:30:00', '0772345678', 'b.perera@hospital.com', 'doctor', 'Colombo'),
(3, 'Dr. C. Fernando', 'Gynecologist', '11:00:00', '0773456789', 'c.fernando@hospital.com', 'doctor', 'Colombo'),
(4, 'Dr. D. Jayawardena', 'Cardiologist', '14:00:00', '0774567890', 'd.jayawardena@hospital.com', 'doctor', 'Colombo'),
(5, 'Dr. E. Wickramasinghe', 'Pediatrician', '16:00:00', '0775678901', 'e.wickramasinghe@hospital.com', 'doctor', 'Colombo'),
(6, 'Dr. F. Ratnayake', 'Physician', '09:30:00', '0776789012', 'f.ratnayake@hospital.com', 'doctor', 'Kandy'),
(7, 'Dr. G. Tennakoon', 'Gynecologist', '10:45:00', '0777890123', 'g.tennakoon@hospital.com', 'doctor', 'Kandy'),
(8, 'Dr. H. Weerasinghe', 'Cardiologist', '12:00:00', '0778901234', 'h.weerasinghe@hospital.com', 'doctor', 'Kandy'),
(9, 'Dr. I. De Silva', 'Pediatrician', '14:30:00', '0779012345', 'i.desilva@hospital.com', 'doctor', 'Kandy'),
(10, 'Dr. J. Karunaratne', 'Physician', '15:45:00', '0770123456', 'j.karunaratne@hospital.com', 'doctor', 'Kandy'),
(11, 'Dr. K. Amarasinghe', 'Gynecologist', '08:30:00', '0771236789', 'k.amarasinghe@hospital.com', 'doctor', 'Kurunegala'),
(12, 'Dr. L. Senanayake', 'Cardiologist', '10:00:00', '0772347890', 'l.senanayake@hospital.com', 'doctor', 'Kurunegala'),
(13, 'Dr. M. Gunawardena', 'Pediatrician', '11:30:00', '0773458901', 'm.gunawardena@hospital.com', 'doctor', 'Kurunegala'),
(14, 'Dr. N. Ekanayake', 'Physician', '13:15:00', '0774569012', 'n.ekanayake@hospital.com', 'doctor', 'Kurunegala'),
(15, 'Dr. O. Alwis', 'Gynecologist', '15:00:00', '0775670123', 'o.alwis@hospital.com', 'doctor', 'Kurunegala'),
(16, 'Dr. P. Bandara', 'Cardiologist', '09:45:00', '0776781234', 'p.bandara@hospital.com', 'doctor', 'Colombo'),
(17, 'Dr. Q. Rajapaksa', 'Pediatrician', '11:15:00', '0777892345', 'q.rajapaksa@hospital.com', 'doctor', 'Kandy'),
(18, 'Dr. R. Jayasooriya', 'Physician', '13:30:00', '0778903456', 'r.jayasooriya@hospital.com', 'doctor', 'Kurunegala'),
(19, 'Dr. S. Dias', 'Gynecologist', '15:30:00', '0779014567', 's.dias@hospital.com', 'doctor', 'Colombo'),
(20, 'Dr. T. Wijesinghe', 'Cardiologist', '08:00:00', '0770125678', 't.wijesinghe@hospital.com', 'doctor', 'Kandy'),
(21, 'Dr. U. Fonseka', 'Pediatrician', '10:15:00', '0771236789', 'u.fonseka@hospital.com', 'doctor', 'Kurunegala');

-- --------------------------------------------------------

--
-- Table structure for table `medical_reports`
--

CREATE TABLE `medical_reports` (
  `receipt_id` int(12) NOT NULL,
  `report_name` int(11) NOT NULL,
  `report_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `patient_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(12) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `full_name`, `email`, `password`, `age`, `phone`, `created_at`) VALUES
(3, 'Dushan Chamuditha', 'micheldushan95@gmail.com', '$2y$10$19Q/R6wYOGImvacd3yJR7.5bj1gUvfM8eCJKJ058Em6xlkl6Qmok.', 23, '0719549345', '2025-02-20 14:11:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`a_id`),
  ADD KEY `fk_patient_id` (`patient_id`),
  ADD KEY `fk_doctor` (`doctor_id`);

--
-- Indexes for table `appointments_opd`
--
ALTER TABLE `appointments_opd`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `doc_name` (`doctor_name`);

--
-- Indexes for table `medical_reports`
--
ALTER TABLE `medical_reports`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `fk_1` (`patient_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `appointments_opd`
--
ALTER TABLE `appointments_opd`
  MODIFY `appointment_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `medical_reports`
--
ALTER TABLE `medical_reports`
  MODIFY `receipt_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_doctor` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_patient_id` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `medical_reports`
--
ALTER TABLE `medical_reports`
  ADD CONSTRAINT `fk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
