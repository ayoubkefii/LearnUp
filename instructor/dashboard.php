<?php
include '../includes/auth.php';
require_login();
require_role('instructor');
include '../includes/header.php';
?>
<h2>Instructor Dashboard</h2>
<p>Welcome, Instructor! Here you can create and manage your courses.</p>
<?php include '../includes/footer.php'; ?> 