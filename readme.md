# Laravel 5.2 Starter Kit

This is a starter kit for building new web application with **Laravel 5.2**.

## Current features
1. User Authentication
    - Login & Logout
    - Register
    - Change Password
    - Forgot Password
    - User Roles and Permissions
- Users, Roles, Permissions, References, and Site Options Migration and seeder
- Users CRUD
- Site Options
- Database Backup and Restore
    - use [Laravel Backup Manager](https://github.com/backup-manager/laravel) package
    - List Backup Files within `/storage/app/backup/db` folder, sort by descending Last Modified time
    - Create New Backup File
    - Restore database from Backup File
    - Download Backup File
    - Delete Backup File
    - Upload Backup File from local machine

### What Seeders do?
1. Add 2 Users: **Admin** (with password: *admin*) and **Member** (with password: *member*)
- Add 2 Roles: `admin` and `member`
- Assign **Admin** user to `admin` role
- Assign **Member** user to `member` role
- Add 4 Permissions: `manage_users`, `manage_options`, `manage_backups`, and `manage_role_permissions`
- Assign 4 mentioned permission above to `admin` role

## How to use?
1. Download zip file and Extract to your localhost document directory
- Or cd into laravel project root and clone the repo
- (within your favorited terminal) install dependencies with command: `composer install`
- *wait until it done*
- don't forget to set permission to storage folder: `sudo chmod 777 -R storage/`
- run your installed application with: `php artisan serve`
- open `http://localhost:8000/` from your browser to access the application

## Custom Services

### Site Option
This is like site preferences or settings feature.
We can use **Site Option** like this within blade file :
```php
{{ Option::get('key') }} // value
// or
{{ Option::get('site_title') }} // Laravel App
```
or within Class file:
```php
use Option;

class MasterController extends Controller {

    public function getSiteTitle() {

        $siteTitle = Option::get('site_title');

        return $siteTitle;
    }

}
```

### Form Field

This service require [Laravel Collective Package](https://laravelcollective.com/docs/5.2/html) and [Bootstrap 3](http://getbootstrap.com/) to make it work.
For example we need a text field within our form:

```php
{!! FormField::text('name') !!}
```
will return
```html
<div class="form-group ">
    <label for="name" class="control-label">Name</label>
    <input class="form-control" name="name" type="text" id="name">
</div>
```

Example for Checkbox and Radios.
We can use **numeric array** or **associative array** for Labels and Values :

```php
{!! FormField::checkboxes('group', [1 => 'Admin', 'Member']) !!}
{!! FormField::radios('status', ['a' => 'Active', 'b' => 'Inactive']) !!}
```
will return
```html
<!-- Checkboxes -->
<div class="form-group ">
    <label for="group" class="control-label">Group</label>
    <div class="checkbox">
        <li>
            <label for="group_1">
                <input id="group_1" name="group[]" type="checkbox" value="1">
                Admin
            </label>
        </li>
        <li>
            <label for="group_2">
                <input id="group_2" name="group[]" type="checkbox" value="2">
                Member
            </label>
        </li>
    </div>
</div>

<!-- Radios -->
<div class="form-group ">
    <div class="radio">
        <label for="status_a">
            <input id="status_a" name="status" type="radio" value="a">
            Active
        </label>
        <label for="status_b">
            <input id="status_b" name="status" type="radio" value="b">
            Inactive
        </label>
    </div>
</div>
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
