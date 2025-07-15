<?php
include '../includes/auth.php';
require_login();
require_role('student');
include '../includes/db.php';
include '../includes/header.php';

// Fetch categories
$categories = [];
$res = $conn->query('SELECT id, name FROM categories');
while ($row = $res->fetch_assoc()) {
    $categories[] = $row;
}

// Handle search/filter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$cat_id = isset($_GET['category']) ? intval($_GET['category']) : 0;

$sql = "SELECT c.*, u.name AS instructor, cat.name AS category FROM courses c LEFT JOIN users u ON c.instructor_id = u.id LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.status = 'approved'";
$params = [];
if ($search) {
    $sql .= " AND c.title LIKE ?";
    $params[] = "%$search%";
}
if ($cat_id) {
    $sql .= " AND c.category_id = ?";
    $params[] = $cat_id;
}
$stmt = $conn->prepare($sql . ' ORDER BY c.created_at DESC');
if ($params) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$res = $stmt->get_result();
?>
<h2>Browse Courses</h2>
<form class="row mb-4" method="get">
  <div class="col-md-4">
    <input type="text" class="form-control" name="search" placeholder="Search by title" value="<?php echo htmlspecialchars($search); ?>">
  </div>
  <div class="col-md-4">
    <select class="form-select" name="category">
      <option value="">All Categories</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?php echo $cat['id']; ?>" <?php if ($cat_id == $cat['id']) echo 'selected'; ?>><?php echo htmlspecialchars($cat['name']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-4">
    <button type="submit" class="btn btn-primary">Search</button>
  </div>
</form>
<div class="row">
  <?php while ($row = $res->fetch_assoc()): ?>
    <div class="col-md-4">
      <div class="card mb-4">
        <img src="/uploads/<?php echo htmlspecialchars($row['thumbnail']); ?>" class="card-img-top" alt="Course Thumbnail">
        <div class="card-body">
          <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
          <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
          <p class="card-text"><small>By <?php echo htmlspecialchars($row['instructor']); ?> | <?php echo htmlspecialchars($row['category']); ?></small></p>
          <a href="course_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Course</a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>
<?php include '../includes/footer.php'; ?> 