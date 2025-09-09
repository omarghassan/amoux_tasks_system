<?php
// api/set_login_session.php
require_once('config.php');

// === Configuration ===
$request_method = "POST";
$required_fields = ["user_id"];
validate_request_method($request_method);
$data = validate_request_body($request_method, $required_fields);

// === Logic ===
function set_login_session($data) {
    global $conn;

    $user_id = (int)$data['user_id'];

    // Get user information from database
    $sql = "SELECT id, name, email, profile_picture FROM users WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        print_response(false, "User not found.");
    }

    $user = $result->fetch_assoc();

    // Start session and store user data
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_profile_picture'] = $user['profile_picture'];
    $_SESSION['logged_in'] = true;

    print_response(true, "Session set successfully.", $user);
}

// === Execute ===
set_login_session($data);