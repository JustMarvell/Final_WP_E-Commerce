<?php
include_once __DIR__ . '/../models/database_connector.php'; // Include database connection file
include_once __DIR__ . '/../models/users.php'; // Include User model
include_once __DIR__ . '/../controllers/utils.php'; // Include utility functions

class UserCnt
{
    private $db_conn;
    private $userModel;
    private $utils; // Utility functions

    public function __construct($db)
    {
        $this->db_conn = $db; // Initialize database connection
        $this->userModel = new Users($db); // Initialize User model
        $this->utils = new Utils(); // Initialize utility functions
    }

    // Function to get all users
    public function GetUsers()
    {
        return $this->userModel->GetAllUsers(); // Call method from User model to get all users
    }

    // Function to delete user by ID
    public function DeleteUser($id)
    {
        return $this->userModel->DeleteUserById($id); // Call method from User model to delete user by ID
    }

    // Function to add a new user
    public function AddUser($username, $password)
    {
        $uID = $this->utils->SetUniqueIntID($this->db_conn, 'users_login_inf');
        $this->userModel->id = $uID;
        $this->userModel->username = $username;
        $this->userModel->password = $password;

        return $this->userModel->AddUser(); // Call method from User model to add a new user
    }

    public function GetUserById($id) {
        return $this->userModel->GetUserById($id);
    }
}
