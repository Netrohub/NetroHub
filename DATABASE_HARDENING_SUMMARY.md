# Database Schema Hardening Summary

## Overview
This document summarizes the database schema hardening improvements made to the NXO marketplace application. All changes are designed to be safe, additive, and non-breaking to existing functionality.

## Migrations Created

### 1. `2025_10_19_200211_harden_database_schema_with_indexes_and_constraints.php`
**Purpose**: Core schema hardening with indexes, foreign keys, and charset conversion

**Key Improvements**:
- **Charset Conversion**: Converts all tables to `utf8mb4` charset and `utf8mb4_unicode_ci` collation
- **Indexes Added**:
  - Users: `(is_active, created_at)`, `email_verified_at`, `phone_verified_at`
  - Products: `status`, `created_at`, `is_featured`, `(seller_id, status, created_at)`, `deleted_at`
  - Orders: `(user_id, created_at)`, `(status, created_at)`, `payment_status`, `paid_at`
  - Order Items: `(seller_id, created_at)`, `product_id`, `delivered_at`
  - Disputes: `order_id`, `buyer_id`, `seller_id`, `(status, created_at)`, `resolved_at`
  - Product Files: `product_id`, `is_primary`, `mime_type`
  - OTP Verifications: `(phone, verified)` unique, `(phone, created_at)`
  - Reviews: `(reviewable_type, reviewable_id)`, `user_id`, `created_at`
- **Foreign Keys Added**:
  - Orders: `user_id` → `users(id)` with `RESTRICT`
  - Order Items: `order_id` → `orders(id)`, `product_id` → `products(id)`, `seller_id` → `sellers(id)`
  - Disputes: `order_id` → `orders(id)`, `buyer_id` → `users(id)`, `seller_id` → `sellers(id)`
  - Product Files: `product_id` → `products(id)` with `CASCADE`
- **Soft Deletes**: Added to `disputes`, `reviews`, and `sellers` tables

### 2. `2025_10_19_200304_ensure_proper_decimal_precision_and_constraints.php`
**Purpose**: Ensure proper decimal precision and add data integrity constraints

**Key Improvements**:
- **Decimal Precision**: All monetary fields updated to `DECIMAL(12,2)`
  - Products: `price`
  - Orders: `subtotal`, `platform_fee`, `total`
  - Order Items: `price`, `seller_amount`, `platform_commission`
  - Wallet Transactions: `amount`
  - Payout Requests: `amount`
  - Refunds: `amount`
- **Check Constraints Added**:
  - Products: `price >= 0`, `stock_count >= 0`, `rating BETWEEN 0 AND 5`
  - Orders: `subtotal >= 0`, `platform_fee >= 0`, `total >= 0`
  - Order Items: `price >= 0`, `seller_amount >= 0`, `platform_commission >= 0`, `quantity > 0`
  - Users: `is_active IN (0, 1)`
  - OTP Verifications: `CHAR_LENGTH(otp) = 6`, `verified IN (0, 1)`

### 3. `2025_10_19_200333_add_missing_unique_constraints_and_phone_handling.php`
**Purpose**: Add missing unique constraints and handle phone number uniqueness safely

**Key Improvements**:
- **Phone Number Handling**:
  - Checks for duplicate phone numbers before adding unique constraints
  - Handles both `phone` and `phone_number` columns
  - Logs warnings if duplicates found, skips constraint addition
- **Unique Constraints Added**:
  - Products: `slug` (if not already unique)
  - Orders: `order_number` (if not already unique)
  - Users: `username` (if not already unique)
  - Sellers: `user_id` (if not already unique)
- **Missing Fields Added**:
  - Users: `email_verified_at`, `phone_verified_at` (if missing)

## Safety Features

### 1. Duplicate Detection
- All unique constraints are checked for existing duplicates before application
- Warnings are logged if duplicates are found
- Migration continues without failing

### 2. Foreign Key Safety
- Foreign keys use appropriate `ON DELETE` rules:
  - `CASCADE`: For dependent data (product files, order items)
  - `RESTRICT`: For critical relationships (orders, disputes)
- Checks for orphaned records before adding constraints

### 3. Index Safety
- All indexes are checked for existence before creation
- Uses descriptive index names to avoid conflicts
- Graceful handling of index creation failures

### 4. Charset Conversion Safety
- Individual table conversion with error handling
- Continues processing even if some tables fail
- Logs success/failure for each table

## Database Configuration

The existing `config/database.php` is already properly configured:
- ✅ `charset: 'utf8mb4'`
- ✅ `collation: 'utf8mb4_unicode_ci'`
- ✅ `strict: true`
- ✅ `engine: null` (defaults to InnoDB)

## Performance Improvements

### Query Performance
- **Composite Indexes**: Added for common query patterns
- **Foreign Key Indexes**: Automatically created for FK relationships
- **Soft Delete Indexes**: Added for efficient soft delete queries

### Data Integrity
- **Check Constraints**: Prevent invalid data entry
- **Foreign Keys**: Ensure referential integrity
- **Unique Constraints**: Prevent duplicate data

### Storage Efficiency
- **Proper Decimal Precision**: `DECIMAL(12,2)` for monetary values
- **UTF8MB4**: Full Unicode support including emojis
- **InnoDB Engine**: ACID compliance and better performance

## Tables Affected

### Core Tables
- `users` - Enhanced with indexes and constraints
- `products` - Comprehensive indexing and constraints
- `orders` - Foreign keys and performance indexes
- `order_items` - Relationship integrity and indexing

### Supporting Tables
- `disputes` - Soft deletes and comprehensive indexing
- `product_files` - Foreign keys and metadata indexing
- `otp_verifications` - Unique constraints and performance indexes
- `reviews` - Polymorphic relationship indexing

### System Tables
- All tables converted to utf8mb4 charset
- Proper collation for international support
- Consistent engine and storage settings

## Migration Execution

To apply these improvements:

```bash
# Run the migrations in order
php artisan migrate

# Check migration status
php artisan migrate:status

# Verify indexes were created
php artisan tinker
>>> DB::select("SHOW INDEX FROM users");
>>> DB::select("SHOW INDEX FROM products");
>>> DB::select("SHOW INDEX FROM orders");
```

## Expected Output

When running the migrations, you should see output like:
```
Converted table users to utf8mb4
Converted table products to utf8mb4
...
Added foreign key: orders.user_id -> users.id
Added foreign key: order_items.order_id -> orders.id
...
Updated products.price to DECIMAL(12,2)
Updated orders.subtotal to DECIMAL(12,2)
...
Added check constraint: products.price >= 0
Added check constraint: orders.subtotal >= 0
...
Added unique constraint on products.slug
Added unique constraint on orders.order_number
```

## Rollback Considerations

These migrations are designed to be safe and additive. Rolling back would require:
1. Careful analysis of what was added
2. Manual removal of constraints and indexes
3. Potential data loss if foreign keys were added

**Recommendation**: Test thoroughly in staging before production deployment.

## Monitoring

After deployment, monitor:
1. **Query Performance**: Check slow query logs
2. **Index Usage**: Monitor index utilization
3. **Constraint Violations**: Watch for check constraint failures
4. **Foreign Key Violations**: Monitor for referential integrity issues

## Future Considerations

1. **Partitioning**: Consider table partitioning for large tables
2. **Archiving**: Implement data archiving for old records
3. **Monitoring**: Set up database performance monitoring
4. **Backup Strategy**: Ensure proper backup procedures for the hardened schema
