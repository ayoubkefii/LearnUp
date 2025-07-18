<?php include 'includes/header.php'; ?>
<h2>Contact Us</h2>
<form method="post" action="contact.php">
  <div class="mb-3">
    <label for="name" class="form-label">Your Name</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Your Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="mb-3">
    <label for="message" class="form-label">Message</label>
    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Send</button>
</form>
<?php include 'includes/footer.php'; ?> 