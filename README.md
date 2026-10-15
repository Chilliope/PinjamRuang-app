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



