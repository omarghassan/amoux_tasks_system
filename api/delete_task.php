<?php
require_once('config.php');

// Validate request method
validate_request_method('POST');

// Define required fields
$required_fields = ['task_id'];

// Validate request body
$input_data = validate_request_body('POST', $required_fields);

// Extract data
$user_id = $_SESSION['user_id'] ?? null; // Fixed: using correct session variable
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
    // First, verify that the task belongs to the current user and is active
    $check_stmt = $conn->prepare("SELECT id, title FROM tasks WHERE id = ? AND user_id = ? AND status = 1");
    
    if (!$check_stmt) {
        print_response(false, "Database error: " . $conn->error);
    }
    
    $check_stmt->bind_param("ii", $task_id, $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows === 0) {
        print_response(false, "Task not found or access denied.");
    }
    
    $task = $result->fetch_assoc();
    $check_stmt->close();
    
    // Perform soft delete by setting status to 0
    $delete_stmt = $conn->prepare("UPDATE tasks SET status = 0, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND user_id = ?");
    
    if (!$delete_stmt) {
        print_response(false, "Database error: " . $conn->error);
    }
    
    // Bind parameters
    $delete_stmt->bind_param("ii", $task_id, $user_id);
    
    // Execute the statement
    if ($delete_stmt->execute()) {
        // Check if any rows were actually updated
        if ($delete_stmt->affected_rows > 0) {
            // Return success response
            print_response(true, "Task deleted successfully.", [
                'task_id' => $task_id,
                'task_title' => $task['title'],
                'deleted_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            print_response(false, "Task could not be deleted or was already deleted.");
        }
    } else {
        print_response(false, "Failed to delete task: " . $delete_stmt->error);
    }
    
} catch (Exception $e) {
    error_log("Delete task error: " . $e->getMessage());
    print_response(false, "An error occurred while deleting the task.");
} finally {
    if (isset($delete_stmt)) {
        $delete_stmt->close();
    }
}