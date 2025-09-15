<?php
require_once('config.php');

// Validate request method
validate_request_method('GET');

// Get user ID from session
$user_id = $_SESSION['user_id'] ?? null;

// Validate user is logged in
if (!$user_id) {
    print_response(false, "User not authenticated.");
}

try {
    // Get all tasks for the user
    $tasks_stmt = $conn->prepare("SELECT id, title, description, priority, task_status, date, created_at FROM tasks WHERE user_id = ? AND status = 1 ORDER BY created_at DESC");
    $tasks_stmt->bind_param("i", $user_id);
    $tasks_stmt->execute();
    $tasks_result = $tasks_stmt->get_result();
    
    $tasks = [];
    while ($row = $tasks_result->fetch_assoc()) {
        $tasks[] = $row;
    }
    
    // Get task statistics
    $stats_stmt = $conn->prepare("SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN task_status = 'completed' THEN 1 ELSE 0 END) as completed,
        SUM(CASE WHEN task_status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
        SUM(CASE WHEN task_status = 'not_started' THEN 1 ELSE 0 END) as not_started
        FROM tasks WHERE user_id = ? AND status = 1");
    $stats_stmt->bind_param("i", $user_id);
    $stats_stmt->execute();
    $stats_result = $stats_stmt->get_result();
    $stats = $stats_result->fetch_assoc();
    
    // Calculate percentages
    $total = (int)$stats['total'];
    if ($total > 0) {
        $completed_percent = round((int)$stats['completed'] / $total * 100);
        $in_progress_percent = round((int)$stats['in_progress'] / $total * 100);
        $not_started_percent = round((int)$stats['not_started'] / $total * 100);
    } else {
        $completed_percent = 0;
        $in_progress_percent = 0;
        $not_started_percent = 0;
    }
    
    $task_stats = [
        'total' => $total,
        'completed' => (int)$stats['completed'],
        'in_progress' => (int)$stats['in_progress'],
        'not_started' => (int)$stats['not_started'],
        'completed_percent' => $completed_percent,
        'in_progress_percent' => $in_progress_percent,
        'not_started_percent' => $not_started_percent
    ];
    
    print_response(true, "Tasks retrieved successfully.", [
        'tasks' => $tasks,
        'stats' => $task_stats
    ]);
    
} catch (Exception $e) {
    error_log("Get tasks error: " . $e->getMessage());
    print_response(false, "An error occurred while retrieving tasks.");
} finally {
    if (isset($tasks_stmt)) $tasks_stmt->close();
    if (isset($stats_stmt)) $stats_stmt->close();
}