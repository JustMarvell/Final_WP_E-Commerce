<?php
    include_once __DIR__ . '/../controllers/utils.php'; // Include utility functions

    class Users {
        private $db_conn;
        private $table = "users_login_inf";
        private $utils;

        public $id;
        public $username;
        public $password;
        

        public function __construct($db) {
            $this->db_conn = $db;
            $this->utils = new Utils(); // Initialize utility functions
        }

        // get all users
        public function GetAllUsers(): array {
            $q = "select * from " . $this->table;
            $sql = $this->db_conn->prepare($q);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC); // return all users
        }

        // delete user by id
        public function DeleteUserById($id): bool {
            $q = "delete from " . $this->table . " where id = :id";
            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $id);
            return $sql->execute(); // return execution result
        }

        // add user
        public function AddUser() {
            $q = 'INSERT INTO ' . $this->table . ' (id, username, password) VALUES (:id, :username, :password)';
            $sql = $this->db_conn->prepare($q);
            // $sql->bindParam(':id', $this->utils->SetUniqueIntID($this->db_conn, $this->table)); // bind unique ID
            $sql->bindParam(':id', $this->id); // bind unique ID
            $sql->bindParam(':username', $this->username);
            $pc = password_hash($this->password, PASSWORD_BCRYPT);
            $sql->bindParam(':password', $pc); // hash password
            return $sql->execute(); // return execution result
        }

        public function GetUserById($id) {
            $q = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
            $sql = $this->db_conn->prepare($q);
            $sql->bindParam(':id', $id);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_ASSOC);
        }

        // public function GetUsernameById($id) {
        //     $q = 'SELECT username FROM ' . $this->table . ' WHERE id=:id';
        //     $sql = $this->db_conn->prepare($q);
        //     $sql->bindParam(':id', $id);
        // }
    }
?>