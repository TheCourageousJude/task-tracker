<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1 class="page-title">Add New Task</h1>
    <p class="page-sub">Fill in the details below to create a new task.</p>
  </div>
  <a href="/" class="btn">&#8592; Back</a>
</div>

<div class="form-card">
  <?php if (!empty($errors)): ?>
    <div class="alert alert-error">
      <?php foreach ($errors as $e): ?>
        <p><?= htmlspecialchars($e) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="/tasks/store" novalidate>

    <div class="form-group">
      <label for="title">Task Title <span class="required">*</span></label>
      <input
        type="text"
        id="title"
        name="title"
        value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
        placeholder="e.g. Write project report"
        required
        maxlength="255"
      />
    </div>

    <div class="form-group">
      <label for="description">Description <span class="hint">(optional)</span></label>
      <textarea
        id="description"
        name="description"
        rows="3"
        placeholder="Add any extra details here…"
      ><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="priority">Priority</label>
        <select id="priority" name="priority">
          <?php foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $val => $label): ?>
            <option value="<?= $val ?>" <?= ($_POST['priority'] ?? 'medium') === $val ? 'selected' : '' ?>>
              <?= $label ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status">
          <?php foreach (['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'] as $val => $label): ?>
            <option value="<?= $val ?>" <?= ($_POST['status'] ?? 'todo') === $val ? 'selected' : '' ?>>
              <?= $label ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="due_date">Due Date <span class="hint">(optional)</span></label>
        <input
          type="date"
          id="due_date"
          name="due_date"
          value="<?= htmlspecialchars($_POST['due_date'] ?? '') ?>"
        />
      </div>
    </div>

    <div class="form-actions">
      <a href="/" class="btn">Cancel</a>
      <button type="submit" class="btn btn-primary">Create Task</button>
    </div>

  </form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
