<?php
include '../includes/auth.php';
require_login();
require_role('instructor');
include '../includes/db.php';
include '../includes/header.php';

$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $lesson_order = intval($_POST['lesson_order']);
    $video_url = '';
    $pdf_url = '';

    if (!$title || !$lesson_order) {
        $errors[] = 'Title and order are required.';
    }

    // Handle video upload
    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));
        if ($ext !== 'mp4') {
            $errors[] = 'Video must be an MP4 file.';
        } else {
            $filename = uniqid('video_') . '.' . $ext;
            $dest = '../uploads/videos/' . $filename;
            if (move_uploaded_file($_FILES['video']['tmp_name'], $dest)) {
                $video_url = $filename;
            } else {
                $errors[] = 'Failed to upload video.';
            }
        }
    }

    // Handle PDF upload
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            $errors[] = 'PDF must be a PDF file.';
        } else {
            $filename = uniqid('pdf_') . '.' . $ext;
            $dest = '../uploads/pdfs/' . $filename;
            if (move_uploaded_file($_FILES['pdf']['tmp_name'], $dest)) {
                $pdf_url = $filename;
            } else {
                $errors[] = 'Failed to upload PDF.';
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO lessons (course_id, title, video_url, pdf_url, lesson_order) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('isssi', $course_id, $title, $video_url, $pdf_url, $lesson_order);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = 'Failed to add lesson.';
        }
        $stmt->close();
    }
}
?>
<h2>Add Lesson</h2>
<?php if ($success): ?>
  <div class="alert alert-success">Lesson added successfully!</div>
<?php endif; ?>
<?php if ($errors): ?>
  <div class="alert alert-danger"><?php echo implode('<br>', $errors); ?></div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" class="form-control" name="title" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Order</label>
    <input type="number" class="form-control" name="lesson_order" required min="1">
  </div>
  <div class="mb-3">
    <label class="form-label">Video (MP4)</label>
    <input type="file" class="form-control" name="video" accept="video/mp4">
  </div>
  <div class="mb-3">
    <label class="form-label">PDF (optional)</label>
    <input type="file" class="form-control" name="pdf" accept="application/pdf">
  </div>
  <button type="submit" class="btn btn-primary">Add Lesson</button>
</form>
<?php include '../includes/footer.php'; ?> 