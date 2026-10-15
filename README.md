## 1. Routes

**File:** `routes/web.php`

### Overview

File `web.php` berfungsi sebagai pusat pendefinisian routing aplikasi. Setiap route menghubungkan URL dan HTTP method dengan controller atau view yang menangani permintaan pengguna.

Pada project ini, routing disusun menggunakan middleware dan route group untuk memisahkan akses berdasarkan status autentikasi serta role pengguna.

### Route Structure

Routing aplikasi dibagi menjadi empat bagian utama:

| Route Group | Fungsi |
|---|---|
| Guest | Menangani halaman login dan proses autentikasi pengguna. |
| Authenticated User | Melindungi route yang hanya dapat diakses setelah login, termasuk proses logout. |
| Admin | Menyediakan dashboard admin serta route CRUD untuk data jurusan dan gedung. |
| Staff & Class Representative | Menyediakan dashboard berdasarkan role masing-masing pengguna. |

### Route Implementation

**1. Authentication Routes**

Route login menggunakan middleware `guest`, dengan method `GET` untuk menampilkan halaman login dan method `POST` untuk memproses autentikasi melalui `AuthController`.

**2. Protected Routes**

Middleware `auth` digunakan untuk melindungi route yang membutuhkan autentikasi. Di dalam grup ini terdapat route logout dan route khusus untuk setiap role.

**3. Admin Routes**

Prefix `/admin` digunakan untuk mengelompokkan route admin. Dashboard ditangani oleh `AdminDashboardController`, sedangkan pengelolaan data jurusan dan gedung menggunakan `MajorController` dan `BuildingController`.

Kedua resource controller didaftarkan menggunakan `Route::resource()`, yang menyediakan route standar untuk operasi CRUD.

**4. Staff Routes**

Prefix `/staff` digunakan untuk dashboard staff yang ditangani oleh `StaffDashboardController`.

**5. Class Representative Routes**

Prefix `/class-representative` digunakan untuk dashboard perwakilan kelas yang ditangani oleh `ClassRepresentativeDashboardController`.

**6. Main Route**

Route `/` menampilkan view `welcome` sebagai halaman utama aplikasi.

### Access Control

Pembatasan akses dilakukan melalui kombinasi middleware:

- `guest`: membatasi akses ke halaman autentikasi untuk pengguna yang belum login.
- `auth`: memastikan pengguna sudah terautentikasi.
- `role:admin`: membatasi akses ke fitur admin.
- `role:staff`: membatasi akses ke dashboard staff.
- `role:class_representative`: membatasi akses ke dashboard perwakilan kelas.

Middleware role diterapkan di dalam grup `auth`, sehingga pengguna harus melewati autentikasi sebelum mengakses halaman sesuai perannya.

### Technical Notes

- Routing menggunakan facade `Illuminate\Support\Facades\Route`.
- Controller dipanggil menggunakan array callable `[Controller::class, 'method']`.
- Route group digunakan untuk mengelompokkan middleware dan prefix URL.
- Resource routing menyederhanakan pendefinisian endpoint CRUD.
- Detail implementasi autentikasi dan validasi role ditangani oleh controller serta middleware terkait.

