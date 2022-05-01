set e

echo "Migrating database..."
php artisan migrate

echo "Seeding database..."
php artisan db:seed

echo "Creating key..."
php artisan key:generate
