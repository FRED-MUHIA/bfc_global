# Building Families and Communitie Global (Laravel + MySQL)

This project is the Laravel conversion of the original React site, with the same page structure and UI style migrated to Blade + Tailwind.

## Stack

- Laravel 12
- PHP 8.2+
- MySQL (MariaDB/XAMPP compatible)
- Vite + Tailwind CSS

## Implemented Pages

- Home
- About
- Parenting Resources
- Marriage & Family Life
- Youth Programs
- Counseling & Support
- Community Outreach
- Blog (listing)
- Blog Article (single post by slug)
- Get Involved
- Contact
- Custom 404

## Database Features

### Seeded
- `blog_posts` (seeded from `config/site.php`)

### Form Storage Tables
- `contact_inquiries`
- `support_inquiries`
- `volunteer_applications`
- `partnership_inquiries`
- `newsletter_subscriptions`

## Setup

1. Create database (if not already created):
```sql
CREATE DATABASE building_families_global CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Confirm `.env` has:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=building_families_global
DB_USERNAME=root
DB_PASSWORD=
```

3. Install PHP dependencies:
```bash
composer install
```

4. Install frontend dependencies:
```bash
npm install
```

5. Run migrations + seeds:
```bash
php artisan migrate --seed
```

6. Start Laravel and Vite:
```bash
php artisan serve
npm run dev
```

Open: `http://127.0.0.1:8000`

Alternative server command (custom launcher added):
```bash
php serve run
```

## Notes

- Shared site content is in `config/site.php`.
- Main page routes are in `routes/web.php`.
- All Blade pages are under `resources/views/pages`.
- Slider and mobile nav interactions are in `resources/js/app.js`.
# bfc_global
