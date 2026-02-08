Laravel Multi-Tenant SaaS Uygulama Altyapısı
Bu proje, tek bir veritabanı veya ayrı veritabanları üzerinden birden fazla bağımsız müşteriye (tenant) hizmet verebilen, ölçeklenebilir bir SaaS (Software as a Service) mimarisi örneğidir. Proje, Laravel'in sunduğu güçlü backend araçları kullanılarak kurumsal standartlarda inşa edilmiştir.

🏗 Mimari Yaklaşım
Multi-Tenancy: Her kiracının (tenant) kendi verilerine, ayarlarına ve kullanıcılarına sahip olduğu izolasyon odaklı bir yapı kurgulanmıştır.

MVC Tasarım Kalıbı: Laravel'in Model-View-Controller mimarisi ile kodun sürdürülebilirliği ve okunabilirliği maksimize edilmiştir.

Veritabanı Yönetimi: Eloquent ORM ve Migration yapısı sayesinde dinamik ve genişletilebilir bir veritabanı şeması oluşturulmuştur.

🛠 Teknik Yetkinlikler
Framework: Laravel 10+ / PHP 8.x

Güvenlik: Kullanıcı kimlik doğrulama (Authentication) ve CSRF koruması ile güvenli bir oturum yönetimi sağlanmıştır.

Frontend: Blade Template Engine ve modern CSS araçları ile kullanıcı dostu arayüzler geliştirilmiştir.

Veri Yönetimi: Karmaşık veritabanı ilişkileri ve tenant bazlı filtreleme mekanizmaları uygulanmıştır.

🚀 Proje Kurulumu
Bağımlılıkları yükleyin: composer install

Çevresel ayarları yapılandırın: cp .env.example .env

Uygulama anahtarını oluşturun: php artisan key:generate

Veritabanını ve tenant yapılarını hazırlayın: php artisan migrate

Sunucuyu başlatın: php artisan serve
