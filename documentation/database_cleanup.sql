-- =====================================================
-- DATABASE CLEANUP: Remove User-Related Data
-- =====================================================
-- Run these SQL commands to complete the auth removal.
-- Make sure to backup your database before proceeding!
-- =====================================================

-- Drop the users table (no longer needed)
DROP TABLE IF EXISTS users;

-- Remove user_id/id_owner columns from dynamic_qrcodes table
-- Note: This may fail if the column doesn't exist, which is fine
ALTER TABLE dynamic_qrcodes DROP COLUMN IF EXISTS user_id;
ALTER TABLE dynamic_qrcodes DROP COLUMN IF EXISTS id_owner;
ALTER TABLE dynamic_qrcodes DROP COLUMN IF EXISTS created_by;

-- Remove user_id/id_owner columns from static_qrcodes table
ALTER TABLE static_qrcodes DROP COLUMN IF EXISTS user_id;
ALTER TABLE static_qrcodes DROP COLUMN IF EXISTS id_owner;
ALTER TABLE static_qrcodes DROP COLUMN IF EXISTS created_by;

-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================
-- Run these to verify the cleanup was successful:

-- Check if users table is dropped
-- SHOW TABLES LIKE 'users';
-- Should return empty result

-- Check dynamic_qrcodes structure
-- DESCRIBE dynamic_qrcodes;
-- Should NOT have user_id, id_owner, or created_by columns

-- Check static_qrcodes structure  
-- DESCRIBE static_qrcodes;
-- Should NOT have user_id, id_owner, or created_by columns

