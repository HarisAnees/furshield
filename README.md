# 🐾 FurShield — Advanced Pet Care & Clinical Intelligence Platform

[![TechWiz 6](https://img.shields.io/badge/Competition-TechWiz%206-emerald.svg)](https://aptech-education.com.pk)
[![Laravel](https://img.shields.io/badge/Laravel-11%20%2F%2012-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3%2B-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

> A modern, competition-grade veterinary healthcare, shelter adoption, and pet parenting ecosystem built for the **TechWiz 6 Global Tech Competition** (Aptech Limited).

---

## 🌟 Key Roles & Dedicated Portals

FurShield features complete **Role-Based Access Control (RBAC)** across 4 distinct user personas:

| Role | Portal URL | Primary Capabilities |
| :--- | :--- | :--- |
| **🛡️ System Administrator** | `/admin` | Clinic oversight, system audit logs, user management, and platform analytics. |
| **🩺 Veterinary Specialist** | `/vet` | Clinical appointments, treatment logger, health passport creation, and doctor schedule. |
| **🏠 Animal Shelter Sanctuary** | `/shelter` | Animal intake, public adoption listings, daily welfare logs (feeding, exercise, medical), and adopter vetting. |
| **🐾 Pet Owner / Parent** | `/owner` | Pet digital passport, appointment booking, reminders, adoption tracking, and supply orders. |

---

## 🚀 Pre-Seeded Competition Test Credentials

All test accounts use the default password: **`password`**

* **Administrator**: `admin@furshield.test`
* **Pet Owner**: `sarah@example.com`
* **Veterinarian Doctor**: `emily@vet.com`
* **Animal Welfare Shelter**: `shelter@furshield.com`

---

## 🛠️ Tech Stack & Architecture

- **Backend Framework**: Laravel 11/12 (PHP 8.3+)
- **Database Support**: MySQL / SQLite / PostgreSQL (with automatic seeding)
- **Frontend Architecture**: Blade Components, Tailwind CSS, Motion/GSAP Animations, Swiper Cards
- **Security**: Granular Role Middleware, CSRF verification, password hashing, and active session management
- **Deployment**: Dockerized with multi-stage Apache + PHP-FPM container ready for Render.com, Koyeb, and Railway

---

## 💻 Local Quickstart

```bash
# 1. Clone the repository
git clone https://github.com/HarisAnees/furshield.git
cd furshield

# 2. Install dependencies
composer install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Migrate and seed test data
php artisan migrate --seed

# 5. Start the local server
php artisan serve
```

---

## 📜 Deliverables & Documentation

- **Full Competition SRS Audit**: [`docs/SRS_AUDIT.md`](docs/SRS_AUDIT.md)
- **Strategic Innovation Roadmap**: [`ROADMAP.md`](ROADMAP.md)
- **Database Schema Export**: [`database/furshield.sql`](database/furshield.sql)

Developed with ❤️ for the **TechWiz 6 Global Tech Competition**.
