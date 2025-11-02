Sistem Manajemen Aset dan Pengajuan Barang Inventaris Sekolah

Konsep Fitur & Alur Sistem

1. Pengguna (Role) Sistem
Role	Keterangan
Admin Tata Usaha	Mengelola data aset, ruang, dan inventaris; memverifikasi pengajuan; mengelola pengguna.
Pengguna Tata Usaha	Mengajukan permintaan barang/inventaris ke Yayasan melalui sistem.
Yayasan	Menerima dan memproses pengajuan barang dari Tata Usaha, mengatur persetujuan.
Pengguna Umum (Guru, Staff, dll)	Bisa melihat inventaris atau mengajukan permintaan barang jika perlu (opsional).
2. Modul & Fitur Utama Sistem
A. Manajemen Ruang

Input data ruang: Nama Ruang, Jenis Ruang (fungsi), Ukuran (kategori), Kondisi, Jumlah unit.

Kondisi ruang: Baik, Rusak Ringan, Sedang, Berat.

Fungsi ruang: Ruang Teori, Ruang Praktik, Ruang Administrasi, dll.

Laporan ruang: Statistik jumlah ruang berdasar ukuran, kondisi, dan fungsi.

Edit / Update data ruang.

B. Manajemen Aset dan Inventaris

Kategori Aset: Barang elektronik, furnitur, alat tulis, dll.

Input data aset: Nama barang, jumlah, kondisi, lokasi (ruang terkait).

Tracking aset: Status aset (baik/rusak), histori perawatan.

Laporan aset: Jumlah aset per kategori, kondisi, dan lokasi.

C. Pengajuan Barang

Form pengajuan barang oleh Tata Usaha:

Pilih barang yang ingin diajukan.

Isi jumlah, alasan, dan kebutuhan.

Status pengajuan: Draft → Kirim → Verifikasi Yayasan → Disetujui / Ditolak.

Notifikasi status pengajuan ke pengaju.

Riwayat pengajuan dapat dilihat oleh Tata Usaha dan Yayasan.

D. Manajemen Pengguna & Hak Akses

Admin Tata Usaha: Full akses manajemen data.

Tata Usaha (pengaju): Mengajukan barang, melihat status pengajuan.

Yayasan: Melihat dan menyetujui pengajuan.

User lain (opsional): hanya view data inventaris.

3. Alur Kerja Sistem
Alur Pengajuan Barang
Tata Usaha (buat pengajuan) 
        ↓
Kirim pengajuan
        ↓
Yayasan (verifikasi & persetujuan)
        ↓
Pengajuan disetujui atau ditolak
        ↓
Notifikasi status ke Tata Usaha

Alur Manajemen Ruang & Inventaris
Admin Tata Usaha → Input data ruang → Update kondisi dan jumlah ruang
           ↓
Input dan update data aset → Cek kondisi dan lokasi
           ↓
Laporan ruang dan aset → Analisa dan keputusan pengadaan baru

4. Struktur Data (Contoh Tabel Utama)
Tabel	Fungsi	Contoh Kolom Penting
users	Data pengguna	id, nama, email, role, password
ruang	Data ruang	id, nama_ruang, jenis_ruang, ukuran, kondisi, jumlah, fungsi
aset	Data barang inventaris	id, nama_aset, kategori, kondisi, jumlah, ruang_id
pengajuan	Data pengajuan barang	id, pengaju_id, tanggal, status, keterangan
detail_pengajuan	Item pengajuan	id, pengajuan_id, aset_id, jumlah, status
5. Tampilan Antarmuka (UI) Sederhana

Dashboard Ringkasan Aset & Ruang

Menu Manajemen Ruang

Menu Manajemen Aset

Menu Pengajuan Barang

Menu Persetujuan Yayasan

Menu Laporan (Ruang, Aset, Pengajuan)

6. Teknologi dan Pendekatan

Backend: PHP (misal dengan MVC sederhana atau framework ringan)

Frontend: HTML/CSS/JS + CDN untuk bootstrap, jQuery agar dinamis dan responsif.

Database: MySQL / MariaDB

Navigasi: Sidebar/menu navigasi tetap (fixed), konten halaman berganti tanpa reload berat.

AJAX untuk form submit dan update data supaya UX lebih baik.