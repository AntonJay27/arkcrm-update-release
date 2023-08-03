-- 2023-01-28

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `modules_and_fields` JSON DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reports_to` int(11) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `can_assign_records_to` varchar(255) DEFAULT NULL,
  `privileges` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salutation` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `primary_email` varchar(150) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_status` enum('1','0') DEFAULT NULL,
  `forgot_password` varchar(150) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 2022-06-24

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) DEFAULT NULL,
  `access_modules` JSON DEFAULT NULL,
  `access_fields` JSON DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salutation` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(150) NOT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_auth_code` varchar(150) NOT NULL,
  `user_status` enum('1','0') DEFAULT NULL,
  `password_auth_code` varchar(150) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `template_description` text DEFAULT NULL,
  `template_subject` varchar(255) DEFAULT NULL,
  `template_content` text DEFAULT NULL,
  `template_visibility` varchar(255) DEFAULT NULL,
  `template_status` enum('1','0') NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `email_template_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) DEFAULT NULL,
  `category_description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `email_templates` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `email_templates` ADD FOREIGN KEY (`category_id`) REFERENCES `email_template_categories` (`id`) ON DELETE CASCADE;


CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salutation` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `primary_email` varchar(150) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `contact_email_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_content` text DEFAULT NULL,
  `email_status` varchar(50) DEFAULT NULl,
  `sent_to` int(11) DEFAULT NULL,
  `sent_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `contacts` ADD FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `contacts` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `contact_email_histories` ADD FOREIGN KEY (`sent_to`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;

ALTER TABLE `contact_email_histories` ADD FOREIGN KEY (`sent_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;


-- 2022-07-15

ALTER TABLE `contacts`
ADD COLUMN `position` varchar(100) DEFAULT NULL AFTER `last_name`,
ADD COLUMN `organization_id` int(11) DEFAULT NULL AFTER `position`,

ADD COLUMN `secondary_email` varchar(150) DEFAULT NULL AFTER `primary_email`,
ADD COLUMN `office_phone` varchar(50) DEFAULT NULL AFTER `secondary_email`,
ADD COLUMN `mobile_phone` varchar(50) DEFAULT NULL AFTER `office_phone`,
ADD COLUMN `home_phone` varchar(50) DEFAULT NULL AFTER `mobile_phone`,
ADD COLUMN `secondary_phone` varchar(50) DEFAULT NULL AFTER `home_phone`,
ADD COLUMN `fax` varchar(50) DEFAULT NULL AFTER `secondary_phone`,
ADD COLUMN `do_not_call` int(11) DEFAULT NULL AFTER `fax`,
ADD COLUMN `date_of_birth` date DEFAULT NULL AFTER `do_not_call`,
ADD COLUMN `intro_letter` varchar(50) DEFAULT NULL AFTER `date_of_birth`,
ADD COLUMN `linkedin_url` varchar(255) DEFAULT NULL AFTER `intro_letter`,
ADD COLUMN `twitter_url` varchar(255) DEFAULT NULL AFTER `linkedin_url`,
ADD COLUMN `facebook_url` varchar(255) DEFAULT NULL AFTER `twitter_url`,
ADD COLUMN `instagram_url` varchar(255) DEFAULT NULL AFTER `facebook_url`,
ADD COLUMN `lead_source` varchar(100) DEFAULT NULL AFTER `instagram_url`,
ADD COLUMN `department` varchar(100) DEFAULT NULL AFTER `lead_source`,
ADD COLUMN `reports_to` int(11) DEFAULT NULL AFTER `department`,

ADD COLUMN `email_opt_out` int(11) DEFAULT NULL AFTER `reports_to`;

ALTER TABLE `contacts` ADD FOREIGN KEY (`reports_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;

CREATE TABLE `contact_address_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `mailing_street` text DEFAULT NULL,
  `mailing_po_box` varchar(100) DEFAULT NULL,
  `mailing_city` varchar(100) DEFAULT NULL,
  `mailing_state` varchar(100) DEFAULT NULL,
  `mailing_zip` varchar(100) DEFAULT NULL,
  `mailing_country` varchar(100) DEFAULT NULL,
  `other_street` text DEFAULT NULL,
  `other_po_box` varchar(100) DEFAULT NULL,
  `other_city` varchar(100) DEFAULT NULL,
  `other_state` varchar(100) DEFAULT NULL,
  `other_zip` varchar(100) DEFAULT NULL,
  `other_country` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contact_address_details` ADD FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_address_details` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_address_details` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

CREATE TABLE `contact_description_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contact_description_details` ADD FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_description_details` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_description_details` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

CREATE TABLE `contact_profile_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contact_profile_pictures` ADD FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_profile_pictures` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_profile_pictures` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;


-- 2022-07-17

ALTER TABLE `contacts`
ADD COLUMN `unsubscribe_auth_code` varchar(255) DEFAULT NULL AFTER `email_opt_out`;

-- 2022-07-20

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_name` varchar(255) NOT NULL,
  `primary_email` varchar(150) NOT NULL,
  `secondary_email` varchar(150) DEFAULT NULL,
  `main_website` varchar(255) DEFAULT NULL,
  `other_website` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `naics_code` varchar(100) DEFAULT NULL,
  `employee_count` int(11) DEFAULT NULL,
  `annual_revenue` decimal(20,2),
  `type` varchar(50) DEFAULT NULL,
  `ticket_symbol` varchar(100) DEFAULT NULL,
  `member_of` int(11) DEFAULT NULL,
  `email_opt_out` int(11) DEFAULT NULL,
  `unsubscribe_auth_code` varchar(255) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `organization_email_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_content` text DEFAULT NULL,
  `email_status` varchar(50) DEFAULT NULl,
  `sent_to` int(11) DEFAULT NULL,
  `sent_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `organizations` ADD FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `organization_email_histories` ADD FOREIGN KEY (`sent_to`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

ALTER TABLE `organization_email_histories` ADD FOREIGN KEY (`sent_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

CREATE TABLE `organization_address_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL,
  `billing_street` text DEFAULT NULL,
  `billing_city` varchar(100) DEFAULT NULL,
  `billing_state` varchar(100) DEFAULT NULL,
  `billing_zip` varchar(100) DEFAULT NULL,
  `billing_country` varchar(100) DEFAULT NULL,
  `shipping_street` text DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_state` varchar(100) DEFAULT NULL,
  `shipping_zip` varchar(100) DEFAULT NULL,
  `shipping_country` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `organization_address_details` ADD FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_address_details` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_address_details` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

CREATE TABLE `organization_description_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `organization_description_details` ADD FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_description_details` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_description_details` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

CREATE TABLE `organization_profile_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `organization_profile_pictures` ADD FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_profile_pictures` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_profile_pictures` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- [2022-07-23]

ALTER TABLE `contacts` ADD FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

ALTER TABLE `contacts`
ADD COLUMN `updated_by` int(11) DEFAULT NULL AFTER `created_date`;
ALTER TABLE `contacts` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- 2022-07-28

CREATE TABLE `contact_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contact_comments` ADD FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_comments` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_comments` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- 2022-07-31

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_name` varchar(255) NOT NULL,
  `campaign_status` varchar(50) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `expected_close_date` date DEFAULT NULL,
  `target_size` int(11) DEFAULT NULL,
  `campaign_type` varchar(50) DEFAULT NULL,
  `target_audience` int(11) DEFAULT NULL,
  `sponsor` varchar(255) DEFAULT NULL,
  `num_sent` decimal(20,2) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `budget_cost` decimal(20,2) DEFAULT NULL,
  `expected_response` varchar(50) DEFAULT NULL,
  `expected_sales_count` decimal(20,2) DEFAULT NULL,
  `expected_response_count` int(11) DEFAULT NULL,
  `expected_roi` decimal(20,2) DEFAULT NULL,
  `actual_cost` decimal(20,2) DEFAULT NULL,
  `expected_revenue` decimal(20,2) DEFAULT NULL,
  `actual_sales_count` decimal(20,2) DEFAULT NULL,
  `actual_response_count` int(11) DEFAULT NULL,
  `actual_roi` decimal(20,2) DEFAULT NULL,
  `campaign_description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `campaigns` ADD FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `campaigns` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;


--2022-08-06

INSERT INTO `users`(`salutation`, `first_name`, `last_name`, `user_email`, `user_password`, `user_auth_code`, `user_status`, `password_auth_code`, `created_date`, `updated_date`) VALUES ('%SALUTATION%','%FIRST_NAME%','%LAST_NAME%','%USER_EMAIL%','%USER_PASSWORD%','%AUTH_CODE%',1,NULL,'%CREATED_DATE%',NULL);


--2022-08-06
CREATE TABLE `contact_campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contact_campaigns` ADD FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_campaigns` ADD FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE;

--2022-08-13
CREATE TABLE `organization_campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `organization_campaigns` ADD FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_campaigns` ADD FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE;


-- 2022-08-18
CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `file_name` text DEFAULT NULL,
  `file_url` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `assigned_to` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `documents` ADD FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `documents` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `documents` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

CREATE TABLE `contact_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `document_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contact_documents` ADD FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_documents` ADD FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_documents` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_documents` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

CREATE TABLE `organization_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL,
  `document_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `organization_documents` ADD FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_documents` ADD FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_documents` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_documents` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `documents`
ADD COLUMN `document_number` varchar(20) DEFAULT NULL AFTER `id`,
ADD COLUMN `file_type` varchar(20) DEFAULT NULL AFTER `file_url`,
ADD COLUMN `file_size` decimal(20,2) DEFAULT NULL AFTER `file_type`,
ADD COLUMN `download_count` decimal(20,2) DEFAULT NULL AFTER `file_size`;


-- 2022-09-01

CREATE TABLE `calendars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_name` varchar(255) NOT NULL,
  `timezone` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(100) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `priority` varchar(50) DEFAULT NULL,
  `visibility` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `events` ADD FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(100) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `priority` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `tasks` ADD FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;

CREATE TABLE `contact_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contact_events` ADD FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_events` ADD FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

CREATE TABLE `contact_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contact_tasks` ADD FOREIGN KEY (`contact_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_tasks` ADD FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

CREATE TABLE `organization_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `organization_events` ADD FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_events` ADD FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

CREATE TABLE `organization_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `organization_tasks` ADD FOREIGN KEY (`organization_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_tasks` ADD FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

CREATE TABLE `campaign_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `campaign_events` ADD FOREIGN KEY (`campaign_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;
ALTER TABLE `campaign_events` ADD FOREIGN KEY (`event_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

CREATE TABLE `campaign_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `campaign_tasks` ADD FOREIGN KEY (`campaign_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;
ALTER TABLE `campaign_tasks` ADD FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

-- 2022-09-16

ALTER TABLE `users`
ADD COLUMN `position` varchar(100) DEFAULT NULL AFTER `last_name`,
ADD COLUMN `picture` varchar(100) DEFAULT NULL AFTER `position`;

-- 2022-09-17

ALTER TABLE `events`
ADD COLUMN `event_timezone` varchar(50) DEFAULT NULL AFTER `assigned_to`;

ALTER TABLE `tasks`
ADD COLUMN `task_timezone` varchar(50) DEFAULT NULL AFTER `assigned_to`;

-- 2022-10-29

ALTER TABLE `email_templates`
ADD COLUMN `updated_by` int(11) DEFAULT NULL AFTER `created_date`;

ALTER TABLE `email_templates` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- 2022-10-29

CREATE TABLE `contact_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `actions` varchar(255) DEFAULT NULL,
  `action_details` text DEFAULT NULL,
  `action_author` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `contact_updates` ADD FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;
ALTER TABLE `contact_updates` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `contact_updates`
ADD COLUMN `action_icon` varchar(50) DEFAULT NULL AFTER `action_author`,
ADD COLUMN `action_background` varchar(50) DEFAULT NULL AFTER `action_icon`;

-- 2022-11-11

CREATE TABLE `organization_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `organization_comments` ADD FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_comments` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_comments` ADD FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

-- 2022-11-12

CREATE TABLE `organization_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) NOT NULL,
  `actions` varchar(255) DEFAULT NULL,
  `action_details` text DEFAULT NULL,
  `action_author` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `organization_updates` ADD FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;
ALTER TABLE `organization_updates` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `organization_updates`
ADD COLUMN `action_icon` varchar(50) DEFAULT NULL AFTER `action_author`,
ADD COLUMN `action_background` varchar(50) DEFAULT NULL AFTER `action_icon`;

-- CREATE TABLE `email_signatures` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `contact_id` int(11) NOT NULL,
--   `actions` varchar(255) DEFAULT NULL,
--   `action_details` text DEFAULT NULL,
--   `action_author` varchar(255) DEFAULT NULL,
--   `created_by` int(11) DEFAULT NULL,
--   `created_date` datetime DEFAULT NULL,
--   `updated_by` int(11) DEFAULT NULL,
--   `updated_date` datetime DEFAULT NULL,
--   PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1; 

-- documents
--  -> id
--  -> title
--  -> type (file_upload/link_external_document)
--  -> file_name (if type == file_upload)
--  -> file_url (if type == link_external_document)
--  -> notes
--  -> assigned_to
--  -> created_by
--  -> created_date
--  -> updated_by
--  -> updated_date

-- contact_documents
--  -> id
--  -> contact_id
--  -> document_id
--  -> created_by
--  -> created_date
--  -> updated_by
--  -> updated_date

-- organization_documents
--  -> id
--  -> organization_id
--  -> document_id
--  -> created_by
--  -> created_date
--  -> updated_by
--  -> updated_date


campaign_activities

contact_activities
contact_documents
contact_campaigns
 ->id
 ->contact_id
 ->campaign_id
 ->created_by
 ->created_date 
contact_comments
 -> id
 -> contact_id
 -> comment_id
 -> comment
 -> comment_index
 -> created_by
 -> created_date

organization_activities
organization_documents
organization_campaigns
organization_comments