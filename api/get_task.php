<?php
require_once('config.php');

// Validate request method
validate_request_method('GET');

// Define required fields
$required_fields = ['task_id'];

// Validate request body
$input_data = validate_request_body('GET', $required_fields);

// Extract data
$user_id = $_SESSION['id'] ?? null;
$task_id = (int)$input_data['task_id'];

// Validate user is logged in
if (!$user_id) {
    print_response(false, "User not authenticated.");
}

// Validate task ID
if ($task_id <= 0) {
    print_response(false, "Invalid task ID.");
}

try {
    // Prepare SQL statement to get task
    $stmt = $conn->prepare("SELECT id, title, date, priority, description, task_status, created_at, updated_at FROM tasks WHERE id = ? AND user_id = ? AND status = 1");
    
    if (!$stmt) {
        print_response(false, "Database error: " . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("ii", $task_id, $user_id);
    
    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        print_response(false, "Task not found or access denied.");
    }
    
    $task = $result->fetch_assoc();
    
    // Return success response with task data
    print_response(true, "Task retrieved successfully.", [
        'task' => $task
    ]);
    
} catch (Exception $e) {
    error_log("Get task error: " . $e->getMessage());
    print_response(false, "An error occurred while retrieving the task.");
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
}