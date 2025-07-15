<?php
include '../includes/auth.php';
require_login();
require_role('admin');
include '../includes/db.php';
include '../includes/header.php';

$res = $conn->query('SELECT c.*, u.name AS instructor, cat.name AS category FROM courses c LEFT JOIN users u ON c.instructor_id = u.id LEFT JOIN categories cat ON c.category_id = cat.id');
?>
<h2>Manage Courses</h2>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Title</th>
      <th>Instructor</th>
      <th>Category</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo htmlspecialchars($row['instructor']); ?></td>
        <td><?php echo htmlspecialchars($row['category']); ?></td>
        <td><?php echo htmlspecialchars($row['status']); ?></td>
        <td>
          <a href="#" class="btn btn-sm btn-success disabled">Approve</a>
          <a href="#" class="btn btn-sm btn-danger disabled">Reject</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php include '../includes/footer.php'; ?> 