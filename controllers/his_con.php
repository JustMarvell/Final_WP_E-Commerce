<?php
include_once __DIR__ . '/../models/database_connector.php';
include_once __DIR__ . '/../models/history.php';

class HistoryController {
    private $db_conn;
    private $history_model;

    public function __construct($db) {
        $this->db_conn = $db;
        $this->history_model = new History($db);
    }

    public function GetAllHistory(): array {
        return $this->history_model->GetAllHistory();
    }

    public function GetHistoryById($id) {
        return $this->history_model->GetHistoryById($id);
    }

    public function GetHistoryByUser($user_id): array {
        return $this->history_model->GetHistoryByUser($user_id);
    }

    public function AddOrderHistory($post) {
        $this->history_model->user_id = $post['user_id'];
        $this->history_model->product_id = $post['prod_id'];
        $this->history_model->order_qty = $post['ord_qty'];
        $this->history_model->order_date = $post['ord_date'];
        $this->history_model->product_name = $post['prod_name'];
        $this->history_model->total_price = intval($post['prod_price']) * intval($post['ord_qty']);

        return $this->history_model->AddOrderHistory();
    }
}
?>