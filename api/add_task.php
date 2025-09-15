<?php
// Start session at the very beginning
session_start();

require_once('config.php');

// Validate request method
validate_request_method('POST');

// Define required fields
$required_fields = ['title', 'date', 'priority', 'description'];

// Validate request body
$input_data = validate_request_body('POST', $required_fields);

// Extract data
// Fix: Use the correct session variable name
$user_id = $_SESSION['user_id'] ?? null; // Changed from 'id' to 'user_id'
$title = trim($input_data['title']);
$date = $input_data['date'];
$priority = $input_data['priority'];
$description = trim($input_data['description']);

// Validate user is logged in
if (!$user_id) {
    // Enhanced debugging
    error_log("Session data: " . print_r($_SESSION, true));
    print_response(false, "User not authenticated.");
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
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, date, priority, description, task_status) VALUES (?, ?, ?, ?, ?, 'not_started')");
    
    if (!$stmt) {
        print_response(false, "Database error: " . $conn->error);
    }
    
    // Bind parameters
    $stmt->bind_param("issss", $user_id, $title, $date, $priority, $description);
    
    // Execute the statement
    if ($stmt->execute()) {
        $task_id = $conn->insert_id;
        
        // Return success response with task data
        print_response(true, "Task added successfully.", [
            'task_id' => $task_id,
            'title' => $title,
            'date' => $date,
            'priority' => $priority,
            'description' => $description
        ]);
    } else {
        print_response(false, "Failed to add task: " . $stmt->error);
    }
    
} catch (Exception $e) {
    error_log("Add task error: " . $e->getMessage());
    print_response(false, "An error occurred while adding the task.");
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
}