# Emmanuel Mayamba — PHP and MySQL Portfolio

Simple HTML, CSS, JavaScript, PHP, and MySQLi. No framework or package installation needed.

## Run with XAMPP

1. Start Apache and MySQL in the XAMPP Control Panel.
2. Copy this whole folder to `C:\xampp\htdocs\emmanuel-mayamba-portfolio`.
3. In phpMyAdmin choose Import and select `database.sql`. It creates the `portfolio` database and tables. Reimporting preserves existing records.
4. Check `config.php`. Defaults: host `127.0.0.1`, port `3306`, database `portfolio`, user `root`, empty password. Environment variables can override these settings.
5. Open http://localhost/emmanuel-mayamba-portfolio/.
6. Select Register to create your own account. My account shows your messages and a logout button.

Alternatively, with MySQL running, run this from the project folder:

```powershell
& C:\xampp\php\php.exe -S 127.0.0.1:5173 -t .
```

Then visit http://localhost:5173/index.php. PHP must serve this version; opening HTML directly or using Python's static server cannot run the backend.

## Database tables

- `users`: names, unique emails, password hashes, creation times.
- `messages`: contact messages, sender details, owner account IDs, creation times.
- `portfolio_content`: portfolio wording, skill and project descriptions, learning topics, contact email, and portrait path.

Edit wording in `portfolio_content` through phpMyAdmin and refresh the page. `learning_topics` is a JSON array of strings. PHP escapes database text before displaying it. The photo itself stays in `assets/`, with its path in MySQL. HTML, CSS, and JavaScript remain source files; PHP manages login sessions. Account interface labels live in the PHP templates.

## Files

- `index.php`: loads portfolio content from MySQL.
- `index.html`: forwards old links to index.php.
- `config.php`, `db.php`: connection settings and reusable MySQLi connection.
- `bootstrap.php`: session, CSRF protection, escaping, and redirect helpers.
- `account.php`: login and registration forms and server validation.
- `dashboard.php`: protected account page with only the current user's latest 100 messages.
- `logout.php`: logout using a CSRF-protected POST request.
- `contact.php`: validates and stores messages from logged-in users.
- `database.sql`: schema and initial portfolio content; no real accounts or messages.
- `script.js`: menu, learning-focus button, browser validation, message submission.
- `styles.css`, `assets/`: responsive theme and portrait.

## Behavior

Passwords use password_hash and password_verify. SQL uses prepared statements for user input. Login regenerates the session ID. Forms use CSRF tokens. Server validation checks names, email, passwords, and messages. The form saves messages in MySQL; it does not send email. Message times are shown in UTC.

The original assignment features remain: external JavaScript, mobile menu, content-changing button, form validation, event listeners, functions, conditions, and dynamic content.

## Verification

Tested registration, password confirmation, duplicate email, correct and incorrect login, logout, protected pages, and message storage/display. PHP and JavaScript syntax checks pass.

## Submission

Commit the whole folder, including database.sql and assets. The recipient imports the SQL file into their own XAMPP installation. GitHub stores the code; GitHub Pages cannot run PHP or MySQL. This setup is for local coursework using XAMPP defaults.
