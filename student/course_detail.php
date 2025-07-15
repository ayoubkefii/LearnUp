<?php
include '../includes/auth.php';
require_login();
require_role('student');
include '../includes/db.php';
include '../includes/header.php';

$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$student_id = $_SESSION['user_id'];

// Fetch course
$stmt = $conn->prepare('SELECT c.*, u.name AS instructor, cat.name AS category FROM courses c LEFT JOIN users u ON c.instructor_id = u.id LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.id = ? AND c.status = "approved"');
$stmt->bind_param('i', $course_id);
$stmt->execute();
$course = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$course) {
    echo '<div class="alert alert-danger">Course not found or not approved.</div>';
    include '../includes/footer.php';
    exit();
}
// Check enrollment
$stmt = $conn->prepare('SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?');
$stmt->bind_param('ii', $student_id, $course_id);
$stmt->execute();
$stmt->store_result();
$enrolled = $stmt->num_rows > 0;
$stmt->close();

// Fetch lessons
$stmt = $conn->prepare('SELECT * FROM lessons WHERE course_id = ? ORDER BY lesson_order ASC');
$stmt->bind_param('i', $course_id);
$stmt->execute();
$lessons = $stmt->get_result();
$stmt->close();

// Fetch progress if enrolled
$completed = [];
if ($enrolled) {
    $stmt = $conn->prepare('SELECT lesson_id FROM progress WHERE enrollment_id = (SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?)');
    $stmt->bind_param('ii', $student_id, $course_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $completed[] = $row['lesson_id'];
    }
    $stmt->close();
}
?>
<h2><?php echo htmlspecialchars($course['title']); ?></h2>
<p><strong>Instructor:</strong> <?php echo htmlspecialchars($course['instructor']); ?> | <strong>Category:</strong> <?php echo htmlspecialchars($course['category']); ?></p>
<img src="/uploads/<?php echo htmlspecialchars($course['thumbnail']); ?>" class="img-fluid mb-3" style="max-width:300px;">
<p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
<?php if (!$enrolled): ?>
  <form method="post" action="enroll.php">
    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
    <button type="submit" class="btn btn-success">Enroll in this course</button>
  </form>
<?php else: ?>
  <div class="alert alert-info">You are enrolled in this course.</div>
<?php endif; ?>
<h4>Lessons</h4>
<ul class="list-group">
  <?php while ($lesson = $lessons->fetch_assoc()): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <span>
        <?php echo htmlspecialchars($lesson['lesson_order'] . '. ' . $lesson['title']); ?>
        <?php if ($lesson['video_url']): ?>
          <a href="/uploads/videos/<?php echo htmlspecialchars($lesson['video_url']); ?>" target="_blank" class="ms-2">[Video]</a>
        <?php endif; ?>
        <?php if ($lesson['pdf_url']): ?>
          <a href="/uploads/pdfs/<?php echo htmlspecialchars($lesson['pdf_url']); ?>" target="_blank" class="ms-2">[PDF]</a>
        <?php endif; ?>
      </span>
      <?php if ($enrolled): ?>
        <form method="post" action="mark_completed.php" class="d-inline">
          <input type="hidden" name="lesson_id" value="<?php echo $lesson['id']; ?>">
          <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
          <button type="submit" class="btn btn-sm <?php echo in_array($lesson['id'], $completed) ? 'btn-success' : 'btn-outline-success'; ?>">
            <?php echo in_array($lesson['id'], $completed) ? 'Completed' : 'Mark as Completed'; ?>
          </button>
        </form>
      <?php endif; ?>
    </li>
  <?php endwhile; ?>
</ul>
<?php include '../includes/footer.php'; ?> 