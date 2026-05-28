MONECH - Website Monitoring Gas (Laragon)

CARA JALANKAN:
1. Extract/copy folder ini ke: C:\laragon\www\monech
2. Buka Laragon, klik Start All.
3. Buka http://localhost/phpmyadmin
4. Buat/import database dari file database/monech_database.sql
5. Jika database lama sudah pernah di-import, jalankan juga database/sync_existing_database.sql
6. Buka browser: http://localhost/monech/
7. Daftar akun menggunakan ID alat MNC-001 atau ID alat lain.

CATATAN LOGIN DAN DATA:
- Register dan login memakai tabel users.
- Field users yang dibutuhkan: nama, email, id_alat, alamat, no_telepon, password_hash.
- Data dashboard diambil dari sensor_readings sesuai id_alat user yang login.
- Data realtime dikirim dari ESP32 ke api/device_reading.php memakai token alat.

CONFIG DATABASE:
api/config.php memakai default Laragon:
host=localhost, user=root, password kosong, database=monech

CATATAN:
- Project ini menggunakan PHP + MySQL + HTML/CSS/JS tanpa framework.
- Data grafik memakai tabel sensor_readings.
- Contoh kode ESP32 + MQ-2 ada di esp32_mq2_gascom.ino.
- Token alat bisa dilihat di halaman Profil setelah login.
- Jika ada lebih dari satu alat, setiap ESP32 harus memakai ID alat dan token miliknya sendiri.
- Pola token mengikuti nomor alat, contoh MNC-002 memakai monech-device-002.

NOTIFIKASI TELEGRAM:
1. Buat bot lewat @BotFather.
2. Ambil token bot.
3. Kirim pesan ke bot atau masukkan bot ke group.
4. Buka https://api.telegram.org/botTOKEN_BOT/getUpdates untuk melihat chat_id.
5. Copy api/telegram_config.local.example.php menjadi api/telegram_config.local.php.
6. Isi TELEGRAM_BOT_TOKEN dan TELEGRAM_CHAT_ID.
7. Notifikasi dikirim saat status sensor danger, maksimal 1 kali per 5 menit per alat.
