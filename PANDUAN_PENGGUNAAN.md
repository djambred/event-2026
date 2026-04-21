# Buku Panduan Penggunaan Aplikasi
# Esa Unggul International Event 2026

---

## Daftar Isi

1. [Gambaran Umum Aplikasi](#1-gambaran-umum-aplikasi)
2. [Struktur & Peran Pengguna](#2-struktur--peran-pengguna)
3. [Halaman Publik (Frontend)](#3-halaman-publik-frontend)
4. [Proses Pendaftaran Peserta](#4-proses-pendaftaran-peserta)
5. [Portal Peserta](#5-portal-peserta)
6. [Panel Admin (Dashboard)](#6-panel-admin-dashboard)
   - 6.1 [Login Admin](#61-login-admin)
   - 6.2 [Event Settings](#62-event-settings)
   - 6.3 [Manajemen Kategori Lomba](#63-manajemen-kategori-lomba)
   - 6.4 [Manajemen Registrasi Peserta](#64-manajemen-registrasi-peserta)
   - 6.5 [Kriteria Penilaian (Judging Criteria)](#65-kriteria-penilaian-judging-criteria)
   - 6.6 [Judge Mapping](#66-judge-mapping)
   - 6.7 [Template Sertifikat](#67-template-sertifikat)
   - 6.8 [Pengumuman (Announcements)](#68-pengumuman-announcements)
   - 6.9 [FAQ](#69-faq)
   - 6.10 [Manajemen Pengguna Admin](#610-manajemen-pengguna-admin)
7. [Panel Juri](#7-panel-juri)
   - 7.1 [Login Juri](#71-login-juri)
   - 7.2 [Daftar Peserta di Panel Juri](#72-daftar-peserta-di-panel-juri)
   - 7.3 [Proses Penilaian Seleksi](#73-proses-penilaian-seleksi)
   - 7.4 [Proses Penilaian Grand Final](#74-proses-penilaian-grand-final)
8. [Alur Lengkap Event (End-to-End)](#8-alur-lengkap-event-end-to-end)
9. [Pengaturan Profil Admin / Juri](#9-pengaturan-profil-admin--juri)
10. [Pertanyaan Umum (Troubleshooting)](#10-pertanyaan-umum-troubleshooting)

---

## 1. Gambaran Umum Aplikasi

Aplikasi ini adalah platform manajemen event kompetisi **Esa Unggul International Event 2026**, yang mencakup:

- **Website publik** — Halaman beranda, peraturan, pendaftaran, dan pengumuman untuk peserta.
- **Portal Peserta** — Dashboard pribadi peserta untuk memantau status, mengunggah video, dan mengunduh sertifikat.
- **Panel Admin** — Dashboard admin untuk mengelola seluruh aspek event: registrasi, penilaian, sertifikat, pengumuman, dan pengaturan konten website.
- **Panel Juri** — Dashboard khusus juri untuk melakukan penilaian peserta berdasarkan kategori yang ditugaskan.

---

## 2. Struktur & Peran Pengguna

| Peran | Akses | Keterangan |
|-------|-------|-----------|
| `super_admin` | Panel Admin penuh | Dapat mengakses semua fitur termasuk manajemen pengguna, pengaturan event, dan laporan |
| `user` | Panel Admin terbatas | Akses admin namun tanpa manajemen pengguna sensitif |
| `jury` | Panel Juri saja | Hanya bisa menilai peserta di kategori yang ditugaskan; tidak bisa akses panel admin |
| Peserta | Portal Peserta | Login dengan email + Register Key; hanya bisa akses data pendaftaran sendiri |

> **Catatan:** Satu akun admin/juri tidak dapat login ke kedua panel sekaligus. Super admin dapat mengakses kedua panel.

---

## 3. Halaman Publik (Frontend)

URL utama: `https://[domain-aplikasi]/`

### 3.1 Beranda (`/`)

Halaman utama yang menampilkan:
- Hero section dengan judul dan deskripsi event
- Highlight kategori lomba (National & International)
- Road to Excellence — timeline tahapan event
- Daftar kategori lomba aktif
- Pengumuman terbaru yang sudah dipublish
- FAQ (Pertanyaan yang sering diajukan)
- Informasi kontak dan footer

### 3.2 Peraturan (`/rules`)

Menampilkan peraturan lengkap setiap kategori lomba, meliputi:
- Ketentuan umum
- Aturan pendaftaran & Zoom
- Tema cerita/pidato
- Aturan video submission
- Kriteria penilaian
- Aturan Grand Final

### 3.3 Pengumuman (`/announcements`)

Menampilkan semua pengumuman yang sudah dipublish:
- **Info** — Pengumuman umum & jadwal
- **Zoom Meeting** — Link Zoom untuk workshop/seleksi
- **Winner Announcement** — Pengumuman pemenang per kategori

---

## 4. Proses Pendaftaran Peserta

### 4.1 Pendaftaran Nasional

URL: `/registration/national`

**Persyaratan:**
- Siswa SMA/SMK Sederajat di Indonesia

**Data yang diisi:**
| Field | Keterangan |
|-------|-----------|
| Nama Lengkap | Sesuai identitas resmi |
| Email | Email aktif (digunakan untuk login portal) |
| WhatsApp | Format: `+62xxx` atau `08xxx` |
| Asal Sekolah/Institusi | Nama lengkap sekolah |
| Kategori Lomba | Pilih kategori yang tersedia untuk nasional |
| Foto Seragam Sekolah | Upload foto (JPG/PNG/PDF, maks 5MB) |
| Bukti Pembayaran | Upload bukti transfer (JPG/PNG/PDF, maks 5MB) |
| URL YouTube | Link video yang sudah diunggah (opsional, bisa diisi belakangan) |
| Captcha | Jawab soal penjumlahan untuk verifikasi |

**Setelah submit:**
1. Sistem akan menampilkan **Register Key** (format: `REG-XXXXXXXX`)
2. **Register Key ini hanya tampil sekali!** Simpan dengan aman.
3. Peserta langsung diarahkan ke Portal Peserta.

> **Penting:** Register Key adalah password awal untuk login portal. Peserta disarankan segera menggantinya di menu *Change Password*.

### 4.2 Pendaftaran Internasional

URL: `/registration/international`

**Persyaratan:**
- Mahasiswa aktif (Diploma/S1/S2/S3) dari institusi lokal maupun internasional

**Data yang diisi:**
| Field | Keterangan |
|-------|-----------|
| Nama Lengkap | Sesuai identitas resmi |
| Email | Email aktif |
| WhatsApp | Format internasional (contoh: `+1xxxxxxxxxx`) |
| Asal Institusi | Nama universitas/perguruan tinggi |
| Kategori Lomba | Pilih kategori yang tersedia untuk internasional |
| Dokumen Identitas | KTM atau Paspor (JPG/PNG/PDF, maks 5MB) |
| Foto Formal 3x4 | Upload foto formal (JPG/PNG, maks 5MB) |
| URL YouTube | Link video (opsional) |
| Captcha | Jawab soal penjumlahan untuk verifikasi |

Proses setelah submit sama dengan pendaftaran nasional.

---

## 5. Portal Peserta

URL: `/participant/login`

### 5.1 Login

1. Masukkan **Email** yang didaftarkan
2. Masukkan **Register Key** (format `REG-XXXXXXXX`) atau password baru jika sudah diganti
3. Jawab captcha
4. Klik **Login**

> Jika status pendaftaran `rejected`, portal akan dikunci dan peserta tidak bisa login.

### 5.2 Dashboard Portal

Setelah login, peserta dapat melihat:

**Info Status:**
- Badge status: `Pending` (kuning) / `Confirmed` (hijau) / `Rejected` (merah)
- Badge tahap: `Seleksi` / `Finalist` / `Grand Final` / `Eliminated`
- Nama kategori lomba

**Banner Tahap:**
- Jika lolos seleksi → Banner hijau "Selamat! Anda Lolos ke Grand Final"
- Jika masuk Grand Final → Banner amber
- Jika tereliminasi → Banner abu-abu dengan skor & peringkat seleksi

**Informasi Pengumuman:**
- Pengumuman terbaru yang relevan dengan kategori peserta

**Informasi Skor (jika sudah dinilai):**
- Progress penilaian: berapa juri yang sudah menilai vs total juri yang ditugaskan
- Detail nilai rata-rata per kriteria dari semua juri

**Dokumen yang Diupload:**
- Daftar berkas pendaftaran (Foto Seragam, Bukti Pembayaran, KTM/Paspor, Foto Formal)
- Klik tombol berkas → **preview langsung di modal** tanpa keluar halaman
  - Gambar (JPG/PNG): ditampilkan sebagai gambar
  - File lain (PDF): ditampilkan dalam iframe embedded
- Tombol **Buka** tersedia untuk membuka file di tab baru

### 5.3 Upload Video YouTube

1. Di portal, temukan bagian **Video Submission**
2. Tempel link YouTube video penampilan
3. Klik **Update Video**
4. Video akan dapat diputar langsung di portal

> Video harus diupload ke YouTube terlebih dahulu (bisa private atau unlisted), kemudian link-nya dimasukkan di sini.

### 5.4 Unduh Sertifikat

Tombol unduh sertifikat muncul secara otomatis sesuai kondisi:

| Jenis Sertifikat | Kondisi Tampil |
|-----------------|----------------|
| **Sertifikat Partisipasi** | Status `confirmed` + template partisipasi aktif tersedia untuk kategori peserta |

Klik tombol → PDF sertifikat akan diunduh langsung.

### 5.5 Ganti Password

URL: `/participant/change-password`

1. Masukkan password baru (minimal 8 karakter)
2. Konfirmasi password baru
3. Jawab captcha
4. Klik **Change Password**

> Sangat disarankan ganti password dari Register Key awal ke password pilihan sendiri.

### 5.6 Logout

Klik tombol **Logout** di pojok kanan atas portal.

---

## 6. Panel Admin (Dashboard)

URL: `/ueu/` (panel admin utama)

### 6.1 Login Admin

1. Buka URL panel admin
2. Masukkan email dan password akun admin
3. Klik **Sign in**

Akun default (dari seeder):
| Email | Password | Role |
|-------|----------|------|
| `admin@admin.com` | `password` | super_admin |
| `rubica@admin.com` | `password` | super_admin |
| `arya@admin.com` | `password` | super_admin |

> **Penting:** Segera ganti password default setelah pertama kali login di produksi!

### 6.2 Event Settings

Menu: **Event Management → Event Settings**

Halaman pengaturan konten website yang dibagi dalam tab:

#### Tab General
- **Site Info:** Judul website, deskripsi, nama penyelenggara
- **Contact:** Email, telepon, lokasi, alamat lengkap, deskripsi footer
- **Payment:** Nama bank, nomor rekening, nama rekening

#### Tab Home Page
- **Hero Section:** Judul, subjudul, deskripsi, badge text, gambar hero
- **Highlights Section:** Teks kartu National & International
- **Categories Section:** Judul & deskripsi bagian kategori
- **Road to Excellence:** Judul, gambar, deskripsi Workshop, Grand Final Day 1 & 2

#### Tab Dates & Timeline
- Semua tanggal penting event: registrasi, workshop, video submission, seleksi, pengumuman finalis, technical meeting, grand final
- Toggle **Registration Open** untuk membuka/menutup pendaftaran
- Informasi venue (onsite & online)

#### Tab Storytelling (EN), Storytelling (ID), Public Speaking
- Pengaturan konten halaman peraturan per kategori lomba:
  - Judul kompetisi & kategori
  - Ketentuan umum (satu baris = satu poin)
  - Aturan pendaftaran & Zoom
  - Tema & aturan video
  - Kriteria penilaian (format: `Nama Kriteria|Persentase%`)
  - Aturan Grand Final

#### Tab Registration Page
- Gambar hero halaman pendaftaran nasional & internasional
- Teks deskripsi halaman pendaftaran

#### Tab FAQ
- Kelola daftar FAQ yang tampil di beranda
- Tambah/edit/hapus pertanyaan & jawaban
- Atur urutan tampil dengan field `Sort Order`
- Toggle aktif/nonaktif per item FAQ

Setelah mengubah pengaturan apapun, klik tombol **Save** di bagian bawah halaman.

---

### 6.3 Manajemen Kategori Lomba

Menu: **Event Management → Competition Categories**

#### Daftar Kategori
Tabel menampilkan semua kategori lomba beserta status aktif, ketersediaan nasional/internasional, dan harga.

#### Tambah Kategori Baru
Klik **New Competition Category**, isi:

| Field | Keterangan |
|-------|-----------|
| Name | Nama kategori (contoh: `English Storytelling`) |
| Slug | URL-friendly name, auto-generate dari nama |
| Description | Deskripsi kategori |
| Icon | Nama ikon Material Symbols (contoh: `auto_stories`) |
| Type | `Individual` atau `Group` |
| Available for National | Toggle aktifkan untuk pendaftaran nasional |
| Price (National) | Biaya pendaftaran nasional (Rp) |
| Available for International | Toggle aktifkan untuk pendaftaran internasional |
| Price (International) | Biaya pendaftaran internasional (Rp) |
| Active | Toggle untuk menonaktifkan kategori tanpa menghapus |

Klik **Create** untuk menyimpan.

#### Edit Kategori
Klik ikon edit (pensil) di baris kategori, ubah data, klik **Save**.

---

### 6.4 Manajemen Registrasi Peserta

Menu: **Event Management → Registrations**

#### Tampilan Daftar

Tabel menampilkan semua pendaftar dengan kolom:
- ID, Tipe (National/International), Nama, Email, Institusi, Kategori
- **Status:** `Pending` (kuning) / `Confirmed` (hijau) / `Rejected` (merah)
- **Stage:** `Seleksi` / `Finalist` / `Grand Final` / `Eliminated`
- Skor Seleksi, Peringkat Seleksi, Skor Grand Final, Peringkat Grand Final
- Link YouTube, Tanggal Daftar
- Foto (Seragam, Bukti Bayar, KTM, Foto Formal) — bisa di-toggle

#### Filter

Gunakan tombol **Filters** untuk menyaring data berdasarkan:
- Tipe registrasi (National/International)
- Status
- Kategori lomba
- Stage

#### Verifikasi Pendaftaran

Untuk setiap baris dengan status `Pending`, tersedia dua aksi:

**Confirm (✅):** Klik → konfirmasi → status berubah ke `Confirmed`

**Reject (❌):** Klik → konfirmasi → status berubah ke `Rejected`

> Peserta dengan status `Rejected` tidak dapat login ke portal.

#### Detail Registrasi

Klik nama peserta atau ikon **View** (mata) untuk melihat detail lengkap:
- Semua data profil & dokumen
- Preview video YouTube (jika ada)
- Dokumen yang diupload (foto seragam, bukti bayar, dll.)
- Tab **Scoring** untuk melihat dan mengelola nilai

#### Mengelola Tahap (Stage) Peserta

Di halaman Edit registrasi, admin dapat mengubah field **Stage**:

| Stage | Keterangan |
|-------|-----------|
| `selection` | Tahap seleksi (default) |
| `finalist` | Lolos seleksi, maju ke Grand Final |
| `grandfinal` | Sedang di Grand Final |
| `eliminated` | Tereliminasi di seleksi |

> **Catatan:** Peserta dengan stage `eliminated` **tidak** akan tampil di panel juri, meskipun status-nya `confirmed`.

#### Hitung Skor Otomatis

Tombol **Calculate Score** (ikon kalkulator) tersedia di daftar, untuk peserta `confirmed` yang sudah memiliki nilai:

1. Klik **Calculate Score** → konfirmasi
2. Sistem otomatis menghitung: $\text{Final Score} = \sum_{i} \frac{\text{avg\_score}_i \times \text{weight}_i}{100}$
3. Sistem memperbarui **rank** untuk semua peserta dalam kategori yang sama

> Hitung skor kembali setiap kali ada nilai baru masuk dari juri.

#### Input Nilai oleh Super Admin (Seolah Semua Juri)

Jika super admin ingin menginput nilai atas nama seluruh juri sekaligus (misalnya menerima nilai offline dari juri):

1. Buka detail peserta → tab **Scoring**
2. Klik tombol **Input Nilai Semua Juri** (panel geser/slide-over)
3. Panel menampilkan kolom input untuk **setiap juri** per **setiap kriteria** — misalnya 3 juri = 3 kolom per kriteria
4. Isi nilai (0–10) untuk masing-masing kombinasi juri × kriteria
5. Klik **Save** → nilai tersimpan atas nama masing-masing akun juri

> - Nilai yang sudah ada akan ditampilkan sebagai nilai awal
> - Kolom kosong tidak akan ditimpa
> - Fitur ini hanya tersedia untuk admin (tidak tampil di panel juri)

#### Generate Sertifikat

**Sertifikat Partisipasi:**
- Tombol **Participation Certificate** muncul untuk peserta `confirmed`
- Klik → konfirmasi → PDF sertifikat di-generate dan disimpan
- Path file tersimpan di field `participation_certificate`

> Sistem hanya menyediakan sertifikat partisipasi. Sertifikat pemenang tidak tersedia.

---

### 6.5 Kriteria Penilaian (Judging Criteria)

Menu: **Event Management → Judging Criteria**

Kriteria penilaian adalah komponen-komponen yang dinilai oleh juri, beserta bobot persentasenya.

#### Tambah Kriteria Baru

Klik **New Judging Criteria**, isi:

| Field | Keterangan |
|-------|-----------|
| Competition Category | Pilih kategori lomba yang berlaku |
| Name | Nama kriteria (contoh: `Content & Creativity`) |
| Description | Penjelasan kriteria |
| Weight (%) | Bobot persentase (contoh: `30`) — total semua kriteria per kategori harus = 100% |
| Sort Order | Urutan tampil (angka lebih kecil = tampil lebih atas) |

> **Penting:** Pastikan total bobot semua kriteria dalam satu kategori = 100%. Jika tidak, perhitungan skor tidak akan akurat.

**Contoh konfigurasi:**
```
Kategori: English Storytelling
- Story Mastery & Content Understanding | 30%
- Vocal Quality & Delivery              | 25%
- Language Fluency & Accuracy          | 20%
- Expression & Stage Presence          | 15%
- Appearance & Costume                 | 10%
Total: 100%
```

---

### 6.6 Judge Mapping

Menu: **Event Management → Judge Mapping**

Halaman ini digunakan untuk menugaskan juri ke kategori lomba tertentu.

> Juri hanya bisa menilai kategori yang sudah ditugaskan. Jika tidak ada penugasan, juri tidak akan melihat peserta apapun.

#### Melihat Daftar Juri

Tabel menampilkan semua akun dengan role `jury` beserta kategori yang sudah ditugaskan.

#### Menugaskan Kategori ke Juri

1. Klik ikon **Edit** (pensil) di baris juri yang ingin dikonfigurasi
2. Di bagian **Competition Assignment**, pilih satu atau lebih kategori lomba
3. Klik **Save**

> Untuk menambah akun juri baru, buat terlebih dahulu di menu **Users** dengan role `jury`.

---

### 6.7 Template Sertifikat

Menu: **Event Management → Certificate Templates**

#### Jenis Template

| Jenis | Keterangan |
|-------|-----------|
| `participation` | Sertifikat partisipasi untuk semua peserta yang dikonfirmasi |

> Hanya tipe **participation** yang tersedia. Sertifikat pemenang tidak digunakan.

#### Membuat Template Baru

Klik **New Certificate Template**, isi:

| Field | Keterangan |
|-------|-----------|
| Name | Nama template (contoh: `Participant Certificate - Storytelling`) |
| Type | Participation |
| Competition Category | Kategori yang berlaku (kosongkan untuk template umum) |
| Background Design | Upload gambar latar sertifikat (JPG/PNG, opsional) |
| Active | Toggle aktif/nonaktif |

**Jika menggunakan latar gambar custom:**
- Upload gambar background sertifikat
- Atur posisi nama peserta (X%, Y%), ukuran font, warna teks
- Atur posisi nama kategori

**Jika tidak menggunakan gambar (HTML template bawaan):**
- Atur ukuran font nama, warna
- Atur ukuran font kategori, warna
- Sistem akan generate sertifikat HTML yang elegan

#### Preview & Sample PDF

Tersedia dua tombol:
- **Preview** — melihat tampilan HTML sertifikat langsung di panel
- **Sample PDF** — mengunduh contoh PDF dengan nama `John Doe` sebagai placeholder

> Hanya satu template per kategori yang bisa aktif pada satu waktu. Jika Anda mengaktifkan template baru, template lama untuk kategori yang sama akan otomatis dinonaktifkan.

---

### 6.8 Pengumuman (Announcements)

Menu: **Event Management → Announcements**

#### Jenis Pengumuman

| Tipe | Keterangan |
|------|-----------|
| `info` | Pengumuman umum — jadwal, informasi penting |
| `zoom` | Link Zoom Meeting untuk workshop/seleksi/grand final |
| `winner` | Pengumuman pemenang — menampilkan daftar pemenang secara otomatis |

#### Membuat Pengumuman Baru

Klik **New Announcement**, isi:

| Field | Keterangan |
|-------|-----------|
| Competition Category | Kategori yang relevan dengan pengumuman |
| Type | Info / Zoom / Winner |
| Title | Judul pengumuman |
| Description | Isi pengumuman |
| Zoom Meeting URL | *(hanya tampil jika tipe = zoom)* URL Zoom meeting |
| Number of Winners | *(hanya tampil jika tipe = winner)* Jumlah pemenang yang ditampilkan |
| Published | Toggle untuk mempublish |
| Publish Date | Tanggal & waktu publish |

#### Pengumuman Pemenang (Winner Announcement)

Pengumuman tipe `winner` bekerja secara otomatis:
1. Sistem mengambil peserta `confirmed` yang sudah memiliki `final_score` dan `rank`
2. Menampilkan N pemenang teratas sesuai field **Number of Winners**
3. Hanya satu pengumuman pemenang aktif per kategori pada satu waktu — jika ada yang baru dipublish, pengumuman lama otomatis dinonaktifkan

> Pastikan sudah menjalankan **Calculate Score** untuk semua peserta sebelum membuat winner announcement.

---

### 6.9 FAQ

FAQ dikelola melalui **Event Settings → Tab FAQ**.

Fitur:
- Tambah pertanyaan & jawaban baru
- Edit pertanyaan yang ada
- Hapus FAQ
- Atur urutan dengan **Sort Order**
- Toggle aktif/nonaktif per FAQ

FAQ yang aktif akan tampil di halaman beranda publik.

---

### 6.10 Manajemen Pengguna Admin

Menu: **Administration → Users**

#### Daftar Pengguna

Tabel menampilkan semua pengguna sistem (bukan peserta) beserta role yang dimiliki.

#### Tambah Pengguna Admin Baru

Klik **New User**, isi:

| Field | Keterangan |
|-------|-----------|
| Name | Nama lengkap |
| Avatar | Upload foto profil (opsional) |
| Email | Email untuk login |
| Password | Password (minimal 8 karakter) |
| Password Confirmation | Konfirmasi password |
| Roles | Pilih role: `super_admin`, `user`, atau `jury` |
| Assigned Competition Categories | *(khusus role jury)* Pilih kategori yang ditugaskan |

#### Membuat Akun Juri

1. Klik **New User**
2. Isi nama, email, password
3. Di bagian **Roles**, pilih `jury`
4. Di bagian **Assigned Competition Categories**, pilih kategori yang boleh dinilai juri ini
5. Klik **Create**

> Alternatif: Buat akun juri dari sini, lalu tugaskan kategori melalui menu **Judge Mapping**.

---

## 7. Panel Juri

URL: `/jury/` (panel khusus juri)

### 7.1 Login Juri

1. Buka URL panel juri: `/jury/`
2. Masukkan email dan password akun juri
3. Klik **Sign in**

Panel juri hanya menampilkan satu menu: **Portal Juri**.

---

### 7.2 Daftar Peserta di Panel Juri

Di panel juri, daftar peserta yang tampil sudah difilter otomatis:
- Status `confirmed` saja (pending & rejected tidak tampil)
- Stage **bukan** `eliminated` (peserta yang tereliminasi tidak tampil)
- Hanya kategori lomba yang **sudah ditugaskan** ke juri tersebut

Kolom yang tampil untuk juri:
- Nama peserta
- Institusi
- Kategori lomba
- Stage (Seleksi / Finalist / Grand Final)
- Link video YouTube (jika sudah diupload)

> Kolom lain seperti email, status pembayaran, dan skor tidak ditampilkan ke juri.

---

### 7.3 Proses Penilaian Seleksi

#### Langkah 1: Pilih Peserta

Klik tombol **Nilai Peserta** di baris peserta → halaman penilaian langsung terbuka.

Halaman juri menampilkan informasi minimal:
- Nama peserta
- Institusi
- Kategori lomba
- Stage
- Preview video YouTube

Scoring panel tersedia langsung di bawah informasi peserta.

#### Langkah 2: Inisialisasi Score (Dianjurkan)

Di tab **Scoring**:
1. Pastikan tab **📋 Seleksi** aktif (default)
2. Klik tombol **Initialize All Criteria**
3. Konfirmasi → sistem membuat entri skor `0` untuk semua kriteria
4. Juri tinggal mengubah nilainya sesuai penilaian

#### Langkah 3: Isi Nilai

Dua cara mengisi nilai:

**Cara 1 — Edit langsung di tabel:**
- Klik kolom **Score** di baris kriteria
- Ketik angka (range: `0` – `10`, bisa desimal seperti `8.5`)
- Tekan Enter atau klik di luar untuk menyimpan otomatis

**Cara 2 — Tambah via form:**
- Klik **Add Single Score**
- Pilih kriteria, isi nilai, tambah catatan (opsional)
- Klik **Create**

#### Langkah 4: Verifikasi Skor

Kolom **Weighted** menampilkan nilai tertimbang setiap kriteria:

$$\text{Weighted} = \frac{\text{Score} \times \text{Weight}}{100}$$

Juri hanya melihat nilai yang mereka sendiri berikan (bukan nilai juri lain).

---

### 7.4 Proses Penilaian Grand Final

Penilaian Grand Final hanya tersedia untuk peserta yang sudah di-set ke stage `finalist` atau `grandfinal` oleh admin.

#### Buka Tab Grand Final

Di panel Scoring, klik tombol **🏆 Grand Final** (tombol ini hanya muncul jika peserta sudah menjadi finalis).

Selanjutnya langkah sama dengan penilaian seleksi. Semua skor tersimpan dengan `round = grandfinal` — terpisah dari nilai seleksi.

> Menilai di tab Grand Final tidak mempengaruhi nilai seleksi.

---

## 8. Alur Lengkap Event (End-to-End)

Berikut adalah urutan workflow event dari awal hingga akhir:

```
1. PERSIAPAN (Admin)
   ├── Buat kategori lomba (Competition Categories)
   ├── Tambah kriteria penilaian per kategori (Judging Criteria)
   ├── Buat akun juri (Users → role jury)
   ├── Tugaskan juri ke kategori (Judge Mapping)
   ├── Upload template sertifikat (Certificate Templates)
   └── Atur konten website (Event Settings)

2. PENDAFTARAN (Peserta)
   ├── Peserta mendaftar di /registration/national atau /registration/international
   ├── Peserta menerima Register Key
   └── Peserta login ke Portal Peserta

3. VERIFIKASI PENDAFTARAN (Admin)
   ├── Buka Registrations → filter Status = Pending
   ├── Review dokumen yang diupload (bukti bayar, KTM, foto)
   └── Klik Confirm atau Reject

4. WORKSHOP & VIDEO SUBMISSION (Peserta)
   ├── Admin buat pengumuman Zoom (tipe: zoom) dengan link meeting
   ├── Peserta menghadiri Zoom Workshop
   ├── Peserta merekam dan upload video ke YouTube
   └── Peserta input link YouTube di Portal Peserta

5. TAHAP SELEKSI (Admin + Juri)
   ├── Juri login ke /jury/ → hanya melihat peserta confirmed & non-eliminated
   ├── Setiap juri klik "Nilai Peserta" → isi nilai per kriteria
   ├── ALTERNATIF: Admin klik "Input Nilai Semua Juri" → isi nilai ketiga juri sekaligus
   ├── Admin klik "Calculate Score" untuk setiap peserta yang sudah dinilai
   └── Rank otomatis diperbarui

6. PENGUMUMAN FINALIS (Admin)
   ├── Update Stage peserta yang lolos ke "finalist"
   ├── Update Stage peserta yang tidak lolos ke "eliminated"
   └── Buat Announcement tipe "info" atau "winner" untuk pengumuman publik

7. GRAND FINAL (Admin + Juri)
   ├── Admin update Stage finalis ke "grandfinal"
   ├── Admin buat pengumuman Zoom untuk Technical Meeting & Grand Final
   ├── Juri menilai di tab Grand Final
   └── Admin klik "Calculate Score" lagi (skor Grand Final)

8. PENGUMUMAN PEMENANG (Admin)
   ├── Skor Grand Final & rank otomatis terupdate via Calculate Score
   ├── Buat Announcement tipe "winner" per kategori
   └── Pengumuman otomatis menampilkan top N pemenang

9. SERTIFIKAT (Admin)
   └── Klik "Participation Certificate" untuk setiap peserta confirmed

10. PESERTA DOWNLOAD SERTIFIKAT
    └── Login portal → tombol "Participation Certificate" tersedia
```

---

## 9. Pengaturan Profil Admin / Juri

Klik nama pengguna di pojok kanan atas panel → **Edit Profile**

Yang dapat diubah:
- Nama
- Email
- Avatar / foto profil
- Password

Fitur tambahan:
- **Active Sessions** — Melihat sesi login yang aktif dari browser/perangkat lain
- **Logout Other Sessions** — Keluar dari semua sesi selain yang sekarang (memerlukan konfirmasi password)

---

## 10. Pertanyaan Umum (Troubleshooting)

### Peserta

**Q: Saya lupa Register Key, bagaimana cara login?**
> Register Key tidak dapat dipulihkan. Hubungi panitia melalui email/WhatsApp yang tertera di website untuk reset password manual.

**Q: Status saya masih "Pending" sudah berapa hari, kenapa?**
> Admin akan memverifikasi pendaftaran setelah memeriksa kelengkapan dokumen dan bukti pembayaran. Tunggu konfirmasi dari panitia.

**Q: Saya sudah upload video YouTube tapi tidak tersimpan?**
> Pastikan link YouTube dalam format `https://www.youtube.com/watch?v=...` atau `https://youtu.be/...`. Link yang salah format tidak akan diterima.

**Q: Tombol Download Sertifikat tidak muncul?**
> Sertifikat Partisipasi hanya tersedia setelah: (1) status `confirmed`, dan (2) template sertifikat aktif sudah dikonfigurasi admin di menu Certificate Templates untuk kategori peserta.

---

### Admin

**Q: Nilai juri tidak masuk setelah klik Calculate Score?**
> Pastikan semua juri yang ditugaskan sudah mengisi nilai untuk semua kriteria. Jika salah satu kriteria belum dinilai, rata-rata tetap akan dihitung dari yang sudah ada.

**Q: Pengumuman winner tidak menampilkan peserta?**
> Pastikan: (1) Ada peserta dengan status `confirmed`, (2) field `final_score` sudah terisi (klik Calculate Score), (3) field `rank` sudah terisi otomatis setelah Calculate Score.

**Q: Template sertifikat sudah dibuat tapi tidak bisa di-generate?**
> Pastikan template dalam status **Active**, tipe `participation`, dan kategori yang dipilih cocok dengan kategori peserta.

**Q: Juri tidak bisa melihat peserta di panelnya?**
> Periksa di menu **Judge Mapping** — pastikan juri sudah ditugaskan ke kategori yang benar. Juri hanya melihat peserta dengan status `confirmed` dan stage **bukan** `eliminated` di kategori yang ditugaskan.

**Q: Bagaimana cara menutup pendaftaran?**
> Buka **Event Settings → Tab Dates & Timeline** → matikan toggle **Registration Open** → Save.

**Q: Saya ingin mengubah teks/konten di halaman website?**
> Semua konten website bisa diubah di **Event Settings** tanpa perlu coding.

---

*Panduan ini dibuat berdasarkan source code aplikasi Esa Unggul International Event 2026.*
*Versi: April 2026 — Rev. 3 (21 April 2026)*
