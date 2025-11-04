## Requirements

- PHP >= 8.2
- Composer
- SMTP mail server or email service (for production)

**Optional:**
- Node.js and npm (only needed if you want to modify or rebuild frontend assets)

## Setup

### Quick Start

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/QuickHR_Replies.git
   cd QuickHR_Replies
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure email settings** (see Email Configuration below)

5. **Start the server**
   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser.

### Email Configuration

Edit the `.env` file and configure your mail settings based on your needs:

#### Gmail SMTP (Production)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Note**: For Gmail, you need to generate an [App Password](https://support.google.com/accounts/answer/185833). Enable 2-Step Verification first, then create an app-specific password.

#### Log Mailer (Development Only)

For testing without sending actual emails:

```env
MAIL_MAILER=log
```

Emails will be logged to `storage/logs/laravel.log`

### Additional Setup Steps

- **Set permissions** (if needed):
  ```bash
  chmod -R 775 storage bootstrap/cache
  ```

- **Clear cache** (if you encounter issues):
  ```bash
  php artisan config:clear
  php artisan cache:clear
  ```
