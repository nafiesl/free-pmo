# Free PMO

Free PMO adalah sebuah alat bantu untuk mempermudah pengelolaan dan monitor project bagi *feelancer* dan agensi/*software house* atau perusahaan yang memiliki layanan berupa project untuk customernya.

## Konsep

Berikut ini adalah konsep-konsep fitur yang telah dan akan diimplementasikan pada Free PMO.

### 1. User dan Jenis Pengguna

Free PMO memiliki dua jenis pengguna/tipe user :

1. **Administrator** (mengendalikan dan mengelola seluruh data)
2. **Worker** (pekerja yang ditugasi job dan diberikan pembayaran fee)

Tidak menutup kemungkinan jika jenis pengguna ini ditambah lagi.

### 2. Project

Project adalah pekerjaan yang dikerjakan oleh agensi untuk customernya

1. Sebuah **project** milik satu **Customer**
2. **Project** memiliki beberapa **Job**/Item pekerjaan
3. **Project** memiliki beberapa **Invoice** (TODO)
4. **Project** memiliki beberapa **Pembayaran** (dengan atau tanpa invoice)
5. **Project** memiliki beberapa **Meeting** (pertemuan dengan customer)
6. **Project** memiliki beberapa **Langganan** (subscription)
7. **Project** memiliki beberapa **File** Dokumen (TODO)

#### Relasi

1. **Project** belongs to a **Customer**; Customer has 0 to many Projects
2. **Project** has 0 to many **Jobs**/Project Items; Feature belongs to a Project
3. **Project** has 0 to many **Invoices**; Invoice belongs to a Project
4. **Project** has 0 to many **Payments**; Payment belongs to a Project
5. **Project** has 0 to many **Meetings**; Meeting belongs to a Project
6. **Project** has 0 to many **Subscriptions**; Subscription belongs to a Project
7. **Project** has 0 to many **Files**; File belongs to a Project

### 3. Job/Item pekerjaan

1. **Job** memiliki harga/biaya (misal untuk membayar pekerja)
2. **Job** memiliki seorang **User** sebagai pekerja/penanggung jawab
3. **Job** memiliki beberapa **task** (semacam checklist progress pekerjaan)
4. **Job** memiliki Atribut:
    - Nama job
    - Deskripsi
    - PIC (pekerja/worker)
    - Biaya/Fee
    - Prioritas
    - tanggal mulai (TODO)
    - tanggal selesai (TODO)
    - tanggal batal (TODO)
5. **Job** memiliki beberapa dependency terhadap job lain (TODO)
    - Misal Job A merupakan dependency dari Job B
    - Maka Job A harus diselesaikan dulu sebelum job B dikerjakan
6. Progress pengerjaan job dihitung otomatis berdasarkan rata-rata  **progress Task** (dalam %)
7. **Job** dapat diurutkan berdasarkan prioritas

### 4. Task

Task adalah item tugas yang dilakukan oleh PIC/Pekerja untuk mengerjakan 1 job.

1. **Task** dimiliki oleh sebuah **Job**/Item pekerjaan
2. **Task** dapat diurutkan berdasarkan prioritas
3. **Task** memiliki Atribut :
    - Nama Task
    - Deskripsi
    - Progress (0 - 100 %)
    - Prioritas

### 5. Pembayaran

Adalah pembayaran yang dilakukan dari Customer kepada Agensi (pemasukan), atau Agensi kepada vendor (pengeluaran), atau Agensi kepada pekerja/user (pengeluaran).

1. Satu **Project** memiliki beberapa **Pembayaran**
2. **Pembayaran** memiliki 1 Project
3. **Pembayaran** memiliki 1 Invoice (TODO)
4. **Pembayaran** dapat cetak **Kuitansi**/Bukti pembayaran
5. **Pembayaran** memiliki 1 partner berupa : vendor/customer/user (Relasi Morph)

### 6. Vendor

Adalah penyedia/supplier/provider yang digunakan oleh Agensi saat ada pengeluaran biaya project.

1. **Vendor** memiliki beberapa **pembayaran**

### 7. Subscription/Langganan

Adalah langganan yang dibayar oleh customer secara berkala, yaitu Hosting, Domain dan Maintenance.

1. **Subscription** memiliki 1 **project**
2. **Subscription** memiliki 1 **customer**
3. **Subscription** memiliki 1 **vendor**

### 7. Laporan Penghasilan

Laporan penghasilan pada Free PMO adalah rekap transaksi pengeluaran dan pemasukan agensi dari project-project yang telah dikerjakan. Halaman ini hanya diakses oleh Admin Agensi.

#### Laporan Tahunan

Adalah laporan berupa **grafik profit** dan **tabel detail laporan** berupa : Nama Bulan, Jumlah Transaksi Pembayaran, Jumlah Uang Masuk, Jumlah Uang Keluar dan Profit (selisih pemasukan dan pengeluaran), serta tombol action untuk melihat **Laporan Bulanan**.

Pada Laporan Tahunan, Admin Agensi dapat memilih tahun yang ingin dilihat.


#### Laporan Bulanan

Adalah laporan berupa **grafik profit** dan **tabel detail laporan** berupa : Tanggal, Jumlah Transaksi Pembayaran, Jumlah Uang Masuk, Jumlah Uang Keluar dan Profit (selisih pemasukan dan pengeluaran), serta tombol action untuk melihat **Laporan Harian**.

Pada Laporan Bulanan, Admin Agensi dapat memilih tahun dan bulan yang ingin dilihat.

#### Laporan Harian

Laporan Harian adalah tabel **daftar transaksi** pembayaran yang terjadi pada tanggal yang dipilih tersebut.

### 8. Laporan Piutang

Laporan ini adalah tabel daftar project dengan pembayaran Customer yang akan diterima oleh Agensi jika project telah selesai dikerjakan.

### 9. Dashboard Admin Agensi

Dashboard Admin Agensi berisi :

1. Statistik jumlah project sesuai dengan statusnya saat ini.
2. Statistik pendapatan :
    - Pendapatan total tahun ini
    - Jumlah Project selesai tahun ini
    - Jumlah pendapatan yang akan datang (akan dibayar oleh Customer)
3. List Langganan Customer yang akan berakhir dalam 60 hari ke depan.

### 10. Invoice

Invoice adalah tagihan pembayaran yang dibuat oleh Agensi kepada diberikan Customer.

1. **Invoice** adalah milik sebuah **project**
2. **Invoice** memiliki beberapa **pembayaran** (misal invoice dibayar dicicil) (TODO)
3. **Invoice** bisa diupdate status Lunas (TODO)
4. **Invoice** memiliki Atribut:
    - Nomor Invoice
    - Project
    - Tanggal
    - Jatuh Tempo
    - Item Invoice
    - Jumlah tagihan (amount)
    - Catatan
    - Status
    - User Pembuat Invoice

### 11. Meeting (TODO)

Meeting adalah pertemuan yang dilakukan bersama Customer.

1. **Meeting** dilakukan untuk 1 project
2. **Meeting** memiliki satu Berita Acara Pertemuan (BAP)
3. BAP terdiri dari :
    - Tanggal
    - Project
    - Daftar hadir
    - Agenda
    - Hasil pertemuan
    - Catatan
