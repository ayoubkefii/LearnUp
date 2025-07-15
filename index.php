<?php include 'includes/header.php'; ?>
<div class="jumbotron text-center bg-primary text-white p-5 mb-4">
  <h1 class="display-4">Welcome to LearnUp!</h1>
  <p class="lead">Your platform to learn, teach, and grow. Browse courses, enroll, and track your progress.</p>
  <a href="login.php" class="btn btn-light btn-lg">Login</a>
  <a href="register.php" class="btn btn-outline-light btn-lg">Register</a>
</div>
<h2 class="mb-4">Featured Courses</h2>
<div class="row">
  <!-- Featured courses will be dynamically loaded here -->
  <div class="col-md-4">
    <div class="card mb-4">
      <img src="assets/images/sample-course.jpg" class="card-img-top" alt="Sample Course">
      <div class="card-body">
        <h5 class="card-title">Sample Course</h5>
        <p class="card-text">This is a sample course description.</p>
        <a href="#" class="btn btn-primary">View Course</a>
      </div>
    </div>
  </div>
  <!-- Repeat for more courses -->
</div>
<?php include 'includes/footer.php'; ?> 