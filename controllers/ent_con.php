<?php
include_once __DIR__ . '/../models/database_connector.php';
include_once __DIR__ . '/../models/entry.php';

class EntryController {
    private $db_conn;
    private $entryModel;

    public function __construct($db) {
        $this->db_conn = $db;
        $this->entryModel = new Entry($db);
    }

    public function GetAllEntry(): array {
        return $this->entryModel->GetAllEntry();
    }
}
?>