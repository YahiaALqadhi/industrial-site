<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

## Industrial Site (Local Setup Notes)

### Public file uploads (required)

This project stores uploaded files (category images, product images, brochures, service images) in `storage/app/public` using the `public` disk.

You must create the public symlink once:

```bash
php artisan storage:link
```

Uploaded files will then be accessible at URLs like:

- `/storage/categories/...`
- `/storage/products/...`

### Frontend assets (Vite/Tailwind/AOS)

The frontend uses Vite to bundle CSS (TailwindCSS) and JS (Alpine.js, AOS). Both the frontend and admin layouts include assets via `@vite(['resources/css/app.css','resources/js/app.js'])`.

To install dependencies and build for production:

```bash
npm install
npm run build
```

The build creates `public/build/` with hashed assets. Ensure `public/build/` exists and is accessible. For production, you do **not** need to run `npm run dev`; only the build output is used.

### Email (Gmail SMTP with App Password)

Inquiries send email notifications to the admin, and replies can be emailed to customers. Configure Gmail SMTP in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=yahiaalqadhi2004@gmail.com
MAIL_PASSWORD=YOUR_GMAIL_APP_PASSWORD
MAIL_FROM_ADDRESS=yahiaalqadhi2004@gmail.com
MAIL_FROM_NAME="Industrial Website"
```

**Important:** Use a Gmail App Password, not your regular password. Enable 2-Step Verification on your Google Account, then generate an App Password:

1. Go to Google Account settings > Security > 2-Step Verification (enable it if off)
2. Go to Security > App passwords
3. Select app: Mail, device: Other (custom name)
4. Copy the 16-character password (no spaces) into `MAIL_PASSWORD`

If mail is not configured, the app stores replies and shows a warning instead of crashing.

### Admin panel

- Admin area is under `/admin` (requires login)
- Roles:
  - `super_admin` (full access incl. admin users)
  - `admin` (manage catalog + inquiries)
  - `support` (view inquiries + update status only)

## Production Deployment

### Environment Setup
1. Copy `.env.example` to `.env` and configure:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com
   
   DB_DATABASE=your_production_db
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_ENCRYPTION=tls
   MAIL_USERNAME=your@gmail.com
   MAIL_PASSWORD=your_gmail_app_password
   MAIL_FROM_ADDRESS=your@gmail.com
   MAIL_FROM_NAME="Your Company"
   ```

2. Generate application key:
   ```bash
   php artisan key:generate
   ```

### Deployment Commands
```bash
# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Clear and cache configurations
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Optimize for production
php artisan optimize
```

### Security Checklist
- [ ] Set `APP_DEBUG=false` in production
- [ ] Configure proper file permissions (755 for directories, 644 for files)
- [ ] Set up SSL certificate
- [ ] Configure firewall rules
- [ ] Set up regular backups
- [ ] Monitor error logs

### Backup Strategy
1. **Database Backup** (run daily):
   ```bash
   mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql
   ```

2. **Storage Backup**:
   ```bash
   tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/
   ```

3. **Configuration Backup**:
   ```bash
   cp .env .env.backup.$(date +%Y%m%d)
   ```

### Health Monitoring
- Access `/admin/system-health` to monitor:
  - Database connection
  - Storage link status
  - Mail configuration
  - Cache system
  - Environment settings

### Performance Optimization
- Settings are cached for 1 hour
- Top categories are cached for performance
- Database indexes added for common queries
- Rate limiting applied to contact forms (10 requests/minute)

### Troubleshooting
- If emails don't send: Check `/admin/test-email` for configuration
- If assets don't load: Ensure `npm run build` was run and `public/build/` exists
- If storage files don't load: Run `php artisan storage:link`
- Clear caches: Use `/admin/system-health` → "Clear All Caches"

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
