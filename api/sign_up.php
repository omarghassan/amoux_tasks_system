<?php
// api/signup.php
require_once('config.php');

// Validate request method (POST only)
validate_request_method('POST');

// Validate request body and required fields
$required_fields = ['name', 'email', 'password'];
$input = validate_request_body('POST', $required_fields);

try {
    // Extract and validate required fields
    $name = isset($input['name']) ? trim($input['name']) : '';
    $email = isset($input['email']) ? trim($input['email']) : '';
    $password = isset($input['password']) ? trim($input['password']) : '';
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    } elseif (strlen($name) < 2) {
        $errors[] = 'Name must be at least 2 characters long';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($password)) {
        $errors[] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long';
    }
    
    // Return validation errors if any
    if (!empty($errors)) {
        print_response(false, 'Validation failed', ['errors' => $errors]);
    }
    
    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        print_response(false, 'Email already exists');
    }
    $check_stmt->close();
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $insert_stmt = $conn->prepare("INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $insert_stmt->bind_param("sss", $name, $email, $hashed_password);
    
    if ($insert_stmt->execute()) {
        $user_id = $conn->insert_id;
        
        // Return success response with user data (excluding password)
        $user_data = [
            'id' => $user_id,
            'name' => $name,
            'email' => $email,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        print_response(true, 'User registered successfully', ['user' => $user_data]);
    } else {
        error_log("Database error during user registration: " . $insert_stmt->error);
        print_response(false, 'Registration failed. Please try again.');
    }
    
    $insert_stmt->close();
    
} catch (Exception $e) {
    error_log("Exception in signup API: " . $e->getMessage());
    print_response(false, 'An error occurred during registration');
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
