# Bản Tin Trường

## Giới thiệu

Bản Tin Trường là một website quản lý và đăng tải tin tức dành cho môi trường học đường.  
Hệ thống cho phép người dùng đăng nhập và thực hiện các chức năng theo từng vai trò khác nhau như học sinh, giáo viên và quản trị viên.

Dự án được xây dựng bằng Laravel và SQLite trong khuôn khổ đồ án tốt nghiệp.  
Mục tiêu của dự án là xây dựng một hệ thống quản lý nội dung cơ bản, có phân quyền và xử lý dữ liệu đầy đủ (CRUD).

## Installation

1. Tải project về máy

git clone https://github.com/kaniheikegani/banchinhthuc.git  
cd Ban_Tin_Truong

2. Cài các thư viện cần thiết

composer install

3. Tạo file cấu hình môi trường

cp .env.example .env  
php artisan key:generate

4. Mở file .env và chỉnh lại thông tin database cho đúng với máy của bạn

5. Tạo database và chạy lệnh

php artisan migrate

6. Chạy project

php artisan serve

Sau đó mở trình duyệt và vào:
http://127.0.0.1:8000