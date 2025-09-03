<?php
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

    // Check if user exists
    $sql = "SELECT id, name, email, password_hash FROM users WHERE email = '$email' AND status = 1 LIMIT 1";
    $res = mysqli_query($conn, $sql);

    if (!$res || mysqli_num_rows($res) === 0) {
        print_response(false, "Invalid email or account doesn't exist.");
    }

    $user = mysqli_fetch_assoc($res);

    // Check password
    if (!password_verify($password, $user['password_hash'])) {
        print_response(false, "Incorrect password.");
    }

    // Optionally generate token or session (if needed)
    unset($user['password_hash']);

    print_response(true, "Login successful.", $user);
}

// === Execute ===
login($data);
