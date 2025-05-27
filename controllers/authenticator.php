<?php
    include_once __DIR__ . '/../models/database_connector.php';
    include_once __DIR__ . '/../controllers/utils.php'; // Include utility functions
    include_once __DIR__ . '/../controllers/usrs_con.php';

    class authentication {
        private $db_conn;
        private $utils;
        public $user_controller;

        // constructor to initialize db connection
        public function __construct($db) {
            $this->db_conn = $db;
            $this->utils = new Utils(); // Initialize utility functions
            $this->user_controller = new UserCnt($db);
        }

        public function login() {
            // Check if the request method is POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = trim($_POST['username']); // Remove whitespace
                $password = $_POST['password'];

                // Check credentials in the database
                $q = "SELECT * FROM users_login_inf WHERE username = :username";
                $sql = $this->db_conn->prepare($q);
                $sql->bindParam(':username', $username);
                $sql->execute();

                if ($sql->rowCount() > 0) {
                    // Fetch user data
                    $user = $sql->fetch(PDO::FETCH_ASSOC);

                    // Debugging: display user information
                    error_log(print_r($user, true)); // Display user information
                    
                    // Verify password with hash from database
                    if (password_verify($password, $user['password'])) {
                        // Store user information in session
                        $_SESSION['user_id'] = $user['id']; // Store user ID
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['role'] = $user['role'];
                        $_SESSION['is_logged_in'] = 'true';

                        // Redirect based on role
                        if ($user['role'] === 'admin') {
                            $this->utils->Redirect('admin_page.php'); // Redirect to admin dashboard
                        } else {
                            $this->utils->Redirect('products_page.php'); // Redirect to user dashboard
                        }
                    } else {
                        error_log("Password does not match for user: $username"); // Add log
                        return "Wrong password, please try again"; // Return error message
                    }
                } else {
                    error_log("User not found: $username"); // Add log
                    return "Wrong username, please try again"; // Return error message
                }
            }
            
            return null; // Return null if no error
        }

        public function register() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);

                // check if the username is exist
                if ($this->CheckUsername($username) == true) {
                    error_log("User already exist: $username"); // Add log
                    return "Wrong username, please try again"; // Return error message
                } else {
                    // add new user
                    $add = $this->user_controller->AddUser($username, $password);
                }

                if ($add) {
                    return 'Register Success, Please login';
                }
            }
            return null;
        }

        public function CheckUsername($username) {
            $q = 'SELECT username FROM users_login_inf WHERE username = :username' ;
            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':username', $username);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                return true;
            }

            return false;
        }
    }
?>