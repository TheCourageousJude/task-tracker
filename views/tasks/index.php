<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1 class="page-title">My Tasks</h1>
    <p class="page-sub">Manage and track all your tasks in one place.</p>
  </div>
  <a href="/tasks/create" class="btn btn-primary">+ Add Task</a>
</div>

<!-- ── STATS CARDS ─────────────────────────────────────────────────── -->
<div class="stats-grid">
  <div class="stat-card">
    <span class="stat-num"><?= $stats['total'] ?></span>
    <span class="stat-lbl">Total</span>
  </div>
  <div class="stat-card">
    <span class="stat-num"><?= $stats['todo'] ?></span>
    <span class="stat-lbl">To Do</span>
  </div>
  <div class="stat-card">
    <span class="stat-num"><?= $stats['in_progress'] ?></span>
    <span class="stat-lbl">In Progress</span>
  </div>
  <div class="stat-card stat-card--done">
    <span class="stat-num"><?= $stats['done'] ?></span>
    <span class="stat-lbl">Completed</span>
  </div>
</div>

<!-- ── SEARCH & FILTER (Dynamic Feature #2) ─────────────────────────── -->
<form method="GET" action="/" class="search-bar">
  <input
    type="text"
    name="q"
    class="search-input"
    placeholder="Search tasks…"
    value="<?= htmlspecialchars($search) ?>"
  />
  <select name="filter" class="filter-select">
    <?php foreach (['all' => 'All Tasks', 'todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'] as $val => $label): ?>
      <option value="<?= $val ?>" <?= $filter === $val ? 'selected' : '' ?>>
        <?= $label ?>
      </option>
    <?php endforeach; ?>
  </select>
  <button type="submit" class="btn">Search</button>
  <?php if ($search || $filter !== 'all'): ?>
    <a href="/" class="btn">Clear</a>
  <?php endif; ?>
</form>

<!-- ── TASK LIST ──────────────────────────────────────────────────────── -->
<div class="task-list" id="task-list">
  <?php if (empty($tasks)): ?>
    <div class="empty-state">
      <p class="empty-icon">📭</p>
      <p class="empty-text">No tasks found.</p>
      <a href="/tasks/create" class="btn btn-primary">Add your first task</a>
    </div>
  <?php endif; ?>

  <?php foreach ($tasks as $t): ?>
  <div class="task-card <?= $t['status'] === 'done' ? 'task-card--done' : '' ?>" id="task-<?= $t['id'] ?>">

    <div class="task-info">
      <h3 class="task-title"><?= htmlspecialchars($t['title']) ?></h3>

      <?php if ($t['description']): ?>
        <p class="task-desc"><?= htmlspecialchars($t['description']) ?></p>
      <?php endif; ?>

      <div class="task-meta">
        <span class="badge badge--<?= $t['priority'] ?>"><?= ucfirst($t['priority']) ?></span>
        <span class="badge badge--<?= $t['status'] ?>"><?= ucfirst(str_replace('_', ' ', $t['status'])) ?></span>
        <?php if ($t['due_date']): ?>
          <span class="badge badge--due">Due: <?= htmlspecialchars($t['due_date']) ?></span>
        <?php endif; ?>
      </div>
    </div>

    <div class="task-actions">
      <?php if ($t['status'] !== 'done'): ?>
      <form method="POST" action="/tasks/<?= $t['id'] ?>/complete">
        <button type="submit" class="btn btn-success btn-sm" title="Mark as done">&#10003; Done</button>
      </form>
      <?php endif; ?>

      <a href="/tasks/<?= $t['id'] ?>/edit" class="btn btn-sm">Edit</a>

      <!-- AJAX delete form (Dynamic Feature #4) -->
      <form
        method="POST"
        action="/tasks/<?= $t['id'] ?>/delete"
        class="delete-form"
        data-id="<?= $t['id'] ?>"
      >
        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
      </form>
    </div>

  </div>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
