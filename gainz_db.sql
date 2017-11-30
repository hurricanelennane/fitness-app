-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 29, 2017 at 02:21 AM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gainz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `eid` int(3) NOT NULL,
  `exercise_name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `sets` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(3) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userworkout`
--

CREATE TABLE `userworkout` (
  `uwid` int(3) NOT NULL,
  `uid` int(3) NOT NULL,
  `wid` int(3) NOT NULL,
  `workout_date` date NOT NULL,
  `time` time NOT NULL,
  `active_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workout`
--

CREATE TABLE `workout` (
  `wid` int(3) NOT NULL,
  `workout_name` varchar(20) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `workoutexercise`
--

CREATE TABLE `workoutexercise` (
  `weid` int(3) NOT NULL,
  `wid` int(3) NOT NULL,
  `eid` int(3) NOT NULL,
  `reps` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `userworkout`
--
ALTER TABLE `userworkout`
  ADD PRIMARY KEY (`uwid`);

--
-- Indexes for table `workout`
--
ALTER TABLE `workout`
  ADD PRIMARY KEY (`wid`);

--
-- Indexes for table `workoutexercise`
--
ALTER TABLE `workoutexercise`
  ADD PRIMARY KEY (`weid`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exercise`
--
ALTER TABLE `exercise`
  MODIFY `eid` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `userworkout`
--
ALTER TABLE `userworkout`
  MODIFY `uwid` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workout`
--
ALTER TABLE `workout`
  MODIFY `wid` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workoutexercise`
--
ALTER TABLE `workoutexercise`
  MODIFY `weid` int(3) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
