-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 26, 2016 at 11:55 AM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `officepedia`
--

-- --------------------------------------------------------

--
-- Table structure for table `mcoagrandparent`
--

CREATE TABLE `mcoagrandparent` (
  `id` int(10) unsigned NOT NULL,
  `mcoagrandparentcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mcoagrandparentname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mcoagrandparenttype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `void` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mcoagrandparent`
--

INSERT INTO `mcoagrandparent` (`id`, `mcoagrandparentcode`, `mcoagrandparentname`, `mcoagrandparenttype`, `void`, `created_at`, `updated_at`, `saldo`) VALUES
(1, '1000.00', 'Harta', 'D', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(2, '2000.00', 'Kewajiban', 'K', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(3, '3000.00', 'Modal', 'K', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(4, '4000.00', 'Pendapatan', 'K', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(5, '5000.00', 'Biaya Atas Pendapatan', 'D', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(6, '6000.00', 'Pengeluaran Operasional', 'D', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(7, '7000.00', 'Pendapatan Luar Usaha', 'K', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(8, '8000.00', 'Pengeluaran Luar Usaha', 'D', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mcoagrandparent`
--
ALTER TABLE `mcoagrandparent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mcoagrandparent_mcoagrandparentcode_unique` (`mcoagrandparentcode`),
  ADD UNIQUE KEY `mcoagrandparent_mcoagrandparentname_unique` (`mcoagrandparentname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mcoagrandparent`
--
ALTER TABLE `mcoagrandparent`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
