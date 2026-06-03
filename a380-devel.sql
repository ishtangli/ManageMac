-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2026 at 04:13 AM
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
-- Database: `a380-devel`
--

-- --------------------------------------------------------

--
-- Table structure for table `aud_audit`
--

CREATE TABLE `aud_audit` (
  `AUD_AUDIT_ID` mediumint(9) NOT NULL,
  `AUD_ACTION` text NOT NULL,
  `AUD_INDEX` mediumint(9) NOT NULL,
  `AUD_DATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `AUD_BY` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_details`
--

CREATE TABLE `inv_details` (
  `INVD_ID` mediumint(9) NOT NULL,
  `INVD_PN_ID` mediumint(9) NOT NULL,
  `INVD_QTY` double NOT NULL,
  `INVD_RESERVED` double NOT NULL DEFAULT 0,
  `INVD_BIN` text NOT NULL,
  `INVD_LOCATION` text NOT NULL,
  `INVD_DATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_history`
--

CREATE TABLE `inv_history` (
  `INVH_ID` mediumint(9) NOT NULL,
  `INVH_INVT_ID` mediumint(9) NOT NULL,
  `INVH_PN_ID` mediumint(9) NOT NULL,
  `INVH_QTY` double NOT NULL,
  `INVH_RETURN_QTY` double NOT NULL,
  `INVH_QTY_AVAILABLE` double NOT NULL,
  `INVH_FROM` text NOT NULL,
  `INVH_TO` text NOT NULL,
  `INVH_FROM_LOC` text NOT NULL,
  `INVH_TO_LOC` text NOT NULL,
  `INVH_BIN` text NOT NULL,
  `INVH_LOCATION` text NOT NULL,
  `INVH_DATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `INVH_FROM_ID` mediumint(9) DEFAULT NULL,
  `INVH_STATUS` enum('OPEN','CLOSED') NOT NULL DEFAULT 'OPEN',
  `INVH_BY` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_transactions`
--

CREATE TABLE `inv_transactions` (
  `INVT_ID` mediumint(9) NOT NULL,
  `INVT_USER` text NOT NULL,
  `INVT_TYPE` text NOT NULL,
  `INVT_AWB` text NOT NULL,
  `INVT_TASKCARD` text NOT NULL,
  `INVT_DATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `INVT_FROM_ID` mediumint(9) DEFAULT NULL,
  `INVT_BY` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_logins`
--

CREATE TABLE `log_logins` (
  `LOG_ID` mediumint(9) NOT NULL,
  `LOG_UID` text NOT NULL,
  `LOG_PWD` text NOT NULL,
  `LOG_NAME` text NOT NULL,
  `LOG_DEPT` text NOT NULL,
  `LOG_DIV` text NOT NULL,
  `LOG_SEC` text NOT NULL,
  `LOG_ADMIN` tinyint(1) NOT NULL,
  `LOG_ACTIVE` tinyint(1) NOT NULL DEFAULT 1,
  `LOG_PWD_SET` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `msn`
--

CREATE TABLE `msn` (
  `MSN_ID` mediumint(9) NOT NULL,
  `MSN` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `not_notes`
--

CREATE TABLE `not_notes` (
  `NOT_ID` mediumint(9) NOT NULL,
  `NOT_PN_ID` mediumint(9) DEFAULT NULL,
  `NOT_INVT_ID` mediumint(9) DEFAULT NULL,
  `NOT_INVH_ID` mediumint(9) DEFAULT NULL,
  `NOT_NOTE` text NOT NULL,
  `NOT_DATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NOT_BY` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pns`
--

CREATE TABLE `pns` (
  `PN_ID` mediumint(9) NOT NULL,
  `PN_KIT` text NOT NULL,
  `PN_MSN` text NOT NULL,
  `PN_DWG` text NOT NULL,
  `PN_KIT_SN` text NOT NULL,
  `PN_VENDOR` text NOT NULL,
  `PN_WORKPACK` text NOT NULL,
  `PN_PRODNUM` text NOT NULL,
  `PN_PN` text NOT NULL,
  `PN_DESC` text NOT NULL,
  `PN_MFR` text NOT NULL,
  `PN_QTY_REQ` double DEFAULT NULL,
  `PN_QTY_REC` double NOT NULL,
  `PN_UOM` text NOT NULL,
  `PN_IDENT` text NOT NULL,
  `PN_KIT_MPN` text NOT NULL,
  `PN_STATUS` text NOT NULL,
  `PN_ACTIVE` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aud_audit`
--
ALTER TABLE `aud_audit`
  ADD PRIMARY KEY (`AUD_AUDIT_ID`);

--
-- Indexes for table `inv_details`
--
ALTER TABLE `inv_details`
  ADD PRIMARY KEY (`INVD_ID`),
  ADD UNIQUE KEY `INVD_PN_ID` (`INVD_PN_ID`);

--
-- Indexes for table `inv_history`
--
ALTER TABLE `inv_history`
  ADD PRIMARY KEY (`INVH_ID`),
  ADD KEY `INVH_PN_ID` (`INVH_PN_ID`),
  ADD KEY `INVH_INVT_ID` (`INVH_INVT_ID`);

--
-- Indexes for table `inv_transactions`
--
ALTER TABLE `inv_transactions`
  ADD PRIMARY KEY (`INVT_ID`),
  ADD KEY `INVT_TASKCARD` (`INVT_TASKCARD`(15));

--
-- Indexes for table `log_logins`
--
ALTER TABLE `log_logins`
  ADD PRIMARY KEY (`LOG_ID`);

--
-- Indexes for table `msn`
--
ALTER TABLE `msn`
  ADD PRIMARY KEY (`MSN_ID`);

--
-- Indexes for table `not_notes`
--
ALTER TABLE `not_notes`
  ADD PRIMARY KEY (`NOT_ID`),
  ADD KEY `NOT_PN_ID` (`NOT_PN_ID`),
  ADD KEY `NOT_INVT_ID` (`NOT_INVT_ID`),
  ADD KEY `NOT_INVH_ID` (`NOT_INVH_ID`);

--
-- Indexes for table `pns`
--
ALTER TABLE `pns`
  ADD PRIMARY KEY (`PN_ID`),
  ADD KEY `PN_KIT` (`PN_KIT`(15)),
  ADD KEY `PN_MSN` (`PN_MSN`(15)),
  ADD KEY `PN_DWG` (`PN_DWG`(15)),
  ADD KEY `PN_PN` (`PN_PN`(15)),
  ADD KEY `PN_STATUS` (`PN_STATUS`(15)),
  ADD KEY `PN_VENDOR` (`PN_VENDOR`(15)),
  ADD KEY `PN_KIT_MPN` (`PN_KIT_MPN`(15));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aud_audit`
--
ALTER TABLE `aud_audit`
  MODIFY `AUD_AUDIT_ID` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_details`
--
ALTER TABLE `inv_details`
  MODIFY `INVD_ID` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_history`
--
ALTER TABLE `inv_history`
  MODIFY `INVH_ID` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_transactions`
--
ALTER TABLE `inv_transactions`
  MODIFY `INVT_ID` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_logins`
--
ALTER TABLE `log_logins`
  MODIFY `LOG_ID` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `msn`
--
ALTER TABLE `msn`
  MODIFY `MSN_ID` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `not_notes`
--
ALTER TABLE `not_notes`
  MODIFY `NOT_ID` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pns`
--
ALTER TABLE `pns`
  MODIFY `PN_ID` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inv_details`
--
ALTER TABLE `inv_details`
  ADD CONSTRAINT `inv_details_ibfk_1` FOREIGN KEY (`INVD_PN_ID`) REFERENCES `pns` (`PN_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inv_history`
--
ALTER TABLE `inv_history`
  ADD CONSTRAINT `inv_history_ibfk_4` FOREIGN KEY (`INVH_INVT_ID`) REFERENCES `inv_transactions` (`INVT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inv_history_ibfk_5` FOREIGN KEY (`INVH_PN_ID`) REFERENCES `pns` (`PN_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
