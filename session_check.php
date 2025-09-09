<?php
// session_check.php - Include this at the top of pages that require authentication

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Make user data available to the page
$current_user = [
    'id' => $_SESSION['user_id'] ?? null,
    'name' => $_SESSION['user_name'] ?? 'User',
    'email' => $_SESSION['user_email'] ?? '',
    'profile_picture' => $_SESSION['user_profile_picture'] ?? null
];

// Function to get user's first name
function getFirstName($fullName) {
    $names = explode(' ', trim($fullName));
    return $names[0];
}

// Function to get profile picture or default
function getProfilePicture($profilePicture) {
    if ($profilePicture && file_exists($profilePicture)) {
        return $profilePicture;
    }
    // Default profile picture
    return "https://avatarfiles.alphacoders.com/159/159787.png";
}