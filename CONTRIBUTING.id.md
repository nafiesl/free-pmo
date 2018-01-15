# Kontribusi ke Free PMO

Terima kasih karena telah berkenan mempertimbangkan untuk berkontribusi pada project ini. Mari kita buat software Free PMO menjadi jauh lebih baik.

### Submit Issue
Project ini masih terus dikembangkan. Sebagian besar fitur yang telah dibuat memiliki **Feature** atau **Unit Testing**, namun sangat mungkin masih ada **bug** yang terlewat dari pengujian tersebut. Jika selama menggunakan software ini Anda temukan **bug** atau **error**, silakan [melaporkan **Issue**](https://github.com/nafiesl/free-pmo/issues/new) dengan **prefix Subject : [BUG]**.

Kita akan mencoba minimalisir **bug** sebisa mungkin.

> Sebelum submit sebuah issue, ada baiknya Anda mencari pada daftar issue sudah dilaporkan oleh kontributor lain, siapa tahu sudah ada yang melaporkan :)

### Usulan Fitur Baru
Pada dasarnya Free PMO sudah mencakup fitur-fitur dasar dalam pengelolaan project (terutama dari sudut pandang *freelancer*). Sangat mungkin beberapa fitur ditambahkan pada masa akan datang. Jika Anda memiliki **ide** yang ingin diusulkan dan dituangkan menjadi sebuah fitur pada project ini agar semua dapat menikmatinya, silakan usulkan dengan **submit Issue** dengan **prefix Subject : [PROPOSAL]**.

Dengan senang hati kita akan diskusikan.

### Membuat Pull Request

Wah, bagian ini adalah kontribusi yang luar biasa, Anda sudah berkenan meluangkan waktu dan pikiran untuk membantu banyak orang, terima kasih banyak. Ada beberapa **kategori pull request** yang dapat Anda berikan :

#### 1. Bugfix

Di mana Anda membantu dalam **perbaikan error** yang dilaporkan oleh kontributor lain melalui [**Issue**](https://github.com/nafiesl/free-pmo/issues). Jika perbaikan error ini berkaitan dengan interaksi ke database (CRUD Operation), mohon agar Anda :

1. Membuat **testing**, terkait fitur yang memiliki bug.
2. Pastikan **semua testing passed** pada saat Anda melakukan **pull request**.

Kita akan review sama-sama terhadap perubahan yang Anda lakukan. Sekedar memastikan tidak ada konflik yang terjadi saat **pull request** ini disetujui.

#### 2. Kesalahan Penulisan

Pada project ini sangat mungkin terjadi kesalahan penulisan pada `halaman web` software, bagian `komentar`, `dokumentasi`, maupun pada file `lang` yang banyak kita gunakan pada sistem. Jika Anda menemukan kesalahan itu, silakan lakukan **pull request** untuk kita perbaiki sama-sama.

#### 3. New Feature

Jenis **pull request** ini akan menambahkan fitur baru pada Free PMO. Jika Anda ingin melakukan pull request jenis ini, kami harapkan agar memenuhi ketentuan berikut :

1. Fitur baru sudah diusulkan dan dibahas sebelumnya pada [**Issue**](https://github.com/nafiesl/free-pmo/issues).
2. Fitur tambahan dilengkapi dengan Feature Test atau Unit Test sesuai keperluan (terutama jika ada interaksi perubahan pada database).
3. Semua **testing passed**.

Kita akan **review dan uji** fitur baru tersebut sebelum **pull request** disetujui.

> ##### Catatan
>
> Jika pada fitur baru terdapat **perubahan struktur** pada tabel yang sudah ada, silakan **langsung ubah pada file migration** yang bersangkutan, karena aplikasi Free PMO masih dalam tahap pengembangan. **Misal**: fitur baru memerlukan perubahan struktur tabel `payments`, silakan update file `2016_11_15_151228_create_payments_table.php`.
>
> Kemudian **mohon** diinformasikan **script sql** dari perubahan struktur tabel tersebut melalui **Komentar Commit** yang bersangkutan (seperti [contoh ini](https://github.com/nafiesl/free-pmo/commit/a813524f680e9926d64f1006a1c615acf86c24f1#commitcomment-26166267)). Hal ini dilakukan untuk mempermudah pengguna Free PMO existing jika ingin meng-update aplikasinya.


#### 4. Lang File

Jenis **pull request** ini akan menambahkan **lang** file pada direktori `resources/lang` sesuai dengan konfigurasi `locale`-nya (misal `lang/en` untuk Bahasa Inggris). Saat ini file-file `lang` yang lengkap hanya pada direktori `id` untuk Bahasa Indonesia dan `en` (Bahasa Inggris).

Jika Anda ingin menambahkan bahasa lainnya, silakan melakukan **pull request** untuk kita **review** bersama.

### Kontribusi Donasi

Sekedar mengingatkan, Free PMO adalah software management project yang bebas (merdeka) dan gratis di bawah [lisensi MIT](LICENSE). **Pengembang sudah ridho** jika Anda menggunakan dan memodifikasinya untuk tujuan pribadi maupun komersil selama Anda tidak menghapus file [lisensi](LICENSE) dari project ini.

Tetapi jika ada merasa sangat terbantu dengan software ini, dan berniat untuk mendonasikan sebagai rezeki Anda kepada pengembang, silakan mengirimkan donasi melalui jalur berikut :


#### Rekening Transfer

| No. Rekening | BCA // 7820088543 |
| --- | --- |
| Atas nama | **Nafies Luthfi** |
| Kode Transfer | 014 |

#### atau

[![Support via PayPal](https://cdn.rawgit.com/twolfson/paypal-github-button/1.0.0/dist/button.svg)](https://www.paypal.me/nafiesl/)

Terima kasih banyak saya ucapan.

### Penutup

Terima kasih atas kontribusinya, semoga menjadi kebaikan untuk semua.

Salam hangat,

<br>
Nafies Luthfi,
Pengembang Free PMO