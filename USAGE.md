# Petunjuk Penggunaan Restaurant Review & Rating System

## URL yang Benar
Untuk mengakses aplikasi ini dengan benar, pastikan Anda mengakses URL yang tepat:

- ✅ **BENAR**: `http://localhost:8001/reviews` atau `http://localhost:8001/` 
  - Ini akan menampilkan antarmuka HTML untuk sistem review
  
- ❌ **SALAH**: `http://localhost:8001/api/reviews`
  - Ini adalah endpoint API yang hanya akan mengembalikan data JSON mentah

## Cara Menjalankan Server

1. Pastikan Nameko service berjalan:
   ```
   nameko run backend.review_rating_service backend.http_gateway --config config.yaml
   ```
   Service ini seharusnya berjalan pada port 8000

2. Jalankan Laravel pada port yang berbeda:
   ```
   cd project_folder
   php artisan serve --port=8001
   ```

3. Buka browser dan akses: `http://localhost:8001/reviews`

## Troubleshooting

Jika Anda melihat JSON mentah:
- Periksa URL Anda - pastikan tidak mengakses endpoint API
- Jika menggunakan Vite atau Webpack dev server, pastikan asset CSS dan JS dimuat dengan benar

Jika terjadi error saat mengakses Nameko service:
- Pastikan service berjalan pada port yang benar
- Periksa file `.env` untuk konfigurasi `NAMEKO_GATEWAY_URL` yang benar (http://localhost:8000)
