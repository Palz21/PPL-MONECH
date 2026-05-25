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
- Tombol Tambah Data Simulasi hanya bisa dipakai setelah login.

CONFIG DATABASE:
api/config.php memakai default Laragon:
host=localhost, user=root, password kosong, database=monech

CATATAN:
- Project ini menggunakan PHP + MySQL + HTML/CSS/JS tanpa framework.
- Data grafik memakai tabel sensor_readings.
- Tombol Tambah Data Simulasi menambahkan data sensor baru ke database untuk user yang login.
