<?php
class MajorModel {
    private $db;
    private $table = 'NganhHoc';

    public function __construct() {
        $this->db = new Database;
    }

    public function getMajors() {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY TenNganh');
        return $this->db->resultSet();
    }

    public function getMajorById($manganh) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE MaNganh = :manganh');
        $this->db->bind(':manganh', $manganh);
        return $this->db->single();
    }
} 