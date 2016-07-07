<?php

use App\Entities\Projects\Project;

// Event::listen('illuminate.query', function($query)
// {
//     echo $query; echo '<br><br>';
// });

// Route::get('add-customers', function() {
//     $customers = ['Huda','Om Ekong','Isra Tanjung','Ahmad Fatah','STAI Buntok','Hasto','Jakhoster','Ujang Rahman','Donny','Ipul Batulicin','Joenathan Tanumiha','Prima','Dinas Koperasi UKM Kalsel','Stikes Husada Borneo','Rumah Web','Herbert','Donny Kurniawan'];
//     foreach ($customers as $customer) {
//         $user = new App\Entities\Users\User;
//         $user->name = $customer;
//         $user->username = str_replace(' ', '_', strtolower($customer));
//         $user->email = $user->username . '@mail.com';
//         $user->password = 'member';
//         $user->save();
//         $user->assignRole('customer');
//     }
// });

Route::get('add-existing-payments', function() {
    // $payments = [
    //     ['Frestour.com','500000','2014-05-14','Jasa website','Heru Yugo'],
    //     ['Elfbandung','500000','2014-06-12','Sistem reservasi','Heru Yugo'],
    //     ['Skripsi Ryan','250000','2014-06-21','Input jadwal, export to XL & PDF','Heru Yugo'],
    //     ['Bandungrafting.com','300000','2014-06-30','Jasa website','Heru Yugo'],
    //     ['Cianjurnews.com','150000','2014-07-09','Halaman index','Heru Yugo'],
    //     ['Bandungrafting.com','150000','2014-07-11','Jasa website','Heru Yugo'],
    //     ['Glowinklash.com','250000','2014-07-20','Jasa website','Heru Yugo'],
    //     ['Trijayatrans.com','50000','2014-07-20','Form reservasi email','Heru Yugo'],
    //     ['Skripsi Rotan','500000','2014-08-10','Shopping cart, halaman produk dgn pengurutan produk terlaris, CRUD tarif pengiriman','Andie'],
    //     ['Skripsi Makarizo','500000','2014-08-10','Shopping cart, laporan penjualan, backup database MySQL','Andie'],
    //     ['Stimi-bjm.ac.id','2000000','2014-08-11','DP jasa website','STIMI'],
    //     ['Stimi-bjm.ac.id','-1000000','2014-08-11','DP jasa website, hosting, domain','Heru Yugo'],
    //     ['Belimukena.com','5000000','2014-08-17','Shopping cart, management sistem','Heru Yugo'],
    //     ['Belimukena.com','-500000','2014-08-17','Pembagian belimukena.com','Heru Yugo'],
    //     ['Skripsi Absensi (sms gateway)','700000','2014-08-17','SMS gateway broadcast, input absen dan laporan semester','Andie'],
    //     ['Skripsi SPB (sms gateway)','300000','2014-08-17','SMS gateway broadcast dan laporan','Andie'],
    //     ['Belimukena.com','200000','2014-09-08','Revisi tambahan','Heru Yugo'],
    //     ['Imet18.com','750000','2014-09-12','Sistem informasi laporan prospecting','Heru Yugo'],
    //     ['Livescore','2000000','2014-09-18','Website seperti livescore','Heru Yugo'],
    //     ['Rajabagus','1400000','2014-09-24','Pembuatan import code/voucher dan signup with voucher','Heru Yugo'],
    //     ['Stimi-bjm.ac.id','2000000','2014-10-14','Pelunasan website stimi','STIMI'],
    //     ['Belimukena.com','600000','2014-11-07','Biaya maintenance 2014-11','Heru Yugo'],
    //     ['bandungtraverservice.com','500000','2014-11-13','fee isi content bandung travel service','Heru Yugo'],
    //     ['Belimukena.com','300000','2014-12-08','Biaya maintenance 2014-12','Heru Yugo'],
    //     ['Belimukena.com','100000','2014-12-08','fee buat reject order reason','Heru Yugo'],
    //     ['Legacyvapestore.com','350000','2014-12-12','fee isi content dan buat tutorial','Heru Yugo'],
    //     ['Aplikasi Toko Obat Sholah (Andie)','700000','2014-12-23','fee buat shopping cart apotik dan print nota','Andie'],
    //     ['Panjimitra.co.id','344500','2015-01-02','DP corporate email panjimitra.co.id','Heru Yugo'],
    //     ['Aplikasi Toko Obat Sholah (Andie)','1000000','2015-01-02','fee revisi shopping cart apotik dan management stok','Andie'],
    //     ['Panjimitra.co.id','580000','2015-01-05','Pelunasan corporate email panjimitra.co.id','Heru Yugo'],
    //     ['elfjakarta.com','150000','2015-01-05','DP pembuatan website dan aplikasi reservasi elfjakarta.com','Heru Yugo'],
    //     ['Aplikasi Toko Obat Sholah (Andie)','100000','2015-01-09','Jasa setting printer dan printout nota','Sholah'],
    //     ['Belimukena.com','300000','2015-01-09','Biaya maintenance 2015-01','Heru Yugo'],
    //     ['elfjakarta.com','150000','2015-01-10','Pelunasan Elfjakarta.com','Heru Yugo'],
    //     ['mambabykid.com','250000','2015-01-16','DP MambabyKid.com','Heru Yugo'],
    //     ['mambabykid.com','250000','2015-01-20','Pelunasan Mambabykid.com','Heru Yugo'],
    //     ['Aplikasi Reservasi Frestour','1000000','2015-01-21','DP Payapps','Heru Yugo'],
    //     ['Belimukena.com','300000','2015-02-10','Biaya maintenance 2015-02','Heru Yugo'],
    //     ['alamjayatrans.com','350000','2015-02-20','Buat landing page untuk car rental','Heru Yugo'],
    //     ['Rajatourbandung.com','50000','2015-02-20','Form reservasi email','Heru Yugo'],
    //     ['Belimukena.com','300000','2015-03-04','Biaya maintenance 2015-03','Heru Yugo'],
    //     ['Belimukena.com','350000','2015-03-04','Revisi form cart (ditambahkan custom nama pengirim di akun admin, reseller dan company reseller)','Heru Yugo'],
    //     ['Diskonmobisuzuki.com','350000','2015-03-20','Pembuatan fitur sales area','Eko'],
    //     ['Aplikasi Order','200000','2015-03-22','DP aplikasi order','Heru Yugo'],
    //     ['azka.co.id','300000','2015-03-30','Landing page car rental','Heru Yugo'],
    //     ['Legacyvapestore.com','350000','2015-04-04','DP redesign Legacyvapestore','Heru Yugo'],
    //     ['autodaihatsu.com','300000','2015-04-08','DP pembuatan website sales daihatsu bandung','Heru Yugo'],
    //     ['Belimukena.com','450000','2015-04-13','Biaya maintenance 2015-04 (plus security)','Heru Yugo'],
    //     ['my-trans.co.id','1300000','2015-04-27','DP pembuatan web company profile www.my-trans.co.id','Yamin'],
    //     ['my-trans.co.id','-650000','2015-04-27','Biaya hosting dan domain','Heru Yugo'],
    //     ['berkahsynergy.com','300000','2015-04-28','Pembuatan template berkahsynergy.com (redesign)','Erwin Fastweb'],
    //     ['autodaihatsu.com','200000','2015-04-30','Pelunasan pembuatan website sales daihatsu bandung','Heru Yugo'],
    //     ['Legacyvapestore.com','250000','2015-05-04','Pelunasan redesign website legacyvapestore','Heru Yugo'],
    //     ['Belimukena.com','1350000','2015-05-15','Biaya maintenance 2015-05, 2015-06, 2015-07','Heru Yugo'],
    //     ['Belimukena.com','150000','2015-05-15','Sebagian biaya maintenance 2015-08 (dipake mas yugo/pak Arise)','Heru Yugo'],
    //     ['Aplikasi Toko Obat Sholah (Andie)','100000','2015-05-23','Backup dan restore aplikasi web toko sholah','Sholah'],
    //     ['Aplikasi Toko Obat Sholah','1000000','2015-05-26','DP pembuatan aplikasi','Sholah'],
    //     ['Kursus Private PHP dan Konsul Skripsi','900000','2015-05-28','DP Kursus Private Pemrograman PHP dan Konsultasi Skirpsi','Huda'],
    //     ['my-trans.co.id','500000','2015-05-29','Pembayaran ke 2 website my-trans dan aplikasi connote','Yamin'],
    //     ['my-trans.co.id','1250000','2015-06-22','Pelunasan website my trans','Yamin'],
    //     ['Aplikasi Toko Obat Sholah','700000','2015-06-23','Pelunasan pembuatan aplikasi toko obat Sholah','Sholah'],
    //     ['Ambasadortrans.com','250000','2015-07-01','DP aplikasi reservasi ambasador trans','Heru Yugo'],
    //     ['Kursus Private PHP dan Konsul Skripsi','900000','2015-07-02','Pelunasan Kursus Private Pemrograman PHP dan Konsultasi Skirpsi','Huda'],
    //     ['Aplikasi Reservasi Frestour','1200000','2015-07-06','Pelunasan payapps tourbandung.com dari total (Rp. 1.500.000)','Heru Yugo'],
    //     ['my-trans.co.id','150000','2015-07-08','Pembayaran fitur Konversi kurs dollar Tarif international dan setting email di ponsel','Yamin'],
    //     ['Aplikasi Toko Obat Sholah','100000','2015-07-23','Perbaiki Jaringan toko Sholah','Sholah'],
    //     ['pulaupermata.com','1000000','2015-07-28','Biaya pembuatan website toko permata','Om Ekong'],
    //     ['Belimukena.com','450000','2015-08-10','Biaya maintenance 2015-08','Heru Yugo'],
    //     ['Ambasadortrans.com','100000','2015-08-18','Pembayaran ke 2 (sisa Rp. 150.000)','Heru Yugo'],
    //     ['Stimi-bjm.ac.id','500000','2015-08-19','Pembayaran perbaikan pengumuman kopertis, pasang channel youtube stimi, setting social icons','STIMI'],
    //     ['Belimukena.com','450000','2015-09-07','Biaya maintenance 2015-09','Heru Yugo'],
    //     ['online.my-trans.co.id','4400000','2015-09-08','Pembayaran uang muka aplikasi My-Trans','Yamin'],
    //     ['Stimi-bjm.ac.id','1000000','2015-09-16','Perpanjangan hosting dan domain s/d 2016-10-01','STIMI'],
    //     ['Stimi-bjm.ac.id','-800000','2015-09-16','Transfer to mas Yugo (plus Rp. 100Rb utk talangan perpanjangan Indonet 2015-09)','Heru Yugo'],
    //     ['Aplikasi Apotek Iloenk','1000000','2015-09-27','DP Aplikasi Apotek Iloenk','Isra Tanjung'],
    //     ['Belimukena.com','900000','2015-09-29','Modifikasi kalkulasi ongkir dgn API Rajaongkir (Migrasi Rajaongkir)','Heru Yugo'],
    //     ['Belimukena.com','450000','2015-10-10','Biaya maintenance 2015-10','Heru Yugo'],
    //     ['Aplikasi Toko Obat Sholah','200000','2015-10-13','Install ulang aplikasi Toko Obat dan Restore Database','Sholah'],
    //     ['sia.stimi-bjm.ac.id','5000000','2015-10-28','Uang muka pembuatan aplikasi SIAKAD STIMI Banjarmasin','STIMI'],
    //     ['Aplikasi Apotek Iloenk','1000000','2015-11-02','Pelunasan Aplikasi Apotek Iloenk','Isra Tanjung'],
    //     ['Belimukena.com','450000','2015-11-06','Biaya maintenance 2015-11','Heru Yugo'],
    //     ['Ambasadortrans.com','150000','2015-12-05','Pelunasan','Heru Yugo'],
    //     ['Belimukena.com','450000','2015-12-07','Biaya maintenance 2015-12','Heru Yugo'],
    //     ['DutaKurirBorneo.co.id','525000','2015-12-08','Biaya hosting dan domain','Ahmad Fatah'],
    //     ['DutaKurirBorneo.co.id','-425000','2015-12-08','Biaya hosting dan domain','Heru Yugo'],
    //     ['Aplikasi Reservasi Frestour','100000','2015-12-08','Cicilan Frestour.com Payapps (sisa Rp. 200.000)','Heru Yugo'],
    //     ['Panjimitra.co.id','300000','2015-12-11','Fee hosting domain panjimitra.co.id','Heru Yugo'],
    //     ['stai-almaarif-buntok.ac.id','2300000','2015-12-14','DP+domain+hosting','STAI Buntok'],
    //     ['stai-almaarif-buntok.ac.id','-1800000','2015-12-14','DP+domain+hosting','Heru Yugo'],
    //     ['stai-almaarif-buntok.ac.id','100000','2015-12-14','Bonus dari Yugo','Heru Yugo'],
    //     ['Aplikasi Reservasi Frestour','200000','2015-12-14','Cicilan Frestour.com Payapps (Lunas)','Heru Yugo'],
    //     ['online.my-trans.co.id','4400000','2015-12-15','Pelunasan Aplikasi E-Connote My-trans','Yamin'],
    //     ['online.my-trans.co.id','-300000','2015-12-15','Fee mas yugo','Heru Yugo'],
    //     ['Belimukena.com','450000','2016-01-06','Biaya maintenance 2016-01','Heru Yugo'],
    //     ['borneotaichiclass.com','500000','2016-01-12','DP Website BorneoTaichiClass.com','Hasto'],
    //     ['borneotaichiclass.com','-240000','2016-01-12','Hosting Domain','Jakhoster'],
    //     ['bintangtimur.co.id','1325000','2016-01-21','DP Website BintangTimur.co.id','Ujang Rahman'],
    //     ['bintangtimur.co.id','-825000','2016-01-25','Domain Hosting Website BintangTimur.co.id','Heru Yugo'],
    //     ['borneotaichiclass.com','650000','2016-01-27','Pelunasan Website BorneoTaichiClass.com, domain taichichuanpropatria-bjm.com dan domain kungfupropatria-bjm.com','Hasto'],
    //     ['kungfupropatria-bjm.com','-240000','2016-01-27','domain taichichuanpropatria-bjm.com dan domain kungfupropatria-bjm.com','Jakhoster'],
    //     ['Belimukena.com','450000','2016-02-10','Biaya maintenance 2016-02','Heru Yugo'],
    //     ['majas.co.id','900000','2016-02-19','DP Pembuatan web majas.co.id','Donny'],
    //     ['Aplikasi Apotek Mubarok','1000000','2016-02-24','DP Pembuatan Aplikasi Apotek Mubarok','Ipul Batulicin'],
    //     ['Aplikasi Apotek Mubarok','1000000','2016-02-28','Pelunasan Pembuatan Aplikasi Apotek Mubarok','Ipul Batulicin'],
    //     ['sia.stimi-bjm.ac.id','5000000','2016-03-03','Pelunasan Aplikasi Siakad dan Tracer Study STIMI','STIMI'],
    //     ['Belimukena.com','450000','2016-03-08','Biaya maintenance 2016-03','Heru Yugo'],
    //     ['attelierjewelry.com','1000000','2016-03-10','DP online store attelierjewelry.com','Joenathan Tanumiha'],
    //     ['Aplikasi QRCode Haki','250000','2016-03-18','Cicilan 1 DP','Erwin Fastweb'],
    //     ['Calief Gallery','1500000','2016-03-31','Cicilan 1 DP Aplikasi Order Calief Gallery','Heru Yugo'],
    //     ['Aplikasi QRCode Haki','250000','2016-03-31','Cicilan 2 DP','Erwin Fastweb'],
    //     ['my-trans.co.id','650000','2016-04-04','Biaya hosting dan domain','Yamin'],
    //     ['my-trans.co.id','-650000','2016-04-04','Biaya hosting dan domain','Heru Yugo'],
    //     ['Calief Gallery','1000000','2016-04-04','Cicilan 2 DP Aplikasi Order Calief Gallery','Heru Yugo'],
    //     ['stai-almaarif-buntok.ac.id','2300000','2016-04-04','Pelunasan pembuatan website stai-almaarif-buntok.ac.id','STAI Buntok'],
    //     ['stai-almaarif-buntok.ac.id','-800000','2016-04-04','Pelunasan pembuatan website stai-almaarif-buntok.ac.id','Heru Yugo'],
    //     ['Belimukena.com','450000','2016-04-05','Biaya maintenance 2016-04','Heru Yugo'],
    //     ['stai-almaarif-buntok.ac.id','-400000','2016-04-06','Fee marketing dari pak Prima','Prima'],
    //     ['Bimtek Pemasaran Online','4000000','2016-04-14','Honor narasumber','Dinas Koperasi UKM Kalsel'],
    //     ['sia.stikeshusada-borneo.ac.id','8000000','2016-04-18','DP Aplikasi Siakad dan Tracer Study STIKES HB','Stikes Husada Borneo'],
    //     ['sia.stikeshusada-borneo.ac.id','-2000000','2016-04-19','Fee Aplikasi Siakad STIKES HB','Prima'],
    //     ['Calief Gallery','1800000','2016-04-19','Pelunasan Aplikasi Order Calief Gallery','Heru Yugo'],
    //     ['borneotaichiclass.com','150000','2016-04-26','Fee revisi website dan edit artikel','Hasto'],
    //     ['attelierjewelry.com','-315000','2016-04-27','Domain Hosting Attelierjewelry.com','Rumah Web'],
    //     ['bintangtimur.co.id','1000000','2016-04-28','Pelunasan Website BintangTimur.co.id (belum entry content)','Ujang Rahman'],
    //     ['Aplikasi QRCode Haki','500000','2016-04-29','Cicilan 3 DP','Erwin Fastweb'],
    //     ['Belimukena.com','450000','2016-05-04','Biaya maintenance 2016-05','Heru Yugo'],
    //     ['majas.co.id','-110000','2016-05-10','Domain majas.co.id','Rumah Web'],
    //     ['majas.co.id','-250000','2016-05-11','Hosting 2GB majas.co.id','Jakhoster'],
    //     ['Belimukena.com','450000','2016-06-06','Biaya maintenance 2016-06','Heru Yugo'],
    //     ['Aplikasi Toko Obat Berkah','1900000','2016-06-17','Aplikasi Toko Obat Berkah','Sholah'],
    //     ['Aplikasi e-report CK Balangan','1200000','2016-06-18','DP Aplikasi Pelaporan Online & Domain+Hosting','Herbert'],
    //     ['Aplikasi Direktori KKF','400000','2016-06-18','DP Aplikasi Direktori Pelaku Usaha KKF','Donny Kurniawan'],
    //     ['Aplikasi e-report CK Balangan','-55000','2016-06-24','Domain ckbalangan.web.id','Rumah Web'],
    //     ['Aplikasi QRCode Haki','1000000','2016-06-29','Cicilan 4','Erwin Fastweb'],
    // ];
    // $formated = [];
    // $projects = Project::all();
    // $customers = App\Entities\Users\User::latest()->hasRoles(['customer'])->get();
    // // dump($projects->lists('name'));
    // foreach ($payments as $payment) {
    //     $formated[] = [
    //         'project_id' => ($project = $projects->where('name', $payment[0])->first()) ? $project->id : 'hit',
    //         'amount' => abs($payment[1]),
    //         'type' => $payment[1] < 0 ? 0 : 1,
    //         'date' => $payment[2],
    //         'description' => $payment[3],
    //         'customer_id' => ($customer = $customers->where('name', $payment[4])->first()) ? $customer->id : 'hit',
    //         'created_at' => $payment[2] . ' 00:00:00',
    //     ];
    // }

    // DB::beginTransaction();
    // DB::table('payments')->insert($formated);
    // DB::commit();

    // echo '<pre>$formated : ', print_r($formated, true), '</pre>';
    // die();
});
