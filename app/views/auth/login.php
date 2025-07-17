<div style="background-color: cyan; padding: 2rem; border-radius: 8px; max-width: 500px; margin: 2rem auto;">
  <h1 class="text-center mb-4">Login</h1>

  <?php if (!empty($message)): ?>
    <div class="alert alert-danger text-center" style="max-width: 400px; margin: 0 auto 1rem auto;">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <form action="/PHP_mini_Project/public/auth/login" method="POST" style="max-width: 400px; margin: auto;">
    <div class="form-group mb-3">
      <label for="username">Username</label>
      <input
        type="text"
        class="form-control"
        id="username"
        name="username"
        required
      >
    </div>

    <div class="form-group mb-3">
      <label for="password">Password</label>
      <input
        type="password"
        class="form-control"
        id="password"
        name="password"
        required
      >
    </div>
    
    <div class="form-check mb-3">
      <input
        type="checkbox"
        class="form-check-input"
        id="remember"
        name="remember"
      >
      <label class="form-check-label" for="remember">Remember me</label>
    </div>

    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>
</div>
