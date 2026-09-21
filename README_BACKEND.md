# FurShield — Entire Backend

This package is the complete backend implementation baseline built from the supplied FurShield SRS and the Vibe Coding workflow. It uses Laravel + PHP + MySQL + Sanctum.

## Included
- Authentication, RBAC, Sanctum API
- Pet/health/medical documents/insurance
- Vet profiles, availability and appointments
- Shelter/adoption/care logs/adopter interests
- Marketplace products, cart, checkout-as-order, order history (no payment gateway)
- Care content
- Reminders and database notifications
- Family sharing baseline
- Ratings
- Admin moderation endpoints
- Policies, validation requests, services, audit logs
- Migrations, seed data and feature tests
- API/security/implementation documentation

## Install
1. Copy `.env.example` to `.env`.
2. Configure MySQL.
3. Run `composer install`.
4. Run `php artisan key:generate`.
5. Run `php artisan migrate --seed`.
6. Run `php artisan storage:link`.
7. Run `php artisan test`.
8. Run `php artisan serve`.

## Demo credentials
- owner@furshield.test / password
- vet@furshield.test / password
- shelter@furshield.test / password
- admin@furshield.test / password

These are development-only seed credentials and must be changed before deployment.

## Scope constraints
The supplied SRS explicitly excludes online payment gateway processing and veterinarian credential authentication. This backend does not add those capabilities.

## Production note
This is a complete application backend source baseline, but production readiness still requires environment-specific dependency installation, database provisioning, secrets, HTTPS, mail/queue/storage configuration, and a full target-environment QA run.
