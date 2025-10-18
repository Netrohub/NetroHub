@echo off
echo Setting up SQLite database...
echo.

REM Create database file if it doesn't exist
if not exist "database\database.sqlite" (
    echo Creating database file...
    type nul > database\database.sqlite
    echo Database file created.
) else (
    echo Database file already exists.
)

echo.
echo Running migrations...
php artisan migrate:fresh --seed

echo.
echo Running role seeder...
php artisan db:seed --class=RolesAndPermissionsSeeder

echo.
echo Creating owner account...
php artisan user:create-owner --email=owner@netrohub.com --name="Platform Owner" --username=owner --password=password123

echo.
echo Clearing cache...
php artisan optimize:clear

echo.
echo ===================================
echo Setup complete!
echo ===================================
echo Admin Panel: http://localhost/admin
echo Email: owner@netrohub.com
echo Password: password123
echo.
echo IMPORTANT: Change the password after first login!
echo.
pause


