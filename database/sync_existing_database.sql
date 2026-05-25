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
