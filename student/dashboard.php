<?php
include '../includes/auth.php';
require_login();
require_role('student');
include '../includes/db.php';
include '../includes/header.php';

$student_id = $_SESSION['user_id'];
$res = $conn->query("SELECT e.course_id, c.title, c.thumbnail, c.description FROM enrollments e JOIN courses c ON e.course_id = c.id WHERE e.student_id = $student_id");
?>
<h2>Student Dashboard</h2>
<p>Welcome, Student! Here you can browse and enroll in courses, and track your progress.</p>
<h4>My Enrolled Courses</h4>
<div class="row">
  <?php while ($row = $res->fetch_assoc()): ?>
    <div class="col-md-4">
      <div class="card mb-4">
        <img src="/uploads/<?php echo htmlspecialchars($row['thumbnail']); ?>" class="card-img-top" alt="Course Thumbnail">
        <div class="card-body">
          <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
          <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
          <a href="course_detail.php?id=<?php echo $row['course_id']; ?>" class="btn btn-primary">View Course</a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>
<?php include '../includes/footer.php'; ?> 