-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 12, 2023 lúc 12:09 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `website_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(14, 'Ốp Lục Giác'),
(15, 'Đèn Âm Trần'),
(16, 'Đèn Pha'),
(17, 'Đèn Ống Bo'),
(18, 'Đèn Trang Trí');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `COM_ID` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `Text` text NOT NULL,
  `NameUser` varchar(256) NOT NULL,
  `date_comment` timestamp NULL DEFAULT current_timestamp(),
  `Start` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`COM_ID`, `product_id`, `Text`, `NameUser`, `date_comment`, `Start`) VALUES
(1, 3, 'Tesst', 'trung', '2023-05-11 01:57:55', 0),
(2, 3, 'Tesst222', 'trung2', '2023-05-11 01:57:55', 0),
(3, 3, '1', 'Tran Trung', '2023-05-11 01:57:55', 0),
(4, 3, '123', 'Tran Trung', '2023-05-11 01:57:55', 0),
(5, 3, '1233333', 'Tran Trung', '2023-05-11 01:57:55', 1),
(6, 3, '1', 'Trung Trần', '2023-05-11 01:57:55', 0),
(8, 3, 'test ko login', '', '2023-05-11 02:23:45', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `logingg`
--

CREATE TABLE `logingg` (
  `ID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `logingg`
--

INSERT INTO `logingg` (`ID`, `email`, `name`) VALUES
(1, 'diemdanhhott@gmail.com', 'Tran Trung'),
(2, 'nguoilanglas16k@gmail.com', 'Trung 1'),
(3, 'chihirotran@gmail.com', 'Trung Trần Hoàng'),
(4, 'nguoilanglas16k@gmail.com', 'Trung Trần');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oder`
--

CREATE TABLE `oder` (
  `ID` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `date_oder` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Address` text NOT NULL,
  `Payment_Type` text NOT NULL,
  `Pay` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `oder`
--

INSERT INTO `oder` (`ID`, `products_id`, `id_user`, `price`, `date_oder`, `Address`, `Payment_Type`, `Pay`) VALUES
(19, 0, '', 310000, '2023-05-11 00:18:14', '123Xã Pải LủngHuyện Mèo VạcTỉnh Hà Giang', 'wire', 0),
(20, 0, '', 300023, '2023-05-11 00:19:35', 'Hung Dao Ty Ky Hai DuongPhường Vĩnh PhúcQuận Ba ĐìnhThành phố Hà Nội', 'wire', 0),
(21, 0, '', 310000, '2023-05-11 00:53:49', 'Số 3 Ngách 157 Ngõ 169 hồ tùng mậuXã Phước HòaHuyện Bác ÁiTỉnh Ninh Thuận', 'MOMO', 0),
(22, 0, '', 1400000, '2023-05-11 19:19:43', '123Phường Đồng XuânQuận Hoàn KiếmThành phố Hà Nội', 'wire', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `oder_detail`
--

CREATE TABLE `oder_detail` (
  `ID` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `oder_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `oder_detail`
--

INSERT INTO `oder_detail` (`ID`, `products_id`, `price`, `quantity`, `oder_id`) VALUES
(1, 3, 109.99, 1, 0),
(2, 3, 109.99, 1, 0),
(3, 9, 149.99, 2, 0),
(4, 10, 449.99, 3, 0),
(5, 3, 109.99, 1, 0),
(6, 9, 149.99, 2, 0),
(7, 10, 449.99, 3, 0),
(8, 3, 109.99, 1, 0),
(9, 9, 149.99, 2, 0),
(10, 10, 449.99, 3, 0),
(11, 3, 109.99, 1, 0),
(12, 9, 149.99, 2, 0),
(13, 10, 449.99, 3, 0),
(14, 3, 109.99, 1, 0),
(15, 9, 149.99, 2, 0),
(16, 10, 449.99, 3, 0),
(17, 6, 168.99, 4, 0),
(18, 3, 109.99, 1, 0),
(19, 9, 149.99, 2, 0),
(20, 10, 449.99, 3, 0),
(21, 6, 168.99, 4, 0),
(22, 3, 109.99, 1, 13),
(23, 9, 149.99, 2, 13),
(24, 10, 449.99, 3, 13),
(25, 6, 168.99, 4, 13),
(26, 11, 149.99, 5, 13),
(27, 3, 109.99, 1, 14),
(28, 9, 149.99, 2, 14),
(29, 10, 449.99, 3, 14),
(30, 6, 168.99, 4, 14),
(31, 11, 299.98, 6, 14),
(32, 3, 109.99, 1, 15),
(33, 9, 149.99, 2, 15),
(34, 10, 449.99, 3, 15),
(35, 6, 168.99, 4, 15),
(36, 3, 109.99, 1, 16),
(37, 9, 149.99, 2, 16),
(38, 10, 449.99, 3, 16),
(39, 6, 168.99, 4, 16),
(40, 3, 109.99, 1, 17),
(41, 9, 149.99, 2, 17),
(42, 10, 449.99, 3, 17),
(43, 6, 168.99, 4, 17),
(44, 5, 159.99, 1, 18),
(45, 31, 310000, 1, 19),
(46, 26, 23, 1, 20),
(47, 30, 300000, 2, 20),
(48, 31, 310000, 1, 21),
(49, 38, 500000, 2, 22),
(50, 30, 900000, 5, 22);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_price` float NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `product_short_desc` text NOT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_category_id`, `product_price`, `product_quantity`, `product_description`, `product_short_desc`, `product_image`) VALUES
(26, '123', 0, 23, 2, '<p>12312312</p>', '123', '8b3d7941a97a388fd60e5f933487242a.jpg'),
(27, '5', 0, 5, 5, '<p>5</p>', '5', 'e96b579c5ce15e2be81f10c75c0aa00e.jpg'),
(28, '6', 0, 6, 6, '<p>7</p>', '6', 'e96b579c5ce15e2be81f10c75c0aa00e.jpg'),
(30, 'Den 1', 14, 300000, 100, '<div style=\"background-color: rgb(40, 42, 54); line-height: 19px;\"><font color=\"#f6f6f4\" face=\"Consolas, Courier New, monospace\"><span style=\"white-space: pre;\">Đèn Lúc Giác</span></font><span style=\"background-color: rgb(255, 255, 255); white-space: pre;\"><font color=\"#f6f6f4\" face=\"Consolas, Courier New, monospace\">Đèn Lúc Giác</font></span><br></div>', 'Đèn Lúc Giác', '8aa41fa13852fcfe5783458c2089dbfb.jpg'),
(31, 'Den 2', 14, 310000, 100, '<p>Đèn Lúc Giác mẫu 2<br></p>', 'Đèn Lúc Giác mẫu 2', '4f10d479943300cbf6d79d1c4b035624.jpg'),
(32, 'Den 3', 15, 410000, 100, '<p>Đèn Âm Trần Mẫu 1</p><p>Đèn Âm Trần Mẫu 1<br></p>', 'Đèn Âm Trần Mẫu 1', '5a90afc9e3dfc8b24600d2c638508dd8.png'),
(33, 'Den 4', 15, 410000, 100, '<p>Đèn Âm Trần Mẫu 2<br></p>', 'Đèn Âm Trần Mẫu 2', '6e14ef3db1833d4e4f1e20bf405df7db.png'),
(34, 'Den 5', 15, 410000, 100, '<p>Đèn Âm Trần Mẫu 3<br></p>', 'Đèn Âm Trần Mẫu 3', '3133bda8768b7de2a32b4d471094b01d.png'),
(35, 'Den 6', 15, 510000, 100, '<p>Đèn Âm Trần Mẫu 3<br></p>', 'Đèn Âm Trần Mẫu 3', '0d11a8cf7109d0661618ff9451d12797.png'),
(36, 'Den pha', 16, 310000, 100, '<p>Đèn pha Mẫu 3<br></p>', 'Đèn pha Mẫu 3', '5fac351c8079a5d578be6cf286a5348d.png'),
(37, 'Den ống bo', 17, 310000, 100, '<p>ád</p>', 'Đèn Mẫu 3', '5fac351c8079a5d578be6cf286a5348d.png'),
(38, 'Đèn Trang Trí 1', 18, 250000, 100, '<p>4312</p>', 'Đèn Mẫu 3', '5909fd461e9f3a9bf6ece4b9efd04c1e.jpg'),
(39, 'Đèn Trang Trí 2', 18, 250000, 100, '<p>adasd</p>', 'Đèn Mẫu 3', '82b920c16fd3fe75bf4ab0f5fc122855.jpg'),
(40, 'Đèn Trang Trí 3', 18, 250000, 100, '<p>dfgsh</p>', 'Đèn Mẫu 3', 'f6e567a91192126e37b4856bbeb887ba.jpg'),
(41, 'Đèn Trang Trí 4', 18, 250000, 100, '<p>sdh</p>', 'Đèn Mẫu 3', 'd76359245249ef148949aee262eb0c7d.jpg'),
(42, 'Đèn Trang Trí 5', 18, 250000, 100, '<p>sdfhg</p>', 'Đèn Mẫu 3', '3dd0070d540c78f70077de731e7e545d.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products_sale`
--

CREATE TABLE `products_sale` (
  `ID` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `saleevent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products_sale`
--

INSERT INTO `products_sale` (`ID`, `product_id`, `saleevent_id`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 4, 1),
(4, 5, 1),
(5, 3, 3),
(6, 5, 2),
(7, 40, 1),
(8, 38, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `saleevent`
--

CREATE TABLE `saleevent` (
  `ID` int(11) NOT NULL,
  `Name` text DEFAULT NULL,
  `date` date NOT NULL,
  `percent` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `saleevent`
--

INSERT INTO `saleevent` (`ID`, `Name`, `date`, `percent`) VALUES
(1, '10', '2023-03-02', 30),
(2, 'test ', '2023-05-11', 25),
(3, 'Trần Trung', '2023-05-20', 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL,
  `gmail_authentication` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `gmail_authentication`) VALUES
(1, 'admin', 'admin@gmail.com', '1234', 1, 0),
(2, 'crncck', 'crncck@gmail.com', '1234', 0, 0),
(5, 'chihirotran', 'chihirotran1501@gmail.com', '123', 0, 1),
(6, '2ly1992', 'Chihirotran1501@gmail.com', '$2y$10$/yvK6gcMo86vjivZx09zwecrQAu2hkFJI03/DrSbecqI.4REwTq/e', 0, 0),
(7, 'chihirotran15', 'chihirotran11@gmail.com', '$2y$10$dWwMUxGIh36Ppg1W47xBR.CnOzc3ceo5HpT86Vvtsm1wW662cdI.O', 0, 0),
(8, '2ly1993', 'chihirotran11@gmail.com', '$2y$10$PC7Lp3/ZAMrmCFO19tKrS.84jJ4RG7WlxkaYabkWsTH4EEcitUGPm', 0, 0),
(9, '2ly1994', 'chihirotran11@gmail.com', '$2y$10$yi287nDKDSsLIoeXPsSXEuW5v7vxvYJ9FawGgZdUj2CgXJmd8fggu', 0, 1),
(10, '2ly1995', 'diemdanhhott@gmail.com', '$2y$10$CnYQGtRa7hKZYtI/xepUZuMgExId3z3iU0rU93az3Crbl7VN8JmrW', 0, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`COM_ID`);

--
-- Chỉ mục cho bảng `logingg`
--
ALTER TABLE `logingg`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `oder`
--
ALTER TABLE `oder`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `oder_detail`
--
ALTER TABLE `oder_detail`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `products_sale`
--
ALTER TABLE `products_sale`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `saleevent`
--
ALTER TABLE `saleevent`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `COM_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `logingg`
--
ALTER TABLE `logingg`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `oder`
--
ALTER TABLE `oder`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `oder_detail`
--
ALTER TABLE `oder_detail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `products_sale`
--
ALTER TABLE `products_sale`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `saleevent`
--
ALTER TABLE `saleevent`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
