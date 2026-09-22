# Laporan Pengerjaan — Website Nusantara Gas Energy

**Klien:** PT. Nusantara Gas Energy
**Status:** ✅ Selesai, dalam tahap pemeliharaan/perbaikan lanjutan

## Progress

- [x] **2026-08-19** — Setup awal proyek: struktur website, seed akun admin default
- [x] **2026-08-21** — Pasang favicon & logo, perbaikan tahun di footer (2026)
- [x] **2026-08-24** — Perbaikan footer, perbaikan password admin
- [x] **2026-08-26** — Perbaikan username akun admin
- [x] **2026-08-27** — Fitur ganti password di panel admin, penerjemahan ke Inggris, perapian tampilan admin
- [x] **2026-09-01** — Perkuat validasi form (warna hex, telepon, email, angka) di seluruh form admin
- [x] **2026-09-02** — Tambah fitur pemilih ikon (icon picker); perbaikan bug struktur organisasi (mencegah hierarki berputar/circular)
- [x] **2026-09-14** — Pisahkan halaman Sertifikasi dari halaman Tentang Kami; aktifkan form "New Inquiry" manual di panel admin
- [x] **2026-09-16** — Verifikasi laporan bug validasi desimal pada field Scale & Display Order (Portofolio Proyek): sudah tertutup di kode, dites ulang lulus 10/10; ditemukan penyebab tampilan Navbar tidak konsisten di halaman internal adalah build frontend yang belum di-rebuild setelah perbaikan terakhir (bukan bug kode)
- [x] **2026-09-22** — Perbaikan form Inquiry publik (/contact): tampilkan pesan error per field saat gagal submit, toast notifikasi saat berhasil (posisi kanan atas), wajibkan & validasi format nomor telepon (maks. 14 digit) dan email; hapus scaffold login/dashboard bawaan Laravel (Fortify) karena login sudah terpusat lewat panel admin Filament

## Belum dikerjakan / potensi lanjutan

- [ ] Ganti password default superadmin sebelum dipakai publik secara resmi
- [ ] Samakan sumber nomor WhatsApp di semua halaman (masih ada yang hardcoded, belum semua pakai Site Settings)
- [ ] Tambah test otomatis untuk beberapa bagian yang belum tercover
