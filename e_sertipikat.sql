CREATE DATABASE IF NOT EXISTS e_sertipikat CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE e_sertipikat;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  role ENUM('admin','operator','viewer') DEFAULT 'operator',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE assets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  no_aset VARCHAR(50) NOT NULL UNIQUE,
  unit_induk VARCHAR(150),
  unit_pelaksana VARCHAR(150),
  nomor_aset_sap VARCHAR(100),
  nama_aset VARCHAR(255),
  luas_m2 DECIMAL(15,2) DEFAULT 0,
  jenis_dokumen_legal VARCHAR(150),
  berlaku_awal DATE NULL,
  berlaku_akhir DATE NULL,
  alamat TEXT,
  desa_kelurahan VARCHAR(150),
  kecamatan VARCHAR(150),
  kabupaten_kota VARCHAR(150),
  provinsi VARCHAR(100) DEFAULT 'Sumatera',
  kantah VARCHAR(150),
  kanwil VARCHAR(150),
  harga_perolehan DECIMAL(20,2) DEFAULT 0,
  kondisi_aset VARCHAR(100),
  tahun_perolehan YEAR NULL,
  nilai_saat_ini DECIMAL(20,2) DEFAULT 0,
  tahun_penilaian YEAR NULL,
  dokumen_legal_terbit VARCHAR(150),
  nomor_dokumen_legal VARCHAR(150),
  tanggal_dokumen_awal DATE NULL,
  tanggal_dokumen_akhir DATE NULL,
  luas_legal_m2 DECIMAL(15,2) DEFAULT 0,
  stakeholder VARCHAR(255),
  koordinat_x DECIMAL(14,8) NULL,
  koordinat_y DECIMAL(14,8) NULL,
  kendala VARCHAR(255),
  narasi_kendala TEXT,
  penguasaan_tanah VARCHAR(150),
  jenis_bangunan VARCHAR(150),
  bulan_realisasi TINYINT NULL,
  tahun_realisasi YEAR NULL,
  aplikasi VARCHAR(150),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE progress_sertifikasi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  asset_id INT NOT NULL,
  pemberkasan DATE NULL,
  pendaftaran_pengukuran DATE NULL,
  sps1_terbayar DATE NULL,
  pengukuran DATE NULL,
  terbit_peta_bidang DATE NULL,
  pendaftaran_permohonan_hak DATE NULL,
  sps2_terbayar DATE NULL,
  kegiatan_panitia_a DATE NULL,
  terbit_sk_hak DATE NULL,
  pendaftaran_sk_turun_hak DATE NULL,
  sps3_terbayar DATE NULL,
  status ENUM('Belum Mulai','Berjalan','Selesai') DEFAULT 'Belum Mulai',
  catatan TEXT,
  FOREIGN KEY (asset_id) REFERENCES assets(id) ON DELETE CASCADE
);

INSERT INTO users (username,password,nama,role)
VALUES ('admin', MD5('admin123'), 'Administrator UIP3B Sumatera', 'admin');

INSERT INTO assets
(no_aset,unit_induk,unit_pelaksana,nomor_aset_sap,nama_aset,luas_m2,jenis_dokumen_legal,provinsi,kondisi_aset,harga_perolehan,nilai_saat_ini,tahun_perolehan,tahun_penilaian,aplikasi)
VALUES
('AST-001','UIP3B Sumatera','UPT Medan','SAP-001','Tanah Gardu Induk Medan',12500,'Sertipikat Hak Pakai','Sumatera Utara','Baik',2500000000,3200000000,2018,2025,'e-Sertipikat'),
('AST-002','UIP3B Sumatera','UPT Pekanbaru','SAP-002','Tanah Gardu Induk Pekanbaru',8700,'Sertipikat Hak Guna Bangunan','Riau','Baik',1800000000,2200000000,2019,2025,'e-Sertipikat'),
('AST-003','UIP3B Sumatera','UPT Palembang','SAP-003','Lahan Transmisi Palembang',15300,'Target Sertipikasi','Sumatera Selatan','Perlu Legalitas',900000000,1100000000,2020,2025,'e-Sertipikat');

INSERT INTO progress_sertifikasi(asset_id,status,pemberkasan,pendaftaran_pengukuran,sps1_terbayar,pengukuran,catatan)
VALUES (1,'Berjalan','2025-01-10','2025-02-15','2025-02-20','2025-03-05','Menunggu tahap peta bidang'),
       (2,'Selesai','2024-03-10','2024-04-15','2024-04-20','2024-05-01','Dokumen lengkap'),
       (3,'Berjalan','2025-05-10',NULL,NULL,NULL,'Menunggu pendaftaran pengukuran');
