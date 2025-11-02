-- PHP fallback backup: 2025-10-26 06:06:26

-- Table structure for `aset`

CREATE TABLE `aset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(100) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `sumber_dana` varchar(100) DEFAULT NULL,
  `satuan_barang` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga_satuan` int(11) DEFAULT NULL,
  `nilai_perolehan` int(11) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `no_inv` varchar(50) DEFAULT NULL,
  `pengguna_barang` varchar(50) DEFAULT NULL,
  `baik` int(11) DEFAULT NULL,
  `kurang_baik` int(11) DEFAULT NULL,
  `rusak` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `aset`
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('19','Meja pimpinan','kayu jati','2025-10-19','yayasan','buah','2','700000','1400000','2023','hall001','PETUGAS','2','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('20','Meja panjang','kayu','2023-11-14','yayasan','buah','4','12000000','48000000','2023','hall002','PETUGAS','4','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('21','kursi pimpinan','putar','2023-07-19','yayasan','buah','4','600000','2400000','2023','hall003','PETUGAS','2','2','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('22','kursi ','besi','2023-10-19','yayasan','buah','20','150000','3000000','2023','hall004','PETUGAS','19','1','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('23','meja besar','kayu kaca','2023-10-19','yayasan','buah','5','1500000','7500000','2023','hall004','PETUGAS','5','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('24','sound','hupper 10 in','2023-10-19','yayasan','paket','1','4000000','4000000','2023','hall005','PETUGAS','1','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('25','mic werelss','shure','2023-10-02','yayasan','buah','1','700000','700000','2023','hall006','PETUGAS','1','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('26','ac','gree','2023-10-01','yayasan','buah','1','3000000','3000000','2023','hall007','PETUGAS','1','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('27','access point','ruigiae','2023-10-19','yayasan','pcs','1','1300000','1300000','2023','hall008','PETUGAS','1','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('28','komputer','campur','2022-10-18','yayasan','unit','4','5000000','20000000','2022','wk001','PETUGAS','4','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('29','meja','kayu','2021-10-12','yayasan','buah','7','800000','5600000','2021','wk002','PETUGAS','7','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('30','kursi','informa','2024-10-01','yayasan','buah','5','700000','3500000','2024','wk003','PETUGAS','5','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('31','lemari','besi brother','2019-10-01','yayasan','buah','4','3000000','12000000','2019','wk005','PETUGAS','4','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('32','printer','canon','2021-10-01','yayasan','buah','4','2000000','8000000','2021','wk006','PETUGAS','4','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('33','rak','besi','2022-10-06','yayasan','buah','8','1000000','8000000','2022','perpus001','PERPUS','8','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('34','komputer','asus','2024-10-01','yayasan','unit','1','4500000','4500000','2024','perpus002','PERPUS','1','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('35','compresor','krisbow','2023-10-04','yayasan','buah','1','10000000','10000000','2023','tkr01','TKR','1','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('38','lemari','brother','2025-10-20','Yayasan','Buah','4','3000000','12000000','2025','WAKA-001','WAKA','4','0','8');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('39','telfon','telkom','2025-10-20','yayasan','buah','1','500000','500000','2025','TU-001','TU','0','0','1');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('40','kom','kom','2025-10-20','Yayasan','Pcs','1','1','1','2025','ADMIN-001','ADMIN','1','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('41','kom','kom','2025-10-20','Yayasan','Pcs','1','10000','10000','2025','TKJ-001','TKJ','1','0','0');
INSERT INTO `aset` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`baik`,`kurang_baik`,`rusak`) VALUES ('42','Tang','Tang','2025-10-23','Yayasan','Pcs','1','20000','20000','2025','TKJ-002','TKJ','1','0','1');

-- Table structure for `lokasi`

CREATE TABLE `lokasi` (
  `id_lokasi` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(100) NOT NULL,
  PRIMARY KEY (`id_lokasi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `lokasi`
INSERT INTO `lokasi` (`id_lokasi`,`nama_lokasi`) VALUES ('1','RUANG GURU');

-- Table structure for `pengadaan`

CREATE TABLE `pengadaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(100) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `sumber_dana` varchar(100) DEFAULT NULL,
  `satuan_barang` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga_satuan` double DEFAULT NULL,
  `nilai_perolehan` double DEFAULT NULL,
  `tahun` varchar(10) DEFAULT NULL,
  `no_inv` varchar(50) DEFAULT NULL,
  `pengguna_barang` varchar(50) DEFAULT NULL,
  `status` enum('Diajukan','Disetujui','Ditolak') DEFAULT 'Diajukan',
  `menunggu` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `pengadaan`
INSERT INTO `pengadaan` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`status`,`menunggu`) VALUES ('30','kipas angin','maspion','2025-10-20','yayasan','buah','2','500000','1000000','2025',NULL,'WAKA','Diajukan',NULL);
INSERT INTO `pengadaan` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`status`,`menunggu`) VALUES ('31','kkkk','llll','2025-10-20','yyy','kkk','1','1000000','1000000','2025',NULL,'TKJ','Disetujui',NULL);
INSERT INTO `pengadaan` (`id`,`nama_barang`,`merk`,`tanggal`,`sumber_dana`,`satuan_barang`,`jumlah`,`harga_satuan`,`nilai_perolehan`,`tahun`,`no_inv`,`pengguna_barang`,`status`,`menunggu`) VALUES ('32','Memori','Sun','2025-10-23','Yayasan','Pcs','1','50000','50000','2025',NULL,'TKJ','Diajukan',NULL);

-- Table structure for `ruang`

CREATE TABLE `ruang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ruang` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `ruang`
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('1','Hallmeet');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('2','Waka');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('3','KS');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('4','guru');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('5','bendahara');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('6','TU');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('7','bk');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('8','lab dkv 1');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('9','lab dkv 2');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('10','lab dkv 3');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('11','lab dkv ');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('12','lab dpib');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('13','kantor dpib');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('14','kantor tkj');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('15','lab bd');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('16','lab jaringan');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('17','lab tkj 1');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('18','lab tkj 2');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('19','bengkel tkr');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('20','bengkel tkr pk');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('21','bengkel tsm');
INSERT INTO `ruang` (`id`,`nama_ruang`) VALUES ('22','perpustakaan');

-- Table structure for `ruang_kantor`

CREATE TABLE `ruang_kantor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_ruangan` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `ukuran` varchar(50) DEFAULT NULL,
  `kondisi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `ruang_kantor`
INSERT INTO `ruang_kantor` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('3','Wakil Kepala Sekolah2','2','8x71','Baik');
INSERT INTO `ruang_kantor` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('10','Ruang Progli TKJ','1','1x1','Baik');
INSERT INTO `ruang_kantor` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('11','Ruang Progli DKV','1','8x7','Baik');
INSERT INTO `ruang_kantor` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('35','bendahara','1','8x7','Baik');

-- Table structure for `ruang_kelas`

CREATE TABLE `ruang_kelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ruang` varchar(100) NOT NULL,
  `jumlah_ruang` int(11) DEFAULT 0,
  `meja_jumlah` int(11) DEFAULT 0,
  `meja_baik` int(11) DEFAULT 0,
  `meja_rusak_ringan` int(11) DEFAULT 0,
  `meja_rusak_berat` int(11) DEFAULT 0,
  `kursi_jumlah` int(11) DEFAULT 0,
  `kursi_baik` int(11) DEFAULT 0,
  `kursi_rusak_ringan` int(11) DEFAULT 0,
  `kursi_rusak_berat` int(11) DEFAULT 0,
  `almari_jumlah` int(11) DEFAULT 0,
  `almari_baik` int(11) DEFAULT 0,
  `almari_rusak_ringan` int(11) DEFAULT 0,
  `almari_rusak_berat` int(11) DEFAULT 0,
  `papan_jumlah` int(11) DEFAULT 0,
  `papan_baik` int(11) DEFAULT 0,
  `papan_rusak_ringan` int(11) DEFAULT 0,
  `papan_rusak_berat` int(11) DEFAULT 0,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `ruang_kelas`
INSERT INTO `ruang_kelas` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jumlah`,`meja_baik`,`meja_rusak_ringan`,`meja_rusak_berat`,`kursi_jumlah`,`kursi_baik`,`kursi_rusak_ringan`,`kursi_rusak_berat`,`almari_jumlah`,`almari_baik`,`almari_rusak_ringan`,`almari_rusak_berat`,`papan_jumlah`,`papan_baik`,`papan_rusak_ringan`,`papan_rusak_berat`,`tanggal_update`) VALUES ('17','bd','1','4','1','0','2','1','1','0','0','1','1','0','0','1','1','0','0','2025-10-21 10:16:21');
INSERT INTO `ruang_kelas` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jumlah`,`meja_baik`,`meja_rusak_ringan`,`meja_rusak_berat`,`kursi_jumlah`,`kursi_baik`,`kursi_rusak_ringan`,`kursi_rusak_berat`,`almari_jumlah`,`almari_baik`,`almari_rusak_ringan`,`almari_rusak_berat`,`papan_jumlah`,`papan_baik`,`papan_rusak_ringan`,`papan_rusak_berat`,`tanggal_update`) VALUES ('18','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2025-10-22 09:34:05');
INSERT INTO `ruang_kelas` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jumlah`,`meja_baik`,`meja_rusak_ringan`,`meja_rusak_berat`,`kursi_jumlah`,`kursi_baik`,`kursi_rusak_ringan`,`kursi_rusak_berat`,`almari_jumlah`,`almari_baik`,`almari_rusak_ringan`,`almari_rusak_berat`,`papan_jumlah`,`papan_baik`,`papan_rusak_ringan`,`papan_rusak_berat`,`tanggal_update`) VALUES ('19','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2025-10-22 09:38:47');
INSERT INTO `ruang_kelas` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jumlah`,`meja_baik`,`meja_rusak_ringan`,`meja_rusak_berat`,`kursi_jumlah`,`kursi_baik`,`kursi_rusak_ringan`,`kursi_rusak_berat`,`almari_jumlah`,`almari_baik`,`almari_rusak_ringan`,`almari_rusak_berat`,`papan_jumlah`,`papan_baik`,`papan_rusak_ringan`,`papan_rusak_berat`,`tanggal_update`) VALUES ('20','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2025-10-22 09:55:46');
INSERT INTO `ruang_kelas` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jumlah`,`meja_baik`,`meja_rusak_ringan`,`meja_rusak_berat`,`kursi_jumlah`,`kursi_baik`,`kursi_rusak_ringan`,`kursi_rusak_berat`,`almari_jumlah`,`almari_baik`,`almari_rusak_ringan`,`almari_rusak_berat`,`papan_jumlah`,`papan_baik`,`papan_rusak_ringan`,`papan_rusak_berat`,`tanggal_update`) VALUES ('21','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2025-10-22 09:56:37');
INSERT INTO `ruang_kelas` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jumlah`,`meja_baik`,`meja_rusak_ringan`,`meja_rusak_berat`,`kursi_jumlah`,`kursi_baik`,`kursi_rusak_ringan`,`kursi_rusak_berat`,`almari_jumlah`,`almari_baik`,`almari_rusak_ringan`,`almari_rusak_berat`,`papan_jumlah`,`papan_baik`,`papan_rusak_ringan`,`papan_rusak_berat`,`tanggal_update`) VALUES ('22','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2025-10-22 09:58:16');
INSERT INTO `ruang_kelas` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jumlah`,`meja_baik`,`meja_rusak_ringan`,`meja_rusak_berat`,`kursi_jumlah`,`kursi_baik`,`kursi_rusak_ringan`,`kursi_rusak_berat`,`almari_jumlah`,`almari_baik`,`almari_rusak_ringan`,`almari_rusak_berat`,`papan_jumlah`,`papan_baik`,`papan_rusak_ringan`,`papan_rusak_berat`,`tanggal_update`) VALUES ('23','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2025-10-22 09:59:51');
INSERT INTO `ruang_kelas` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jumlah`,`meja_baik`,`meja_rusak_ringan`,`meja_rusak_berat`,`kursi_jumlah`,`kursi_baik`,`kursi_rusak_ringan`,`kursi_rusak_berat`,`almari_jumlah`,`almari_baik`,`almari_rusak_ringan`,`almari_rusak_berat`,`papan_jumlah`,`papan_baik`,`papan_rusak_ringan`,`papan_rusak_berat`,`tanggal_update`) VALUES ('24','','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','2025-10-22 10:00:44');

-- Table structure for `ruang_kelas_perabot`

CREATE TABLE `ruang_kelas_perabot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ruang` varchar(100) DEFAULT NULL,
  `jumlah_ruang` int(11) DEFAULT NULL,
  `meja_jml` int(11) DEFAULT NULL,
  `meja_baik` int(11) DEFAULT NULL,
  `meja_ringan` int(11) DEFAULT NULL,
  `meja_berat` int(11) DEFAULT NULL,
  `kursi_jml` int(11) DEFAULT NULL,
  `kursi_baik` int(11) DEFAULT NULL,
  `kursi_ringan` int(11) DEFAULT NULL,
  `kursi_berat` int(11) DEFAULT NULL,
  `almari_jml` int(11) DEFAULT NULL,
  `almari_baik` int(11) DEFAULT NULL,
  `almari_ringan` int(11) DEFAULT NULL,
  `almari_berat` int(11) DEFAULT NULL,
  `papan_jml` int(11) DEFAULT NULL,
  `papan_baik` int(11) DEFAULT NULL,
  `papan_ringan` int(11) DEFAULT NULL,
  `papan_berat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `ruang_kelas_perabot`
INSERT INTO `ruang_kelas_perabot` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jml`,`meja_baik`,`meja_ringan`,`meja_berat`,`kursi_jml`,`kursi_baik`,`kursi_ringan`,`kursi_berat`,`almari_jml`,`almari_baik`,`almari_ringan`,`almari_berat`,`papan_jml`,`papan_baik`,`papan_ringan`,`papan_berat`) VALUES ('2','bd','1','1','1','1','0','1','0','1','0','1','0','1','0','1','0','1','0');
INSERT INTO `ruang_kelas_perabot` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jml`,`meja_baik`,`meja_ringan`,`meja_berat`,`kursi_jml`,`kursi_baik`,`kursi_ringan`,`kursi_berat`,`almari_jml`,`almari_baik`,`almari_ringan`,`almari_berat`,`papan_jml`,`papan_baik`,`papan_ringan`,`papan_berat`) VALUES ('3','tkj','1','20','23','5','0','40','30','5','5','0','0','0','0','1','1','0','0');
INSERT INTO `ruang_kelas_perabot` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jml`,`meja_baik`,`meja_ringan`,`meja_berat`,`kursi_jml`,`kursi_baik`,`kursi_ringan`,`kursi_berat`,`almari_jml`,`almari_baik`,`almari_ringan`,`almari_berat`,`papan_jml`,`papan_baik`,`papan_ringan`,`papan_berat`) VALUES ('4','qqq','11','1','1','0','0','1','1','0','0','1','1','0','0','1','1','0','0');
INSERT INTO `ruang_kelas_perabot` (`id`,`nama_ruang`,`jumlah_ruang`,`meja_jml`,`meja_baik`,`meja_ringan`,`meja_berat`,`kursi_jml`,`kursi_baik`,`kursi_ringan`,`kursi_berat`,`almari_jml`,`almari_baik`,`almari_ringan`,`almari_berat`,`papan_jml`,`papan_baik`,`papan_ringan`,`papan_berat`) VALUES ('5','tkjA','1','100','1','1','1','0','0','0','0','0','0','0','0','0','0','0','0');

-- Table structure for `ruang_lainnya`

CREATE TABLE `ruang_lainnya` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_ruangan` varchar(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `ukuran` varchar(50) DEFAULT NULL,
  `kondisi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `ruang_lainnya`
INSERT INTO `ruang_lainnya` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('8','xii tkr1','12','8x7','Baik');
INSERT INTO `ruang_lainnya` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('9','rt','1','8x71','Baik');
INSERT INTO `ruang_lainnya` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('10','rw','1','8x71','Baik');

-- Table structure for `ruang_penunjang`

CREATE TABLE `ruang_penunjang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_ruangan` varchar(150) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 0,
  `ukuran` varchar(50) DEFAULT NULL,
  `kondisi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `ruang_penunjang`
INSERT INTO `ruang_penunjang` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('1','olahraga','11','8x71','Baik');
INSERT INTO `ruang_penunjang` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('2','lapangana','1','8x7','Baik');
INSERT INTO `ruang_penunjang` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('10','xii tkr1','1','8x7','Rusak Sedang');
INSERT INTO `ruang_penunjang` (`id`,`jenis_ruangan`,`jumlah`,`ukuran`,`kondisi`) VALUES ('11','11weww','1','8x71','Baik');

-- Table structure for `ruang_teori`

CREATE TABLE `ruang_teori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kondisi` varchar(50) DEFAULT NULL,
  `ukuran_8x9` int(11) DEFAULT NULL,
  `ukuran_lebih73` int(11) DEFAULT NULL,
  `ukuran_kurang73` int(11) DEFAULT NULL,
  `jumlah_ruang` int(11) DEFAULT NULL,
  `baik` int(11) DEFAULT NULL,
  `rusak_ringan` int(11) DEFAULT NULL,
  `rusak_sedang` int(11) DEFAULT NULL,
  `rusak_berat` int(11) DEFAULT NULL,
  `ruang_digunakan` int(11) DEFAULT NULL,
  `jumlah_keseluruhan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `ruang_teori`
INSERT INTO `ruang_teori` (`id`,`kondisi`,`ukuran_8x9`,`ukuran_lebih73`,`ukuran_kurang73`,`jumlah_ruang`,`baik`,`rusak_ringan`,`rusak_sedang`,`rusak_berat`,`ruang_digunakan`,`jumlah_keseluruhan`) VALUES ('1','ruang 01','12','1','0','1','1','0','0','0','0','1');
INSERT INTO `ruang_teori` (`id`,`kondisi`,`ukuran_8x9`,`ukuran_lebih73`,`ukuran_kurang73`,`jumlah_ruang`,`baik`,`rusak_ringan`,`rusak_sedang`,`rusak_berat`,`ruang_digunakan`,`jumlah_keseluruhan`) VALUES ('2','ruang 02','5','5','5','30','5','5','5','5','5','35');

-- Table structure for `user`

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for `user`
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('1','admin','admin123','admin');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('2','dpib','dpib123','dpib');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('3','tkr','tkr123','tkr');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('4','tkj','tkj123','tkj');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('5','tsm','tsm123','tsm');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('6','dkv','dkv123','dkv');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('7','bd','bd123','bd');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('8','petugas','petugas123','petugas');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('9','perpus','perpus321','perpus');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('10','hallmeet','hallmeet321','hallmeet');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('11','waka','waka321','waka');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('12','ks','ks321','ks');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('13','guru','guru321','guru');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('14','bendahara','bendahara321','bendahara');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('15','tu','tu321','tu');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('16','informatika','informatika123','informatika');
INSERT INTO `user` (`id`,`username`,`password`,`level`) VALUES ('17','tkrpk','tkrpk123','tkrpk');

