
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
) ;

--
-- Đang đổ dữ liệu cho bảng `inventory`
--

INSERT INTO `inventory` (`id`, `device_id`, `branch_id`, `quantity`, `status`) VALUES
(29, 15, 18, 6, 1),
(30, 15, 20, 20, 1),
(31, 11, 20, 4, 1),
(32, 8, 5, 5, 1),
(33, 11, 22, 10, 1),
(34, 16, 1, 5, 1),
(36, 15, 16, 20, 1),
(37, 15, 1, 11, 1),
(38, 16, 18, 2, 1),
(39, 11, 18, 1, 1);

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
(43, 15, 20, 18, 'export', 6, '                done', '2024-05-25 05:01:50', 1, NULL, NULL),
(44, 11, 22, 20, 'export', 5, '           sửa chữa', '2024-05-25 06:39:50', 1, NULL, NULL),
(45, 11, 22, 20, 'export', 5, '           sửa chữa', '2024-05-25 06:40:12', 1, NULL, NULL),
(46, 16, 1, 0, 'import', 4, '', '2024-05-25 06:57:38', 1, NULL, NULL),
(47, 16, 1, 0, 'import', 1, '', '2024-05-25 06:58:48', 1, NULL, NULL),
(48, 15, 18, 0, 'import', 2, '', '2024-05-25 09:07:31', 1, NULL, NULL),
(49, 15, 18, 0, 'import', 1, '', '2024-05-25 09:07:45', 2, NULL, NULL),
(50, 15, 18, 0, 'import', 1, '', '2024-05-25 09:12:38', 1, NULL, NULL),
(52, 15, 16, 20, 'export', 5, '                test xem khóa hàng có chạy không', '2024-05-25 09:13:33', 2, NULL, NULL),
(53, 15, 16, 20, 'export', 5, '                test xem khóa hàng có chạy không', '2024-05-25 09:13:38', 2, NULL, NULL),
(54, 15, 16, 20, 'export', 5, '                test xem khóa hàng có chạy không', '2024-05-25 09:13:38', 2, NULL, NULL),
(55, 15, 16, 20, 'export', 5, '                test xem khóa hàng có chạy không', '2024-05-25 09:13:38', 2, NULL, NULL),
(56, 15, 1, 18, 'export', 3, '                câcsascasc', '2024-05-25 09:29:21', 2, NULL, NULL),
(57, 15, 18, 0, 'import', 1, '', '2024-05-25 09:29:31', 1, NULL, NULL),
(58, 15, 1, 18, 'export', 1, '                gggggggg', '2024-05-25 09:30:56', 2, NULL, NULL),
(60, 15, 1, 18, 'export', 1, '                test khóa hàng tại chi nhánh  và tai nghe', '2024-05-25 09:37:35', 2, NULL, NULL),
(61, 15, 18, 0, 'import', 1, '', '2024-05-25 09:37:39', 1, NULL, NULL),
(62, 15, 1, 18, 'export', 2, '                jjjjjjj', '2024-05-25 09:43:46', 2, NULL, NULL),
(63, 15, 18, 0, 'import', 1, '', '2024-05-25 09:43:48', 1, NULL, NULL),
(64, 15, 20, 18, 'export', 2, '              test 123', '2024-05-27 01:07:02', 1, NULL, NULL),
(65, 15, 20, 0, 'import', 1, '', '2024-05-27 01:07:49', 1, NULL, NULL),
(66, 15, 18, 0, 'import', 1, '', '2024-05-27 01:23:21', 1, NULL, NULL),
(67, 15, 20, 18, 'export', 3, '                wef', '2024-05-27 01:23:51', 2, NULL, NULL),
(68, 15, 18, 1, 'export', 5, '                cdscsd', '2024-05-27 05:08:53', 1, NULL, NULL),
(72, 15, 20, 18, 'export', 1, '                ádfsdfsdfsdfsdfsdf', '2024-05-27 06:53:03', 1, NULL, NULL),
(73, 15, 18, 0, 'import', 1, '', '2024-05-27 06:55:42', 1, NULL, NULL),
(74, 15, 20, 18, 'export', 1, '                qqsqsqs', '2024-05-27 06:55:46', 1, NULL, NULL),
(75, 15, 18, 0, 'import', 1, '', '2024-05-27 06:57:10', 1, NULL, NULL),
(76, 15, 20, 18, 'export', 1, '                qsqsqsqs', '2024-05-27 06:57:12', 1, NULL, NULL),
(77, 16, 18, 0, 'import', 2, '', '2024-05-27 07:00:34', 1, NULL, NULL),
(78, 15, 18, 0, 'import', 2, '', '2024-05-27 07:01:38', 1, NULL, NULL),
(79, 15, 20, 18, 'export', 12, '                ẻerteretert', '2024-05-27 07:01:41', 1, NULL, NULL),
(80, 15, 18, 20, 'export', 25, '               trả thiết bị', '2024-05-27 07:03:05', 1, NULL, NULL),
(81, 15, 20, 18, 'export', 25, '                aaaa', '2024-05-27 07:04:54', 1, NULL, NULL),
(82, 15, 20, 18, 'export', 1, '                test nếu số xuất bé hơn số hiện có', '2024-05-27 07:28:21', 1, NULL, NULL),
(83, 15, 18, 20, 'export', 1, '                tgyvtvg', '2024-05-27 07:29:20', 1, NULL, NULL),
(86, 15, 18, 20, 'export', 10, '                ádasdasASdasasdasasdasdasd', '2024-05-27 07:35:12', 1, NULL, NULL),
(88, 15, 20, 18, 'export', 10, 'xuất hết hàng trong kho B ra', '2024-05-27 07:39:22', 1, NULL, NULL),
(90, 15, 18, 20, 'export', 1, '               test deadlock', '2024-05-28 01:26:08', 1, NULL, NULL),
(92, 15, 20, 18, 'export', 1, '                test deadlock2', '2024-05-28 01:30:14', 1, NULL, NULL),
(94, 15, 18, 20, 'export', 1, '                test deadlock2', '2024-05-28 01:30:53', 2, NULL, NULL),
(95, 15, 18, 20, 'export', 1, '                test deadlock 3', '2024-05-28 01:39:21', 2, NULL, NULL),
(97, 15, 1, 18, 'export', 2, '                test deadlock 3', '2024-05-28 01:42:05', 1, NULL, NULL),
(98, 15, 18, 20, 'export', 1, '                www', '2024-05-28 01:42:18', 2, NULL, NULL),
(99, 15, 18, 20, 'export', 1, '                test deadlock 4', '2024-05-28 01:48:11', 1, NULL, NULL),
(101, 15, 18, 20, 'export', 1, '                test deadlock 5', '2024-05-28 02:11:30', 1, NULL, NULL),
(103, 15, 20, 18, 'export', 1, '                test deadlock5', '2024-05-28 02:14:51', 2, NULL, NULL),
(104, 11, 18, 20, 'export', 1, '                ừefwefwe', '2024-05-28 02:15:17', 1, NULL, NULL),
(106, 15, 18, 0, 'import', 10, '', '2024-05-28 02:19:24', 2, NULL, NULL),
(107, 15, 20, 18, 'export', 2, '                jmjjmjmjm', '2024-05-28 02:19:30', 1, NULL, NULL),
(108, 15, 18, 0, 'import', 2, '', '2024-05-28 02:23:19', 1, NULL, NULL),
(109, 15, 20, 18, 'export', 5, '                èerrfefer', '2024-05-28 02:23:24', 2, NULL, NULL),
(110, 15, 1, 18, 'export', 1, '                yyyyyyyy', '2024-05-28 02:28:42', 2, NULL, NULL),
(112, 15, 18, 20, 'export', 1, '                test deadlock', '2024-05-28 02:31:49', 2, NULL, NULL),
(114, 15, 20, 18, 'export', 1, '  deadlock', '2024-05-28 02:34:12', 1, NULL, NULL),
(116, 15, 1, 20, 'export', 5, '                chuyển thiết bị sang chi nhánh A', '2024-05-28 07:12:08', 1, NULL, NULL),
(117, 15, 1, 20, 'export', 1, '                vvvvvvv', '2024-05-28 07:13:53', 1, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `inventory_history`
--
ALTER TABLE `inventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
