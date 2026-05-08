# NetKey - Hệ Thống Quản Lý Tài Khoản & Sản Phẩm Số

Dự án **NetKey** là một hệ thống quản lý người dùng, sản phẩm số và giao dịch được xây dựng trên nền tảng **Laravel** và **Vite**. Hệ thống hỗ trợ quản lý Key, ví điện tử, và các gói dịch vụ đa dạng.

---

## 1. Yêu Cầu Hệ Thống

Trước khi cài đặt, hãy đảm bảo máy tính của bạn đã có:

- **PHP**: Phiên bản >= 8.1
- **Composer**: Trình quản lý thư viện PHP
- **Node.js & NPM**: Phiên bản LTS (để build frontend)
- **Cơ sở dữ liệu**: MySQL/MariaDB (hoặc SQLite để cài đặt nhanh)
- **Git**: Để tải mã nguồn

---

## 2. Các Bước Cài Đặt Thực Tế

Thực hiện theo các bước dưới đây để thiết lập dự án thành công:

### Bước 2.1: Tải Mã Nguồn
```bash
git clone https://github.com/DatSpirit/NetKey.git
cd NetKey
```

### Bước 2.2: Cài Đặt Thư Viện (Backend & Frontend)
```bash
# Cài đặt thư viện PHP
composer install

# Nếu gặp lỗi "Class not found" hoặc treo ở bước autoload, hãy chạy:
composer dump-autoload

# Cài đặt thư viện Node.js
npm install
```

### Bước 2.3: Cấu Hình Môi Trường (.env)
1. Tạo file cấu hình:
   ```bash
   cp .env.example .env
   ```
2. Tạo khóa ứng dụng:
   ```bash
   php artisan key:generate
   ```
3. Cấu hình Database trong `.env`:
   - **Cách 1: Sử dụng SQLite (Nhanh nhất)**
     ```env
     DB_CONNECTION=sqlite
     ```
     *(Laravel sẽ tự động tạo file database.sqlite nếu chưa có)*
   - **Cách 2: Sử dụng MySQL (XAMPP/Docker)**
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=ten_database_cua_ban
     DB_USERNAME=root
     DB_PASSWORD=
     ```

### Bước 2.4: Build Giao Diện (Bắt buộc)
Bước này cực kỳ quan trọng để giao diện hiển thị đúng (CSS/JS):
```bash
npm run build
```

### Bước 2.5: Khởi Tạo Cơ Sở Dữ Liệu & Dữ Liệu Mẫu
Chạy lệnh migrate kèm seeder để có sẵn tài khoản Admin và dữ liệu mẫu:
```bash
php artisan migrate --seed
```
*Lưu ý: Nếu dùng SQLite, chọn "Yes" khi được hỏi có muốn tạo file database không.*

### Bước 2.6: Tạo Liên Kết Lưu Trữ
```bash
php artisan storage:link
```

---

## 3. Chạy Ứng Dụng

Sau khi hoàn tất, khởi động server:
```bash
php artisan serve
```
Truy cập ứng dụng tại: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 4. Các Lưu Ý Quan Trọng

- **Tài khoản Admin:** Sau khi chạy `--seed`, hãy kiểm tra file `database/seeders/UserSeeder.php` để xem thông tin đăng nhập mặc định.
- **Lỗi CSS/JS:** Nếu trang web không có định dạng, hãy chạy lại lệnh `npm run build`.
- **Dữ liệu mẫu:** Seeder sẽ tạo ra hơn 200 giao dịch mẫu, các gói VIP và Key để bạn có thể trải nghiệm đầy đủ các tính năng của Dashboard ngay lập tức.
- **Xóa Cache (nếu cần):**
  ```bash
  php artisan config:clear
  php artisan cache:clear
  ```

---

## 5. Đóng Góp & Hỗ Trợ
Nếu bạn gặp bất kỳ lỗi nào trong quá trình cài đặt, vui lòng kiểm tra lại phiên bản PHP và file `.env`.

**Chúc bạn trải nghiệm NetKey thành công!**
