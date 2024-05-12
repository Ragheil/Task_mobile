<?php
header('Content-Type: application/json'); // Set header to indicate JSON response

class Admin_Class {
    public static $db;

    public static function initDatabase() {
        // Database connection settings
        $host_name = 'localhost';
        $user_name = 'root';
        $password = '';
        $db_name = 'etms_db';

        try {
            // Connect to the database using PDO
            self::$db = new PDO("mysql:host={$host_name};dbname={$db_name}", $user_name, $password);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle database connection error
            die(json_encode(array('success' => false, 'message' => 'Database connection error')));
        }
    }

    // Method to sanitize form input data
    public static function test_form_input_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Admin Login Check
    public static function admin_login_check($data) {
        self::initDatabase(); // Initialize database connection

        $username = self::test_form_input_data($data['username']);
        $password = self::test_form_input_data($data['admin_password']);

        // Hash the password (use a more secure hashing algorithm than md5)
        $hashed_password = md5($password);

        try {
            $stmt = self::$db->prepare("SELECT * FROM tbl_admin WHERE username = :uname AND password = :upass LIMIT 1");
            $stmt->execute(array(':uname' => $username, ':upass' => $hashed_password));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userRow) {
                // Start session and store user information
                session_start();
                $_SESSION['admin_id'] = $userRow['user_id'];
                $_SESSION['name'] = $userRow['fullname'];
                $_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
                $_SESSION['user_role'] = $userRow['user_role'];
                $_SESSION['temp_password'] = $userRow['temp_password'];

                // Return success response
                echo json_encode(array('success' => true, 'message' => 'Login successful'));
            } else {
                // Return error response
                echo json_encode(array('success' => false, 'message' => 'Invalid username or password'));
            }
        } catch (PDOException $e) {
            // Handle database error
            echo json_encode(array('success' => false, 'message' => 'Database error: ' . $e->getMessage()));
        }
    }
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);

    // Call admin_login_check method with the received data
    Admin_Class::admin_login_check($data);
} else {
    // Handle unsupported request method
    echo json_encode(array('success' => false, 'message' => 'Unsupported request method'));
}
?>
