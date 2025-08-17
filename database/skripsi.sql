-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 11 Jul 2025 pada 11.10
-- Versi server: 8.4.3
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skripsi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `platform`
--

CREATE TABLE `platform` (
  `id` int NOT NULL,
  `id_produk` int NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `whatsapp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `blibli` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lazada` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shopee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tokopedia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tiktok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `promosi`
--

CREATE TABLE `promosi` (
  `id` int NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fasilitasi_promosi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hambatan_memasarkan_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bantuan_dibutuhkan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `berminat_bazar_ramadhan` enum('Ya','Tidak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `berminat_pelatihan_online` enum('Ya','Tidak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `umkm`
--

CREATE TABLE `umkm` (
  `id` int NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_usaha` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_merek_produk` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kategori_produk` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_usaha` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `pendapatan` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `jalan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `desa_kelurahan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kecamatan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nib` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pirt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bpom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `halal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `haki` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lainnya` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `online` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `offline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `agen_reseller` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi_produk` varchar(900) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'default.png',
  `status` enum('menunggu','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu',
  `catatan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '-',
  `whatsapp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `blibli` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lazada` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shopee` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tokopedia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instagram` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tiktok` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `twitter` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `umkm`
--

INSERT INTO `umkm` (`id`, `username`, `nama_usaha`, `nama_merek_produk`, `kategori_produk`, `jenis_usaha`, `pendapatan`, `jalan`, `desa_kelurahan`, `kecamatan`, `nib`, `pirt`, `bpom`, `halal`, `haki`, `lainnya`, `online`, `offline`, `agen_reseller`, `deskripsi_produk`, `photo`, `status`, `catatan`, `whatsapp`, `blibli`, `lazada`, `shopee`, `tokopedia`, `facebook`, `instagram`, `tiktok`, `twitter`) VALUES
(288, 'david123', 'PT GREAT THIOFILUS PERKASA', '180degrees', 'Fashion', 'Menengah', 'Rp 15.000.000.000 - Rp 50.000.000.000', 'Jalan Sadang No. 69B', 'Margahayu Tengah', 'Margahayu', '9120005871688', NULL, NULL, NULL, 'IDM000128301', 'https://180degrees.co.id/', 'online', 'offline', '0', 'Produk fashion dengan bahan recycle polyester yang terbuat dari bahan botol plastic (PET) yang di daur ulang menjadi serat yang kemudian ditenun menjadi kain baru, dengan komposisi kain yang dicampur dengan bahan serat lainnya yang memiliki daya penyerapan keringat yang lebih baik dan terasa sejuk saat dikenakan. 180 Degrees memiliki sertifikat resmi Recycled Claim Standard (RCS).', '84975a21f1cb67b3ab6d9fc62906c09d.png', 'disetujui', '-', 'https://wa.me/628236510180', 'https://www.blibli.com/user/180 Degrees Official Store', 'https://www.lazada.co.id/shop/180 Degrees', 'https://shopee.co.id/180 Degrees', 'https://www.tokopedia.com/180 Degrees', 'https://www.facebook.com/180 Degree Clothing', 'https://www.instagram.com/180degrees.clothing', 'https://www.tiktok.com/@180Degrees', NULL),
(289, 'nenden', 'CV RESTU MANDE', 'Restu Mande', 'Kerajinan', 'Kecil', 'Rp 2.000.000.000 - Rp 15.000.000.000', 'Cibiru Raya A No 86 RT 01 RW 15', 'Rancakole', 'Arjasari', '1243000632356', '124300063235600000009 ', 'MD 855628009508', 'ID32110000244381121', 'IDM000396940', 'https://padiumkm.id/store/631a5d4eaa3096cbda2600a0', 'online', 'offline', '0', 'Masakan dan bumbu padang', '9b76a0ffb5363f0d650efdd52ae1145a.jpg', 'disetujui', '-', 'https://wa.me/6281122900451', 'https://www.blibli.com/user/Rendang Restu Mande', NULL, 'https://shopee.co.id/Restu Mande Official Shop', 'https://www.tokopedia.com/Bumbu Padang Restu Mande', 'https://www.facebook.com/Rendang Kemasan vacuum Restu Mande', 'https://www.instagram.com/restumande.id', 'https://www.tiktok.com/@restumande.id', NULL),
(290, 'lilis', 'CV GLOBAL BEST LS LS (LIES SEUHAH)', 'LS (Lies Seuhah)', 'Kuliner', 'Menengah', 'Rp 15.000.000.000 - Rp 50.000.000.000', 'Komplek GBI Blok H10 No 5A', 'Buahbatu', 'Bojongsoang', '9120001410781', '912000141078100000001', NULL, '01101261510721', 'IDM000757382', NULL, 'online', 'offline', '0', 'Produk cemilan berbahan dasar aci dengan berbagai varian rasa dan bumbu yang khas', 'e75ae9c7d9e9c2e4fdb57cb297f21503.jpg', 'disetujui', '-', 'https://wa.me/6282118276944', NULL, NULL, 'https://shopee.co.id/Cireng LS Official', 'https://www.tokopedia.com/CirengLS Official', 'https://www.facebook.com/Cireng LS', 'https://www.instagram.com/cirengls_official', 'https://www.tiktok.com/@cirengls_official', NULL),
(291, 'ani123', 'RAMINA CANTIQUE MANDIRI', 'Nukuma Cantique', 'Kuliner', 'Mikro', 'Rp 2.000.000.000', 'Kavling Rancamas E19 RT 03 RW 19', 'Rancamanyar', 'Baleendah', '0220201172708', '2063204013174-25', NULL, NULL, NULL, NULL, 'online', 'offline', 'agen_reseller', 'Olahan sus kering inovatif', '6e4c31fe307567c84fc8797774ff490c.jpg', 'disetujui', '-', 'https://wa.me/6285727700722', 'https://www.blibli.com/user/CantiQue Soes', NULL, NULL, 'https://www.tokopedia.com/Nukuma Food', 'https://www.facebook.com/CantiQue Soes', 'https://www.instagram.com/soesnukuma', 'https://www.tiktok.com/@NUKUMA SOES', NULL),
(292, 'ayu123', 'BALANTIK', 'Balantik', 'Fashion', 'Kecil', 'Rp 2.000.000.000 - Rp 15.000.000.000', 'Jalan Cigantri No. 38', 'Cipagalo', 'Bojongsoang', '1236000502317', NULL, NULL, NULL, 'IDM001027810', NULL, 'online', '0', '0', 'Produk fashion berupa alas kaki untuk keperluan sehari-hari', '3d667ba5d768d103a446d155226436dc.jpg', 'disetujui', '-', 'https://wa.me/6285967125798', 'https://www.blibli.com/user/Balantik', 'https://www.lazada.co.id/shop/Balantik_id', 'https://shopee.co.id/Balantik_id', 'https://www.tokopedia.com/Balantik Official Store', 'https://www.facebook.com/Balantik.id', 'https://www.instagram.com/balantik.id', 'https://www.tiktok.com/@balantik.official', NULL),
(293, 'akbar123', 'CV TRI SATYA KENCANA', 'Ovi Kids', 'Fashion', 'Menengah', 'Rp 15.000.000.000 - Rp 50.000.000.000', 'Kampung Panyawungan Bumi Abdi Negara III RT 01 RW 03', 'Cileunyi Wetan', 'Cileunyi', '0212210046114', NULL, NULL, NULL, NULL, NULL, 'online', '0', 'agen_reseller', 'Produk fashion anak-anak', 'fa1f714e44c196d883ff4a2d8c2aee39.png', 'disetujui', '-', 'https://wa.me/6281220190086', 'https://www.blibli.com/user/OVI Kids Official Store', NULL, 'https://shopee.co.id/OVI Kids Official Shop', 'https://www.tokopedia.com/OVI Kids Official', 'https://www.facebook.com/OviKids Bandung', 'https://www.instagram.com/ovikids.official', 'https://www.tiktok.com/@ovikids', NULL),
(306, 'nur12345', 'Surafada Cake', 'Surafada', 'Kuliner', 'Mikro', 'Rp 2.000.000.000', 'Kp. Andir No. 44 Gg. Barokah RT 09 RW 02', 'Karamatmulya', 'Soreang', '2811220002498', '2043204012718-23', NULL, '1101223680119', NULL, NULL, 'online', 'offline', 'agen_reseller', 'Donut lumer, es lumut, jelly ball', '83b95b0d16d293591949f99012ea05f3.jpeg', 'disetujui', '-', 'https://wa.me/6289650570262', NULL, NULL, NULL, NULL, NULL, 'https://www.instagram.com/surafada cake', NULL, NULL),
(307, 'Nurhayati123', 'NURHAYATI', 'UmyFasya', 'Kuliner', 'Menengah', 'Rp 15.000.000.000 - Rp 50.000.000.000', 'Kp. Cipeuteuy RT 01 RW 02', 'Cingcin', 'Soreang', '708210024574', NULL, NULL, NULL, NULL, NULL, 'online', 'offline', '0', 'Batagor, Cuanki, Baso Tahu, Ayam Frosen', 'default.png', 'disetujui', '-', 'https://wa.me/62853 2086 2331', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(308, 'numa1234', 'Perorangan', 'Lana_Kitchen151', 'Kuliner', 'Mikro', 'Rp 2.000.000.000', 'Kp. Ciloa No. 151 RT 03 RW 10', 'Cingcin', 'Soreang', '2712220014648', NULL, NULL, NULL, NULL, NULL, 'online', 'offline', '0', 'Risol mayo, risol rogut sayur, cheesecuit', 'default.png', 'disetujui', '-', 'https://wa.me/628557842011', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(309, 'rita1234', 'RITA DAMAYANTI', 'Dapor Rakha', 'Kuliner', 'Menengah', 'Rp 15.000.000.000 - Rp 50.000.000.000', 'Kp.Simpang Wetan', 'Parungserab', 'Soreang', '2907220020585', NULL, NULL, NULL, NULL, NULL, '0', 'offline', 'agen_reseller', 'Kue basah', 'default.png', 'disetujui', '-', 'https://wa.me/6283821964884', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(310, 'roni1234', 'MyCollection', 'MyCollection', 'Fashion', 'Mikro', 'Rp 2.000.000.000', 'Bojong Kp. Cipandan Kidul RT 03 RW 13', 'Sadu', 'Soreang', '8120011292655', 'IDM000912350', '2063204012862-23', NULL, NULL, NULL, 'online', 'offline', 'agen_reseller', 'Baju Muslim', 'default.png', 'disetujui', '-', 'https://wa.me/6282218721327', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(315, 'test345', 'test12345', 'test12345', 'Kuliner', 'Kecil', 'Rp 2.000.000.000 - Rp 15.000.000.000', 'test345', 'Ancolmekar', 'Arjasari', '12312321321', NULL, NULL, NULL, NULL, NULL, 'online', '0', '0', 'asdasdsadsad', 'default.png', 'menunggu', '-', 'https://wa.me/6282218721327', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fullname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usertype` enum('Admin','Owner') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Admin',
  `nomor_hp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `fullname`, `usertype`, `nomor_hp`, `email`, `password`, `photo`) VALUES
('admin', 'Test Admin', 'Admin', '087976857', 'denipurwanto800@gmail.com', '$2y$10$eqvqlRdMyFpJzXltgUt77O0JyADq.fm2sIJJFVHm6E1M9.wHJsn8u', 'Transitions_2.gif'),
('akbar123', 'Muhammad Akbar Mutaqien, M.Pd.', 'Owner', '089667769604', 'mutiara.ovigroup@gmail.com', '$2a$10$qpWPAYWw9Qp9aXQI1q5tLuz9ayIzb4qFjMljjd0aJEYF5Vlf1MOI2', 'default.png'),
('Ani123', 'Ani Widiastuti', 'Owner', '085861237419', 'nukumafood@gmail.com', '$2a$10$0n6.jQWS3cQQJ6hKa17qiOxfbYSRFR4mSWDTPDa6aDshFTqhrSf/y', 'default.png'),
('ayu123', 'Ayu Ashari Achmad', 'Owner', '085967125798', 'balantik.id@gmail.com', '$2a$10$0Bxx1uv7rnpAYbWI6GaFCeHDkhZmg.nrjb8Bw31ufcWY7N09YtZDm', 'default.png'),
('david123', 'David Thio', 'Owner', '082365180180', '180degrees.clothing@gmail.com', '$2a$10$YyyZavA4Fxn.UvgbR4G4YO1lYw1g/I8qBv7EbAgE62QW49kC9yAPW', 'default.png'),
('lilis', 'Lilis Komariah', 'Owner', '082118276944', 'cv.globbestls@gmail.com', '$2a$10$3rRraB0NAMW35Ac1EvWvlelM22yANe7zBMs23R14I3cAQTOw4Jg0q', 'default.png'),
('nenden', 'Nenden Rospiani', 'Owner', '089656557573', 'restumande.id@gmail.com', '$2a$10$XkCMFzTQtqah2nriCDYU3ecchWgnwkMfNjF8vpT9z6dw6OUM4PL2K', 'default.png'),
('numa1234', 'Nurna Siti Nurjanah', 'Owner', '08557842011', 'numasiti@gmail.com', '$2a$10$wR5voecJTRoaU0Aqg1F4puGsLFm4F6HGCd4Vxbl8jvkMiasQurbHO', 'default.png'),
('nur12345', 'Nur Maedah', 'Owner', '089650570262', 'rafandacake@gmail.com', '$2a$10$EezcuyFwNW.oTUjJ1ghDUOB5Ld8IJQ3Bw8exY5cWMGorcF3uy/252', 'default.png'),
('Nurhayati123', 'Nurhayati', 'Owner', '085320862331', 'nurhayati@gmail.com', '$2a$10$CfFsIuFKINFbyI.bASnW7eQfJoBJqo2ep3R8AdFvcW3jrojj5BXs2', 'default.png'),
('owner123', 'Test Owner', 'Owner', '089765432112', 'testowner123@gmail.com', '$2a$10$oBhnmtmCmOkiQjKqj.2gUOeUSuzXkv4mnmHPccy.pqVoeUYrZJ8Ve', 'default.png'),
('rita1234', 'Rita Damayanti', 'Owner', '083821964884', 'ritadamayanti@gmail.com', '$2a$10$vmNSdpCljs.9.E//VIMRmO6xUc7d9kjyaKxTTLROZFjFNHTced18.', 'default.png'),
('roni1234', 'Roni Kusnaedi', 'Owner', '082218721327', 'roni123@gmail.com', '$2a$10$VgIi/VR.bt8XFsPaolJh1.xmZuuolN6F.8dUIbGfLVv10D/3xAcjO', 'default.png'),
('test345', 'test345', 'Owner', '0892173', 'test345@gmail.com', '$2a$10$BRctxQjcHFM6dvkLcLNQ7u2bC094io4ydH3GdA72J.YUryTS6DSoW', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `platform`
--
ALTER TABLE `platform`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_produk` (`id_produk`),
  ADD KEY `fk_username` (`username`);

--
-- Indeks untuk tabel `promosi`
--
ALTER TABLE `promosi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_username` (`username`);

--
-- Indeks untuk tabel `umkm`
--
ALTER TABLE `umkm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_umkm_users_username` (`username`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `platform`
--
ALTER TABLE `platform`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT untuk tabel `promosi`
--
ALTER TABLE `promosi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT untuk tabel `umkm`
--
ALTER TABLE `umkm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=316;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `platform`
--
ALTER TABLE `platform`
  ADD CONSTRAINT `platform_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Ketidakleluasaan untuk tabel `promosi`
--
ALTER TABLE `promosi`
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Ketidakleluasaan untuk tabel `umkm`
--
ALTER TABLE `umkm`
  ADD CONSTRAINT `fk_umkm_users_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
