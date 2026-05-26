USE monech;

SET @has_alamat := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'users'
    AND COLUMN_NAME = 'alamat'
);

SET @sql_alamat := IF(
  @has_alamat = 0,
  'ALTER TABLE users ADD COLUMN alamat VARCHAR(255) NOT NULL DEFAULT '''' AFTER id_alat',
  'SELECT ''Kolom alamat sudah ada'' AS info'
);

PREPARE stmt_alamat FROM @sql_alamat;
EXECUTE stmt_alamat;
DEALLOCATE PREPARE stmt_alamat;

SET @has_no_telepon := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'users'
    AND COLUMN_NAME = 'no_telepon'
);

SET @sql_no_telepon := IF(
  @has_no_telepon = 0,
  'ALTER TABLE users ADD COLUMN no_telepon VARCHAR(30) DEFAULT NULL AFTER alamat',
  'SELECT ''Kolom no_telepon sudah ada'' AS info'
);

PREPARE stmt_no_telepon FROM @sql_no_telepon;
EXECUTE stmt_no_telepon;
DEALLOCATE PREPARE stmt_no_telepon;

SET @has_foto_profil := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'users'
    AND COLUMN_NAME = 'foto_profil'
);

SET @sql_foto_profil := IF(
  @has_foto_profil = 0,
  'ALTER TABLE users ADD COLUMN foto_profil VARCHAR(255) DEFAULT NULL AFTER no_telepon',
  'SELECT ''Kolom foto_profil sudah ada'' AS info'
);

PREPARE stmt_foto_profil FROM @sql_foto_profil;
EXECUTE stmt_foto_profil;
DEALLOCATE PREPARE stmt_foto_profil;

SET @has_api_token := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'devices'
    AND COLUMN_NAME = 'api_token'
);

SET @sql_api_token := IF(
  @has_api_token = 0,
  'ALTER TABLE devices ADD COLUMN api_token VARCHAR(100) NOT NULL DEFAULT ''monech-device-001'' AFTER lokasi',
  'SELECT ''Kolom api_token sudah ada'' AS info'
);

PREPARE stmt_api_token FROM @sql_api_token;
EXECUTE stmt_api_token;
DEALLOCATE PREPARE stmt_api_token;

SET @has_last_seen := (
  SELECT COUNT(*)
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'devices'
    AND COLUMN_NAME = 'last_seen'
);

SET @sql_last_seen := IF(
  @has_last_seen = 0,
  'ALTER TABLE devices ADD COLUMN last_seen TIMESTAMP NULL DEFAULT NULL AFTER status',
  'SELECT ''Kolom last_seen sudah ada'' AS info'
);

PREPARE stmt_last_seen FROM @sql_last_seen;
EXECUTE stmt_last_seen;
DEALLOCATE PREPARE stmt_last_seen;

INSERT INTO devices (id_alat, nama_alat, lokasi, api_token, status)
SELECT
  u.id_alat,
  'MONECH Device',
  COALESCE(NULLIF(u.alamat, ''), 'Area Utama'),
  CASE
    WHEN u.id_alat REGEXP '^MNC-[0-9]+$'
      THEN CONCAT('monech-device-', LPAD(CAST(SUBSTRING(u.id_alat, 5) AS UNSIGNED), 3, '0'))
    ELSE CONCAT('monech-device-', LOWER(u.id_alat))
  END,
  'online'
FROM users u
LEFT JOIN devices d ON d.id_alat = u.id_alat
WHERE d.id_alat IS NULL;

UPDATE devices
SET api_token = CASE
  WHEN id_alat REGEXP '^MNC-[0-9]+$'
    THEN CONCAT('monech-device-', LPAD(CAST(SUBSTRING(id_alat, 5) AS UNSIGNED), 3, '0'))
  ELSE CONCAT('monech-device-', LOWER(id_alat))
END;
