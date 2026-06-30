## Development & Execution
- `npm run dev` Running Vite for local development
- `npm run build` Build assets for production
- `php artisan serve` Start the Laravel development server
- `php artisan tinker` Interact with your application in a REPL shell

## Database & Migrations
- `php artisan migrate` Run outstanding migrations
- `php artisan make:migration [name]` Create a new migration file
- `php artisan make:migration [name] --table=[table]` Create a migration to modify an existing table
- `php artisan migrate:reset` Rollback all database migrations
- `php artisan migrate:rollback` Rollback the last database migration
- `php artisan migrate:fresh` Drop all tables and re-run all migrations
- `php artisan migrate:refresh` Rollback and re-run all migrations
- `php artisan migrate:refresh --seed --force` Rollback, re-run migrations, and seed the database in production
- `php artisan make:seeder SeederName` Create a new seeder class
- `php artisan db:seed` Seed the database with records

## Generators (Controllers, Classes & Components)
- `php artisan make:controller ControllerName` Create a new controller
- `php artisan make:viewcomposer Name` Create a new view composer
- `php artisan make:component [name] --inline` Create a new inline Blade component
- `php artisan make:scope ProjectScope` Create a new Eloquent global scope
- `php artisan make:trait` Create a new Trait
- `php artisan make:command CustomTask` Create a new Artisan command
- `php artisan make:class CustomClass` Create a new PHP class

## Livewire
- `php artisan make:livewire dir.name` Create a new Livewire component
- `php artisan make:livewire dir.name --inline` Create a new inline Livewire component
- `php artisan livewire:stubs` Publish Livewire stubs for customization
- `php artisan livewire:layout` Create a new Livewire layout file

## Optimization & Maintenance
- `php artisan cache:clear` Flush the application cache
- `php artisan view:clear` Clear all compiled view files
- `php artisan config:clear` Remove the configuration cache file
- `php artisan route:clear` Remove the route cache file
- `composer dump-autoload` Regenerate the list of all classes that need to be included
- `php artisan config:show myapp` Display the contents of a configuration file

## Routing & Scheduling
- `php artisan route:list` List all registered routes
- `php artisan schedule:run` Run the scheduled commands
- `php artisan schedule:work` Start the schedule worker (local development)
- `php artisan schedule:list` List the scheduled tasks

## Custom Application Commands (Imports & Sync)
- `php artisan app:generate-album --url https://laravel-core.vades.dev/` Generate album from storage URL
- `php artisan app:import-project-content` Import project contents from markdown files
- `php artisan app:generate-sitemap laravel-core` Generate laravel-core.test sitemap
- `php artisan app:generate-sitemap ivnbg --path=../domains/ivnbg.com/public_html/` Generate ivnbg.com sitemap
# Preview files without downloading
php artisan github:download-publish-files --dry-run

# Download all files
php artisan github:download-publish-files

- `php artisan app:db-test` Run database connection/integrity test
- `php artisan app:import-project --name [name]` Import specific project data
- `php artisan app:generate-album --url [url]` Generate album from storage URL
- `php artisan app:csv-to-md` Convert CSV files to Markdown
- `php artisan app:generate-ivnbg-sitemap` Generate sitemap for ivnbg.com
- `php artisan app:generate-martinvach-sitemap` Generate sitemap for martinvach.com
- `php artisan app:sync-drive-to-local [path] [target]` Sync Google Drive folder to local
- `php artisan app:google-drive-synchronize [folder] [target]` Synchronize Google Drive assets
- `php artisan app:google-drive-download-files [src] [dest]` Download specific files from Google Drive
 

## Model Generation Flags
*Common flags used with `php artisan make:model ModelName`*

- `-c`, `--controller` Create a new controller for the model
- `-f`, `--factory` Create a new factory for the model
- `--force` Create the class even if the model already exists
- `-m`, `--migration` Create a new migration file for the model
- `-s`, `--seed` Create a new seeder file for the model
- `-p`, `--pivot` Indicates if the model should be a custom intermediate table model
- `-r`, `--resource` Indicates if the controller should be a resource controller

## Path Helpers
- `base_path();` /var/www/mysite
- `app_path();` /var/www/mysite/app
- `storage_path();` /var/www/mysite/storage