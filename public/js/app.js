/**
 * app.js — Task Tracker frontend
 *
 * Dynamic Feature #4: AJAX delete
 * Removes a task card from the page instantly without a full reload.
 */

document.addEventListener('DOMContentLoaded', () => {

  // ── AJAX DELETE ───────────────────────────────────────────────────────────
  document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      if (!confirm('Are you sure you want to delete this task?')) return;

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const data = await response.json();

        if (data.success) {
          // Find the task card and animate it out
          const card = form.closest('.task-card');
          card.style.transition = 'opacity .25s, transform .25s';
          card.style.opacity = '0';
          card.style.transform = 'translateX(20px)';
          setTimeout(() => card.remove(), 260);

          // Update the total count in the stats bar if present
          const totalEl = document.querySelector('.stats-grid .stat-card:first-child .stat-num');
          if (totalEl) totalEl.textContent = Math.max(0, parseInt(totalEl.textContent) - 1);
        }
      } catch (err) {
        // Fallback: submit the form normally if AJAX fails
        form.submit();
      }
    });
  });

  // ── CLIENT-SIDE VALIDATION (bonus — server also validates) ────────────────
  document.querySelectorAll('form[novalidate]').forEach(form => {
    form.addEventListener('submit', (e) => {
      const titleInput = form.querySelector('input[name="title"]');
      if (titleInput && !titleInput.value.trim()) {
        e.preventDefault();
        titleInput.style.borderColor = '#A32D2D';
        titleInput.focus();

        // Show inline error if not already present
        if (!form.querySelector('.inline-error')) {
          const err = document.createElement('p');
          err.className = 'inline-error';
          err.style.cssText = 'color:#A32D2D;font-size:.8rem;margin-top:.25rem';
          err.textContent = 'Task title is required.';
          titleInput.after(err);
        }
        return;
      }
    });
  });

});
