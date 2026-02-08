<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Company;

// 1. GİRİŞ VE SEÇİM EKRANI
Route::get('/', function () {
    
    // --- VERİTABANI HAZIRLIĞI (Otomatik) ---
    // Şirketleri ve Kullanıcıları Oluştur
    $sirketA = Company::firstOrCreate(['name' => 'Firma A']);
    $ali = User::firstOrCreate(['email' => 'ali@a.com'], ['name' => 'Ali', 'password' => bcrypt('123'), 'company_id' => $sirketA->id]);

    $sirketB = Company::firstOrCreate(['name' => 'Firma B']);
    $veli = User::firstOrCreate(['email' => 'veli@b.com'], ['name' => 'Veli', 'password' => bcrypt('123'), 'company_id' => $sirketB->id]);

    // Ürünleri Oluştur (Giriş yaparak ekliyoruz ki senin Trait çalışsın)
    Auth::login($ali);
    if(Product::where('name', 'Ali Laptop')->doesntExist()){ Product::create(['name' => 'Ali Laptop', 'price' => 15000]); }
    if(Product::where('name', 'Ali Mouse')->doesntExist()){ Product::create(['name' => 'Ali Mouse', 'price' => 500]); }
    Auth::logout();

    Auth::login($veli);
    if(Product::where('name', 'Veli Telefon')->doesntExist()){ Product::create(['name' => 'Veli Telefon', 'price' => 20000]); }
    if(Product::where('name', 'Veli Kulaklık')->doesntExist()){ Product::create(['name' => 'Veli Kulaklık', 'price' => 1000]); }
    Auth::logout();
    // -----------------------------------------

    // HTML GİRİŞ EKRANI
    return '
    <div style="font-family: sans-serif; text-align: center; margin-top: 50px;">
        <h1>Multi-Tenant (Çoklu Şirket) Testi</h1>
        <p>Aşağıdan giriş yapmak istediğiniz kullanıcıyı seçin:</p>
        
        <div style="display: flex; justify-content: center; gap: 20px;">
            <a href="/giris/ali" style="background: #3498db; color: white; padding: 20px; text-decoration: none; border-radius: 8px; font-size: 18px;">
                👨‍💻 <b>Ali Olarak Gir</b><br><small>Firma A</small>
            </a>

            <a href="/giris/veli" style="background: #e74c3c; color: white; padding: 20px; text-decoration: none; border-radius: 8px; font-size: 18px;">
                👨‍💼 <b>Veli Olarak Gir</b><br><small>Firma B</small>
            </a>
        </div>
        <br><br>
        <p style="color: gray;">Not: Veritabanında tüm ürünler yan yana duruyor,<br>ama giriş yapınca ayrışacaklar.</p>
    </div>
    ';
});

// 2. GİRİŞ YAPMA ROTASI
Route::get('/giris/{kim}', function ($kim) {
    $email = ($kim == 'ali') ? 'ali@a.com' : 'veli@b.com';
    $user = User::where('email', $email)->first();
    Auth::login($user);
    return redirect('/panel');
});

// 3. ÜRÜNLERİ GÖRDÜĞÜMÜZ PANEL
Route::get('/panel', function () {
    if (!Auth::check()) { return redirect('/'); }

    // DİKKAT: Burada "where company_id = ..." YAZMIYORUZ!
    // Senin yazdığın Scope bunu arka planda otomatik yapıyor.
    $urunler = Product::all(); 
    
    $renk = (Auth::user()->name == 'Ali') ? '#3498db' : '#e74c3c';

    return '
    <div style="font-family: sans-serif; padding: 40px; max-width: 600px; margin: 0 auto; border: 2px solid '.$renk.'; border-radius: 10px;">
        <h1 style="color: '.$renk.';">Hoşgeldin, '.Auth::user()->name.'</h1>
        <h3>Şirket: '.Auth::user()->company->name.'</h3>
        <hr>
        
        <h3>📋 Sizin Şirketin Ürünleri:</h3>
        <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
            <tr style="background: #f0f0f0;"><th>Ürün Adı</th><th>Fiyat</th></tr>
            '. $urunler->map(function($u){ 
                return "<tr><td>{$u->name}</td><td>{$u->price} TL</td></tr>"; 
            })->implode('') .'
        </table>

        '. ($urunler->isEmpty() ? '<p>Hiç ürün yok.</p>' : '') .'

        <br><br>
        <a href="/cikis" style="background: #555; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Çıkış Yap</a>
    </div>
    ';
});

// 4. ÇIKIŞ ROTASI
Route::get('/cikis', function () {
    Auth::logout();
    return redirect('/');
});