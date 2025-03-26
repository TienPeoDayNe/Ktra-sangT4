<?php
class Category extends Controller {
    private $categoryModel;
    
    public function __construct() {
        if(!isLoggedIn()) {
            redirect('auth/login');
        }
        
        $this->categoryModel = $this->model('CategoryModel');
    }

    public function index() {
        $categories = $this->categoryModel->getCategories();

        $data = [
            'title' => 'Quản lý danh mục',
            'categories' => $categories
        ];

        $this->view('category/list', $data);
    }

    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'name_err' => '',
                'description_err' => ''
            ];

            // Validate data
            if(empty($data['name'])) {
                $data['name_err'] = 'Vui lòng nhập tên danh mục';
            }

            // Make sure no errors
            if(empty($data['name_err'])) {
                // Validated
                if($this->categoryModel->addCategory($data)) {
                    flash('category_message', 'Thêm danh mục thành công');
                    redirect('category');
                } else {
                    die('Có lỗi xảy ra');
                }
            } else {
                // Load view with errors
                $this->view('category/add', $data);
            }
        } else {
            $data = [
                'title' => 'Thêm danh mục mới',
                'name' => '',
                'description' => '',
                'name_err' => '',
                'description_err' => ''
            ];

            $this->view('category/add', $data);
        }
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'name_err' => '',
                'description_err' => ''
            ];

            // Validate data
            if(empty($data['name'])) {
                $data['name_err'] = 'Vui lòng nhập tên danh mục';
            }

            // Make sure no errors
            if(empty($data['name_err'])) {
                // Validated
                if($this->categoryModel->updateCategory($data)) {
                    flash('category_message', 'Cập nhật danh mục thành công');
                    redirect('category');
                } else {
                    die('Có lỗi xảy ra');
                }
            } else {
                // Load view with errors
                $this->view('category/edit', $data);
            }
        } else {
            // Get category
            $category = $this->categoryModel->getCategoryById($id);

            if(!$category) {
                redirect('category');
            }

            $data = [
                'title' => 'Sửa danh mục',
                'id' => $id,
                'name' => $category->name,
                'description' => $category->description,
                'name_err' => '',
                'description_err' => ''
            ];

            $this->view('category/edit', $data);
        }
    }

    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get category
            $category = $this->categoryModel->getCategoryById($id);

            if(!$category) {
                redirect('category');
            }

            // Check if category has products
            if($this->categoryModel->hasProducts($id)) {
                flash('category_message', 'Không thể xóa danh mục này vì có sản phẩm đang sử dụng', 'alert alert-danger');
                redirect('category');
            }

            if($this->categoryModel->deleteCategory($id)) {
                flash('category_message', 'Xóa danh mục thành công');
                redirect('category');
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            redirect('category');
        }
    }
} 