BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "attendances" (
	"id"	integer NOT NULL,
	"student_id"	integer NOT NULL,
	"date"	date NOT NULL,
	"check_in"	time,
	"check_out"	time,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("student_id") REFERENCES "students"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "cache" (
	"key"	varchar NOT NULL,
	"value"	text NOT NULL,
	"expiration"	integer NOT NULL,
	PRIMARY KEY("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks" (
	"key"	varchar NOT NULL,
	"owner"	varchar NOT NULL,
	"expiration"	integer NOT NULL,
	PRIMARY KEY("key")
);
CREATE TABLE IF NOT EXISTS "centers" (
	"id"	integer NOT NULL,
	"name"	varchar NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "failed_jobs" (
	"id"	integer NOT NULL,
	"uuid"	varchar NOT NULL,
	"connection"	text NOT NULL,
	"queue"	text NOT NULL,
	"payload"	text NOT NULL,
	"exception"	text NOT NULL,
	"failed_at"	datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "job_batches" (
	"id"	varchar NOT NULL,
	"name"	varchar NOT NULL,
	"total_jobs"	integer NOT NULL,
	"pending_jobs"	integer NOT NULL,
	"failed_jobs"	integer NOT NULL,
	"failed_job_ids"	text NOT NULL,
	"options"	text,
	"cancelled_at"	integer,
	"created_at"	integer NOT NULL,
	"finished_at"	integer,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "jobs" (
	"id"	integer NOT NULL,
	"queue"	varchar NOT NULL,
	"payload"	text NOT NULL,
	"attempts"	integer NOT NULL,
	"reserved_at"	integer,
	"available_at"	integer NOT NULL,
	"created_at"	integer NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "migrations" (
	"id"	integer NOT NULL,
	"migration"	varchar NOT NULL,
	"batch"	integer NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "password_reset_tokens" (
	"email"	varchar NOT NULL,
	"token"	varchar NOT NULL,
	"created_at"	datetime,
	PRIMARY KEY("email")
);
CREATE TABLE IF NOT EXISTS "results" (
	"id"	integer NOT NULL,
	"student_id"	integer NOT NULL,
	"subject"	varchar NOT NULL,
	"score"	integer NOT NULL,
	"max_score"	integer NOT NULL DEFAULT '100',
	"result_date"	date NOT NULL,
	"notes"	text,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("student_id") REFERENCES "students"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "sessions" (
	"id"	varchar NOT NULL,
	"user_id"	integer,
	"ip_address"	varchar,
	"user_agent"	text,
	"payload"	text NOT NULL,
	"last_activity"	integer NOT NULL,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "students" (
	"id"	integer NOT NULL,
	"name"	varchar NOT NULL,
	"student_code"	varchar NOT NULL,
	"phone"	varchar,
	"parent_phone"	varchar NOT NULL,
	"photo"	varchar,
	"national_id"	varchar,
	"email"	varchar,
	"grade"	varchar,
	"birth_date"	date,
	"notes"	text,
	"created_at"	datetime,
	"updated_at"	datetime,
	"center_id"	integer,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("center_id") REFERENCES "centers"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "users" (
	"id"	integer NOT NULL,
	"name"	varchar NOT NULL,
	"email"	varchar NOT NULL,
	"email_verified_at"	datetime,
	"password"	varchar NOT NULL,
	"remember_token"	varchar,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
INSERT INTO "attendances" VALUES (4,11,'2026-04-28 00:00:00','2026-04-28 13:06:11','2026-04-28 13:06:34','2026-04-28 13:06:11','2026-04-28 13:06:34');
INSERT INTO "attendances" VALUES (6,12,'2026-04-30 00:00:00','2026-04-30 07:30:06',NULL,'2026-04-30 07:30:06','2026-04-30 07:30:06');
INSERT INTO "attendances" VALUES (7,13,'2026-05-02 00:00:00','2026-05-02 06:03:12',NULL,'2026-05-02 06:03:12','2026-05-02 06:03:12');
INSERT INTO "attendances" VALUES (8,12,'2026-05-02 00:00:00','2026-05-02 06:15:19',NULL,'2026-05-02 06:15:19','2026-05-02 06:15:19');
INSERT INTO "attendances" VALUES (9,11,'2026-05-02 00:00:00','2026-05-02 06:32:12',NULL,'2026-05-02 06:32:12','2026-05-02 06:32:12');
INSERT INTO "centers" VALUES (1,'مركز الإسكندرية','2026-04-28 10:07:50','2026-04-28 10:07:50');
INSERT INTO "centers" VALUES (2,'مركز سموحة','2026-04-28 10:07:50','2026-04-28 10:07:50');
INSERT INTO "centers" VALUES (3,'مركز المنتزه','2026-04-28 10:07:52','2026-04-28 10:07:52');
INSERT INTO "migrations" VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO "migrations" VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO "migrations" VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO "migrations" VALUES (4,'2026_04_26_111522_create_students_table',1);
INSERT INTO "migrations" VALUES (5,'2026_04_26_115558_create_attendances_table',1);
INSERT INTO "migrations" VALUES (6,'2026_04_27_105025_create_results_table',1);
INSERT INTO "migrations" VALUES (7,'2026_04_28_090958_create_centers_table',2);
INSERT INTO "migrations" VALUES (8,'2026_04_28_091059_add_center_id_and_photo_to_students_table',3);
INSERT INTO "results" VALUES (3,11,'عربي',60,100,'2026-04-28',NULL,'2026-04-28 13:06:54','2026-04-28 13:06:54');
INSERT INTO "results" VALUES (4,11,'عربي',90,100,'2026-04-28',NULL,'2026-04-28 13:07:02','2026-04-28 13:07:02');
INSERT INTO "results" VALUES (5,11,'English',30,100,'2026-04-28',NULL,'2026-04-28 15:35:32','2026-04-28 15:35:32');
INSERT INTO "sessions" VALUES ('Z0COK1sbgoGvTCjgzQBNstshzQk7ebUsrxwSSa2c',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoickxoR1k3S3M2Qmpsa3hPNkQ3VEVXeU93ZXFTZTF1aWJCckp4d09uMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hdHRlbmRhbmNlIjtzOjU6InJvdXRlIjtzOjE2OiJhdHRlbmRhbmNlLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1777705850);
INSERT INTO "students" VALUES (9,'ريهام سعيد محمد','STD-S8UAHO',NULL,'0123695414','1777381526_581390171_4182782458676057_5908561437204561295_n.jpg',NULL,NULL,NULL,NULL,NULL,'2026-04-28 13:05:26','2026-04-28 13:05:26',2);
INSERT INTO "students" VALUES (11,'شيرين محمد محمد','STD-RLDYCQ',NULL,'01789365','1777381564_cq5dam.web.1280.1280.jpg',NULL,NULL,NULL,NULL,NULL,'2026-04-28 13:06:04','2026-04-28 13:06:04',3);
INSERT INTO "students" VALUES (12,'احمد السيد علي حسين','STD-BS1SSE',NULL,'012145','1777534192_concrete-boom-pump.jpg',NULL,NULL,NULL,NULL,NULL,'2026-04-30 07:29:52','2026-04-30 07:29:52',1);
INSERT INTO "students" VALUES (13,'علي السيد علي','STD-NYRXKH',NULL,'01233625596','1777701770_male.jpg',NULL,NULL,NULL,NULL,NULL,'2026-05-02 06:02:50','2026-05-02 06:02:50',1);
CREATE UNIQUE INDEX IF NOT EXISTS "attendances_student_id_date_unique" ON "attendances" (
	"student_id",
	"date"
);
CREATE INDEX IF NOT EXISTS "cache_expiration_index" ON "cache" (
	"expiration"
);
CREATE INDEX IF NOT EXISTS "cache_locks_expiration_index" ON "cache_locks" (
	"expiration"
);
CREATE UNIQUE INDEX IF NOT EXISTS "failed_jobs_uuid_unique" ON "failed_jobs" (
	"uuid"
);
CREATE INDEX IF NOT EXISTS "jobs_queue_index" ON "jobs" (
	"queue"
);
CREATE INDEX IF NOT EXISTS "sessions_last_activity_index" ON "sessions" (
	"last_activity"
);
CREATE INDEX IF NOT EXISTS "sessions_user_id_index" ON "sessions" (
	"user_id"
);
CREATE UNIQUE INDEX IF NOT EXISTS "students_student_code_unique" ON "students" (
	"student_code"
);
CREATE UNIQUE INDEX IF NOT EXISTS "users_email_unique" ON "users" (
	"email"
);
COMMIT;
