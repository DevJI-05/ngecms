# Laporan Pengerjaan Website Nusantara Gas Energy

**Klien:** PT. Nusantara Gas Energy
**Jenis Pekerjaan:** Pembuatan Website Company Profile + Sistem Admin (CMS)
**Durasi Pengerjaan:** 2 hari
**Status:** ✅ Selesai 100%

---

## Ringkasan Singkat

Website company profile dibangun dari desain awal menjadi website yang benar-benar bisa dipakai — lengkap dengan sistem admin supaya tim internal bisa update isi website sendiri (foto proyek, layanan, data tim, dll) **tanpa perlu bantuan programmer lagi**. Semua halaman juga sudah rapi dibuka dari HP, tablet, maupun laptop.

---

## Timeline Pengerjaan

### 🗓️ Hari ke-1 — Pembangunan Website & Tampilan

**1. Analisis desain & struktur halaman**
Meninjau 6 desain halaman yang sudah ada (Beranda, Tentang Kami, Layanan, Portofolio, Kontak, Template WhatsApp) untuk dipetakan menjadi struktur website yang rapi dan mudah dikembangkan ke depannya.

**2. Membangun 6 halaman utama website**
Setiap halaman disusun ulang jadi komponen-komponen kecil yang bisa dipakai berulang (contoh: kartu layanan, kartu proyek, tombol, navigasi) — supaya ke depannya kalau ada perubahan tampilan, cukup diubah di satu tempat saja dan otomatis berlaku ke semua halaman.

**3. Pasang alamat halaman (routing)**
Setiap halaman diberi alamat sendiri yang rapi: `/`, `/about`, `/contact`, `/portofolio`, `/services`, `/inquiry` — supaya bisa dibagikan dan diakses langsung.

**4. Penyesuaian font, ikon, dan warna**
Memastikan semua font, ikon, dan warna tampil identik dengan desain awal di semua browser.

**5. Uji coba tampilan & perbaikan teknis**
Melakukan pengecekan menyeluruh saat website diakses lewat berbagai metode (localhost, domain lokal, tunneling publik), sekaligus menyelesaikan beberapa kendala teknis koneksi yang muncul di tengah proses testing.

**6. Membuat tampilan responsive (mobile-friendly)**
Seluruh halaman dirapikan ulang supaya nyaman dilihat di HP, tablet, maupun laptop — termasuk menu navigasi yang otomatis berubah jadi menu geser (hamburger menu) di layar kecil, dan semua kotak/gambar/tombol menyesuaikan ukuran layar secara otomatis.

---

### 🗓️ Hari ke-2 — Sistem Admin (CMS) & Database

**7. Instalasi sistem admin (Filament)**
Memasang panel admin di alamat `/admin` lengkap dengan halaman login khusus untuk pemilik website.

**8. Pembuatan akun superadmin**
Membuat 1 akun khusus pemilik website yang punya akses penuh untuk mengelola seluruh isi website.

**9. Membangun 8 modul pengelolaan data**, masing-masing dengan fitur tambah / ubah / hapus data:
   - Data Portofolio Proyek (12 proyek)
   - Data Layanan Perusahaan (5 layanan)
   - Data Pesan Masuk dari Pengunjung (Inquiry / calon klien)
   - Data Sejarah & Pencapaian Perusahaan (9 milestone)
   - Data Sertifikasi & Izin Usaha (6 sertifikat)
   - Data Struktur Organisasi & Tim (11 posisi, lengkap dengan hierarki jabatan)
   - Data Nilai-Nilai Perusahaan (6 nilai)
   - Pengaturan Umum Website (alamat, telepon, jam operasional, kontak PIC, angka statistik)

**10. Migrasi seluruh isi website ke database**
Semua teks, angka, dan data yang sebelumnya "tertanam" langsung di kode website dipindahkan ke database — artinya sekarang bisa diubah kapan saja lewat halaman admin, tanpa perlu edit kode sama sekali.

**11. Menghubungkan halaman ke sistem admin**
Semua 6 halaman website disambungkan ke database, jadi begitu ada perubahan data di admin panel, otomatis langsung tampil di website.

**12. Mengaktifkan form kontak yang sesungguhnya**
Form "Hubungi Kami" yang tadinya cuma simulasi, sekarang benar-benar menyimpan data pengunjung ke database dan bisa dipantau/ditindaklanjuti lewat admin panel (status: Baru → Dihubungi → Selesai).

**13. Pengecekan kualitas & pengujian akhir**
Menjalankan serangkaian pengecekan otomatis (format kode, validasi tipe data, build produksi) untuk memastikan seluruh sistem berjalan tanpa error sebelum dinyatakan selesai.

---

## Hasil Akhir

✅ Website company profile lengkap 6 halaman, sudah online dan siap diakses
✅ Tampilan rapi & nyaman dibuka dari perangkat apa saja (HP/tablet/laptop)
✅ Sistem admin (CMS) untuk kelola semua konten sendiri tanpa perlu programmer
✅ Form kontak yang benar-benar menyimpan data calon klien
✅ 8 modul data yang bisa diatur bebas lewat panel admin
✅ Semua sudah melalui pengujian teknis sebelum serah terima

---

## Catatan untuk Langkah Berikutnya

- Ganti password akun admin default sebelum website dipakai publik secara resmi.
- Tim internal bisa mulai belajar pakai panel admin di `/admin` untuk update konten kapan saja.
