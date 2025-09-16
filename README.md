# 🗳️ Candidat-Who

**Candidat-Who** is a Laravel-based web application for managing **SK officials, running candidates, elections, voters, and feedback**.
It helps barangays organize and track officials, candidates, and election-related activities with an easy-to-use interface.

---

## 📦 Installation

Follow these steps to set up **Candidat-Who** locally:

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/candidat-who.git
cd candidat-who
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Setup Environment

Rename `.env.example` to `.env`:

```bash
cp .env.example .env
```

Update `.env` with your database and app details:

```
APP_NAME=Candidat.Who?
APP_URL=http://candidat-who.test

DB_DATABASE=candidat-who
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create Session Table

```bash
php artisan session:table
php artisan migrate
```

### 7. Seed Super Admin User

```bash
php artisan db:seed --class=SuperAdminSeeder
```

### 8. Run Migrations

```bash
php artisan migrate
```

Visit **(http://candidat-who.test)** in your browser.

---

## 🧭 Navigation Guide

### 1. **Authentication**

* **Login/Register** – Access the system as Admin, Super Admin or User.

### 2. **Home Page**

* Public landing page with system overview.

### 3. **Current SK Officials**

* **Index:** View all current officials
* **Create/Edit:** Add or update officials (**Admin and Super Admin**)
* **Show:** View detailed profile of an official

### 4. **Running SK Officials**

* **Index:** List all candidates
* **Show:** Candidate profile with platform and feedback
* **Create/Edit:** Add or update candidates (**Admin and Super Admin**)


### 5. **admin and superadmin**

* **Admin:** Register and manage candidates
* **Super Admin only:** Verify user and Admin Account as well as Register and manage candidates

### 6. **Feedback**

* **Users:** Submit feedback
* **Admin and SuperAdmin:** View and manage feedback

### 7. **Admin and Super Admin Dashboard**

* Central hub to manage the entire system:

  * Officials
  * Candidates
  * Feedback
  * Reports

---

## ⚙️ Tech Stack

* **Framework:** Laravel 12 (PHP 8.4+)
* **Frontend:** Blade + TailwindCSS
* **Database:** MySQL

---

## 📌 Notes

* Reset database if needed:

```bash
php artisan migrate:fresh --seed
```

---

