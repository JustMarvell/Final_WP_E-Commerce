<?php
include_once __DIR__ . '/../controllers/utils.php';

class Entry {
    private $db_conn;
    private $table = 'products_history';
    private $utils;

    public $id;
    public $product_name;
    public $product_category;
    public $product_quantity;
    public $product_price;
    public $entry_date;

    public function __construct($db) {
        $this->db_conn = $db;
        $this->utils = new Utils();
    }

    public function GetAllEntry(): array {
        $q = 'SELECT * FROM ' . $this->table . ' ORDER BY ' . $this->table . '.entry_date ASC';
        $sql = $this->db_conn->prepare($q);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function AddProductEntry() {
        $q = 'INSERT INTO ' . $this->table . ' (id, product_name, product_category, product_quantity, product_price, entry_date)
        VALUES (:id, :product_name, :product_category, :product_quantity, :product_price, :entry_date)';

        $sql = $this->db_conn->prepare($q); 
        $sql->bindParam(':id', $this->id);
        $sql->bindParam(':product_name', $this->product_name);
        $sql->bindParam(':product_category', $this->product_category);
        $sql->bindParam(':product_quantity', $this->product_quantity);
        $sql->bindParam(':product_price', $this->product_price);
        $sql->bindParam(':entry_date', $this->entry_date);

        return $sql->execute();
    }
}
?>