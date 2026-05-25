MONECH - Figma Like Website (Laragon)

CARA JALANKAN:
1. Extract folder ini ke: C:\laragon\www\monech_figma_exact
2. Buka Laragon, klik Start All.
3. Buka http://localhost/phpmyadmin
4. Import file database/monech.sql
5. Buka browser: http://localhost/monech_figma_exact/
6. Daftar akun menggunakan ID alat MNC-001 atau ID alat lain.

CONFIG DATABASE:
api/config.php memakai default Laragon:
host=localhost, user=root, password kosong, database=monech

CATATAN:
- Project ini menggunakan PHP + MySQL + HTML/CSS/JS tanpa framework.
- Data grafik memakai tabel sensor_readings.
- Tombol Tambah Data Simulasi menambahkan data sensor baru ke database.
