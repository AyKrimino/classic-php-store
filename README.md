# Classic PHP Store

This is a **simple e-commerce application** built with **PHP (procedural style)** and **MySQL/MariaDB**, designed and developed by [AyKrimino](https://github.com/AyKrimino). It was created as an educational project to showcase classic PHP development practices, including a custom database schema, user authentication, product management, and more.

---

## ⚡ Requirements

- PHP >= 7.x (preferably 7.4 or above)
- MySQL/MariaDB server
- A web server such as Apache or Nginx (or use PHP's built-in server)
- XAMPP/LAMPP if on Linux (for an easier installation setup)
- Basic knowledge of PHP and SQL

---

## 📂 Installation

1. **Clone the project**

   ```bash
   git clone https://github.com/AyKrimino/classic-php-store.git
   cd classic-php-store


2. **Create the database**

- Start your MySQL/MariaDB server
- Create a new database (for example, classic_php_store).
- Import the SQL schema located in config/schema.sql.
> Example using the MySQL shell:
    ```bash
    mysql -u your_username -p classic_php_store < config/schema.sql
    ```

3. **Configure Database Credentials**

This project uses a simple `.env` file to manage your database credentials.

> This file is not provided by default for security reasons.

### Step 1: Create a `.env` file in the root of the project

```
DB_HOST=127.0.0.1
DB_USER=your_mysql_username
DB_PASS=your_mysql_password
DB_NAME=your_database_name
```

### Step 2: Save the file


4. **Set Up Your Web Server**
- For XAMPP/LAMPP Users: Place the project folder in your /opt/lampp/htdocs/ directory.
- Other Web Servers: Configure your virtual host to point to the project directory.
> Open your browser and navigate to:
    ```bash
    http://localhost/classic-php-store
    ```

---

## 🛠 Creating an Admin Account

To create an admin account for testing purposes, follow these steps:
1. **Open your terminal.**

2. **Run the Admin Creation Script:**
- If you're on Linux using XAMPP/LAMPP, run:
    ```bash
    /opt/lampp/bin/php createsuperuser.php -n "admin" -e "admin@admin.com" -p "Admin123"
    ```
- For other environments, simply use the PHP binary installed on your system:
    ```bash
    php createsuperuser.php -n "admin" -e "admin@admin.com" -p "Admin123"
    ```
**Notes:**
    - Ensure your MySQL server is running.
    - The script will hash the password and insert the admin user into the User table, then link the record in the Admin table.

3. **Log In as Admin:**

Open your browser and navigate to:
    
```bash
http://localhost/classic-php-store/admin-sign-in.php
```
Use the credentials:
- **email:** admin@admin.com
- **password:** Admin123

---

## ⚠️ Notes

- This project is developed for educational purposes and demonstrates classic procedural PHP development practices.
- While functional, security practices in this project are basic. For production-ready systems, consider implementing more robust security, validation, and error handling.
- If you modify the database schema or configuration settings, make sure to update your .env file accordingly.

---

## 📄 License
This project is for educational purposes. Feel free to use and modify the code as needed.

---
