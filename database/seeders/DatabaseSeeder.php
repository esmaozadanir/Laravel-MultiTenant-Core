<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // TRUNCATE SATIRLARINI SİLDİK (Hata veren yer orasıydı)
        
        // 10 Tane Rastgele Şirket Oluşturuyoruz
        for ($i = 1; $i <= 10; $i++) {
            
            // 1. Şirketi Kur
            $company = Company::create(['name' => "Şirket - $i A.Ş."]);

            // 2. Bu şirketin Patronunu Oluştur
            $user = User::create([
                'name' => "Patron $i",
                'email' => "patron$i@test.com",
                'password' => bcrypt('123'),
                'company_id' => $company->id
            ]);

            // 3. Patron giriş yapsın ki Trait çalışsın
            Auth::login($user);

            // 4. Rastgele Ürünler Ekle
            Product::create(['name' => "Laptop (Şirket $i Malı)", 'price' => rand(5000, 20000)]);
            Product::create(['name' => "Telefon (Şirket $i Malı)", 'price' => rand(3000, 10000)]);
            
            Auth::logout();
        }
    }
}