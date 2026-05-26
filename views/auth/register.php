<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="auth-wrap">
  <div class="auth-card">
    <h1 class="auth-title">Create account</h1>
    <p class="auth-sub">Fill in the form below to get started.</p>

    <?php if ($error): ?>
      <div class="alert alert-error"><p><?= htmlspecialchars($error) ?></p></div>
    <?php endif; ?>

    <form method="POST" action="/register" novalidate>

      <div class="form-group">
        <label for="name">Full name</label>
        <input
          type="text"
          id="name"
          name="name"
          value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
          placeholder="Jane Doe"
          required
        />
      </div>

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
        <label for="password">Password <span class="hint">(min. 8 characters)</span></label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="••••••••"
          required
          autocomplete="new-password"
        />
      </div>

      <div class="form-group">
        <label for="confirm">Confirm password</label>
        <input
          type="password"
          id="confirm"
          name="confirm"
          placeholder="••••••••"
          required
          autocomplete="new-password"
        />
      </div>

      <button type="submit" class="btn btn-primary btn-full">Create account</button>
    </form>

    <p class="auth-footer">
      Already have an account? <a href="/login">Sign in</a>
    </p>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
