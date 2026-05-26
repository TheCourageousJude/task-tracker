<?php

/**
 * Task model — all SQL related to the tasks table lives here only.
 */
class Task {

    public function __construct(private PDO $db) {}

    /**
     * Get all tasks for a user.
     * Supports optional status filter and keyword search (Dynamic Feature #2).
     */
    public function allForUser(int $userId, string $filter = '', string $search = ''): array {
        $sql    = 'SELECT * FROM tasks WHERE user_id = :uid';
        $params = ['uid' => $userId];

        if ($filter && $filter !== 'all') {
            $sql .= ' AND status = :status';
            $params['status'] = $filter;
        }

        if ($search) {
            $sql .= ' AND (title LIKE :q OR description LIKE :q)';
            $params['q'] = "%$search%";
        }

        $sql .= ' ORDER BY created_at DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Count tasks grouped by status — used for dashboard stats cards.
     */
    public function countByStatus(int $userId): array {
        $stmt = $this->db->prepare(
            'SELECT status, COUNT(*) AS total FROM tasks WHERE user_id = ? GROUP BY status'
        );
        $stmt->execute([$userId]);

        $result = ['todo' => 0, 'in_progress' => 0, 'done' => 0, 'total' => 0];
        foreach ($stmt->fetchAll() as $row) {
            $result[$row['status']]  = (int) $row['total'];
            $result['total']        += (int) $row['total'];
        }
        return $result;
    }

    /**
     * Find a single task by ID — only returns it if it belongs to this user.
     */
    public function find(int $id, int $userId): array|false {
        $stmt = $this->db->prepare('SELECT * FROM tasks WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    /**
     * Insert a new task record.
     */
    public function create(int $userId, array $d): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO tasks (user_id, title, description, priority, status, due_date)
             VALUES (:uid, :title, :desc, :priority, :status, :due)'
        );
        return $stmt->execute([
            'uid'      => $userId,
            'title'    => $d['title'],
            'desc'     => $d['description'] ?? null,
            'priority' => $d['priority'],
            'status'   => $d['status'],
            'due'      => $d['due_date'] ?: null,
        ]);
    }

    /**
     * Update an existing task — user_id check prevents editing another user's tasks.
     */
    public function update(int $id, int $userId, array $d): bool {
        $stmt = $this->db->prepare(
            'UPDATE tasks
             SET title = :title, description = :desc, priority = :priority,
                 status = :status, due_date = :due
             WHERE id = :id AND user_id = :uid'
        );
        return $stmt->execute([
            'title'    => $d['title'],
            'desc'     => $d['description'] ?? null,
            'priority' => $d['priority'],
            'status'   => $d['status'],
            'due'      => $d['due_date'] ?: null,
            'id'       => $id,
            'uid'      => $userId,
        ]);
    }

    /**
     * Delete a task — user_id check prevents deleting another user's tasks.
     */
    public function delete(int $id, int $userId): bool {
        $stmt = $this->db->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
        return $stmt->execute([$id, $userId]);
    }

    /**
     * Mark a task as done.
     */
    public function markComplete(int $id, int $userId): bool {
        $stmt = $this->db->prepare(
            "UPDATE tasks SET status = 'done' WHERE id = ? AND user_id = ?"
        );
        return $stmt->execute([$id, $userId]);
    }
}
