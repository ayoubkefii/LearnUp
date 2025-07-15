<?php
include '../includes/auth.php';
require_login();
require_role('admin');
include '../includes/db.php';
include '../includes/header.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    if ($name) {
        $stmt = $conn->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->close();
        header('Location: manage_categories.php');
        exit();
    } else {
        $errors[] = 'Category name required.';
    }
}
$res = $conn->query('SELECT * FROM categories');
?>
<h2>Manage Categories</h2>
<?php if ($errors): ?>
  <div class="alert alert-danger"><?php echo implode('<br>', $errors); ?></div>
<?php endif; ?>
<form method="post" class="mb-3">
  <div class="input-group">
    <input type="text" class="form-control" name="name" placeholder="New category name" required>
    <button class="btn btn-primary" type="submit">Add</button>
  </div>
</form>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><a href="#" class="btn btn-sm btn-danger disabled">Delete</a></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php include '../includes/footer.php'; ?> 