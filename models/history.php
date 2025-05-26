<?php
include_once __DIR__ . '/../controllers/utils.php'; // Include utility functions    

class History {
    private $db_conn;
    private $table = 'order_history';
    private $utils;

    public $id;
    public $user_id;
    public $product_id;
    public $order_qty;
    public $order_date;
    public $product_name;
    public $total_price;

    public function __construct($db) {
        $this->db_conn = $db;
        $this->utils = new Utils();
    }

    public function GetAllHistory(): array {
        $q = "SELECT * FROM " . $this->table . " ORDER BY " . $this->table . ".user_id ASC";
        $sql = $this->db_conn->prepare($q);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetHistoryById($id) {
        $q = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $sql = $this->db_conn->prepare($q);
        $sql->bindParam(':id', $id);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function GetHistoryByUser($user_id): array {
        $q = 'SELECT * FROM ' . $this->table . ' WHERE user_id = :user_id';
        $sql = $this->db_conn->prepare($q);
        $sql->bindParam(':user_id', $user_id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function AddOrderHistory() {
        $q = 'INSERT INTO ' . $this->table . ' (id, user_id, product_id, order_qty, order_date, product_name, total_price)
        VALUES (:id, :user_id, :product_id, :order_qty, :order_date, :product_name, :total_price)';

        $oId = $this->utils->SetUniqueOrderId();
        $this->id = $oId;

        $sql = $this->db_conn->prepare($q);
        $sql->bindParam(':id', $oId);
        $sql->bindParam(':user_id', $this->user_id);
        $sql->bindParam(':product_id', $this->product_id);
        $sql->bindParam(':order_qty', $this->order_qty);
        $sql->bindParam(':order_date', $this->order_date);
        $sql->bindParam(':product_name', $this->product_name);
        $sql->bindParam(':total_price', $this->total_price);

        return $sql->execute();
    }
}
?>