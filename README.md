# LearnUp

LearnUp is a PHP-based online learning platform supporting Admin, Instructor, and Student roles. Instructors can create and manage courses with video lessons, and students can enroll and track their progress.

## Requirements

- PHP 7.4+
- MySQL
- XAMPP or similar local server
- Composer (optional, if using Laravel)

## Installation

1. Clone or download this repository.
2. Place the project folder in your XAMPP `htdocs` directory.
3. Import the `database.sql` file into your MySQL server (e.g., via phpMyAdmin).
4. Update `includes/db.php` with your database credentials.
5. Start Apache and MySQL from XAMPP Control Panel.
6. Access the app at `http://localhost/LearnUp/`.

## Folder Structure

- `admin/` - Admin dashboard and management
- `instructor/` - Instructor dashboard and course management
- `student/` - Student dashboard and course browsing
- `uploads/` - Uploaded videos and PDFs
- `includes/` - Shared PHP includes (DB, auth, header, footer)
- `assets/` - CSS, JS, images

## Default Admin Login

- Email: admin@learnup.com
- Password: admin123

## Features

- Authentication (Admin, Instructor, Student)
- Course management
- Enrollment and progress tracking
- Admin approval for courses

---

For more details, see the documentation in each folder.
"# LearnUp" 
