# Database Configuration Guide

## Environment Variables

Ensure your `.env` file contains the following database configuration:

```env
# Database Connection
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nxo
DB_USERNAME=root
DB_PASSWORD=your_password

# Database Charset and Collation (already set in config)
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci

# Timezone (optional but recommended)
DB_TIMEZONE=+00:00

# SSL Configuration (for production)
MYSQL_ATTR_SSL_CA=/path/to/ca-cert.pem
```

## MySQL Configuration

For optimal performance with the hardened schema, ensure your MySQL configuration includes:

### my.cnf / my.ini Settings

```ini
[mysqld]
# Character set and collation
character-set-server=utf8mb4
collation-server=utf8mb4_unicode_ci

# InnoDB settings
default-storage-engine=InnoDB
innodb_buffer_pool_size=1G  # Adjust based on available RAM
innodb_log_file_size=256M
innodb_flush_log_at_trx_commit=1

# Connection settings
max_connections=200
max_allowed_packet=64M

# Query cache (MySQL 5.7 and earlier)
query_cache_type=1
query_cache_size=64M

# Performance schema
performance_schema=ON

# Binary logging (for replication/backups)
log-bin=mysql-bin
binlog_format=ROW
expire_logs_days=7
```

## Verification Commands

### 1. Check Database Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### 2. Verify Charset and Collation
```bash
php artisan tinker
>>> DB::select("SELECT @@character_set_database, @@collation_database");
```

### 3. Check Table Charsets
```bash
php artisan tinker
>>> DB::select("SELECT TABLE_NAME, TABLE_COLLATION FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE()");
```

### 4. Verify Indexes
```bash
php artisan tinker
>>> DB::select("SHOW INDEX FROM users");
>>> DB::select("SHOW INDEX FROM products");
>>> DB::select("SHOW INDEX FROM orders");
```

### 5. Check Foreign Keys
```bash
php artisan tinker
>>> DB::select("SELECT TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL");
```

## Performance Monitoring

### 1. Slow Query Log
Enable slow query logging in MySQL:
```sql
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;
SET GLOBAL slow_query_log_file = '/var/log/mysql/slow.log';
```

### 2. Index Usage Monitoring
```sql
-- Check index usage statistics
SELECT 
    TABLE_NAME,
    INDEX_NAME,
    CARDINALITY,
    SUB_PART,
    PACKED,
    NULLABLE,
    INDEX_TYPE
FROM information_schema.STATISTICS 
WHERE TABLE_SCHEMA = DATABASE()
ORDER BY TABLE_NAME, SEQ_IN_INDEX;
```

### 3. Foreign Key Performance
```sql
-- Check for foreign key constraint violations
SELECT 
    CONSTRAINT_NAME,
    TABLE_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_SCHEMA = DATABASE() 
AND REFERENCED_TABLE_NAME IS NOT NULL;
```

## Backup Considerations

### 1. Before Running Migrations
```bash
# Create a full database backup
mysqldump -u root -p --single-transaction --routines --triggers nxo > backup_before_hardening.sql
```

### 2. After Running Migrations
```bash
# Create a post-migration backup
mysqldump -u root -p --single-transaction --routines --triggers nxo > backup_after_hardening.sql
```

### 3. Test Backup Restoration
```bash
# Test restore on a separate database
mysql -u root -p -e "CREATE DATABASE nxo_test;"
mysql -u root -p nxo_test < backup_after_hardening.sql
```

## Troubleshooting

### Common Issues

1. **Charset Conversion Fails**
   - Ensure MySQL version supports utf8mb4
   - Check for existing data that might conflict
   - Run conversion on smaller tables first

2. **Foreign Key Constraint Violations**
   - Check for orphaned records before adding FKs
   - Use `RESTRICT` instead of `CASCADE` for safety
   - Clean up data before adding constraints

3. **Index Creation Fails**
   - Check for duplicate values in unique indexes
   - Ensure sufficient disk space
   - Monitor for lock timeouts

4. **Decimal Precision Issues**
   - Existing data might have different precision
   - Test on staging environment first
   - Consider data migration for existing records

### Recovery Procedures

1. **Rollback Migrations**
   ```bash
   # Rollback specific migration
   php artisan migrate:rollback --step=1
   
   # Rollback to specific batch
   php artisan migrate:rollback --batch=5
   ```

2. **Manual Cleanup**
   ```sql
   -- Remove specific index
   DROP INDEX index_name ON table_name;
   
   -- Remove foreign key
   ALTER TABLE table_name DROP FOREIGN KEY constraint_name;
   
   -- Remove check constraint
   ALTER TABLE table_name DROP CHECK constraint_name;
   ```

## Production Deployment Checklist

- [ ] Database backup created
- [ ] Migrations tested on staging
- [ ] Performance impact assessed
- [ ] Monitoring configured
- [ ] Rollback plan prepared
- [ ] Team notified of deployment
- [ ] Maintenance window scheduled (if needed)
- [ ] Post-deployment verification planned

## Support

For issues with the database hardening:
1. Check the migration logs
2. Review the verification script output
3. Consult the troubleshooting section
4. Test on staging environment first
5. Contact the development team if needed
