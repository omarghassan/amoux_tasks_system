<?php
require_once('config.php');

// Validate request method
validate_request_method('POST');

// Define required fields
$required_fields = ['task_id', 'title', 'date', 'priority', 'description'];

// Validate request body
$input_data = validate_request_body('POST', $required_fields);

// Extract data
$user_id = $_SESSION['id'] ?? null;
$task_id = (int)$input_data['task_id'];
$title = trim($input_data['title']);
$date = $input_data['date'];
$priority = $input_data['priority'];
$description = trim($input_data['description']);

// Validate user is logged in
if (!$user_id) {
    print_response(false, "User not authenticated.");
}

// Validate task ID
if ($task_id <= 0) {
    print_response(false, "Invalid task ID.");
}

// Validate priority value
$valid_priorities = ['extreme', 'moderate', 'low'];
if (!in_array($priority, $valid_priorities)) {
    print_response(false, "Invalid priority value.");
}

// Validate date format (YYYY-MM-DD)
if (!DateTime::createFromFormat('Y-m-d', $date)) {
    print_response(false, "Invalid date format. Use YYYY-MM-DD.");
}

try {
    // First, verify that the task belongs to the current user
    $check_stmt = $conn->prepare("SELECT id FROM tasks WHERE id = ? AND user_id = ? AND status = 1");
    
    if (!$check_stmt) {
        print_response(false, "Database error: " . $conn->error);
    }
    
    $check_stmt->bind_param("ii", $task_id, $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows === 0) {
        print_response(false, "Task not found or access denied.");
    }
    
    $check_stmt->close();
    
    // Prepare SQL statement for update
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, date = ?, priority = ?, description = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND user_id = ?");
    
    if (!$stmt) {
        print_response(false, "Database error: " . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("ssssii", $title, $date, $priority, $description, $task_id, $user_id);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Check if any rows were actually updated
        if ($stmt->affected_rows > 0) {
            // Return success response with updated task data
            print_response(true, "Task updated successfully.", [
                'task_id' => $task_id,
                'title' => $title,
                'date' => $date,
                'priority' => $priority,
                'description' => $description,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            print_response(false, "No changes were made to the task.");
        }
    } else {
        print_response(false, "Failed to update task: " . $stmt->error);
    }
    
} catch (Exception $e) {
    error_log("Edit task error: " . $e->getMessage());
    print_response(false, "An error occurred while updating the task.");
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
}