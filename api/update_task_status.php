<?php
require_once('config.php');

// Validate request method
validate_request_method('POST');

// Define required fields
$required_fields = ['task_id', 'status'];

// Validate request body
$input_data = validate_request_body('POST', $required_fields);

// Extract data
$user_id = $_SESSION['user_id'] ?? null; // Changed from 'id' to 'user_id'
$task_id = (int)$input_data['task_id'];
$new_status = trim($input_data['status']);

// Validate user is logged in
if (!$user_id) {
    print_response(false, "User not authenticated.");
}

// Validate status value
$valid_statuses = ['not_started', 'in_progress', 'completed'];
if (!in_array($new_status, $valid_statuses)) {
    print_response(false, "Invalid status value.");
}

try {
    // First check if task exists and belongs to the user
    $check_stmt = $conn->prepare("SELECT id, task_status FROM tasks WHERE id = ? AND user_id = ? AND status = 1");
    $check_stmt->bind_param("ii", $task_id, $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows === 0) {
        print_response(false, "Task not found or you don't have permission to update it.");
    }
    
    $task = $result->fetch_assoc();
    $check_stmt->close();
    
    // Check if status is actually changing
    if ($task['task_status'] === $new_status) {
        print_response(true, "Task status is already set to " . $new_status . ".");
    }
    
    // Update the task status
    $update_stmt = $conn->prepare("UPDATE tasks SET task_status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ? AND user_id = ?");
    $update_stmt->bind_param("sii", $new_status, $task_id, $user_id);
    
    if ($update_stmt->execute()) {
        // Return success response
        print_response(true, "Task status updated successfully.", [
            'task_id' => $task_id,
            'old_status' => $task['task_status'],
            'new_status' => $new_status
        ]);
    } else {
        print_response(false, "Failed to update task status: " . $update_stmt->error);
    }
    
} catch (Exception $e) {
    error_log("Update task status error: " . $e->getMessage());
    print_response(false, "An error occurred while updating the task status.");
} finally {
    if (isset($update_stmt)) {
        $update_stmt->close();
    }
}