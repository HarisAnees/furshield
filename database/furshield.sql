-- ========================================================
-- FurShield Platform Database Schema & Initial Data Dump
-- TechWiz 6 Project Requirements Deliverable
-- Generated: 2026-09-21 12:16:27
-- ========================================================

SET FOREIGN_KEY_CHECKS=0;

-- --------------------------------------------------------
-- Table structure for table `adoption_interests`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `adoption_interests`;
CREATE TABLE `adoption_interests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `adoption_listing_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `adoption_interests_adoption_listing_id_user_id_unique` (`adoption_listing_id`,`user_id`),
  KEY `adoption_interests_user_id_foreign` (`user_id`),
  CONSTRAINT `adoption_interests_adoption_listing_id_foreign` FOREIGN KEY (`adoption_listing_id`) REFERENCES `adoption_listings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `adoption_interests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `adoption_listings`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `adoption_listings`;
CREATE TABLE `adoption_listings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `shelter_id` bigint(20) unsigned NOT NULL,
  `pet_name` varchar(255) NOT NULL,
  `species` varchar(255) NOT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `age_text` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `health_summary` text DEFAULT NULL,
  `care_summary` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `adoption_listings_shelter_id_foreign` (`shelter_id`),
  KEY `adoption_listings_status_species_index` (`status`,`species`),
  CONSTRAINT `adoption_listings_shelter_id_foreign` FOREIGN KEY (`shelter_id`) REFERENCES `shelters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `adoption_listings`
INSERT INTO `adoption_listings` (`id`, `shelter_id`, `pet_name`, `species`, `breed`, `age_text`, `sex`, `health_summary`, `care_summary`, `status`, `image_path`, `created_at`, `updated_at`) VALUES ('1', '1', 'Charlie', 'dog', 'Golden Retriever', '2 years old', 'male', 'Fully vaccinated, microchipped, neutered, clear heartworm panel.', 'Extremely friendly, gentle with children, loves fetch and swimming.', 'pending', '/images/charlie.jpg', '2026-09-20 15:08:06', '2026-09-20 15:08:40');
INSERT INTO `adoption_listings` (`id`, `shelter_id`, `pet_name`, `species`, `breed`, `age_text`, `sex`, `health_summary`, `care_summary`, `status`, `image_path`, `created_at`, `updated_at`) VALUES ('2', '1', 'Bella', 'dog', 'Beagle', '1.5 years old', 'female', 'Up to date on vaccinations, spayed, active and healthy.', 'Curious and energetic puppy, great on leash, gets along with other dogs.', 'available', '/images/bella.jpg', '2026-09-20 15:08:06', '2026-09-20 15:08:06');
INSERT INTO `adoption_listings` (`id`, `shelter_id`, `pet_name`, `species`, `breed`, `age_text`, `sex`, `health_summary`, `care_summary`, `status`, `image_path`, `created_at`, `updated_at`) VALUES ('3', '1', 'Rocky', 'dog', 'German Shepherd', '3 years old', 'male', 'Excellent physical condition, full vaccination schedule completed.', 'Loyal guardian, highly intelligent, trained in basic obedience commands.', 'available', '/images/rocky.jpg', '2026-09-20 15:08:06', '2026-09-20 15:08:06');
INSERT INTO `adoption_listings` (`id`, `shelter_id`, `pet_name`, `species`, `breed`, `age_text`, `sex`, `health_summary`, `care_summary`, `status`, `image_path`, `created_at`, `updated_at`) VALUES ('4', '1', 'Luna', 'cat', 'Domestic Short Hair', '1 year old', 'female', 'Vaccinated, dewormed, spayed, FIV/FeLV negative.', 'Sweet lap cat, loves cozy corners and interactive feather toys.', 'available', '/images/luna.jpg', '2026-09-20 15:08:06', '2026-09-20 15:08:06');

-- --------------------------------------------------------
-- Table structure for table `appointments`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `pet_id` bigint(20) unsigned NOT NULL,
  `vet_id` bigint(20) unsigned NOT NULL,
  `starts_at` datetime NOT NULL,
  `ends_at` datetime DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `symptoms` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'scheduled',
  `diagnosis` text DEFAULT NULL,
  `medication` text DEFAULT NULL,
  `follow_up_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_pet_id_foreign` (`pet_id`),
  KEY `appointments_vet_id_starts_at_index` (`vet_id`,`starts_at`),
  KEY `appointments_user_id_starts_at_index` (`user_id`,`starts_at`),
  CONSTRAINT `appointments_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `appointments_vet_id_foreign` FOREIGN KEY (`vet_id`) REFERENCES `vets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `appointments`
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('1', '5', '1', '2', '2026-09-20 10:00:00', '2026-09-20 10:30:00', 'General Checkup', NULL, 'confirmed', NULL, NULL, NULL, '2026-09-20 13:54:45', '2026-09-20 13:54:45');
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('2', '9', '2', '3', '2026-09-20 11:30:00', '2026-09-20 12:00:00', 'Vaccination & Wellness', NULL, 'confirmed', NULL, NULL, NULL, '2026-09-20 13:54:45', '2026-09-20 13:54:45');
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('3', '10', '3', '4', '2026-09-20 14:00:00', '2026-09-20 14:30:00', 'Ear Examination', NULL, 'pending', NULL, NULL, NULL, '2026-09-20 13:54:45', '2026-09-20 13:54:45');
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('4', '11', '4', '5', '2026-09-20 16:30:00', '2026-09-20 17:00:00', 'Puppy Health Review', NULL, 'confirmed', NULL, NULL, NULL, '2026-09-20 13:54:45', '2026-09-20 13:54:45');
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('5', '5', '1', '1', '2026-09-25 14:34:00', '2026-09-25 15:04:00', 'Cardiology and Heart Ultrasound', NULL, 'completed', NULL, NULL, NULL, '2026-09-20 14:34:45', '2026-09-20 14:35:55');
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('6', '5', '1', '1', '2026-09-25 10:00:00', '2026-09-25 10:30:00', 'Annual booster vaccination & ear checkup', NULL, 'confirmed', NULL, NULL, NULL, '2026-09-20 15:08:40', '2026-09-20 15:08:40');
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('7', '5', '1', '1', '2026-09-25 10:00:00', '2026-09-25 10:30:00', 'Annual booster vaccination & ear checkup', NULL, 'confirmed', NULL, NULL, NULL, '2026-09-20 15:09:52', '2026-09-20 15:09:52');
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('8', '5', '1', '2', '2026-09-21 10:00:00', '2026-09-21 10:30:00', 'General Checkup', NULL, 'confirmed', NULL, NULL, NULL, '2026-09-21 10:23:56', '2026-09-21 10:23:56');
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('9', '9', '2', '3', '2026-09-21 11:30:00', '2026-09-21 12:00:00', 'Vaccination & Wellness', NULL, 'confirmed', NULL, NULL, NULL, '2026-09-21 10:23:56', '2026-09-21 10:23:56');
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('10', '10', '3', '4', '2026-09-21 14:00:00', '2026-09-21 14:30:00', 'Ear Examination', NULL, 'pending', NULL, NULL, NULL, '2026-09-21 10:23:56', '2026-09-21 10:23:56');
INSERT INTO `appointments` (`id`, `user_id`, `pet_id`, `vet_id`, `starts_at`, `ends_at`, `reason`, `symptoms`, `status`, `diagnosis`, `medication`, `follow_up_notes`, `created_at`, `updated_at`) VALUES ('11', '11', '4', '5', '2026-09-21 16:30:00', '2026-09-21 17:00:00', 'Puppy Health Review', NULL, 'confirmed', NULL, NULL, NULL, '2026-09-21 10:23:56', '2026-09-21 10:23:56');

-- --------------------------------------------------------
-- Table structure for table `audit_logs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE `audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`),
  KEY `audit_logs_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `audit_logs`
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('1', '10', 'New adoption request for Max', 'App\\Models\\AdoptionListing', '1', NULL, NULL, NULL, '2026-09-20 11:54:45', '2026-09-20 13:54:45');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('2', '5', 'Order #ORD-1024 placed by Sarah Johnson', 'App\\Models\\Order', '1', NULL, NULL, NULL, '2026-09-20 10:54:45', '2026-09-20 13:54:45');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('3', '12', 'Health record updated for Luna', 'App\\Models\\HealthRecord', '3', NULL, NULL, NULL, '2026-09-20 09:54:45', '2026-09-20 13:54:45');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('4', '5', 'New review received for Pet Food', 'App\\Models\\Product', '2', NULL, NULL, NULL, '2026-09-20 08:54:45', '2026-09-20 13:54:45');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('5', '11', 'User registration: David Lee (Owner)', 'App\\Models\\User', '11', NULL, NULL, NULL, '2026-09-20 07:54:45', '2026-09-20 13:54:45');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('6', '5', 'Appointment Booked: Annual booster vaccination & ear checkup', 'Appointment', '6', NULL, NULL, '{\"pet_id\":\"1\",\"vet_id\":\"1\"}', '2026-09-20 15:08:40', '2026-09-20 15:08:40');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('7', '5', 'Adoption Application for Charlie', 'AdoptionListing', '1', NULL, NULL, '{\"applicant_name\":\"Sarah Johnson\",\"applicant_email\":\"sarah@example.com\",\"applicant_phone\":\"+1 (555) 019-2834\",\"notes\":\"We have a large fenced yard and love Golden Retrievers!\"}', '2026-09-20 15:08:40', '2026-09-20 15:08:40');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('8', '1', 'Customer Inquiry from Sarah Johnson', 'ContactInquiry', NULL, NULL, NULL, '{\"name\":\"Sarah Johnson\",\"email\":\"sarah@example.com\",\"message\":\"Hello, do you offer dental scaling for senior cats?\"}', '2026-09-20 15:08:41', '2026-09-20 15:08:41');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('9', '1', 'Newsletter Subscription: sarah.petcare@example.com', 'Newsletter', NULL, NULL, NULL, '{\"email\":\"sarah.petcare@example.com\"}', '2026-09-20 15:08:42', '2026-09-20 15:08:42');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('10', '5', 'Appointment Booked: Annual booster vaccination & ear checkup', 'Appointment', '7', NULL, NULL, '{\"pet_id\":\"1\",\"vet_id\":\"1\"}', '2026-09-20 15:09:52', '2026-09-20 15:09:52');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('11', '5', 'Adoption Application for Charlie', 'AdoptionListing', '1', NULL, NULL, '{\"applicant_name\":\"Sarah Johnson\",\"applicant_email\":\"sarah@example.com\",\"applicant_phone\":\"+1 (555) 019-2834\",\"notes\":\"We have a large fenced yard and love Golden Retrievers!\"}', '2026-09-20 15:09:53', '2026-09-20 15:09:53');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('12', '1', 'Customer Inquiry from Sarah Johnson', 'ContactInquiry', NULL, NULL, NULL, '{\"name\":\"Sarah Johnson\",\"email\":\"sarah@example.com\",\"message\":\"Hello, do you offer dental scaling for senior cats?\"}', '2026-09-20 15:09:54', '2026-09-20 15:09:54');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('13', '1', 'Newsletter Subscription: sarah.petcare@example.com', 'Newsletter', NULL, NULL, NULL, '{\"email\":\"sarah.petcare@example.com\"}', '2026-09-20 15:09:55', '2026-09-20 15:09:55');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('14', '10', 'New adoption request for Max', 'App\\Models\\AdoptionListing', '1', NULL, NULL, NULL, '2026-09-20 17:32:05', '2026-09-20 19:32:05');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('15', '5', 'Order #ORD-1024 placed by Sarah Johnson', 'App\\Models\\Order', '1', NULL, NULL, NULL, '2026-09-20 16:32:05', '2026-09-20 19:32:05');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('16', '12', 'Health record updated for Luna', 'App\\Models\\HealthRecord', '3', NULL, NULL, NULL, '2026-09-20 15:32:06', '2026-09-20 19:32:06');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('17', '5', 'New review received for Pet Food', 'App\\Models\\Product', '2', NULL, NULL, NULL, '2026-09-20 14:32:06', '2026-09-20 19:32:06');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('18', '11', 'User registration: David Lee (Owner)', 'App\\Models\\User', '11', NULL, NULL, NULL, '2026-09-20 13:32:06', '2026-09-20 19:32:06');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('19', '1', 'Newsletter Subscription: test_sub@furshield.test', 'Newsletter', NULL, NULL, NULL, '{\"email\":\"test_sub@furshield.test\"}', '2026-09-20 20:01:57', '2026-09-20 20:01:57');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('20', '5', 'Newsletter Subscription: searchgpt73@gmail.com', 'Newsletter', NULL, NULL, NULL, '{\"email\":\"searchgpt73@gmail.com\"}', '2026-09-21 02:49:00', '2026-09-21 02:49:00');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('21', '10', 'New adoption request for Max', 'App\\Models\\AdoptionListing', '1', NULL, NULL, NULL, '2026-09-21 08:23:56', '2026-09-21 10:23:56');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('22', '5', 'Order #ORD-1024 placed by Sarah Johnson', 'App\\Models\\Order', '1', NULL, NULL, NULL, '2026-09-21 07:23:56', '2026-09-21 10:23:56');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('23', '12', 'Health record updated for Luna', 'App\\Models\\HealthRecord', '3', NULL, NULL, NULL, '2026-09-21 06:23:56', '2026-09-21 10:23:56');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('24', '5', 'New review received for Pet Food', 'App\\Models\\Product', '2', NULL, NULL, NULL, '2026-09-21 05:23:56', '2026-09-21 10:23:56');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `subject_type`, `subject_id`, `ip_address`, `user_agent`, `metadata`, `created_at`, `updated_at`) VALUES ('25', '11', 'User registration: David Lee (Owner)', 'App\\Models\\User', '11', NULL, NULL, NULL, '2026-09-21 04:23:56', '2026-09-21 10:23:56');

-- --------------------------------------------------------
-- Table structure for table `cache`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `cache_locks`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `care_contents`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `care_contents`;
CREATE TABLE `care_contents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `care_contents_slug_unique` (`slug`),
  KEY `care_contents_category_index` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `care_contents`
INSERT INTO `care_contents` (`id`, `title`, `slug`, `category`, `content`, `video_url`, `is_published`, `created_at`, `updated_at`) VALUES ('1', 'Keep Your Pets Hydrated', 'keep-your-pets-hydrated', 'Tips', 'Fresh water is essential for your pet\'s health. Make sure they always have access to clean, fresh water.', NULL, '1', '2026-09-20 13:54:46', '2026-09-20 13:54:46');
INSERT INTO `care_contents` (`id`, `title`, `slug`, `category`, `content`, `video_url`, `is_published`, `created_at`, `updated_at`) VALUES ('2', 'Vaccination Basics', 'vaccination-basics', 'Health', 'Keep vaccinations current according to veterinary guidance to protect against preventable illnesses.', NULL, '1', '2026-09-20 13:54:46', '2026-09-20 13:54:46');
INSERT INTO `care_contents` (`id`, `title`, `slug`, `category`, `content`, `video_url`, `is_published`, `created_at`, `updated_at`) VALUES ('3', 'Essential Dog Vaccination Schedules & Disease Prevention', 'dog-vaccination-schedule-guide', 'health', 'Vaccinating your puppy and adult dog is the single most effective way to shield them from fatal viral infections like Rabies, Parvovirus, Canine Distemper, and Leptospirosis.

Core vaccines should begin at 6 to 8 weeks of age and continue with booster shots every 3 to 4 weeks until 16 weeks old. Adult dogs require rabies and DHPP boosters every 1 to 3 years depending on local veterinary regulations.

Always consult your FurShield veterinarian to customize a vaccination regimen tailored to your pet\'s lifestyle and geographic risk factors.', NULL, '1', '2026-09-20 15:08:06', '2026-09-20 15:08:06');
INSERT INTO `care_contents` (`id`, `title`, `slug`, `category`, `content`, `video_url`, `is_published`, `created_at`, `updated_at`) VALUES ('4', 'Complete Feline Nutrition: Balanced Diets for Indoor Cats', 'complete-feline-nutrition-guide', 'nutrition', 'Cats are obligate carnivores requiring high animal protein, essential amino acids like taurine, and proper hydration to prevent urinary tract disorders and kidney disease.

Feeding a combination of moisture-rich wet food alongside veterinarian-approved dry kibble helps maintain healthy kidney function and optimal weight. Avoid table scraps, onion, garlic, chocolate, and milk containing lactose.

Keep fresh water bowls or water fountains in multiple rooms to encourage regular drinking.', NULL, '1', '2026-09-20 15:08:06', '2026-09-20 15:08:06');
INSERT INTO `care_contents` (`id`, `title`, `slug`, `category`, `content`, `video_url`, `is_published`, `created_at`, `updated_at`) VALUES ('5', 'Positive Reinforcement Dog Training for Beginners', 'positive-reinforcement-training', 'training', 'Positive reinforcement uses rewards—such as healthy treats, enthusiastic praise, or favorite toys—to encourage desirable behaviors. Consistency and immediate timing are key: reward your dog within 1-2 seconds of the correct action.

Keep training sessions short (5 to 10 minutes) and always end on a successful note. Patience and repetition will build an unbreakable bond of trust between you and your canine companion.', NULL, '1', '2026-09-20 15:08:06', '2026-09-20 15:08:06');
INSERT INTO `care_contents` (`id`, `title`, `slug`, `category`, `content`, `video_url`, `is_published`, `created_at`, `updated_at`) VALUES ('6', 'At-Home Pet Grooming: Coat Brushing, Ear Care & Dental Hygiene', 'at-home-pet-grooming-guide', 'grooming', 'Regular home grooming prevents painful hair matting, skin dermatitis, and periodontal disease. Brush long coats daily with an undercoat rake or pin brush.

Check ears weekly for redness or dark debris, which may indicate yeast or bacterial ear infections. Clean gently using veterinary ear cleanser and cotton pads—never insert cotton swabs into the ear canal.

Introduce enzymatic pet toothpaste early with finger brushes for sparkling teeth and fresh breath.', NULL, '1', '2026-09-20 15:08:06', '2026-09-20 15:08:06');

-- --------------------------------------------------------
-- Table structure for table `cart_items`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE `cart_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `carts`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carts_user_id_unique` (`user_id`),
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `failed_jobs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `family_members`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `family_members`;
CREATE TABLE `family_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint(20) unsigned NOT NULL,
  `member_id` bigint(20) unsigned NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `permissions` varchar(255) NOT NULL DEFAULT 'view',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `family_members_owner_id_member_id_unique` (`owner_id`,`member_id`),
  KEY `family_members_member_id_foreign` (`member_id`),
  CONSTRAINT `family_members_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `family_members_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `health_records`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `health_records`;
CREATE TABLE `health_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pet_id` bigint(20) unsigned NOT NULL,
  `record_type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `recorded_at` datetime NOT NULL,
  `provider_name` varchar(255) DEFAULT NULL,
  `medication` text DEFAULT NULL,
  `follow_up_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `health_records_pet_id_record_type_recorded_at_index` (`pet_id`,`record_type`,`recorded_at`),
  CONSTRAINT `health_records_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `health_records`
INSERT INTO `health_records` (`id`, `pet_id`, `record_type`, `title`, `description`, `recorded_at`, `provider_name`, `medication`, `follow_up_at`, `created_at`, `updated_at`) VALUES ('1', '1', 'vaccination', 'Annual Rabies & DHPP', 'Vaccines administered, no adverse reactions.', '2026-07-21 10:23:56', 'Dr. Emily Carter', NULL, NULL, '2026-09-20 13:54:45', '2026-09-21 10:23:56');
INSERT INTO `health_records` (`id`, `pet_id`, `record_type`, `title`, `description`, `recorded_at`, `provider_name`, `medication`, `follow_up_at`, `created_at`, `updated_at`) VALUES ('2', '1', 'checkup', 'Routine Physical Exam', 'Vitals excellent, teeth clean.', '2026-03-21 10:23:56', 'Dr. Emily Carter', NULL, NULL, '2026-09-20 13:54:45', '2026-09-21 10:23:56');
INSERT INTO `health_records` (`id`, `pet_id`, `record_type`, `title`, `description`, `recorded_at`, `provider_name`, `medication`, `follow_up_at`, `created_at`, `updated_at`) VALUES ('3', '2', 'vaccination', 'FVRCP Booster Due', 'Scheduled for booster.', '2025-10-21 10:23:56', 'Dr. Wilson', NULL, NULL, '2026-09-20 13:54:45', '2026-09-21 10:23:56');

-- --------------------------------------------------------
-- Table structure for table `insurance_policies`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `insurance_policies`;
CREATE TABLE `insurance_policies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pet_id` bigint(20) unsigned NOT NULL,
  `provider` varchar(255) NOT NULL,
  `policy_number` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `coverage_summary` text DEFAULT NULL,
  `claims` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`claims`)),
  `document_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `insurance_policies_pet_id_policy_number_index` (`pet_id`,`policy_number`),
  CONSTRAINT `insurance_policies_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `jobs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `medical_documents`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `medical_documents`;
CREATE TABLE `medical_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pet_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medical_documents_pet_id_foreign` (`pet_id`),
  CONSTRAINT `medical_documents_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `migrations`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '2026_01_01_01_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '2026_01_01_02_create_pets_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '2026_01_01_03_create_health_records_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_01_01_04_create_medical_documents_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_01_01_05_create_vets_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_01_01_06_create_appointments_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_01_01_07_create_shelters_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_01_01_08_create_adoption_listings_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_01_01_09_create_adoption_interests_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_01_01_10_create_products_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_01_01_11_create_carts_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2026_01_01_12_create_orders_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('13', '2026_01_01_13_create_care_content_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('14', '2026_01_01_14_create_ratings_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('15', '2026_01_01_15_create_personal_access_tokens_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('16', '2026_01_01_16_create_notifications_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('17', '2026_01_01_17_create_family_members_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('18', '2026_01_01_18_create_vet_availabilities_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('19', '2026_01_01_19_create_insurance_policies_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('20', '2026_01_01_20_create_reminders_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('21', '2026_01_01_21_create_shelter_care_logs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('22', '2026_01_01_22_create_audit_logs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('23', '2026_01_01_23_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('24', '2026_01_01_24_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('25', '2026_01_01_25_create_password_reset_tokens_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('26', '2026_01_01_26_add_is_active_to_users_table', '1');

-- --------------------------------------------------------
-- Table structure for table `notifications`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `order_items`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `line_total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `order_items`
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES ('1', '1', '2', 'Premium Dog Food', '24.99', '128', '3198.72', '2026-09-20 13:54:45', '2026-09-20 13:54:45');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES ('2', '2', '3', 'Cat Litter', '12.99', '96', '1247.04', '2026-09-20 13:54:45', '2026-09-20 13:54:45');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES ('3', '3', '4', 'Pet Shampoo', '8.99', '68', '611.32', '2026-09-20 13:54:45', '2026-09-20 13:54:45');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES ('4', '4', '5', 'Dog Toys', '6.99', '57', '398.43', '2026-09-20 13:54:45', '2026-09-20 13:54:45');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES ('5', '5', '1', 'Premium Pet Food', '19.99', '2', '39.98', '2026-09-20 14:32:13', '2026-09-20 14:32:13');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES ('6', '6', '1', 'Premium Pet Food', '19.99', '2', '39.98', '2026-09-20 15:06:41', '2026-09-20 15:06:41');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES ('7', '7', '2', 'Premium Dog Food', '24.99', '2', '49.98', '2026-09-20 15:13:59', '2026-09-20 15:13:59');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES ('8', '8', '1', 'Premium Pet Food', '19.99', '1', '19.99', '2026-09-20 15:32:09', '2026-09-20 15:32:09');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `line_total`, `created_at`, `updated_at`) VALUES ('9', '9', '4', 'Pet Shampoo', '8.99', '1', '8.99', '2026-09-21 00:48:38', '2026-09-21 00:48:38');

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'requested',
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `orders`
INSERT INTO `orders` (`id`, `user_id`, `status`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES ('1', '5', 'completed', '3198.72', 'Order #ORD-1024', '2026-09-21 07:23:56', '2026-09-21 10:23:56');
INSERT INTO `orders` (`id`, `user_id`, `status`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES ('2', '9', 'completed', '1247.04', 'Order #ORD-1025', '2026-09-21 02:23:56', '2026-09-21 10:23:56');
INSERT INTO `orders` (`id`, `user_id`, `status`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES ('3', '8', 'completed', '611.32', 'Order #ORD-1026', '2026-09-20 10:23:56', '2026-09-21 10:23:56');
INSERT INTO `orders` (`id`, `user_id`, `status`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES ('4', '11', 'completed', '398.43', 'Order #ORD-1027', '2026-09-19 10:23:56', '2026-09-21 10:23:56');
INSERT INTO `orders` (`id`, `user_id`, `status`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES ('5', '5', 'completed', '39.98', 'Direct Order for Premium Pet Food', '2026-09-20 14:32:13', '2026-09-20 14:32:13');
INSERT INTO `orders` (`id`, `user_id`, `status`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES ('6', '5', 'requested', '39.98', 'Delivery to: 742 Evergreen Terrace, Springfield. Payment: Cash on Delivery / In-Clinic', '2026-09-20 15:06:41', '2026-09-20 15:06:41');
INSERT INTO `orders` (`id`, `user_id`, `status`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES ('7', '1', 'requested', '49.98', 'Delivery to: FurShield HQ. Payment: Cash on Delivery / In-Clinic', '2026-09-20 15:13:59', '2026-09-20 15:13:59');
INSERT INTO `orders` (`id`, `user_id`, `status`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES ('8', '1', 'requested', '19.99', 'Delivery to: 123 Pet Lane, Lahore, Punjab 54000, Pakistan. Payment: Cash on Delivery / In-Clinic', '2026-09-20 15:32:09', '2026-09-20 15:32:09');
INSERT INTO `orders` (`id`, `user_id`, `status`, `subtotal`, `notes`, `created_at`, `updated_at`) VALUES ('9', '5', 'completed', '8.99', 'Delivery to: 123 Pet Lane, Lahore, Punjab 54000, Pakistan. Payment: Cash on Delivery / In-Clinic', '2026-09-21 00:48:38', '2026-09-21 00:49:05');

-- --------------------------------------------------------
-- Table structure for table `password_reset_tokens`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `personal_access_tokens`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `pets`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `pets`;
CREATE TABLE `pets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `species` varchar(255) NOT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `sex` varchar(255) NOT NULL DEFAULT 'unknown',
  `weight_kg` decimal(8,2) DEFAULT NULL,
  `microchip_number` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pets_user_id_species_index` (`user_id`,`species`),
  KEY `pets_microchip_number_index` (`microchip_number`),
  CONSTRAINT `pets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `pets`
INSERT INTO `pets` (`id`, `user_id`, `name`, `species`, `breed`, `date_of_birth`, `sex`, `weight_kg`, `microchip_number`, `notes`, `image_path`, `created_at`, `updated_at`) VALUES ('1', '5', 'Buddy', 'Dog', 'Golden Retriever', '2023-09-21', 'male', '29.50', 'FS-DOG-99201', 'Friendly, energetic, healthy.', NULL, '2026-09-20 13:54:11', '2026-09-21 10:23:56');
INSERT INTO `pets` (`id`, `user_id`, `name`, `species`, `breed`, `date_of_birth`, `sex`, `weight_kg`, `microchip_number`, `notes`, `image_path`, `created_at`, `updated_at`) VALUES ('2', '5', 'Luna', 'Cat', 'Domestic Cat', '2024-09-21', 'female', '4.10', 'FS-CAT-33104', 'Indoor cat, vaccination due this month.', NULL, '2026-09-20 13:54:11', '2026-09-21 10:23:56');
INSERT INTO `pets` (`id`, `user_id`, `name`, `species`, `breed`, `date_of_birth`, `sex`, `weight_kg`, `microchip_number`, `notes`, `image_path`, `created_at`, `updated_at`) VALUES ('3', '10', 'Max', 'Dog', 'German Shepherd', '2022-09-21', 'male', '34.00', NULL, NULL, NULL, '2026-09-20 13:54:11', '2026-09-21 10:23:56');
INSERT INTO `pets` (`id`, `user_id`, `name`, `species`, `breed`, `date_of_birth`, `sex`, `weight_kg`, `microchip_number`, `notes`, `image_path`, `created_at`, `updated_at`) VALUES ('4', '11', 'Bella', 'Dog', 'Beagle', '2025-09-21', 'female', '10.20', NULL, NULL, NULL, '2026-09-20 13:54:11', '2026-09-21 10:23:56');
INSERT INTO `pets` (`id`, `user_id`, `name`, `species`, `breed`, `date_of_birth`, `sex`, `weight_kg`, `microchip_number`, `notes`, `image_path`, `created_at`, `updated_at`) VALUES ('5', '5', 'Milo', 'Cat', 'Persian Cat', '2023-05-15', 'male', '3.80', NULL, 'Healthy fluffy white kitten', NULL, '2026-09-20 15:08:39', '2026-09-20 15:08:39');
INSERT INTO `pets` (`id`, `user_id`, `name`, `species`, `breed`, `date_of_birth`, `sex`, `weight_kg`, `microchip_number`, `notes`, `image_path`, `created_at`, `updated_at`) VALUES ('6', '5', 'Milo', 'Cat', 'Persian Cat', '2023-05-15', 'male', '3.80', NULL, 'Healthy fluffy white kitten', NULL, '2026-09-20 15:09:15', '2026-09-20 15:09:15');
INSERT INTO `pets` (`id`, `user_id`, `name`, `species`, `breed`, `date_of_birth`, `sex`, `weight_kg`, `microchip_number`, `notes`, `image_path`, `created_at`, `updated_at`) VALUES ('7', '5', 'Milo', 'Cat', 'Persian Cat', '2023-05-15', 'male', '3.80', NULL, 'Healthy fluffy white kitten', NULL, '2026-09-20 15:09:52', '2026-09-20 15:09:52');

-- --------------------------------------------------------
-- Table structure for table `products`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock_quantity` int(10) unsigned NOT NULL DEFAULT 0,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_index` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `products`
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Premium Pet Food', 'premium-pet-food', 'Food', 'Demo product', '19.99', '47', NULL, '1', '2026-09-20 13:52:08', '2026-09-20 15:32:09');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Premium Dog Food', 'premium-dog-food', 'Food', 'Nutrient-rich balanced nutrition for active adult dogs.', '24.99', '240', NULL, '1', '2026-09-20 13:54:45', '2026-09-20 19:32:05');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Cat Litter', 'cat-litter', 'Care', 'Low dust, odor-locking premium clumping litter.', '12.99', '180', NULL, '1', '2026-09-20 13:54:45', '2026-09-20 13:54:45');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('4', 'Pet Shampoo', 'pet-shampoo', 'Grooming', 'Gentle hypoallergenic oatmeal soothing shampoo.', '8.99', '110', NULL, '1', '2026-09-20 13:54:45', '2026-09-21 10:23:56');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('5', 'Dog Toys', 'dog-toys', 'Toys', 'Durable chew ropes and squeaky fetch balls.', '6.99', '200', NULL, '1', '2026-09-20 13:54:45', '2026-09-20 13:54:45');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('6', 'Premium Adult Dog Kibble', 'premium-adult-dog-kibble', 'Food', 'Nutrient-rich balanced kibble with omega fatty acids for active adult dogs.', '24.99', '140', '/images/dog-food.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('7', 'Grain-Free Feline Feast', 'grain-free-feline-feast', 'Food', 'High-protein poultry and salmon blend formulated for optimal feline digestion.', '21.50', '110', '/images/dog-food.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('8', 'Puppy Vitality Growth Formula', 'puppy-vitality-growth-formula', 'Food', 'DHA and calcium-fortified meal designed for growing puppies up to 12 months.', '27.99', '90', '/images/dog-food.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('9', 'Senior Companion Joint Kibble', 'senior-companion-joint-kibble', 'Food', 'Fortified with glucosamine and chondroitin for senior companion mobility.', '29.99', '75', '/images/dog-food.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('10', 'Odor-Lock Ultra Cat Litter', 'odor-lock-ultra-cat-litter', 'Care', 'Fast-clumping, low-dust premium litter with natural carbon odor absorption.', '14.99', '180', '/images/cat-litter.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('11', 'Enzymatic Stain & Odor Eliminator', 'enzymatic-stain-odor-eliminator', 'Care', 'Bio-enzymatic spray that removes tough pet stains, urine, and odors instantly.', '12.50', '95', '/images/cat-litter.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('12', 'Antimicrobial Dental Chews', 'antimicrobial-dental-chews', 'Care', 'Veterinarian-formulated dental chews to prevent plaque and tartar buildup.', '9.99', '130', '/images/cat-litter.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('13', 'Paw & Nose Soothing Balm', 'paw-nose-soothing-balm', 'Care', 'Organic beeswax and shea butter protection for dry, cracked paws and snouts.', '8.50', '80', '/images/cat-litter.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('14', 'Hypoallergenic Pet Shampoo', 'hypoallergenic-pet-shampoo', 'Grooming', 'Soothing colloidal oatmeal and aloe vera wash for sensitive and allergic skin.', '11.99', '110', '/images/pet-shampoo.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('15', 'De-Shedding Undercoat Rake', 'de-shedding-undercoat-rake', 'Grooming', 'Precision dual-sided stainless steel teeth remove loose undercoat without scratching.', '16.99', '65', '/images/pet-shampoo.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('16', 'Gentle Tearless Puppy Shampoo', 'gentle-tearless-puppy-shampoo', 'Grooming', 'Tear-free chamomile cleansing formula safe for young puppies and kittens.', '9.49', '85', '/images/pet-shampoo.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('17', 'Silky Coat Detangling Spray', 'silky-coat-detangling-spray', 'Grooming', 'Leave-in conditioning mist that eliminates mats, tangles, and static.', '10.99', '70', '/images/pet-shampoo.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('18', 'Durable Braided Chew Rope', 'durable-braided-chew-rope', 'Toys', 'Heavy-duty cotton rope toy for tug-of-war, chewing, and natural dental flossing.', '7.99', '200', '/images/dog-toys.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('19', 'Interactive Puzzle Treat Feeder', 'interactive-puzzle-treat-feeder', 'Toys', 'Mental stimulation sliding puzzle that rewards pets with healthy treats.', '18.99', '50', '/images/dog-toys.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('20', 'Squeaky Plush Duck Companion', 'squeaky-plush-duck-companion', 'Toys', 'Soft reinforced plush companion with dual squeakers for fetch and comfort.', '6.49', '120', '/images/dog-toys.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('21', 'Laser Chase Feline Wand', 'laser-chase-feline-wand', 'Toys', 'Rechargeable LED laser toy with feather attachment for indoor cat play.', '5.99', '90', '/images/dog-toys.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('22', 'Omega-3 Wild Salmon Oil', 'omega-3-wild-salmon-oil', 'Wellness', 'Pure cold-pressed EPA & DHA supplement for shiny coat and immune defense.', '22.99', '105', '/images/dog-food.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('23', 'Joint Support Glucosamine Tablets', 'joint-support-glucosamine-tablets', 'Wellness', 'Advanced joint support chewables with MSM and turmeric for hip mobility.', '26.50', '60', '/images/care-tips.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('24', 'Calming Herbal Pet Chews', 'calming-herbal-pet-chews', 'Wellness', 'Valerian root and chamomile soothing bites for anxiety, storms, and travel.', '19.99', '75', '/images/care-tips.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');
INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `price`, `stock_quantity`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES ('25', 'Multi-Strain Probiotic Powder', 'multi-strain-probiotic-powder', 'Wellness', 'Digestive health balance with 5 billion CFUs of active cultures.', '21.99', '85', '/images/care-tips.jpg', '1', '2026-09-21 02:03:04', '2026-09-21 02:03:04');

-- --------------------------------------------------------
-- Table structure for table `ratings`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `ratings`;
CREATE TABLE `ratings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `rateable_type` varchar(255) NOT NULL,
  `rateable_id` bigint(20) unsigned NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratings_user_id_rateable_type_rateable_id_unique` (`user_id`,`rateable_type`,`rateable_id`),
  KEY `ratings_rateable_type_rateable_id_index` (`rateable_type`,`rateable_id`),
  CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `reminders`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `reminders`;
CREATE TABLE `reminders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `pet_id` bigint(20) unsigned DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `due_at` datetime NOT NULL,
  `completed_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reminders_pet_id_foreign` (`pet_id`),
  KEY `reminders_user_id_due_at_index` (`user_id`,`due_at`),
  CONSTRAINT `reminders_pet_id_foreign` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reminders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `shelter_care_logs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `shelter_care_logs`;
CREATE TABLE `shelter_care_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `adoption_listing_id` bigint(20) unsigned NOT NULL,
  `shelter_id` bigint(20) unsigned NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `logged_at` datetime NOT NULL,
  `category` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shelter_care_logs_adoption_listing_id_foreign` (`adoption_listing_id`),
  KEY `shelter_care_logs_shelter_id_foreign` (`shelter_id`),
  KEY `shelter_care_logs_created_by_foreign` (`created_by`),
  CONSTRAINT `shelter_care_logs_adoption_listing_id_foreign` FOREIGN KEY (`adoption_listing_id`) REFERENCES `adoption_listings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `shelter_care_logs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `shelter_care_logs_shelter_id_foreign` FOREIGN KEY (`shelter_id`) REFERENCES `shelters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `shelters`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `shelters`;
CREATE TABLE `shelters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `organization_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shelters_user_id_unique` (`user_id`),
  CONSTRAINT `shelters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `shelters`
INSERT INTO `shelters` (`id`, `user_id`, `organization_name`, `description`, `phone`, `address`, `city`, `verified_at`, `created_at`, `updated_at`) VALUES ('1', '4', 'FurShield Rescue', 'Demo shelter', '0000000000', 'Demo City', 'Demo City', '2026-09-20 13:52:08', '2026-09-20 13:52:08', '2026-09-20 13:52:08');
INSERT INTO `shelters` (`id`, `user_id`, `organization_name`, `description`, `phone`, `address`, `city`, `verified_at`, `created_at`, `updated_at`) VALUES ('2', '7', 'Happy Paws Shelter', 'Dedicated to finding loving forever homes for rescued pets.', '+1 555-0199', '88 Rescue Blvd', 'Metro City', '2026-09-21 10:23:56', '2026-09-20 13:54:11', '2026-09-21 10:23:56');

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('owner','vet','shelter','admin') NOT NULL DEFAULT 'owner',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'Admin', 'admin@furshield.test', NULL, '$2y$12$ZD5xG/.KndwVXOYNrzG6hOWQdmprS3mtasKuaV5yx3TwG.JytBI1m', '+1 555-0100', 'FurShield HQ', 'admin', '1', '4fV7ItgT4CRaTdC2qgpgnPjQnJzRcz2rtlTW4yx128n4CKNJqABfxZ82QuXX', '2025-01-01 10:00:00', '2026-09-21 10:23:51');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('2', 'Demo Owner', 'owner@furshield.test', NULL, '$2y$12$eBK9kGM3nFBUdakUQ0tfvuBGuE2jd16q3CFCFLPVtVRRWuNP2iILi', '0000000000', 'Demo', 'owner', '1', NULL, '2026-09-20 13:52:07', '2026-09-21 10:23:55');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('3', 'Demo Veterinarian', 'vet@furshield.test', NULL, '$2y$12$UPTYXIqY5VOB3xsFETUMiuj6n19NHnBBN8zj69p1p5TFIm10E2lBa', NULL, NULL, 'vet', '1', NULL, '2026-09-20 13:52:07', '2026-09-21 10:23:55');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('4', 'Demo Shelter', 'shelter@furshield.test', NULL, '$2y$12$0GW.xwXH2GDO7ZLD5nH2Ielz/nXc8P.nqgeF7XU06Mmbq27K4wxXC', NULL, NULL, 'shelter', '1', NULL, '2026-09-20 13:52:08', '2026-09-21 10:23:56');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('5', 'Sarah Johnson', 'sarah@example.com', NULL, '$2y$12$MLjWZDmF0EhYoZo2YKdRQOomO0QuKU6wc7gnbWyvZUdqDQ6HKjl26', '+1 555-0144', '124 Maple Street', 'owner', '1', 'yxGH7UVeNmQWbOw8dW2V0j97FGAlfCjba1GOhANU5quoF4amTzypxbz0PpbJ', '2025-04-24 09:30:00', '2026-09-21 10:23:52');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('6', 'Dr. Emily Carter', 'emily@vet.com', NULL, '$2y$12$9TU0KVpxh2wmyrY9ainqFObDA3WRyUeiIvRBa1RwOLTGcOXAjaTIq', '+1 555-0182', 'Carter Animal Health Clinic', 'vet', '1', NULL, '2025-04-23 11:15:00', '2026-09-21 10:23:52');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('7', 'Happy Paws Shelter', 'shelter@furshield.com', NULL, '$2y$12$7O4xaBCAa0AzAYC9zWBvqOWXpFFELn1g.dpjEFU6RRCAcJ4ijdsCW', '+1 555-0199', '88 Rescue Blvd', 'shelter', '1', NULL, '2025-04-22 14:20:00', '2026-09-21 10:23:52');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('8', 'James Wilson', 'james@example.com', NULL, '$2y$12$Rtm.tzpOUpgYUBDtwRbSVuEBVryaFRJGyUCFu3iHyLQr96ZUnuxgC', '+1 555-0163', '42 Oak Avenue', 'owner', '1', NULL, '2025-04-20 16:45:00', '2026-09-21 10:23:53');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('9', 'Mike R.', 'mike@example.com', NULL, '$2y$12$OR8a9blt4IKfC2u2k7IxgupCxH42iqy5Sar1z0mv7/zWqZfFgeuRa', NULL, NULL, 'owner', '1', NULL, '2025-04-18 10:00:00', '2026-09-21 10:23:53');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('10', 'Emily S.', 'emilys@example.com', NULL, '$2y$12$CdjUUK.hUn5gGGbRUK3P2uV5FGmyWH3/xWoeoPwMyaYkFarQrBqfy', NULL, NULL, 'owner', '1', NULL, '2025-04-15 12:00:00', '2026-09-21 10:23:53');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('11', 'David Lee', 'david@example.com', NULL, '$2y$12$qmxpiKj6l/wvMHqvXcnQgeZ3yF4QIj6tErt3Xb/.tx5j.CdvqhGLK', NULL, NULL, 'owner', '1', NULL, '2025-04-25 08:00:00', '2026-09-21 10:23:54');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('12', 'Dr. Wilson', 'drwilson@vet.com', NULL, '$2y$12$T8ut1/ULU8efMcG5RlV8ye1.bhLrToiVw0AYkcDojbS5fApG5rEGa', NULL, NULL, 'vet', '1', NULL, '2026-09-20 13:54:10', '2026-09-21 10:23:54');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('13', 'Dr. Brown', 'drbrown@vet.com', NULL, '$2y$12$FohZIlM0ifQAAxbZZFy0o.UTbh03A17OVbPl6jwPx77cGSvL3.eQS', NULL, NULL, 'vet', '1', NULL, '2026-09-20 13:54:10', '2026-09-21 10:23:54');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('14', 'Dr. Davis', 'drdavis@vet.com', NULL, '$2y$12$b344Rl4UzN14AYi35wy4XOVjbFU6p8LjvODEQxsoWtP7U4d6xwAf.', NULL, NULL, 'vet', '1', NULL, '2026-09-20 13:54:10', '2026-09-21 10:23:55');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('15', 'Marcus Vance', 'marcus.vance@example.com', NULL, '$2y$12$BhfybBfMwuOM5Ld1nuPbieHik0WjjfPD5/5ms0NtDrETbMJu/.A0G', '+1 (555) 987-6543', '450 Ocean Avenue, Miami', 'owner', '1', NULL, '2026-09-20 14:34:57', '2026-09-20 14:34:57');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES ('17', 'Haris', 'haris123@gmail.com', NULL, '$2y$12$Vn0/Z/Qa97627nCMVnLvsuHOswiprcm3LrB7zNb.Bov06XOyojC7i', NULL, NULL, 'shelter', '1', NULL, '2026-09-21 11:10:56', '2026-09-21 11:10:56');

-- --------------------------------------------------------
-- Table structure for table `vet_availabilities`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `vet_availabilities`;
CREATE TABLE `vet_availabilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vet_id` bigint(20) unsigned NOT NULL,
  `day_of_week` tinyint(3) unsigned NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vet_availabilities_vet_id_day_of_week_index` (`vet_id`,`day_of_week`),
  CONSTRAINT `vet_availabilities_vet_id_foreign` FOREIGN KEY (`vet_id`) REFERENCES `vets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `vets`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `vets`;
CREATE TABLE `vets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `experience_years` smallint(5) unsigned NOT NULL DEFAULT 0,
  `bio` text DEFAULT NULL,
  `clinic_name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vets_user_id_unique` (`user_id`),
  KEY `vets_city_specialization_index` (`city`,`specialization`),
  CONSTRAINT `vets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `vets`
INSERT INTO `vets` (`id`, `user_id`, `specialization`, `experience_years`, `bio`, `clinic_name`, `address`, `city`, `latitude`, `longitude`, `is_available`, `created_at`, `updated_at`) VALUES ('1', '3', 'General Veterinary Care', '8', 'Demo veterinarian profile', 'FurShield Vet Clinic', 'Demo City', 'Demo City', NULL, NULL, '1', '2026-09-20 13:52:08', '2026-09-20 13:52:08');
INSERT INTO `vets` (`id`, `user_id`, `specialization`, `experience_years`, `bio`, `clinic_name`, `address`, `city`, `latitude`, `longitude`, `is_available`, `created_at`, `updated_at`) VALUES ('2', '6', 'General Veterinary Care', '10', NULL, 'Carter Animal Clinic', '100 Medical Center Way', 'Metro City', NULL, NULL, '1', '2026-09-20 13:54:11', '2026-09-20 13:54:11');
INSERT INTO `vets` (`id`, `user_id`, `specialization`, `experience_years`, `bio`, `clinic_name`, `address`, `city`, `latitude`, `longitude`, `is_available`, `created_at`, `updated_at`) VALUES ('3', '12', 'Feline Medicine & Surgery', '7', NULL, 'Metro Pet Health', '200 Vet Parkway', 'Metro City', NULL, NULL, '1', '2026-09-20 13:54:11', '2026-09-20 13:54:11');
INSERT INTO `vets` (`id`, `user_id`, `specialization`, `experience_years`, `bio`, `clinic_name`, `address`, `city`, `latitude`, `longitude`, `is_available`, `created_at`, `updated_at`) VALUES ('4', '13', 'Diagnostics & Internal Medicine', '12', NULL, 'Brown Animal Hospital', '350 Care Road', 'Metro City', NULL, NULL, '1', '2026-09-20 13:54:11', '2026-09-20 13:54:11');
INSERT INTO `vets` (`id`, `user_id`, `specialization`, `experience_years`, `bio`, `clinic_name`, `address`, `city`, `latitude`, `longitude`, `is_available`, `created_at`, `updated_at`) VALUES ('5', '14', 'Canine Wellness & Rehabilitation', '8', NULL, 'Davis Companion Care', '420 Paw Street', 'Metro City', NULL, NULL, '1', '2026-09-20 13:54:11', '2026-09-20 13:54:11');

SET FOREIGN_KEY_CHECKS=1;
