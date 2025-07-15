<?php
include '../includes/auth.php';
require_login();
require_role('admin');
include '../includes/header.php';
?>
<h2>Admin Dashboard</h2>
<p>Welcome, Admin! Here you can manage users, courses, categories, and more.</p>
<ul>
  <li><a href="manage_users.php">Manage Users</a></li>
  <li><a href="manage_courses.php">Manage Courses</a></li>
  <li><a href="manage_categories.php">Manage Categories</a></li>
</ul>
<?php include '../includes/footer.php'; ?> 