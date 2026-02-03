# Deployment Instructions
This document provides step-by-step instructions for deploying the application to a production environment.
## Create symbolic link for storage
To ensure that images stored in the `storage` folder are accessible via the web, you need to create a symbolic link. Run the following command in your terminal:
```bash
php artisan storage:link
```
This command creates a symbolic link from `public/storage` to `storage/app/public`, allowing you to access images stored in the storage folder through your web server.
### Verify the symbolic link
After running the command, verify that the symbolic link was created successfully by checking the contents of the `public` directory:
```bash
ls -la public/
```
You should see a line indicating that `storage` is a symbolic link pointing to `../storage/app/public`.
### Set correct permissions
Ensure that the web server has the correct permissions to read from the `storage` folder. You may need to adjust the permissions using the following command:
```bash
chmod -R 775 storage
```
Make sure the web server user (e.g., `www-data` for Apache) has access to the `storage` directory.
### Test image access
To confirm that images can be accessed correctly, try to load an image stored in the `storage/app/public` directory via your web browser. The URL should look like this:
```
http://your-domain.com/storage/images/your-image.jpg
```