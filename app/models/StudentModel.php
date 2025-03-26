<?php
class StudentModel {
    private $db;
    private $table = 'SinhVien';

    public function __construct() {
        $this->db = new Database;
    }

    public function getStudents() {
        $this->db->query('SELECT sv.*, nh.TenNganh 
                         FROM ' . $this->table . ' sv 
                         LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                         ORDER BY sv.MaSV');
        return $this->db->resultSet();
    }

    public function getStudentWithMajor($masv) {
        $this->db->query('SELECT sv.*, nh.TenNganh 
                         FROM SinhVien sv 
                         JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh 
                         WHERE sv.MaSV = :masv');
        $this->db->bind(':masv', $masv);
        return $this->db->single();
    }

    public function addStudent($data) {
        $this->db->query('INSERT INTO ' . $this->table . ' (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                         VALUES (:masv, :hoten, :gioitinh, :ngaysinh, :hinh, :manganh)');
        
        // Bind values
        $this->db->bind(':masv', $data['masv']);
        $this->db->bind(':hoten', $data['hoten']);
        $this->db->bind(':gioitinh', $data['gioitinh']);
        $this->db->bind(':ngaysinh', $data['ngaysinh']);
        $this->db->bind(':hinh', $data['hinh']);
        $this->db->bind(':manganh', $data['manganh']);

        // Execute
        return $this->db->execute();
    }

    public function updateStudent($data) {
        $this->db->query('UPDATE ' . $this->table . ' 
                         SET HoTen = :hoten, GioiTinh = :gioitinh, 
                             NgaySinh = :ngaysinh, Hinh = :hinh, MaNganh = :manganh 
                         WHERE MaSV = :masv');
        
        // Bind values
        $this->db->bind(':masv', $data['masv']);
        $this->db->bind(':hoten', $data['hoten']);
        $this->db->bind(':gioitinh', $data['gioitinh']);
        $this->db->bind(':ngaysinh', $data['ngaysinh']);
        $this->db->bind(':hinh', $data['hinh']);
        $this->db->bind(':manganh', $data['manganh']);

        // Execute
        return $this->db->execute();
    }

    public function getStudentById($masv) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE MaSV = :masv');
        $this->db->bind(':masv', $masv);
        return $this->db->single();
    }

    public function deleteStudent($masv) {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE MaSV = :masv');
        // Bind values
        $this->db->bind(':masv', $masv);
        // Execute
        return $this->db->execute();
    }

    public function findStudentByMaSV($masv) {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE MaSV = :masv');
        $this->db->bind(':masv', $masv);
        
        $row = $this->db->single();
        return ($row) ? true : false;
    }
} 