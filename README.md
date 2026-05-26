# Task Tracker — CST5 Final Project

A dynamic, database-driven task management web application built with PHP and MySQL.

## Features

- **Register / Login / Logout** — secure authentication with bcrypt password hashing
- **Dashboard** — stats overview (total, to do, in progress, done)
- **CRUD Tasks** — create, read, update, and delete tasks
- **Mark as Complete** — one-click task completion
- **Search & Filter** — find tasks by keyword or status
- **AJAX Delete** — removes tasks without page reload
- **Server-side Validation** — all forms are validated before saving

## Technologies Used

| Layer      | Technology                        |
|------------|-----------------------------------|
| Backend    | PHP 8.1                           |
| Database   | MySQL 8.0 with PDO                |
| Frontend   | HTML5, CSS3, Vanilla JavaScript   |
| Deployment | Railway                           |
| Version Control | Git + GitHub               |

## Project Structure

```
task-tracker/
├── config/         → Database connection (PDO)
├── controllers/    → AuthController, TaskController
├── models/         → User.php, Task.php (all SQL here)
├── middleware/      → auth.php (session guard)
├── views/          → PHP HTML templates
├── public/         → Entry point, CSS, JS
└── database/       → schema.sql
```

## Local Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/YOUR_USERNAME/task-tracker.git
   cd task-tracker
   ```

2. Create the database:
   ```bash
   mysql -u root -p < database/schema.sql
   ```

3. Copy and configure environment variables:
   ```bash
   cp .env.example .env
   # Edit .env with your DB credentials
   ```

4. Start the PHP development server:
   ```bash
   php -S localhost:8080 -t public/
   ```

5. Open in browser: `http://localhost:8080`

## Environment Variables

| Variable   | Description                |
|------------|----------------------------|
| DB_HOST    | MySQL host (e.g. 127.0.0.1)|
| DB_NAME    | Database name              |
| DB_USER    | MySQL username             |
| DB_PASS    | MySQL password             |
| APP_ENV    | development or production  |
| APP_URL    | Base URL of the application|

## Database Structure

**users** — stores registered accounts (id, name, email, password hash, created_at)

**tasks** — stores all tasks (id, user_id, title, description, priority, status, due_date, timestamps)

See `database/schema.sql` for the full CREATE TABLE statements.

## Deployed Application

🔗 [Live App on Railway](#) ← replace with your Railway URL

## GitHub Repository

🔗 [GitHub Repo](#) ← replace with your GitHub URL

## Video Presentation

🎥 [Google Drive Video](#) ← replace with your Drive link
