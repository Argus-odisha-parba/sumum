# Production deployment — SUM Ultimate Medicare

PHP site with JSON-based content storage and an admin dashboard. No Composer build step required.

## Server requirements

- PHP 8.0+ (8.1 or 8.2 recommended)
- Apache with `mod_rewrite` enabled (or Nginx with equivalent rules)
- PHP extensions: `mysqli`, `json`, `fileinfo`, `mbstring`
- MySQL 5.7+ or MariaDB 10.3+ (optional today; required if you migrate to database storage later)
- HTTPS (SSL certificate) — strongly recommended for admin and forms

## 1. Upload files

Upload the project to the web root, for example:

- `public_html/` (cPanel)
- `/var/www/html/sumum/` (VPS)
- subdomain folder on shared hosting

**Do not** commit or expose on a public repo:

- `data/admin-config.php`
- `data/db-config.php`
- `data/appointments.json` (patient form data)

## 2. Database settings (Admin → Database)

| Key | Production example | Notes |
|-----|-------------------|--------|
| `DB_HOST` | `localhost` | Same server: use `localhost`. Remote DB: host from your provider (e.g. `mysql.yourhost.com`). |
| `DB_NAME` | `sumum_prod` | Create empty database in cPanel / phpMyAdmin first. |
| `DB_USERNAME` | `sumum_user` | **Do not** use `root` on shared hosting. |
| `DB_PORT` | `3306` | Default MySQL port; change only if host specifies another. |
| `DB_PASSWORD` | *(strong password)* | Use a long random password from your hosting panel. |

After filling the form:

1. Click **Test connection**
2. Click **Save settings**

Config is written to `data/db-config.php` (blocked from web access).

### WAMP (local) vs production

| Setting | Local (WAMP) | Production |
|---------|--------------|------------|
| DB_HOST | `localhost` | `localhost` or provider hostname |
| DB_USERNAME | `root` | Dedicated DB user |
| DB_PASSWORD | *(empty)* | Strong password |
| DB_NAME | `sumum` | e.g. `sumum_prod` |

## 3. Admin dashboard security

1. Open `https://yourdomain.com/admin/login.php`
2. If you see the default-password warning, create `data/admin-config.php`:

```php
<?php
return [
    'password' => 'your-very-strong-admin-password-here',
];
```

Or copy from `data/admin-config.sample.php` and change the password.

3. Use a long password (16+ characters). Never leave `sumum2026` on production.

## 4. File & folder permissions

Typical Linux permissions:

| Path | Permission | Why |
|------|------------|-----|
| Project files | `644` files / `755` dirs | Standard web readable |
| `data/` | `755` dir, writable by PHP | JSON + config saves |
| `assets/img/team/`, `assets/img/gallery/` | `755`, writable | Doctor & gallery uploads |
| `data/admin-config.php`, `data/db-config.php` | `640` | Readable by web server only |

On shared hosting, `755` for `data/` is usually enough if PHP runs as your user.

## 5. Apache / HTTPS

Ensure `.htaccess` in the project root is honored (`AllowOverride All`).

Doctor profile URLs use rewrite rules:

- `/doctors/dr-name` → `doctor-profile.php`

Force HTTPS in root `.htaccess` (uncomment on production):

```apache
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

## 6. Post-deploy checklist

- [ ] SSL certificate active (HTTPS)
- [ ] Admin password changed (`data/admin-config.php`)
- [ ] Database connection tested (Admin → Database)
- [ ] Contact details updated (Admin → Contact)
- [ ] Doctors & departments reviewed (Admin → Doctors / Departments)
- [ ] Gallery images uploaded (Admin → Gallery)
- [ ] Homepage appointment form submits and appears in Admin → Appointments
- [ ] `data/` not accessible in browser (should return 403)
- [ ] PHP `display_errors` **Off** in production `php.ini`
- [ ] Back up `data/` folder regularly (JSON + configs)

## 7. URLs after deployment

| Page | URL |
|------|-----|
| Website | `https://yourdomain.com/` |
| Admin login | `https://yourdomain.com/admin/login.php` |
| Admin dashboard | `https://yourdomain.com/admin/index.php` |
| Database settings | `https://yourdomain.com/admin/database.php` |

## 8. Backups

Back up regularly:

- `data/doctors.json`
- `data/departments.json`
- `data/gallery.json`
- `data/contact.json`
- `data/appointments.json`
- `data/admin-config.php`
- `data/db-config.php`
- `assets/img/team/` and `assets/img/gallery/` (uploaded images)

## 9. Optional: Nginx

If using Nginx instead of Apache, add equivalent rewrite for doctor profiles and deny `/data/`:

```nginx
location ^~ /data/ {
    deny all;
    return 403;
}

location ~ ^/doctors/([a-zA-Z0-9\-]+)/?$ {
    try_files $uri /doctor-profile.php?slug=$1;
}
```

## 10. Troubleshooting

| Issue | Fix |
|-------|-----|
| 404 on `/doctors/...` | Enable `mod_rewrite`; check `.htaccess` |
| Admin login fails | Verify `data/admin-config.php` exists and password matches |
| Cannot save doctors/gallery | Make `data/` and upload folders writable |
| DB connection failed | Confirm DB name/user/password in hosting panel; remote MySQL may require host IP whitelist |
| Blank page | Check PHP error log; enable logging only, not `display_errors` |
