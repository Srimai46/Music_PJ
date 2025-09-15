# 🎵 Music Booking System

> A Laravel 12 project for managing music room bookings.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/Database-MySQL-blue?logo=mysql&logoColor=white)
![PHP](https://img.shields.io/badge/PHP->=8.2-777bb4?logo=php&logoColor=white)

---

## 🚀 Create Project in htdocs

Open terminal in your `htdocs` (or local server directory) and run:

    composer create-project "laravel/laravel:^12.0" ProjectName
    # Replace ProjectName with your desired project folder name

---

## 🗄 Connecting to Database

1. **Import SQL file**  
   Go to `/database/music_booking.sql` and import it into your database.  
   (Recommended: Use phpMyAdmin)

2. **Update `.env` file**  
   Configure your database and session settings:
   ```
    DB_CONNECTION=mysql       # Change from sqlite to mysql or others
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=music_booking # Database name
    DB_USERNAME=root
    DB_PASSWORD=

    SESSION_DRIVER=file       # Change from (database) to (file)
    SESSION_LIFETIME=120
    SESSION_ENCRYPT=false
    SESSION_PATH=/
    SESSION_DOMAIN=null
   ```
---

## 🏃‍♂️ Run Project

Start the Laravel development server:

    php artisan serve

Access your project at:  
👉 http://127.0.0.1:8000

---

## 📊 Simulate Dataset

> Default password (if reset by admin): **12345678**

### 👤 User Accounts
- `ssd` — **ssd@gmail.com** — `ssdresetupdate12345Test`  
- `Testing123new` — **Testing123@gmail.com** — `12345678`  
- `Testing333444` — **Testing333@gmail.com** — `12345678`
- `Newlookauth3` — **Newlookauth3@gmail.com** — `Newlookauth3cyreneNewlookauth3cyrene`

### 🛠 Admin Accounts
- `admin` — **admin@gmail.com** — `adminniggaupdate12345Test`  
- `test2` — **test2@gmail.com** — `12345678`

---
