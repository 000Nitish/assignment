# Assignment - PHP MySQL CRUD Web Application

A simple web application with user authentication and CRUD operations for managing items (tasks/notes). Built with PHP, MySQL, Bootstrap, HTML, CSS and JavaScript.

## Technologies Used

- **HTML** - Page structure
- **CSS** - Styling (Bootstrap + basic custom CSS)
- **JavaScript** - Form validation (optional)
- **Bootstrap 5** - Layout and forms
- **PHP** - Server-side logic, sessions, validation
- **MySQL** - Database (users and items)

## Project Structure

```
assingment/
├── config/
│   ├── db.php           # Database connection
│   └── check_login.php  # Session check for protected pages
├── auth/
│   ├── login.php        # Login page and process
│   ├── signup.php       # Sign up page and process
│   └── logout.php       # Logout and redirect to login
├── crud/
│   ├── index.php        # List all items (dashboard)
│   ├── add.php          # Add new item
│   ├── edit.php         # Edit existing item
│   └── delete.php       # Delete item
├── assets/
│   └── css/
│       └── style.css    # Optional custom CSS
├── database/
│   └── schema.sql      # Database tables
├── index.php            # Redirect to login or dashboard
└── README.md
```

## Setup Steps (XAMPP / WAMP)

### 1. Start Apache and MySQL

- Open XAMPP Control Panel (or WAMP).
- Start **Apache** and **MySQL**.

### 2. Create Database and Tables

- Open phpMyAdmin: `http://localhost/phpmyadmin`
- Go to **Import** tab.
- Choose the file: `database/schema.sql` from this project.
- Click **Go** to run the SQL. This will create the database `assignment_db` and tables `users` and `items`.

**Or run manually:**

- Create a new database named `assignment_db`.
- Open `database/schema.sql`, copy its contents and run in the SQL tab of phpMyAdmin.

### 3. Database Connection (if needed)

- Open `config/db.php`.
- Default values: host `localhost`, database `assignment_db`, user `root`, password `` (empty).
- Change `$username` and `$password` if your MySQL user is different.

### 4. Run the Application

- Place the project folder inside `htdocs` (XAMPP) or `www` (WAMP).
- In browser open: `http://localhost/assingment/` (or your folder name).

## How to Test

### Login and Sign Up

1. Open `http://localhost/assingment/` — you should be redirected to the login page.
2. Click **Sign Up** and create an account:
   - Enter name, email, password (min 6 characters), confirm password.
   - Submit. You should see a success message and be redirected to login.
3. On the login page, enter the same email and password and click **Login**.
4. You should be redirected to **My Items** (dashboard). If you are not logged in and try to open `crud/index.php` directly, you will be redirected to login.

### CRUD Features

1. **Create:** On the dashboard click **Add Item**. Enter title and description, click **Save**. You should see the new item in the list.
2. **View:** The dashboard (`crud/index.php`) shows a table of all your items (title, description, date, actions).
3. **Edit:** Click **Edit** on any item. Change title or description and click **Update**. The list should show the updated data.
4. **Delete:** Click **Delete** on any item. Confirm in the alert. The item should be removed from the list.

Each user sees only their own items (linked by `user_id`). Create another user and add items to verify that items are separate per user.

## Database Tables

- **users:** id, name, email, password (hashed), created_at
- **items:** id, user_id, title, description, created_at

Passwords are stored using PHP `password_hash()`. All database queries use prepared statements to avoid SQL injection.

## Notes

- No frameworks (e.g. Laravel) are used.
- Code is kept simple and suitable for a student assignment.
- For production use you would add more validation, CSRF protection, and secure session settings.
