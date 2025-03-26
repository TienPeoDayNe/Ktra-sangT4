<?php
class CategoryModel
{
    private $db;
    private $table = 'categories';

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getCategories()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY name ASC');
        return $this->db->resultSet();
    }

    public function getCategoryById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addCategory($data)
    {
        $this->db->query('INSERT INTO ' . $this->table . ' (name, description) VALUES (:name, :description)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        return $this->db->execute();
    }

    public function updateCategory($data)
    {
        $this->db->query('UPDATE ' . $this->table . ' SET name = :name, description = :description WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        return $this->db->execute();
    }

    public function deleteCategory($id)
    {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function hasProducts($id)
    {
        $this->db->query('SELECT COUNT(*) as count FROM products WHERE category_id = :category_id');
        $this->db->bind(':category_id', $id);
        $row = $this->db->single();
        return $row->count > 0;
    }
}
?>
