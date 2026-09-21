# FurShield API

Base URL: `/api/v1`. Authentication uses Laravel Sanctum bearer tokens.

## Public
- `POST /auth/register`, `POST /auth/login`
- `GET /products`, `/products/{id}`
- `GET /vets`, `/vets/{id}`, `/vets/{id}/availability`
- `GET /shelters`
- `GET /adoptions`, `/adoptions/{id}`
- `GET /care-content`
- `GET /ratings`

## Authenticated owner
- Auth profile/logout
- Pets CRUD
- Health records CRUD with ownership checks
- Medical documents upload/download/delete
- Insurance policies
- Appointments
- Reminders
- Family sharing
- Cart, checkout, orders
- Adoption interest
- Ratings

## Veterinarian
- Availability slots
- Appointment/medical access is limited to pets connected to booked appointments.

## Shelter
- Adoption listings
- Care logs
- Adoption interest status workflow

## Admin
- Dashboard/user administration
- Product CRUD
- Care content CRUD

No payment gateway is implemented, per SRS. Veterinarian credential authentication/verification is intentionally outside scope.
