<?php

require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../middleware/auth.php';

/**
 * TaskController — handles all CRUD operations for tasks.
 * Every method calls requireAuth() first to guard against unauthenticated access.
 */
class TaskController {

    private Task $task;

    public function __construct() {
        $this->task = new Task(getDB());
    }

    // ── INDEX (Dashboard) ─────────────────────────────────────────────────
    // GET / → show all tasks with stats, search, and filter
    public function index(): void {
        requireAuth();
        $userId = (int) $_SESSION['user_id'];
        $filter = $_GET['filter'] ?? 'all';
        $search = trim($_GET['q'] ?? '');
        $tasks  = $this->task->allForUser($userId, $filter, $search);
        $stats  = $this->task->countByStatus($userId);
        require __DIR__ . '/../views/tasks/index.php';
    }

    // ── CREATE ────────────────────────────────────────────────────────────
    // GET /tasks/create → show the add-task form
    public function create(): void {
        requireAuth();
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);
        require __DIR__ . '/../views/tasks/create.php';
    }

    // ── STORE ─────────────────────────────────────────────────────────────
    // POST /tasks/store → validate and save a new task
    public function store(): void {
        requireAuth();
        $errors = $this->validateTask($_POST);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            header('Location: /tasks/create');
            exit;
        }

        $this->task->create((int) $_SESSION['user_id'], $_POST);
        $_SESSION['success'] = 'Task created successfully!';
        header('Location: /');
        exit;
    }

    // ── EDIT ──────────────────────────────────────────────────────────────
    // GET /tasks/{id}/edit → show the edit form pre-filled with task data
    public function edit(int $id): void {
        requireAuth();
        $task = $this->task->find($id, (int) $_SESSION['user_id']);
        if (!$task) {
            http_response_code(404);
            die('<h2>Task not found.</h2><a href="/">Go back</a>');
        }
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);
        require __DIR__ . '/../views/tasks/edit.php';
    }

    // ── UPDATE ────────────────────────────────────────────────────────────
    // POST /tasks/{id}/update → save changes to an existing task
    public function update(int $id): void {
        requireAuth();
        $errors = $this->validateTask($_POST);

        if ($errors) {
            $_SESSION['errors'] = $errors;
            header("Location: /tasks/$id/edit");
            exit;
        }

        $this->task->update($id, (int) $_SESSION['user_id'], $_POST);
        $_SESSION['success'] = 'Task updated successfully!';
        header('Location: /');
        exit;
    }

    // ── DELETE ────────────────────────────────────────────────────────────
    // POST /tasks/{id}/delete → delete a task
    // Supports AJAX (Dynamic Feature #4): returns JSON if X-Requested-With header is set
    public function delete(int $id): void {
        requireAuth();
        $this->task->delete($id, (int) $_SESSION['user_id']);

        // AJAX request → return JSON so JS can remove the card instantly
        if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        }

        header('Location: /');
        exit;
    }

    // ── COMPLETE ──────────────────────────────────────────────────────────
    // POST /tasks/{id}/complete → mark a task as done
    public function complete(int $id): void {
        requireAuth();
        $this->task->markComplete($id, (int) $_SESSION['user_id']);
        header('Location: /');
        exit;
    }

    // ── VALIDATION ────────────────────────────────────────────────────────
    // Server-side input validation — Dynamic Feature #3
    private function validateTask(array $data): array {
        $errors = [];

        if (empty(trim($data['title'] ?? ''))) {
            $errors[] = 'Task title is required.';
        } elseif (strlen($data['title']) > 255) {
            $errors[] = 'Task title must be under 255 characters.';
        }

        $validPriority = ['low', 'medium', 'high'];
        if (!in_array($data['priority'] ?? '', $validPriority, true)) {
            $errors[] = 'Please select a valid priority.';
        }

        $validStatus = ['todo', 'in_progress', 'done'];
        if (!in_array($data['status'] ?? '', $validStatus, true)) {
            $errors[] = 'Please select a valid status.';
        }

        return $errors;
    }
}
