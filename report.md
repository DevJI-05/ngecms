# Laporan Pengerjaan — Website Nusantara Gas Energi

**Klien:** PT. Nusantara Gas Energi
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
- [x] **2026-09-25** — Fitur export CSV untuk data Inquiry di panel admin; fitur upload gambar untuk Portfolio Projects (tampil menggantikan ikon di kartu & detail proyek publik); struktur organisasi (Team Members) diubah dari 4 level tetap menjadi level angka otomatis tak terbatas (mengikuti siapa yang dilapori/"Reports To"), tampilan pohon organisasi di halaman Tentang Kami dirombak jadi render otomatis mengikuti kedalaman berapa pun
- [x] **2026-09-28** — Batas ukuran upload file (max 5MB) tidak lagi hardcode, sekarang bisa diatur admin lewat Site Settings; perbaikan proporsi & posisi logo NGE serta rapikan alignment tombol "Hubungi Kami" di navbar; background canvas Struktur Organisasi (halaman Tentang Kami) dibuat full-width/responsive; tab "Company Profile" di Site Settings diganti nama jadi "General" dan judul tab browser sekarang otomatis ikut nama perusahaan yang di-set di Site Settings; dropdown "Jenis Layanan" pada form Inquiry publik (/contact) disinkronkan otomatis dengan data Services di CMS (tidak hardcode lagi) dan menambahkan field isian manual saat memilih "Lainnya"; fitur export data Inquiry diubah dari CSV menjadi Excel (XLSX) dengan streamed response, ditambah pilihan export semua data atau rentang tanggal tertentu, disertai progress bar real-time saat proses export berjalan
- [x] **2026-09-29** — Perbaikan bug production: (1) export Inquiry yang stuck di 0% — penyebabnya job export jalan lewat queue (`QUEUE_CONNECTION=database`) tapi server tidak punya queue worker aktif, jadi job menumpuk tak terproses; diubah jadi dijalankan langsung/synchronous saat tombol export ditekan, tidak lagi bergantung pada queue worker; (2) upload gambar Portfolio Project gagal ("failed to upload") meskipun ukuran file di bawah batas 5MB yang diset — root cause-nya ternyata dobel: server PHP punya batas `upload_max_filesize`/`post_max_size` default yang lebih kecil dari 5MB (diperbaiki lewat `public/.user.ini` & `public/.htaccess`), dan konfigurasi Nginx di VPS (`client_max_body_size`) belum di-set di blok `server` HTTPS (443) sehingga request ditolak duluan oleh Nginx sebelum sampai ke PHP (diperbaiki dengan menambahkan `client_max_body_size 20m;` di config Nginx VPS)

## Belum dikerjakan / potensi lanjutan

- [ ] Ganti password default superadmin sebelum dipakai publik secara resmi
- [ ] Samakan sumber nomor WhatsApp di semua halaman (masih ada yang hardcoded, belum semua pakai Site Settings)
- [ ] Tambah test otomatis untuk beberapa bagian yang belum tercover
