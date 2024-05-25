-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 25, 2024 lúc 07:03 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `hardware`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `branch`
--

INSERT INTO `branch` (`id`, `name`, `address`) VALUES
(1, 'Chi nhánh A', 'Địa chỉ A'),
(5, 'Chi nhánh C', 'Địa chỉ C'),
(7, 'Chi nhánh D', 'Địa chỉ D'),
(16, 'Chi nhánh F', 'Địa chỉ F'),
(18, 'Chi nhánh B', 'Địa chỉ B'),
(20, 'Chi nhánh E', 'Địa chỉ E'),
(21, 'Kho thiết bị bỏ', 'Gò Vấp'),
(22, 'Kho thiết bị sửa chữa', 'Gò Vấp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_buy` date DEFAULT NULL,
  `active` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `device`
--

INSERT INTO `device` (`id`, `name`, `type`, `description`, `date_buy`, `active`) VALUES
(1, 'Màn Hình ', NULL, 'Siêu nét hơn Sony', '2024-05-19', '1'),
(3, 'Timer', NULL, 'Điều khiển cách 2km', '2024-05-19', '1'),
(4, 'Gateway 16', NULL, '', '2024-05-19', '0'),
(5, 'Gateway 32', NULL, '', '2024-05-01', '1'),
(6, 'CPU', NULL, 'Siêu xử lý các tiến trình nhiều tầng', '2024-05-20', '0'),
(7, 'Bàn Phím', NULL, 'Gõ code không bug', '2024-05-20', '1'),
(8, 'UPS', NULL, 'độ sắc nét hoàn hảo', '2024-05-20', '1'),
(11, 'Phím Chuột', NULL, 'tùy chỉnh nhiều chế độ ,  tăng trải nghiệm người dùng', '2024-05-22', '1'),
(15, 'Tai nghe', NULL, 'Tận hưởng trải nghiệm tuyệt vời khi thư giãn', '2024-05-23', '1'),
(16, 'Ghế NV', NULL, 'Ngồi êm , bảo vê cột sống', '2024-05-23', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `status` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `inventory`
--

INSERT INTO `inventory` (`id`, `device_id`, `branch_id`, `quantity`, `status`) VALUES
(29, 15, 18, 10, 1),
(30, 15, 20, 22, 1),
(31, 11, 20, 15, 1),
(32, 8, 5, 5, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `inventory_history`
--

CREATE TABLE `inventory_history` (
  `id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `branch_id_recieve` int(11) NOT NULL,
  `branch_id_send` int(11) DEFAULT NULL,
  `type` text NOT NULL,
  `quantity` float NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `inventory_history`
--

INSERT INTO `inventory_history` (`id`, `device_id`, `branch_id_recieve`, `branch_id_send`, `type`, `quantity`, `note`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(34, 15, 18, 0, 'import', 10, '', '2024-05-25 04:17:48', 1, NULL, NULL),
(35, 15, 18, 0, 'import', 10, '', '2024-05-25 04:18:13', 1, NULL, NULL),
(36, 15, 20, 0, 'import', 10, '', '2024-05-25 04:19:13', 1, NULL, NULL),
(37, 11, 20, 0, 'import', 10, '', '2024-05-25 04:19:19', 1, NULL, NULL),
(38, 15, 20, 0, 'import', 2, '', '2024-05-25 04:19:37', 1, NULL, NULL),
(39, 15, 20, 18, 'export', 3, '              Chuyển thiết bị tai nghe cho chi nhánh e', '2024-05-25 04:21:12', 1, NULL, NULL),
(40, 11, 20, 0, 'import', 5, '', '2024-05-25 04:43:35', 1, NULL, NULL),
(41, 8, 5, 0, 'import', 5, '', '2024-05-25 04:43:54', 1, NULL, NULL),
(42, 15, 20, 18, 'export', 1, '                cấp B về E 1 tai nghe', '2024-05-25 04:45:42', 1, NULL, NULL),
(43, 15, 20, 18, 'export', 6, '                done', '2024-05-25 05:01:50', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'user1', 'admin@gmail.com', 'b2fbccf5955d6b8da72d8261d640998cb353a308', 'admin');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_id` (`device_id`,`branch_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Chỉ mục cho bảng `inventory_history`
--
ALTER TABLE `inventory_history`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `inventory_history`
--
ALTER TABLE `inventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
