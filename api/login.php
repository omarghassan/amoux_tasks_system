<?php
// api/login.php
require_once('config.php');

// === Configuration ===
$request_method = "POST";
$required_fields = ["email", "password"];
validate_request_method($request_method);
$data = validate_request_body($request_method, $required_fields);

// === Logic ===
function login($data) {
    global $conn;

    $email = mysqli_real_escape_string($conn, trim($data['email']));
    $password = trim($data['password']);

    // Check if user exists (adapted to your DB structure)
    $sql = "SELECT id, name, email, password FROM users WHERE email = '$email' LIMIT 1";
    $res = mysqli_query($conn, $sql);

    if (!$res || mysqli_num_rows($res) === 0) {
        print_response(false, "Invalid email or account doesn't exist.");
    }

    $user = mysqli_fetch_assoc($res);

    // Check password (using your 'password' column)
    if (!password_verify($password, $user['password'])) {
        print_response(false, "Incorrect password.");
    }

    // Remove password from response for security
    unset($user['password']);

    print_response(true, "Login successful.", $user);
}

// === Execute ===
login($data);
?>