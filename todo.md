# TODO — Filament CMS untuk Nusantara Gas Energy

Status: **Selesai.** Filament v4 ter-install di `/admin`, 7 Resource + 1 Settings page dibuat, semua data
dipindah dari hardcoded Vue/TS ke database, dan ke-6 halaman publik (`resources/js/pages/gas/`) sekarang
mengambil kontennya lewat Inertia props dari controller (bukan lagi hardcoded).

Login superadmin: `admin@nusantaragas.co.id` / `password` (ganti sebelum deploy ke production).

## Selesai

- [x] **Portfolio Projects** — model `PortfolioProject`, resource `app/Filament/Resources/PortfolioProjects/`, seeder `PortfolioProjectSeeder` (12 proyek). Dipakai di `Portfolio.vue` & teaser `Home.vue`.
- [x] **Services** — model `Service`, resource `app/Filament/Resources/Services/`, seeder `ServiceSeeder` (5 layanan). Dipakai di `Services.vue` & teaser `Home.vue`.
- [x] **Inquiries (leads)** — model `Inquiry`, resource read/edit-only (tanpa Create — leads masuk dari form publik), form `Contact.vue` sekarang submit sungguhan ke `POST /contact` (`ContactController@store`) dan tersimpan di DB, bisa dikelola & diubah status follow-up-nya di Filament.
- [x] **Company Timeline / Milestones** — model `Milestone`, resource `Milestones`, seeder (9 milestone). Dipakai di tab "Sejarah & Pencapaian" `About.vue`.
- [x] **Certifications** — model `Certification`, resource `Certifications`, seeder (6 sertifikat). Dipakai di `About.vue` tab Sertifikasi.
- [x] **Team / Org Structure** — model `TeamMember` (self-referencing `parent_id` + `level`), resource `TeamMembers`, seeder membangun hierarki Komisaris → Direktur Utama → 3 Direktur → 6 Departemen. `About.vue` tab Struktur Organisasi sekarang render dinamis dari data ini (bukan markup hardcoded lagi).
- [x] **Company Values (nilai-nilai)** — model `CompanyValue`, resource `CompanyValues`, seeder (6 nilai). Dipakai di `About.vue` tab Profil.
- [x] **Site Settings** — model `SiteSetting` (single row via `SiteSetting::current()`), Filament Settings page `App\Filament\Pages\ManageSiteSettings` (`/admin/manage-site-settings`). Mengelola kontak, jam operasional, PIC, dan angka statistik hero — dipakai di `Home.vue`, `About.vue`, `Contact.vue`, `Portfolio.vue`, `Services.vue`, `Inquiry.vue`.

## Verifikasi yang sudah dijalankan

- `php artisan migrate:fresh --seed` — bersih dari awal.
- `vendor/bin/pint`, `npx eslint`, `npx vue-tsc --noEmit`, `npm run build` — semua lulus.
- `vendor/bin/phpstan analyse` — lulus (1 error pre-existing di `UserFactory.php`, tidak terkait perubahan ini).
- Smoke test semua route publik (`/`, `/about`, `/contact`, `/portofolio`, `/services`, `/inquiry`, `/admin/login`) → HTTP 200, tanpa error di log server.
- Verifikasi login superadmin (`canAccessPanel`) dan penyimpanan Inquiry lewat model — berhasil.

## Belum dikerjakan / potensi lanjutan

- [ ] Ganti password default superadmin sebelum production.
- [ ] `whatsapp_number` dari Site Settings baru dipakai penuh di halaman Inquiry; halaman About/Portfolio/Services/Contact masih pakai nomor default hardcoded di `resources/js/lib/whatsapp.ts` untuk tombol "Chat WA" — bisa dirapikan supaya semua pakai `settings.whatsapp_number` dari CMS.
- [ ] Belum ada test otomatis (Pest) untuk `ContactController@store` maupun Filament Resource — kalau mau menambah test coverage untuk CI.
