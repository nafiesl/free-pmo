# Project Management Office

Project Management Office, is a project management tool for freelancers and agencies to manage and monitor their project easier.

## Konsep

### 1. Project

Project adalah pekerjaan yang dikerjakan oleh agency untuk seorang customernya

1. Sebuah project adalah milik sebuah Customer
2. Project memiliki beberapa Job/Item pekerjaan
3. Project memiliki beberapa Invoice
4. Project memiliki beberapa Pembayaran (dengan atau tanpa invoice)
5. Project memiliki beberapa Meeting (pertemuan dengan customer)

#### Relasi

1. Project belongs to a Customer; Customer has 0 to many Projects
2. Project has 0 to many Features/Project Items; Feature belongs to a Project
3. Project has 0 to many Invoices; Invoice belongs to a Project
4. Project has 0 to many Payments; Payment belongs to a Project
5. Project has 0 to many Meetings; Meeting belongs to a Project


### 2. Job/Item pekerjaan

1. Job memiliki harga/biaya
2. Job memiliki seorang pekerja/PIC
3. Job memiliki beberapa sub-job
4. Job memiliki beberapa task (semacam checklist pekerjaan)
5. Job memiliki Atribut:
    - Nama job
    - Deskripsi
    - PIC (pekerja/worker)
    - Biaya/Fee
    - Prioritas
    - tanggal mulai
    - tanggal selesai
    - tanggal batal
6. Job memiliki beberapa dependency terhadap job lain
    - Misal Job A merupakan dependency dari Job B
    - Maka Job A harus diselesaikan dulu sebelum job B dikerjakan
7. Progress pengerjaan job dihitung otomatis berdasarkan rata-rata % Progress task
8. Job dapat diurutkan berdasarkan prioritas

### 3. Task

Task adalah item tugas yang dilakukan oleh PIC/Pekerja untuk memgerjakan 1 job

1. Task dimiliki oleh sebuah Job/Item pekerjaan
2. Task dapat diurutkan berdasarkan prioritas
3. Task memiliki Atribut :
    - Nama Task
    - Deskripsi
    - Progress (0 - 100 %)
    - Prioritas

### 4. Meeting (TODO)

Meeting adalah pertemuan yang dilakukan bersama Customer

1. Meeting dilakukan untuk 1 project
2. Meeting memiliki Berita Acara Pertemuan (BAP)
3. BAP terdiri dari :
    - tanggal
    - daftar hadir
    - agenda
    - hasil pertemuan


### 5. Invoice (TODO)

Invoice adalah tagihan pembayaran yang dibuat oleh Agensi kepada diberikan Customer.

1. Invoice adalah milik sebuah project
2. Invoice memiliki beberapa pembayaran (misal invoice dibayar dicicil)
3. Invoice bisa diupdate status Lunas

### 6. Pembayaran

Adalah pembayaran yang dilakukan dari Customer kepada Agensi (pemasukan), atau Agensi kepada vendor (pengeluaran).

1. Project memiliki beberapa Pembayaran
2. Pembayaran memiliki 1 Project
3. Pembayaran memiliki 1 Invoice (TODO)
4. Pembayaran dapat cetak Kuitansi/Bukti pembayaran
5. Pembayaran memiliki 1 partner berupa : vendor/customer/user

### 6. Vendor

Adalah penyedia/supplier/provider yang digunakan oleh Agensi saat ada pengeluaran biaya project.

1. Vendor memiliki beberapa pembayaran

### 7. Subscription/Langganan

Adalah langganan yang dibayar oleh customer secara berkala, yaitu hosting dan domain.

1. Subscription memiliki 1 project
2. Subscription memiliki 1 customer
3. Subscription memiliki 1 vendor