# Orbit — Project & Task Manager

Orbit is a polished Laravel 10 project workspace with secure user-owned projects, nested tasks, status filtering, and completion celebrations.

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
# The included configuration uses SQLite, then:
composer migrate:sqlite
npm install
npm run build
composer serve:sqlite
```

Moving a task to **Done** triggers an animated in-app completion alert. All project and task writes use Form Requests; ownership is enforced with Laravel policies and unauthorized access returns HTTP 403.

## Tests

```bash
composer test:sqlite
```
