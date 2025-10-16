# 🏫 SMK Jurusan Management API — Laravel RESTful Backend

Sistem backend berbasis **Laravel REST API** untuk mengelola data **jurusan, siswa, guru, kelas, dan angkatan** di lingkungan sekolah SMK.  
Dibangun dengan **Repository Pattern** dan **Resource API** agar modular, efisien, dan mudah diintegrasikan ke frontend berbasis **Vite/Vue** atau **mobile app**.

---

## 🚀 Fitur Utama

-   🔐 Autentikasi berbasis **Laravel Sanctum**
-   🎓 Manajemen **Siswa, Guru, Jurusan, dan Angkatan**
-   🔄 Relasi antar entitas (contoh: `siswa` ↔ `angkatan`, `jurusan` ↔ `guru`)
-   🔍 Filtering, Sorting, dan Pagination otomatis
-   🧱 Arsitektur **Repository Pattern**
-   📦 Format response konsisten pakai **API Resource**
-   🧠 Validasi menggunakan **Form Request**

---

## 📁 Struktur Direktori Utama

app/
├── Helpers/
│ └── QueryFilterHelper.php
├── Http/
│ ├── Controllers/
│ │ ├── Api/
│ ├── Requests/
│ ├── Resources/
├── Interfaces/
├── Models/
├── Repositories/
routes/
├── api.php
└── web.php
