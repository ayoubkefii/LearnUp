<?php
include '../includes/auth.php';
require_login();
require_role('instructor');
include '../includes/db.php';
include '../includes/header.php';

$errors = [];
$success = false;

// Fetch categories
$categories = [];
$res = $conn->query('SELECT id, name FROM categories');
while ($row = $res->fetch_assoc()) {
    $categories[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $category_id = $_POST['category_id'];
    $description = trim($_POST['description']);
    $instructor_id = $_SESSION['user_id'];
    $thumbnail = '';

    if (!$title || !$category_id || !$description) {
        $errors[] = 'All fields are required.';
    }

    // Handle thumbnail upload
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            $errors[] = 'Thumbnail must be a JPG or PNG image.';
        } else {
            $filename = uniqid('thumb_') . '.' . $ext;
            $dest = '../uploads/' . $filename;
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $dest)) {
                $thumbnail = $filename;
            } else {
                $errors[] = 'Failed to upload thumbnail.';
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO courses (title, category_id, description, thumbnail, instructor_id) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sisss', $title, $category_id, $description, $thumbnail, $instructor_id);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = 'Failed to create course.';
        }
        $stmt->close();
    }
}
?>
<h2>Create New Course</h2>
<?php if ($success): ?>
  <div class="alert alert-success">Course created successfully! Awaiting admin approval.</div>
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
    <label class="form-label">Category</label>
    <select class="form-select" name="category_id" required>
      <option value="">Select category</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea class="form-control" name="description" rows="4" required></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Thumbnail (JPG/PNG)</label>
    <input type="file" class="form-control" name="thumbnail" accept="image/*">
  </div>
  <button type="submit" class="btn btn-primary">Create Course</button>
</form>
<?php include '../includes/footer.php'; ?> 