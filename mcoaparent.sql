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
-- Table structure for table `mcoaparent`
--

CREATE TABLE `mcoaparent` (
  `id` int(10) unsigned NOT NULL,
  `mcoaparentcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mcoaparentname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mcoaparenttype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mcoagrandparentcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mcoagrandparentname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `void` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mcoaparent`
--

INSERT INTO `mcoaparent` (`id`, `mcoaparentcode`, `mcoaparentname`, `mcoaparenttype`, `mcoagrandparentcode`, `mcoagrandparentname`, `void`, `created_at`, `updated_at`, `saldo`) VALUES
(1, '1101.00', 'Kas', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(2, '1102.00', 'Bank', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(3, '1103.00', 'Piutang Usaha', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(4, '1104.00', 'Piutang Non Usaha', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(5, '1105.00', 'Persediaan', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(6, '1106.00', 'Uang Muka', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(7, '1107.00', 'Pajak Dibayar Dimuka', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(8, '1108.00', 'Biaya Dibayar Dimuka', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(9, '1109.00', 'Investasi Jangka Panjang', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(10, '1110.00', 'Harta Lainya', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(11, '1201.00', 'Harta Tetap Berwujud', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(12, '1202.00', 'Harta Tetap Tidak Berwujud', 'D', '1000.00', 'Harta', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(13, '2101.00', 'Hutang Lancar', 'K', '2000.00', 'Kewajiban', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(14, '2102.00', 'Hutang Pajak', 'K', '2000.00', 'Kewajiban', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(15, '2103.00', 'Pendapatan Di Terima Di Muka', 'K', '2000.00', 'Kewajiban', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(16, '2201.00', 'Hutang Jangka Panjang', 'K', '2000.00', 'Kewajiban', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(17, '3100.00', 'Modal', 'K', '3000.00', 'Modal', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(18, '3200.00', 'Laba', 'K', '3000.00', 'Modal', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(19, '3300.00', 'Dividen', 'K', '3000.00', 'Modal', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(20, '4100.00', 'Pendapatan Usaha', 'K', '4000.00', 'Pendapatan', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(21, '5100.00', 'Beban Pokok Penjualan', 'D', '5000.00', 'Biaya Atas Pendapatan', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(22, '5200.00', 'Biaya Lain', 'D', '5000.00', 'Biaya Atas Pendapatan', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(23, '6100.00', 'Biaya Operasional', 'D', '6000.00', 'Pengeluaran Operasional', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(24, '6200.00', 'Biaya Non Operasional', 'D', '6000.00', 'Pengeluaran Operasional', '', '2016-09-23 14:03:54', '2016-09-23 14:03:54', 0),
(25, '7100.00', 'Pendapatan Luar Usaha', 'K', '7000.00', 'Pendapatan Luar Usaha', '', '2016-09-23 14:03:55', '2016-09-23 14:03:55', 0),
(26, '8100.00', 'Pengeluaran Luar Usaha', 'D', '8000.00', 'Pengeluaran Luar Usaha', '', '2016-09-23 14:03:55', '2016-09-23 14:03:55', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mcoaparent`
--
ALTER TABLE `mcoaparent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mcoaparent_mcoaparentcode_unique` (`mcoaparentcode`),
  ADD UNIQUE KEY `mcoaparent_mcoaparentname_unique` (`mcoaparentname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mcoaparent`
--
ALTER TABLE `mcoaparent`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
