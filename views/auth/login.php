<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="auth-wrap">
  <div class="auth-card">
    <h1 class="auth-title">Sign in</h1>
    <p class="auth-sub">Welcome back! Enter your credentials to continue.</p>

    <?php if ($error): ?>
      <div class="alert alert-error"><p><?= htmlspecialchars($error) ?></p></div>
    <?php endif; ?>

    <form method="POST" action="/login" novalidate>

      <div class="form-group">
        <label for="email">Email address</label>
        <input
          type="email"
          id="email"
          name="email"
          value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
          placeholder="you@example.com"
          required
          autocomplete="email"
        />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="••••••••"
          required
          autocomplete="current-password"
        />
      </div>

      <button type="submit" class="btn btn-primary btn-full">Sign in</button>
    </form>

    <p class="auth-footer">
      Don&apos;t have an account? <a href="/register">Register here</a>
    </p>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
