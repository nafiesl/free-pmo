# Project Management Office

> # PMO.web.id

Project Management Office, is a project management tool for freelancers and agencies to manage their project professionally.
Sebuah aplikasi untuk membantu freelancer dan agensi mengelola project web

## Konsep

### 1. Agency

Agency adalah lembaga yang mengelola dan mengerjakan project, Agency tidak terbatas untuk perusahaan saja, freelancer juga dapat membuat agency

1. User yang mendaftar menjadi seorang admin dari sebuah agency
2. Agency memiliki dari beberapa project
3. Agency memiliki dari beberapa user (pekerja)
4. Agency memiliki dari beberapa vendor
5. Agency memiliki beberapa customer
6. Seorang User yang telah terdaftar sebagai Worker dapat membuat Agency sendiri, untuk mengelola project sendiri.

#### Relasi

1. User has 0 to 1 Agency; Agency belongs to 1 User
2. Agency has 0 to many projects; Project belongs to an Agency
3. Agency has 1 to many workers; Worker (User) belongs to an Agency
4. Agency has 0 to many vendor; Vendor belongs to an Agency
5. Agency has 0 to many customer; Customer belongs to an Agency

### 2. Project

Project adalah pekerjaan yang dikerjakan oleh agency untuk seorang customernya

1. Sebuah project adalah milik sebuah Agency
2. Sebuah project adalah milik sebuah Customer
3. Project memiliki beberapa Fitur/Item pekerjaan
4. Project memiliki beberapa Invoice
5. Project memiliki beberapa Pembayaran (dengan atau tanpa invoice)
6. Project memiliki beberapa Meeting (pertemuan dengan customer)

#### Relasi

1. Project belongs to an Agency; Agency has 0 to many Projects
2. Project belongs to a Customer; Customer has 0 to many Projects
3. Project has 0 to many Features/Project Items; Feature belongs to a Project
4. Project has 0 to many Invoices; Invoice belongs to a Project
5. Project has 0 to many Payments; Payment belongs to a Project
6. Project has 0 to many Meetings; Meeting belongs to a Project


### 3. Fitur/Item pekerjaan

1. Fitur memiliki harga/biaya
2. Fitur memiliki seorang pekerja/PIC
3. Fitur memiliki beberapa sub-fitur
4. Fitur memiliki beberapa task (semacam checklist pekerjaan)
5. Fitur memiliki Atribut:
    - Nama fitur
    - Deskripsi
    - PIC (pekerja/worker)
    - Biaya/Fee
    - Prioritas
    - tanggal mulai
    - tanggal selesai
    - tanggal batal
6. Fitur memiliki beberapa dependency terhadap fitur lain
    - Misal Fitur A merupakan dependency dari Fitur B
    - Maka Fitur A harus diselesaikan dulu sebelum fitur B dikerjakan
7. Progress pengerjaan fitur dihitung otomatis berdasarkan rata-rata % Progress task
8. Fitur dapat diurutkan berdasarkan prioritas

### 4. Task

Task adalah item tugas yang dilakukan oleh PIC/Pekerja untuk memgerjakan 1 fitur

1. Task dimiliki oleh sebuah Fitur/Item pekerjaan
2. Task dapat diurutkan berdasarkan prioritas
3. Task memiliki Atribut :
    - Nama Task
    - Deskripsi
    - Progress (0 - 100 %)
    - Prioritas

### 5. Meeting

Meeting adalah pertemuan yang dilakukan bersama Customer

1. Meeting dilakukan untuk 1 project
2. Meeting memiliki Berita Acara Pertemuan (BAP)
3. BAP terdiri dari :
    - tanggal
    - daftar hadir
    - agenda
    - hasil pertemuan


### 6. Invoice

Invoice adalah tagihan pembayaran yang dibuat oleh Agency kepada diberikan Customer.

1. Invoice adalah milik sebuah project
2. Invoice memiliki beberapa pembayaran (misal invoice dibayar dicicil)
3. Invoice bisa diupdate status Lunas

### 7. Pembayaran

Adalah pembayaran yang dilakukan dari Customer kepada Agency (pemasukan), atau Agency kepada vendor (pengeluaran).

1. Project memiliki beberapa Pembayaran
2. Pembayaran memiliki 1 Project
3. Pembayaran memiliki 1 Invoice
4. Pembayaran dapat cetak Kuitansi/Bukti pembayaran