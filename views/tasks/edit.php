<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
  <div>
    <h1 class="page-title">Edit Task</h1>
    <p class="page-sub">Update the details of your task below.</p>
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

  <form method="POST" action="/tasks/<?= $task['id'] ?>/update" novalidate>

    <div class="form-group">
      <label for="title">Task Title <span class="required">*</span></label>
      <input
        type="text"
        id="title"
        name="title"
        value="<?= htmlspecialchars($task['title']) ?>"
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
      ><?= htmlspecialchars($task['description'] ?? '') ?></textarea>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="priority">Priority</label>
        <select id="priority" name="priority">
          <?php foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $val => $label): ?>
            <option value="<?= $val ?>" <?= $task['priority'] === $val ? 'selected' : '' ?>>
              <?= $label ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status">
          <?php foreach (['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'] as $val => $label): ?>
            <option value="<?= $val ?>" <?= $task['status'] === $val ? 'selected' : '' ?>>
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
          value="<?= htmlspecialchars($task['due_date'] ?? '') ?>"
        />
      </div>
    </div>

    <div class="form-actions">
      <a href="/" class="btn">Cancel</a>
      <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>

  </form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
