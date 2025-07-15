<?php
include '../includes/auth.php';
require_login();
require_role('student');
include '../includes/db.php';

$student_id = $_SESSION['user_id'];
$course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;

if ($course_id) {
    // Check if already enrolled
    $stmt = $conn->prepare('SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?');
    $stmt->bind_param('ii', $student_id, $course_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 0) {
        $stmt->close();
        $stmt = $conn->prepare('INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)');
        $stmt->bind_param('ii', $student_id, $course_id);
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt->close();
    }
}
header('Location: course_detail.php?id=' . $course_id);
exit(); 