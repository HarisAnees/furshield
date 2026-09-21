# SRS Backend Implementation Matrix

| SRS area | Backend coverage |
|---|---|
| Registration/login/RBAC | Implemented |
| Pet profiles + multiple pets | Implemented |
| Health records/timeline data | Implemented |
| Medical document storage | Implemented |
| Insurance policy/claims view/storage | Implemented |
| Vet profiles + availability | Implemented |
| Appointment booking + overlap protection | Implemented |
| Vet access via booked appointment relationship | Implemented in policy/controller flow |
| Treatment/health record logging | Implemented |
| Shelter/adoption listings | Implemented |
| Shelter care logs | Implemented |
| Adoption interest/status | Implemented |
| Product browsing/filtering/cart/orders | Implemented; no payment/delivery |
| Care articles/videos/FAQs | Implemented |
| Reminders/notifications | Implemented as database notifications + scheduler |
| Family account sharing | Implemented baseline |
| Ratings/feedback | Implemented |
| Search/filter/sort | Implemented on key collections |
| Google Maps/OpenStreetMap | Backend stores location fields; external map integration remains frontend/config concern |
| Vet credential authentication | Not implemented because explicitly out of scope |
| Payment gateway | Not implemented because explicitly out of scope |
