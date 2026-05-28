# PPL-MONECH

Website monitoring kebocoran gas berbasis PHP, MySQL, HTML, CSS, dan JavaScript.

## Setup Singkat

1. Letakkan folder project di `C:\laragon\www\monech`.
2. Jalankan Laragon.
3. Import `database/monech_database.sql` melalui phpMyAdmin.
4. Jika database sudah pernah dibuat sebelumnya, jalankan juga `database/sync_existing_database.sql`.
5. Buka `http://localhost/monech/`.

## Catatan

- Konfigurasi database ada di `api/config.php`.
- Dashboard membaca data dari tabel `sensor_readings` berdasarkan `id_alat` user yang login.
- Endpoint data sensor membutuhkan session login.

## Integrasi ESP32 + MQ-2

- Endpoint alat: `api/device_reading.php`.
- Method: `POST`.
- Format JSON: `id_alat`, `token`, `gas_ppm`, `suhu`, `kelembapan`.
- Token alat bisa dilihat di halaman Profil setelah login.
- Untuk lebih dari satu alat, setiap ESP32 harus memakai pasangan `id_alat` dan token miliknya sendiri.
- Pola token mengikuti nomor alat, misalnya `MNC-002` memakai `monech-device-002`.
- Contoh kode ESP32 ada di `esp32_mq2_gascom.ino`.

Jika memakai Laragon lokal, `SERVER_URL` di kode ESP32 harus memakai IP laptop, bukan `localhost`.

## Notifikasi Telegram

Telegram dipilih karena paling ringan untuk project ini. WhatsApp otomatis biasanya butuh WhatsApp Business API atau layanan pihak ketiga.

Setup singkat:

1. Buat bot lewat Telegram `@BotFather`.
2. Ambil bot token.
3. Kirim pesan apa pun ke bot, atau masukkan bot ke group Telegram.
4. Cari `chat_id` memakai URL:
   `https://api.telegram.org/botTOKEN_BOT/getUpdates`
5. Copy `api/telegram_config.local.example.php` menjadi `api/telegram_config.local.php`.
6. Isi `TELEGRAM_BOT_TOKEN` dan `TELEGRAM_CHAT_ID`.

Notifikasi dikirim saat status sensor `danger`. Supaya tidak spam, notifikasi dibatasi 1 kali per 5 menit per alat.
