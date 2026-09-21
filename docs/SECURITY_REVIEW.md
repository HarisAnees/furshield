# Security Review Baseline

- Sanctum token authentication.
- Role middleware and ownership checks.
- Private storage for medical/insurance documents.
- MIME/extension/size validation on uploaded documents.
- Appointment overlap validation.
- Audit log model/service included.
- No payment credentials or payment gateway.
- No veterinarian credential-authentication workflow, matching SRS scope.

Before production: configure HTTPS, secrets, mail, backups, rate limits/WAF, log retention, queue worker, storage, database credentials, monitoring, and run the complete test suite in the target environment.
