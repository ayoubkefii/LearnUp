<?php
include '../includes/auth.php';
require_login();
require_role('instructor');
include '../includes/db.php';
include '../includes/header.php';

$instructor_id = $_SESSION['user_id'];
$res = $conn->query("SELECT c.*, cat.name AS category FROM courses c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.instructor_id = $instructor_id");
?>
<h2>My Courses</h2>
<a href="create_course.php" class="btn btn-success mb-3">Create New Course</a>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo htmlspecialchars($row['category']); ?></td>
        <td><?php echo htmlspecialchars($row['status']); ?></td>
        <td>
          <a href="edit_course.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
          <a href="delete_course.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this course?');">Delete</a>
          <a href="add_lesson.php?course_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-secondary">Add Lesson</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php include '../includes/footer.php'; ?> 