<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


# F28 System

F28 is a **multi-tenant** system built with **Laravel 11.x** and **Filament**, designed to manage multiple tenants with separate databases. Each tenant has an independent admin panel and operates within its own database environment.

## Features

- **Multi-Tenant Architecture:** Tenant are managed using subdomains (`{tenant1}.f28.local`).
- **Separate Databases:** Each tenant has its own database for better data isolation.
- **Filament Admin Panel:** Modern UI for managing tenants, users, and roles.
- **Dynamic Database Connection:** Automatically switches databases based on subdomains.
- **Role-Based Access Control (RBAC):** Secure user access with Laravel policies.
- **Multi-Language Support:** Supports Sinhala, Tamil, and English (default: Sinhala).
- **Vendor Management Module:** Create, update, and manage tenants.
- **User & Role Management:** Separate user management for tenants.
- **Custom Artisan Commands:** Manage tenant migrations and seeders.

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Laravel 11.x
- MySQL 8+
- Nginx or Apache
- Node.js & npm (for frontend assets)

### Steps to Install

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/kanishkamaduranga/Prime-multi-tenancy f28-system
   cd f28-system
   ```
2. **Install Dependencies:**
   ```bash
   composer install
   ```
3. **Configure Environment:**
   ```bash
   cp .env.example .env
   ```
   Update `.env` with database credentials.

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```
5. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```
6. **Setup Tenant Database & Subdomain:**
    - Add tenant subdomains in your local environment (e.g., `tenant1.f28.local` in `/etc/hosts`).
    - Use the **Tenant Management Module** to register tenants and configure their databases.

7. **Start the Development Server:**
   ```bash
   php artisan serve
   ```

## Multi-Tenant Functionality
- Tenants are identified by subdomains.
- Database connections switch dynamically.
- Each tenant has its own user & role management.

- **Update central domain**
   - Open config/tenancy.php file
   - find "central_domains" and update your central domain

- **Create Tenant by CLI command**
  ```bash
  php artisan tenant:create {tenant id} {tenant full url with subdomain} --email=={admin@email.com} --password={admin password}
  ```
- **Run Tenant Migrations:**
  ```bash
  php artisan tenants:migrate
  ```
- **Seed Tenant Database:**
  ```bash
  php artisan tenants:seed
  ```

## Multi-Language Support
- Default Language: **Sinhala**
- Available Languages: **Sinhala, Tamil, English**
- Language switcher available in the Filament top bar.

## License
This project is licensed under the MIT License.

## Contributors
- Kanishka Maduranga

## Contact
For support, contact [kanishka1000@gmail.com].

