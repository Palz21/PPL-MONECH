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
