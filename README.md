# InternConnect

Tanzania's premier internship management platform — connecting graduates with verified organisations.

## Requirements

- PHP ^8.3
- Composer
- Node.js ^20
- MySQL

## Setup

```bash
cp .env.example .env
# Edit .env with your database credentials and Resend API key

composer install
npm install

php artisan key:generate
php artisan migrate --seed
npm run build
```

## Development

```bash
composer dev
```

This runs the server, queue worker, logs, and Vite dev server concurrently.

## Testing

```bash
composer test
```

## Demo Accounts

The database seeder creates the following demo accounts for local development and testing:

| Role             | Name                  | Email                           | Password      |
|------------------|-----------------------|---------------------------------|---------------|
| Super Admin      | Super Administrator   | superadmin@internconnect.test   | Password@123  |
| Admin            | System Administrator  | admin@internconnect.test        | Password@123  |
| Employer         | Tech Solutions Ltd    | employer@internconnect.test     | Password@123  |
| Job Seeker       | John Applicant        | jobseeker@internconnect.test    | Password@123  |

> **Note:** Demo accounts are created with `email_verified_at` already set, so they bypass email verification. These accounts exist **only for local development and testing**. Real users who register through the application must verify their email normally.

### Account Types & Access

| Role         | Account Type | Dashboard Route        |
|--------------|-------------|------------------------|
| Super Admin  | admin       | `/admin/dashboard`     |
| Admin        | admin       | `/admin/dashboard`     |
| Employer     | company     | `/company/dashboard`   |
| Job Seeker   | student     | `/student/dashboard`   |

## Email

The application uses [Resend](https://resend.com) for email delivery. Configure your API key in `.env`:

```
MAIL_MAILER=resend
RESEND_KEY=re_...
MAIL_FROM_ADDRESS=noreply@internconnect.co.tz
MAIL_FROM_NAME="${APP_NAME}"
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
