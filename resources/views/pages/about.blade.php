@extends('layouts.guest')

@section('content')
<h1 class="page-header">Aplikasi ...</h1>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-success">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-info fa-fw"></i> Tentang Aplikasi</h3></div>
            <div class="panel-body">
                <p>Ini adalah starter kit untuk membuat aplikasi berbasis Web dengan <strong>Laravel 5.2</strong>.</p>
                <p>
                    Pada aplikasi ini terdapat beberapa fitur dasar biasa digunakan untuk aplikasi Web :
                    <ol>
                        <li>Autentikasi User
                            <ul>
                                <li>Login</li>
                                <li>Logout</li>
                                <li>Register</li>
                                <li>Ganti Password</li>
                                <li>Lupa Password</li>
                            </ul>
                        </li>
                        <li>b</li>
                        <li>c</li>
                        <li>d</li>
                    </ol>
                </p>
                <p>Aplikasi ini dibuat dengan mempertimbangkan kemudahan penggunaan, mempermudah proses transaksi, minimalisir kemungkinan kesalahan input dengan fitur validasi data sebelum menyimpan ke dalam database.</p>
                <p>Aplikasi ini dapat dikembangkan lebih lanjut dengan fitur-fitur baru menyesuaikan kebutuhan.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading"><h3 class="panel-title">Tentang Pengembang Aplikasi</h3></div>
            <div class="panel-body">
                <p>
                    Aplikasi ini dibuat oleh:
                    <table class="table">
                        <tbody>
                            <tr><td>Nama</td><td>:</td><td>Nafies Luthfi</td></tr>
                            <tr><td>Kontak</td><td>:</td><td>0817-532-654</td></tr>
                            <tr><td>Email</td><td>:</td><td>nafiesL@gmail.com</td></tr>
                            <tr><td>Website</td><td>:</td><td><a href="http://jasawebsitebanjarmasin.com" target="_blank">JasaWebsiteBanjarmasin.com</a></td></tr>
                            <tr><td>Alamat</td><td>:</td><td>Jln. Pramuka, Gg. Mawar, Rt. 09, No. 60, Kel. Pemurus Luar, Kec. Banjarmasin Timur, Kota Banjarmasin - 70249</td></tr>
                        </tbody>
                    </table>
                </p>
                <p>Silakan menghubungi saya untuk pembuatan website, aplikasi berbasis web, blog, dan jasa SEO (menjadikan website anda terindex pada halaman 1 di mesin mencari google).</p>
            </div>
        </div>
    </div>
</div>
@endsection