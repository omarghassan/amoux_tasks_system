<?php

/**
 * Validates the request method.
 * @param string $method Expected request method.
 */
function validate_request_method($method): void {
    if ($_SERVER['REQUEST_METHOD'] != $method) {
        print_response(false, $_SERVER['REQUEST_METHOD'] . " Invalid request method. Expected $method.");
        exit; // Stop further execution
    }
}

/**
 * Validates the request body and ensures the required fields are present.
 * @param string $method Expected request method.
 * @param array $required_fields Array of required fields.
 * @return array The validated request body data.
 */
function validate_request_body($method, $required_fields) {
    switch($method){
        case "POST":
            $input_data = json_decode(file_get_contents('php://input'), true);
            error_log(print_r($input_data, true));  // Log the input data
            break;
        case "GET":
            $input_data = $_GET;
            break;
        default:
            print_response(false, "Invalid request method. Expected $method.");
    }

    // For GET requests, check if parameters are empty (if expected parameters are not provided)
    if ($method === "GET" && empty($input_data) && !empty($required_fields)) {
        print_response(false, "No query parameters provided.");
    }

    // Check for missing fields (only for POST requests)
    if ($method === "POST") {
        foreach ($required_fields as $field) {
            if (!isset($input_data[$field])) {
                print_response(false, "Missing required field: $field.");
            }            
        }
    }

    return $input_data;
}


/**
 * Function to print a standardized API response as an object.
 *
 * @param bool $success Whether the request was successful.
 * @param string $message A message describing the result.
 * @param array|null $data Additional data to include in the response (optional).
 */
function print_response(bool $success, string $message, ?array $data = null): void {
    // Create the response object
    $response = (object) [
        'success' => $success,
        'message' => $message,
        'data' => $data
    ];

    // Set content type to JSON
    header('Content-Type: application/json');

    // Print the response as JSON
    echo json_encode($response);

    // Stop further script execution
    exit();
}
