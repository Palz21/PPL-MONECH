CREATE DATABASE IF NOT EXISTS monech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE monech;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  id_alat VARCHAR(50) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS devices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_alat VARCHAR(50) NOT NULL UNIQUE,
  nama_alat VARCHAR(100) DEFAULT 'MONECH Device',
  lokasi VARCHAR(120) DEFAULT 'Area Utama',
  status ENUM('online','offline','warning','danger') DEFAULT 'online',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS sensor_readings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_alat VARCHAR(50) NOT NULL,
  gas_ppm INT NOT NULL,
  suhu DECIMAL(5,2) NOT NULL,
  kelembapan DECIMAL(5,2) NOT NULL,
  status ENUM('safe','warning','danger') NOT NULL DEFAULT 'safe',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX(id_alat), INDEX(created_at)
);

INSERT IGNORE INTO devices (id_alat, nama_alat, lokasi, status) VALUES
('MNC-001','MONECH Sensor 01','Dapur / Kitchen','online');

INSERT INTO sensor_readings (id_alat, gas_ppm, suhu, kelembapan, status, created_at) VALUES
('MNC-001',120,28.4,65,'safe',NOW() - INTERVAL 7 HOUR),
('MNC-001',135,28.7,64,'safe',NOW() - INTERVAL 6 HOUR),
('MNC-001',210,29.0,63,'safe',NOW() - INTERVAL 5 HOUR),
('MNC-001',345,29.8,61,'warning',NOW() - INTERVAL 4 HOUR),
('MNC-001',280,29.2,62,'safe',NOW() - INTERVAL 3 HOUR),
('MNC-001',430,30.1,59,'warning',NOW() - INTERVAL 2 HOUR),
('MNC-001',180,28.9,64,'safe',NOW() - INTERVAL 1 HOUR),
('MNC-001',155,28.6,66,'safe',NOW());
