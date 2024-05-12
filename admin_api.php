<?php
// admin_api.php

// Include your Admin_Class
require_once 'Admin_Class.php';

// Create an instance of the Admin_Class
$admin = new Admin_Class();

// Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check the action parameter sent with the request
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // Perform different actions based on the action parameter
        switch ($action) {
            case 'admin_login':
                // Handle admin login
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $data = array(
                        'username' => $_POST['username'],
                        'admin_password' => $_POST['password']
                    );
                    $result = $admin->admin_login_check($data);
                    echo json_encode($result);
                }
                break;
            case 'add_new_user':
                // Handle adding a new user
                if (isset($_POST['em_fullname']) && isset($_POST['em_username']) && isset($_POST['em_email'])) {
                    $data = array(
                        'em_fullname' => $_POST['em_fullname'],
                        'em_username' => $_POST['em_username'],
                        'em_email' => $_POST['em_email']
                        // Add other required parameters here
                    );
                    $result = $admin->add_new_user($data);
                    echo json_encode($result);
                }
                break;
            // Add more cases for other actions
            default:
                echo json_encode(array('error' => 'Invalid action'));
                break;
        }
    } else {
        echo json_encode(array('error' => 'Action parameter missing'));
    }
} else {
    echo json_encode(array('error' => 'Invalid request method'));
}
?>
