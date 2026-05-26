<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Task Tracker</title>
  <link rel="stylesheet" href="/css/style.css" />
</head>
<body>

<nav class="navbar">
  <a class="brand" href="/">Task Tracker</a>
  <?php if (!empty($_SESSION['user_id'])): ?>
  <div class="nav-right">
    <span class="nav-user">Hello, <?= htmlspecialchars($_SESSION['name']) ?></span>
    <form method="POST" action="/logout" style="display:inline">
      <button type="submit" class="btn btn-sm">Sign out</button>
    </form>
  </div>
  <?php endif; ?>
</nav>

<main class="container">

<?php if (!empty($_SESSION['success'])): ?>
  <div class="alert alert-success">
    <?= htmlspecialchars($_SESSION['success']) ?>
    <?php unset($_SESSION['success']); ?>
  </div>
<?php endif; ?>

<?php if (!empty($_SESSION['errors'])): ?>
  <div class="alert alert-error">
    <?php foreach ($_SESSION['errors'] as $e): ?>
      <p><?= htmlspecialchars($e) ?></p>
    <?php endforeach; unset($_SESSION['errors']); ?>
  </div>
<?php endif; ?>
