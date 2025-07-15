<?php
include '../includes/auth.php';
require_login();
require_role('admin');
include '../includes/db.php';
include '../includes/header.php';

$res = $conn->query('SELECT id, name, email, role, created_at FROM users');
?>
<h2>Manage Users</h2>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Registered</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['role']); ?></td>
        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
        <td>
          <a href="#" class="btn btn-sm btn-danger disabled">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php include '../includes/footer.php'; ?> 