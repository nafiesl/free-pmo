# AGENTS.md - Free PMO

## Project Overview
Free PMO is a Laravel 8.x project management app for freelancers/agencies. Bilingual (English/Indonesian), timezone: Asia/Makassar.

## Critical Commands

### Testing
```bash
php artisan test --parallel          # Run all tests (preferred)
php artisan test                     # Run tests sequentially
php artisan test --filter=ManageProjectsTest  # Single test class
php artisan test --filter=test_name  # Single test by method name
```
Tests use SQLite in-memory database (configured in phpunit.xml). No external services needed.

### Frontend Build
```bash
npm run dev     # Development build
npm run prod    # Production build
```

### Setup
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
# Then visit /app-install to complete setup
```

## Architecture

### Entity Pattern (Non-Standard Laravel)
Models live in `app/Entities/` (not `app/`), organized by domain:
- `app/Entities/Projects/` - Project, Job, Task, Issue
- `app/Entities/Partners/` - Customer, Vendor
- `app/Entities/Payments/` - Payment
- `app/Entities/Invoices/` - Invoice
- `app/Entities/Subscriptions/` - Subscription

Models use `PresentableTrait` with corresponding `*Presenter` classes. Use `$guarded` (not `$fillable`).

### Routes
Routes are split by domain in `routes/web/`:
- `routes/web/projects.php`, `routes/web/payments.php`, etc.
- Included via `routes/web.php`
- Admin-only routes use `Route::group(['middleware' => ['role:admin']])`

### Testing Conventions
Tests use `BrowserKitTesting` (not HTTP testing). Key helpers in `tests/TestCase.php`:
```php
$this->adminUserSigningIn()   // Create & auth admin user
$this->userSigningIn()        // Create & auth worker user
$this->createUser('admin')    // Create user with role
```
Tests use `$this->visit()`, `$this->submitForm()`, `$this->see()` (BrowserKit style).
All tests use `RefreshDatabase` trait.

### Code Style
- StyleCI with Laravel preset (disabled: `not_operator_with_successor_space`)
- No PR comments unless asked
- Use `__()` helper for translatable strings (lang files in `resources/lang/{en,id,de}/`)

### CRUD Generator
New CRUD scaffolding available via:
```bash
php artisan crud:generate {Model}
```
Config: `config/simple-crud.php` (base layout: `layouts.app`, base test class: `Tests\TestCase`)

### Global Helpers
`app/helpers.php` contains: `format_no()`, `format_money()`, `date_id()`, `month_id()`, `flash()`, etc.
These use Indonesian formatting by default (dot for thousands separator).

### User Roles
Two roles: `admin` and `worker`. Role checks use `role:admin` middleware.
Users assigned via `$user->assignRole('admin')`.

### Migrations
Single migration files (no alters). For schema changes, update existing migration file directly and document ALTER SQL in commit message.

### Testing a Single Feature
```bash
php artisan test --filter=Feature/ManageProjectsTest
php artisan test --filter="admin_can_input_new_project"
```

## Authorization
- All controllers should call `$this->authorize()` for access control
- Routes should be wrapped in `auth` middleware group as defense in depth
- Example: `$this->authorize('update', $issue)` before modifying models
- Policies live in `app/Policies/`

## Workflow
- Use `gh pr create` for GitHub PR workflow
- Branch naming: `fix/description` or `feature/description`
- Run `php artisan test` before opening PR
