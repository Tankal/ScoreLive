# Live Score

Live Score is a PHP/MySQL live-score portfolio project for listing football matches, teams, leagues, match details and basic user profile flows.

## Features

- Match listing by date
- League, team and match detail pages
- Live search across teams, countries and leagues
- Login, registration and profile update flow
- Responsive Bootstrap-based UI

## Tech Stack

- PHP 8+
- MySQL / MariaDB
- PDO
- Bootstrap
- jQuery
- Socket.IO client asset for realtime-ready UI

## Screenshots

Add screenshots or a short demo GIF here before publishing the repository.

## Installation

1. Clone the repository into your local web server directory.
2. Create a MySQL database named `jetskor` with `utf8mb4` charset.
3. Import the clean schema and sanitized seed data.
4. Copy `.env.example` values into your server environment or configure the same variables in Apache/XAMPP.

## Environment Variables

| Variable | Description | Default |
| --- | --- | --- |
| `DB_HOST` | MySQL host | `localhost` |
| `DB_NAME` | Database name | `jetskor` |
| `DB_USER` | Database user | `root` |
| `DB_PASS` | Database password | empty |
| `DB_CHARSET` | Database charset | `utf8mb4` |

## Database Setup

Using the MySQL CLI from XAMPP on Windows:

```powershell
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS jetskor CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
C:\xampp\mysql\bin\mysql.exe -u root jetskor < database/schema.sql
C:\xampp\mysql\bin\mysql.exe -u root jetskor < database/seed.sql
```

Using phpMyAdmin:

1. Create a database named `jetskor`.
2. Set collation to `utf8mb4_unicode_ci`.
3. Import `database/schema.sql`.
4. Import `database/seed.sql`.
5. Configure the same database name/user/password through environment variables.

Demo account:

```text
Email: demo@example.com
Password: demo1234
```

## Running Locally

With XAMPP, place the project under `htdocs` and open:

```text
http://localhost/skor/
```

## Build and Test Commands

This project does not currently use Node.js, Composer or a frontend build step. Useful local checks:

```bash
php -v
php -l index.php
```

For a full syntax check on Windows PowerShell:

```powershell
Get-ChildItem -Recurse -Include *.php | ForEach-Object { php -l $_.FullName }
```

## Project Structure

```text
assets/        CSS, JavaScript, fonts and images
inc/           Database connection, helper functions and form actions
update/        Legacy/static design source files
update2/       Legacy/static design source files
*.php          Main application pages
```

## Notes / Limitations

- `database/schema.sql` and `database/seed.sql` are the supported setup files.
- Realtime score updates are prepared in the UI, but the repository does not include a WebSocket backend.
- Passwords are hashed for new/updated users. Existing plaintext passwords are migrated on successful login.
