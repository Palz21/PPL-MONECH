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
