<?php
class ProductModel
{
    private $db;
    private $table = 'products';

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getProducts()
    {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM ' . $this->table . ' p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         ORDER BY p.id DESC');
        return $this->db->resultSet();
    }

    public function getProductById($id)
    {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM ' . $this->table . ' p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         WHERE p.id = :id');
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    public function addProduct($data)
    {
        $this->db->query('INSERT INTO ' . $this->table . ' (name, description, price, category_id, image) 
                         VALUES (:name, :description, :price, :category_id, :image)');
        
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':image', $data['image']);

        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProduct($data)
    {
        $query = 'UPDATE ' . $this->table . ' 
                 SET name = :name, description = :description, 
                     price = :price, category_id = :category_id';
        
        if(!empty($data['image'])) {
            $query .= ', image = :image';
        }
        
        $query .= ' WHERE id = :id';
        
        $this->db->query($query);

        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':category_id', $data['category_id']);
        
        if(!empty($data['image'])) {
            $this->db->bind(':image', $data['image']);
        }

        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProduct($id)
    {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }
}
?>
