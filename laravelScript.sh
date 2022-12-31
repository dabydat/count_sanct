php artisan migrate:refresh
php artisan db:seed --class=UserTableSeeder
php artisan db:seed --class=StudentTableSeeder
php artisan db:seed --class=CategoryTableSeeder
php artisan db:seed --class=PeriodTableSeeder
php artisan db:seed --class=ContributionTableSeeder
php artisan optimize:clear
