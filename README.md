# PinjamRuang

## Gambaran Umum Proyek

PinjamRuang merupakan aplikasi berbasis web yang dikembangkan menggunakan Laravel untuk mengelola data gedung, ruangan, pengguna, serta peminjaman ruang kelas di lingkungan institusi pendidikan.

Aplikasi ini menerapkan pembagian hak akses berdasarkan peran (*role-based access control*) untuk memisahkan tanggung jawab setiap pengguna, mulai dari pengelolaan data utama hingga proses peminjaman ruang kelas.

## Aktor dan Hak Akses

Aplikasi PinjamRuang memiliki tiga aktor utama, yaitu Admin, Staff, dan Class Representative.

### 1. Admin

Admin bertanggung jawab mengelola data utama yang digunakan dalam sistem.

Tanggung jawab:
- Mengelola data gedung.
- Mengelola data jurusan.
- Mengelola akun pengguna, termasuk Admin, Staff, dan Class Representative.

### 2. Staff

Staff bertanggung jawab mengelola ruangan dan menangani peminjaman ruang kelas pada gedung yang menjadi tanggung jawabnya.

Tanggung jawab:
- Mengelola data ruangan pada gedung masing-masing.
- Menangani proses peminjaman ruang kelas.
- Mengelola informasi ruangan sesuai dengan hak akses yang diberikan.

### 3. Class Representative

Class Representative merupakan pengguna yang mengajukan peminjaman ruang kelas melalui aplikasi.

Tanggung jawab:
- Melihat informasi ruangan yang tersedia.
- Mengajukan peminjaman ruang kelas.
- Mengakses fitur peminjaman sesuai dengan hak akses yang diberikan.

## Arsitektur Aplikasi

PinjamRuang menggunakan arsitektur MVC (*Model-View-Controller*) yang disediakan oleh Laravel untuk memisahkan pengelolaan data, logika aplikasi, dan tampilan antarmuka.

Komponen utama aplikasi meliputi:

- **Routes:** Mengatur URL aplikasi dan menghubungkan permintaan dengan controller.
- **Controllers:** Menangani logika aplikasi dan pemrosesan permintaan pengguna.
- **Views:** Menampilkan antarmuka aplikasi kepada pengguna.
- **Models:** Merepresentasikan data dan hubungan antarentitas dalam database.
- **Migrations:** Mendefinisikan struktur tabel database.
- **Seeders:** Menyediakan data awal untuk kebutuhan pengembangan atau pengujian.
- **Middleware:** Mengatur autentikasi dan pembatasan akses berdasarkan peran pengguna.

## Modul Utama Aplikasi

| Modul | Aktor | Fungsi |
|---|---|---|
| Manajemen Pengguna | Admin | Mengelola akun dan peran pengguna |
| Manajemen Gedung | Admin | Mengelola data gedung |
| Manajemen Jurusan | Admin | Mengelola data jurusan |
| Manajemen Ruangan | Staff | Mengelola ruangan pada gedung yang menjadi tanggung jawabnya |
| Pengajuan Peminjaman | Class Representative | Mengajukan peminjaman ruang kelas |
| Penanganan Peminjaman | Staff | Menangani pengajuan peminjaman ruang kelas |

*Catatan: Rincian proses peminjaman akan disesuaikan dengan implementasi controller, model, dan tampilan yang digunakan dalam aplikasi.*


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

## 2. Controllers

### Overview

Controller merupakan bagian dari arsitektur MVC (*Model-View-Controller*) yang bertanggung jawab menangani request dari pengguna, menjalankan logika aplikasi, dan menentukan response yang diberikan.

Pada project ini, `AuthController` menangani proses autentikasi pengguna, mulai dari menampilkan halaman login, memvalidasi kredensial, menentukan redirect berdasarkan role, hingga mengakhiri sesi pengguna.

### AuthController

**File:** `app/Http/Controllers/AuthController.php`

`AuthController` menggunakan facade `Auth` untuk mengelola autentikasi Laravel dan class `Request` untuk menerima serta memvalidasi input dari pengguna.

#### 1. Login Page

Method `login()` digunakan untuk menampilkan halaman login melalui view `auth.login`.

```php
public function login()
{
    return view('auth.login');
}
```

Method ini tidak memproses autentikasi, tetapi hanya mengembalikan halaman login agar pengguna dapat memasukkan email dan password.

#### 2. Authentication Process

Method `authenticate(Request $request)` menangani proses login pengguna.

```php
$credentials = $request->validate([
    'email' => 'required|email',
    'password' => 'required',
]);
```

Input email dan password divalidasi sebelum digunakan. Email wajib diisi dan harus memiliki format email yang valid, sedangkan password wajib diisi.

```php
if (Auth::attempt($credentials)) {
    $request->session()->regenerate();
```

`Auth::attempt()` memeriksa kredensial menggunakan mekanisme autentikasi Laravel. Jika berhasil, session ID diperbarui melalui `regenerate()` untuk membantu mencegah session fixation.

#### 3. Role-Based Redirection

Setelah autentikasi berhasil, aplikasi membaca role pengguna dan mengarahkan pengguna ke dashboard yang sesuai.

```php
$role = Auth::user()->role;

return match ($role) {
    'admin' => redirect('/admin'),
    'staff' => redirect('/staff'),
    'class_representative' => redirect('/class-representative'),
    default => $this->logoutInvalidRole($request),
};
```

Pemetaan redirect yang diterapkan:

| Role | Destination |
|---|---|
| `admin` | `/admin` |
| `staff` | `/staff` |
| `class_representative` | `/class-representative` |
| Role lainnya | Logout dan redirect ke `/login` |

Pernyataan `match` digunakan untuk menentukan tujuan redirect berdasarkan nilai role. Jika role tidak termasuk dalam daftar yang didukung, aplikasi memanggil `logoutInvalidRole()`.

#### 4. Invalid Role Handling

Method `logoutInvalidRole()` menangani akun yang berhasil diautentikasi tetapi memiliki role yang tidak dikenali oleh aplikasi.

```php
Auth::logout();

$request->session()->invalidate();
$request->session()->regenerateToken();
```

Proses ini mencakup penghapusan status autentikasi, invalidasi session, dan regenerasi CSRF token. Setelah itu, pengguna diarahkan kembali ke halaman login dengan pesan bahwa role akun tidak valid.

#### 5. Failed Authentication

Jika `Auth::attempt()` gagal, pengguna dikembalikan ke halaman sebelumnya dengan pesan kesalahan.

```php
return back()
    ->withErrors([
        'email' => 'Email atau password yang Anda masukkan salah.',
    ])
    ->onlyInput('email');
```

Pesan kesalahan ditampilkan melalui mekanisme error session Laravel. Method `onlyInput('email')` mempertahankan input email, tetapi tidak mempertahankan password.

#### 6. Logout Process

Method `logout(Request $request)` digunakan untuk mengakhiri sesi pengguna yang sedang login.

```php
Auth::logout();

$request->session()->invalidate();
$request->session()->regenerateToken();

return redirect('/login')->with(
    'success',
    'Anda berhasil logout.'
);
```

Tahapan logout meliputi:

1. Menghapus status autentikasi pengguna.
2. Membatalkan session yang sedang aktif.
3. Membuat ulang CSRF token.
4. Mengarahkan pengguna ke halaman login dengan pesan keberhasilan.

### Authentication Flow

Alur autentikasi pada `AuthController` dapat diringkas sebagai berikut:

1. Pengguna membuka halaman login.
2. Pengguna mengirimkan email dan password.
3. Aplikasi memvalidasi input.
4. Laravel memeriksa kredensial menggunakan `Auth::attempt()`.
5. Jika gagal, aplikasi menampilkan pesan kesalahan.
6. Jika berhasil, session ID diperbarui dan role pengguna diperiksa.
7. Pengguna diarahkan ke dashboard sesuai role.
8. Jika role tidak valid, sesi diakhiri dan pengguna dikembalikan ke halaman login.

### Technical Notes

- Menggunakan facade `Illuminate\Support\Facades\Auth` untuk autentikasi.
- Menggunakan validasi Laravel melalui `$request->validate()`.
- Menggunakan `Auth::attempt()` untuk memverifikasi kredensial.
- Menggunakan `match` untuk pemetaan role ke URL dashboard.
- Menggunakan session regeneration untuk meningkatkan keamanan sesi.
- Menggunakan session invalidation dan CSRF token regeneration saat logout.
- Menggunakan flash message dan validation errors untuk memberikan umpan balik kepada pengguna.

## 2.2 Admin Controllers

Admin controllers bertanggung jawab menangani pengelolaan data yang hanya dapat diakses melalui route admin. Pada project ini, terdapat dua controller utama, yaitu `BuildingController` untuk pengelolaan gedung dan `MajorController` untuk pengelolaan jurusan.

Kedua controller menggunakan Eloquent ORM untuk berinteraksi dengan database serta memanfaatkan validasi Laravel untuk memeriksa input pengguna.

### A. BuildingController

**File:** `app/Http/Controllers/Admin/BuildingController.php`

`BuildingController` menangani operasi CRUD data gedung serta pengelolaan hubungan antara gedung dan jurusan melalui model `BuildingMajor`.

#### 1. Index — Menampilkan Data Gedung

Method `index()` mengambil parameter pencarian dari request, kemudian menjalankan query menggunakan Eloquent.

Implementasi ini menggunakan `when()` untuk menerapkan filter nama gedung hanya ketika input pencarian tersedia. Relasi `majors` dimuat menggunakan `with()` agar data jurusan terkait dapat diakses tanpa harus menjalankan query relasi berulang kali.

Controller juga memeriksa `$request->ajax()`. Jika request berasal dari AJAX, controller mengembalikan partial view tabel. Jika tidak, controller menampilkan halaman utama daftar gedung.

View yang digunakan:
- `admin.buildings.index`
- `admin.buildings.partials.table`

#### 2. Create — Form Tambah Gedung

Method `create()` mengambil seluruh data jurusan melalui `Major::get()`, kemudian mengirimkannya ke view `admin.buildings.create`.

Data jurusan digunakan sebagai pilihan pada formulir sehingga pengguna dapat menentukan jurusan yang berhubungan dengan gedung.

#### 3. Store — Menyimpan Data Gedung

Method `store()` memvalidasi input sebelum menyimpan data.

Aturan validasi yang diterapkan:
- `building_name`: wajib diisi dan harus unik pada tabel `buildings`.
- `major_id`: boleh kosong, harus berupa bilangan bulat jika diisi, dan harus merujuk pada data jurusan yang tersedia.

Setelah validasi berhasil, controller membuat data gedung menggunakan `Building::create()`, kemudian membuat data relasi melalui `BuildingMajor::create()`.

Dengan demikian, penyimpanan gedung dan relasi jurusannya dilakukan melalui dua model yang berbeda.

#### 4. Edit — Menampilkan Form Edit

Method `edit(Building $building)` menggunakan *Route Model Binding* untuk memperoleh data gedung berdasarkan parameter route.

Controller mencari relasi gedung melalui `BuildingMajor`, mengambil data jurusan yang terhubung jika tersedia, lalu mengirimkan data gedung dan daftar jurusan ke view `admin.buildings.edit`.

Jika belum terdapat relasi jurusan, variabel `$major` akan bernilai `null`.

#### 5. Update — Memperbarui Data Gedung

Method `update()` memvalidasi input nama gedung dan jurusan sebelum memperbarui data.

Validasi nama gedung menggunakan aturan unik dengan pengecualian ID gedung yang sedang diedit. Hal ini memungkinkan nama gedung tetap dipertahankan tanpa dianggap duplikat.

Setelah nama gedung diperbarui, controller menghapus relasi sebelumnya pada `BuildingMajor`. Jika `major_id` baru diisi, controller membuat relasi pengganti.

Pola ini memungkinkan hubungan gedung dengan jurusan diubah atau dihapus ketika pilihan jurusan dikosongkan.

#### 6. Destroy — Menghapus Data Gedung

Method `destroy(Building $building)` menghapus data gedung melalui Eloquent, kemudian mengarahkan pengguna kembali ke `/admin/buildings` dengan pesan keberhasilan.

Penghapusan data relasi terkait bergantung pada konfigurasi foreign key, cascade delete, atau mekanisme penghapusan lain yang diterapkan pada database.

### B. MajorController

**File:** `app/Http/Controllers/Admin/MajorController.php`

`MajorController` bertanggung jawab mengelola data jurusan melalui operasi CRUD. Controller menggunakan model `Major` untuk mengambil, menyimpan, memperbarui, dan menghapus data jurusan.

#### 1. Index — Menampilkan Data Jurusan

Method `index()` menerima input pencarian melalui parameter `search`. Query menggunakan `when()` untuk memfilter kolom `major` berdasarkan kata kunci yang dimasukkan.

Jika request merupakan AJAX, controller mengembalikan partial view `admin.majors.partials.table`. Untuk request biasa, controller menampilkan view `admin.majors.index`.

Implementasi ini mendukung pencarian data tanpa harus menggunakan query SQL mentah.

#### 2. Create — Form Tambah Jurusan

Method `create()` menampilkan view `admin.majors.create`, yang digunakan sebagai formulir penambahan data jurusan.

#### 3. Store — Menyimpan Data Jurusan

Method `store()` memvalidasi input `major` menggunakan dua aturan:
- `required`: nama jurusan wajib diisi.
- `unique:majors,major`: nama jurusan tidak boleh sama dengan data yang sudah ada pada tabel `majors`.

Setelah validasi berhasil, data disimpan menggunakan `Major::create()`.

#### 4. Edit — Menampilkan Form Edit

Method `edit(Major $major)` menggunakan *Route Model Binding* untuk mengambil data jurusan yang akan diedit, kemudian mengirimkannya ke view `admin.majors.edit`.

#### 5. Update — Memperbarui Data Jurusan

Method `update()` memvalidasi nama jurusan menggunakan facade `Rule`.

Aturan `Rule::unique('majors', 'major')->ignore($major->id)` memastikan nama jurusan tetap unik dengan mengecualikan data yang sedang diperbarui.

Pesan validasi khusus juga disediakan untuk memberi informasi yang lebih jelas ketika nama jurusan belum diisi atau sudah terdaftar.

Jika validasi berhasil, perubahan disimpan melalui `$major->update($validatedData)`.

#### 6. Destroy — Menghapus Data Jurusan

Method `destroy(Major $major)` menghapus data jurusan menggunakan Eloquent, lalu mengarahkan pengguna kembali ke `/admin/majors` dengan pesan keberhasilan.

Keberhasilan penghapusan juga bergantung pada apakah jurusan tersebut masih digunakan oleh data relasi atau tabel lain yang memiliki foreign key.

### C. Implementasi Teknis

Kedua controller menerapkan beberapa fitur Laravel berikut:

| Fitur | Implementasi |
|---|---|
| Eloquent ORM | Mengelola data melalui model |
| CRUD | `index()`, `create()`, `store()`, `edit()`, `update()`, `destroy()` |
| Request Validation | `$request->validate()` |
| Route Model Binding | Parameter `Building $building` dan `Major $major` |
| Conditional Query | `when()` untuk pencarian |
| AJAX Response | Pemeriksaan `$request->ajax()` |
| Partial View | Mengembalikan bagian tabel secara terpisah |
| Flash Message | `with('success', ...)` |
| Relationship Management | Model `BuildingMajor` dan relasi `majors` |

### D. Catatan Implementasi

Pada `BuildingController`, aturan validasi `major_id` memperbolehkan nilai kosong. Namun, method `store()` tetap mencoba mengakses `$major->id` setelah pencarian jurusan. Jika `major_id` tidak diisi atau tidak menghasilkan data jurusan, proses penyimpanan relasi berpotensi gagal.

Selain itu, penyimpanan gedung dan relasinya dilakukan melalui dua operasi terpisah. Penggunaan database transaction dan penanganan nilai `major_id` yang kosong perlu dipertimbangkan agar proses penyimpanan lebih konsisten.



