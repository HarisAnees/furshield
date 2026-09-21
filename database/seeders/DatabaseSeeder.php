<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Vet, Shelter, Pet, Appointment, Product, Order, OrderItem, AuditLog, CareContent, HealthRecord};
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        // 1. Core Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@furshield.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+1 555-0100',
                'address' => 'FurShield HQ',
                'is_active' => true,
                'created_at' => Carbon::parse('2025-01-01 10:00:00')
            ]
        );

        $sarah = User::updateOrCreate(
            ['email' => 'sarah@example.com'],
            [
                'name' => 'Sarah Johnson',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'phone' => '+1 555-0144',
                'address' => '124 Maple Street',
                'is_active' => true,
                'created_at' => Carbon::parse('2025-04-24 09:30:00')
            ]
        );

        $drCarter = User::updateOrCreate(
            ['email' => 'emily@vet.com'],
            [
                'name' => 'Dr. Emily Carter',
                'password' => Hash::make('password'),
                'role' => 'vet',
                'phone' => '+1 555-0182',
                'address' => 'Carter Animal Health Clinic',
                'is_active' => true,
                'created_at' => Carbon::parse('2025-04-23 11:15:00')
            ]
        );

        $shelter = User::updateOrCreate(
            ['email' => 'shelter@furshield.com'],
            [
                'name' => 'Happy Paws Shelter',
                'password' => Hash::make('password'),
                'role' => 'shelter',
                'phone' => '+1 555-0199',
                'address' => '88 Rescue Blvd',
                'is_active' => true,
                'created_at' => Carbon::parse('2025-04-22 14:20:00')
            ]
        );

        $james = User::updateOrCreate(
            ['email' => 'james@example.com'],
            [
                'name' => 'James Wilson',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'phone' => '+1 555-0163',
                'address' => '42 Oak Avenue',
                'is_active' => true,
                'created_at' => Carbon::parse('2025-04-20 16:45:00')
            ]
        );

        $mike = User::updateOrCreate(
            ['email' => 'mike@example.com'],
            [
                'name' => 'Mike R.',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'is_active' => true,
                'created_at' => Carbon::parse('2025-04-18 10:00:00')
            ]
        );

        $emilyS = User::updateOrCreate(
            ['email' => 'emilys@example.com'],
            [
                'name' => 'Emily S.',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'is_active' => true,
                'created_at' => Carbon::parse('2025-04-15 12:00:00')
            ]
        );

        $david = User::updateOrCreate(
            ['email' => 'david@example.com'],
            [
                'name' => 'David Lee',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'is_active' => true,
                'created_at' => Carbon::parse('2025-04-25 08:00:00')
            ]
        );

        $drWilson = User::updateOrCreate(
            ['email' => 'drwilson@vet.com'],
            ['name' => 'Dr. Wilson', 'password' => Hash::make('password'), 'role' => 'vet', 'is_active' => true]
        );
        $drBrown = User::updateOrCreate(
            ['email' => 'drbrown@vet.com'],
            ['name' => 'Dr. Brown', 'password' => Hash::make('password'), 'role' => 'vet', 'is_active' => true]
        );
        $drDavis = User::updateOrCreate(
            ['email' => 'drdavis@vet.com'],
            ['name' => 'Dr. Davis', 'password' => Hash::make('password'), 'role' => 'vet', 'is_active' => true]
        );

        // Standard seed users for testing
        User::updateOrCreate(
            ['email' => 'owner@furshield.test'],
            ['name' => 'Demo Owner', 'password' => Hash::make('password'), 'role' => 'owner', 'is_active' => true]
        );
        User::updateOrCreate(
            ['email' => 'vet@furshield.test'],
            ['name' => 'Demo Veterinarian', 'password' => Hash::make('password'), 'role' => 'vet', 'is_active' => true]
        );
        User::updateOrCreate(
            ['email' => 'shelter@furshield.test'],
            ['name' => 'Demo Shelter', 'password' => Hash::make('password'), 'role' => 'shelter', 'is_active' => true]
        );

        // 2. Vet Profiles
        $vet1 = Vet::updateOrCreate(['user_id' => $drCarter->id], [
            'specialization' => 'General Veterinary Care', 'experience_years' => 10,
            'clinic_name' => 'Carter Animal Clinic', 'address' => '100 Medical Center Way', 'city' => 'Metro City', 'is_available' => true
        ]);
        $vet2 = Vet::updateOrCreate(['user_id' => $drWilson->id], [
            'specialization' => 'Feline Medicine & Surgery', 'experience_years' => 7,
            'clinic_name' => 'Metro Pet Health', 'address' => '200 Vet Parkway', 'city' => 'Metro City', 'is_available' => true
        ]);
        $vet3 = Vet::updateOrCreate(['user_id' => $drBrown->id], [
            'specialization' => 'Diagnostics & Internal Medicine', 'experience_years' => 12,
            'clinic_name' => 'Brown Animal Hospital', 'address' => '350 Care Road', 'city' => 'Metro City', 'is_available' => true
        ]);
        $vet4 = Vet::updateOrCreate(['user_id' => $drDavis->id], [
            'specialization' => 'Canine Wellness & Rehabilitation', 'experience_years' => 8,
            'clinic_name' => 'Davis Companion Care', 'address' => '420 Paw Street', 'city' => 'Metro City', 'is_available' => true
        ]);

        // 3. Shelter Profile
        Shelter::updateOrCreate(['user_id' => $shelter->id], [
            'organization_name' => 'Happy Paws Shelter',
            'description' => 'Dedicated to finding loving forever homes for rescued pets.',
            'phone' => '+1 555-0199',
            'address' => '88 Rescue Blvd',
            'city' => 'Metro City',
            'verified_at' => now()
        ]);

        // 4. Pets
        $buddy = Pet::updateOrCreate(
            ['user_id' => $sarah->id, 'name' => 'Buddy'],
            [
                'species' => 'Dog',
                'breed' => 'Golden Retriever',
                'sex' => 'male',
                'date_of_birth' => Carbon::now()->subYears(3),
                'weight_kg' => 29.5,
                'microchip_number' => 'FS-DOG-99201',
                'notes' => 'Friendly, energetic, healthy.'
            ]
        );

        $luna = Pet::updateOrCreate(
            ['user_id' => $sarah->id, 'name' => 'Luna'],
            [
                'species' => 'Cat',
                'breed' => 'Domestic Cat',
                'sex' => 'female',
                'date_of_birth' => Carbon::now()->subYears(2),
                'weight_kg' => 4.1,
                'microchip_number' => 'FS-CAT-33104',
                'notes' => 'Indoor cat, vaccination due this month.'
            ]
        );

        $max = Pet::updateOrCreate(
            ['user_id' => $emilyS->id, 'name' => 'Max'],
            ['species' => 'Dog', 'breed' => 'German Shepherd', 'sex' => 'male', 'date_of_birth' => Carbon::now()->subYears(4), 'weight_kg' => 34.0]
        );

        $bella = Pet::updateOrCreate(
            ['user_id' => $david->id, 'name' => 'Bella'],
            ['species' => 'Dog', 'breed' => 'Beagle', 'sex' => 'female', 'date_of_birth' => Carbon::now()->subYears(1), 'weight_kg' => 10.2]
        );

        // 5. Health records for Sarah's pets
        HealthRecord::updateOrCreate(
            ['pet_id' => $buddy->id, 'record_type' => 'vaccination', 'title' => 'Annual Rabies & DHPP'],
            ['recorded_at' => Carbon::now()->subMonths(2), 'description' => 'Vaccines administered, no adverse reactions.', 'provider_name' => 'Dr. Emily Carter']
        );
        HealthRecord::updateOrCreate(
            ['pet_id' => $buddy->id, 'record_type' => 'checkup', 'title' => 'Routine Physical Exam'],
            ['recorded_at' => Carbon::now()->subMonths(6), 'description' => 'Vitals excellent, teeth clean.', 'provider_name' => 'Dr. Emily Carter']
        );
        HealthRecord::updateOrCreate(
            ['pet_id' => $luna->id, 'record_type' => 'vaccination', 'title' => 'FVRCP Booster Due'],
            ['recorded_at' => Carbon::now()->subMonths(11), 'description' => 'Scheduled for booster.', 'provider_name' => 'Dr. Wilson']
        );

        // 6. Appointments
        Appointment::updateOrCreate(
            ['pet_id' => $buddy->id, 'starts_at' => $today->copy()->setTime(10, 0)],
            [
                'user_id' => $sarah->id,
                'vet_id' => $vet1->id,
                'ends_at' => $today->copy()->setTime(10, 30),
                'reason' => 'General Checkup',
                'status' => 'confirmed'
            ]
        );

        Appointment::updateOrCreate(
            ['pet_id' => $luna->id, 'starts_at' => $today->copy()->setTime(11, 30)],
            [
                'user_id' => $mike->id,
                'vet_id' => $vet2->id,
                'ends_at' => $today->copy()->setTime(12, 0),
                'reason' => 'Vaccination & Wellness',
                'status' => 'confirmed'
            ]
        );

        Appointment::updateOrCreate(
            ['pet_id' => $max->id, 'starts_at' => $today->copy()->setTime(14, 0)],
            [
                'user_id' => $emilyS->id,
                'vet_id' => $vet3->id,
                'ends_at' => $today->copy()->setTime(14, 30),
                'reason' => 'Ear Examination',
                'status' => 'pending'
            ]
        );

        Appointment::updateOrCreate(
            ['pet_id' => $bella->id, 'starts_at' => $today->copy()->setTime(16, 30)],
            [
                'user_id' => $david->id,
                'vet_id' => $vet4->id,
                'ends_at' => $today->copy()->setTime(17, 0),
                'reason' => 'Puppy Health Review',
                'status' => 'confirmed'
            ]
        );

        // 7. Products
        $p1 = Product::updateOrCreate(
            ['slug' => 'premium-dog-food'],
            ['name' => 'Premium Dog Food', 'category' => 'Food', 'description' => 'Nutrient-rich balanced nutrition for active adult dogs.', 'price' => 24.99, 'stock_quantity' => 240, 'is_active' => true]
        );
        $p2 = Product::updateOrCreate(
            ['slug' => 'cat-litter'],
            ['name' => 'Cat Litter', 'category' => 'Care', 'description' => 'Low dust, odor-locking premium clumping litter.', 'price' => 12.99, 'stock_quantity' => 180, 'is_active' => true]
        );
        $p3 = Product::updateOrCreate(
            ['slug' => 'pet-shampoo'],
            ['name' => 'Pet Shampoo', 'category' => 'Grooming', 'description' => 'Gentle hypoallergenic oatmeal soothing shampoo.', 'price' => 8.99, 'stock_quantity' => 110, 'is_active' => true]
        );
        $p4 = Product::updateOrCreate(
            ['slug' => 'dog-toys'],
            ['name' => 'Dog Toys', 'category' => 'Toys', 'description' => 'Durable chew ropes and squeaky fetch balls.', 'price' => 6.99, 'stock_quantity' => 200, 'is_active' => true]
        );

        // 8. Orders & Order Items
        $order1 = Order::updateOrCreate(
            ['user_id' => $sarah->id, 'notes' => 'Order #ORD-1024'],
            ['status' => 'completed', 'subtotal' => 3198.72, 'created_at' => Carbon::now()->subHours(3)]
        );
        OrderItem::updateOrCreate(
            ['order_id' => $order1->id, 'product_id' => $p1->id],
            ['product_name' => 'Premium Dog Food', 'unit_price' => 24.99, 'quantity' => 128, 'line_total' => 3198.72]
        );

        $order2 = Order::updateOrCreate(
            ['user_id' => $mike->id, 'notes' => 'Order #ORD-1025'],
            ['status' => 'completed', 'subtotal' => 1247.04, 'created_at' => Carbon::now()->subHours(8)]
        );
        OrderItem::updateOrCreate(
            ['order_id' => $order2->id, 'product_id' => $p2->id],
            ['product_name' => 'Cat Litter', 'unit_price' => 12.99, 'quantity' => 96, 'line_total' => 1247.04]
        );

        $order3 = Order::updateOrCreate(
            ['user_id' => $james->id, 'notes' => 'Order #ORD-1026'],
            ['status' => 'completed', 'subtotal' => 611.32, 'created_at' => Carbon::now()->subDay()]
        );
        OrderItem::updateOrCreate(
            ['order_id' => $order3->id, 'product_id' => $p3->id],
            ['product_name' => 'Pet Shampoo', 'unit_price' => 8.99, 'quantity' => 68, 'line_total' => 611.32]
        );

        $order4 = Order::updateOrCreate(
            ['user_id' => $david->id, 'notes' => 'Order #ORD-1027'],
            ['status' => 'completed', 'subtotal' => 398.43, 'created_at' => Carbon::now()->subDays(2)]
        );
        OrderItem::updateOrCreate(
            ['order_id' => $order4->id, 'product_id' => $p4->id],
            ['product_name' => 'Dog Toys', 'unit_price' => 6.99, 'quantity' => 57, 'line_total' => 398.43]
        );

        // 9. Audit Logs
        AuditLog::create([
            'action' => 'New adoption request for Max',
            'user_id' => $emilyS->id,
            'subject_type' => 'App\Models\AdoptionListing',
            'subject_id' => 1,
            'created_at' => Carbon::now()->subHours(2),
        ]);
        AuditLog::create([
            'action' => 'Order #ORD-1024 placed by Sarah Johnson',
            'user_id' => $sarah->id,
            'subject_type' => 'App\Models\Order',
            'subject_id' => $order1->id,
            'created_at' => Carbon::now()->subHours(3),
        ]);
        AuditLog::create([
            'action' => 'Health record updated for Luna',
            'user_id' => $drWilson->id,
            'subject_type' => 'App\Models\HealthRecord',
            'subject_id' => 3,
            'created_at' => Carbon::now()->subHours(4),
        ]);
        AuditLog::create([
            'action' => 'New review received for Pet Food',
            'user_id' => $sarah->id,
            'subject_type' => 'App\Models\Product',
            'subject_id' => $p1->id,
            'created_at' => Carbon::now()->subHours(5),
        ]);
        AuditLog::create([
            'action' => 'User registration: David Lee (Owner)',
            'user_id' => $david->id,
            'subject_type' => 'App\Models\User',
            'subject_id' => $david->id,
            'created_at' => Carbon::now()->subHours(6),
        ]);

        // 10. Care Content
        CareContent::updateOrCreate(
            ['slug' => 'keep-your-pets-hydrated'],
            [
                'title' => 'Keep Your Pets Hydrated',
                'category' => 'Tips',
                'content' => 'Fresh water is essential for your pet\'s health. Make sure they always have access to clean, fresh water.',
                'is_published' => true,
            ]
        );

        CareContent::updateOrCreate(
            ['slug' => 'vaccination-basics'],
            [
                'title' => 'Vaccination Basics',
                'category' => 'Health',
                'content' => 'Keep vaccinations current according to veterinary guidance to protect against preventable illnesses.',
                'is_published' => true,
            ]
        );
    }
}
