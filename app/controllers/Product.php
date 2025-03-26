<?php
class Product extends Controller {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        if(!isLoggedIn()) {
            redirect('auth/login');
        }
        
        $this->productModel = $this->model('ProductModel');
        $this->categoryModel = $this->model('CategoryModel');
    }

    public function index() {
        $products = $this->productModel->getProducts();
        $categories = $this->categoryModel->getCategories();

        $data = [
            'title' => 'Quản lý sản phẩm',
            'products' => $products,
            'categories' => $categories
        ];

        $this->view('products/index', $data);
    }

    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Handle file upload
            $imagePath = '';
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadDir = 'public/uploads/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imagePath = $uploadDir . time() . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            }

            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'price' => trim($_POST['price']),
                'category_id' => trim($_POST['category_id']),
                'image' => $imagePath,
                'name_err' => '',
                'description_err' => '',
                'price_err' => '',
                'category_id_err' => ''
            ];

            // Validate data
            if(empty($data['name'])) {
                $data['name_err'] = 'Vui lòng nhập tên sản phẩm';
            }
            if(empty($data['description'])) {
                $data['description_err'] = 'Vui lòng nhập mô tả';
            }
            if(empty($data['price'])) {
                $data['price_err'] = 'Vui lòng nhập giá';
            }
            if(empty($data['category_id'])) {
                $data['category_id_err'] = 'Vui lòng chọn danh mục';
            }

            // Make sure no errors
            if(empty($data['name_err']) && empty($data['description_err']) && 
               empty($data['price_err']) && empty($data['category_id_err'])) {
                // Validated
                if($this->productModel->addProduct($data)) {
                    flash('product_message', 'Thêm sản phẩm thành công');
                    redirect('product');
                } else {
                    die('Có lỗi xảy ra');
                }
            } else {
                // Load view with errors
                $this->view('products/add', $data);
            }
        } else {
            $categories = $this->categoryModel->getCategories();
            
            $data = [
                'title' => 'Thêm sản phẩm mới',
                'categories' => $categories,
                'name' => '',
                'description' => '',
                'price' => '',
                'category_id' => '',
                'name_err' => '',
                'description_err' => '',
                'price_err' => '',
                'category_id_err' => ''
            ];

            $this->view('products/add', $data);
        }
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Handle file upload
            $imagePath = '';
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadDir = 'public/uploads/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imagePath = $uploadDir . time() . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            }

            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'price' => trim($_POST['price']),
                'category_id' => trim($_POST['category_id']),
                'image' => $imagePath,
                'name_err' => '',
                'description_err' => '',
                'price_err' => '',
                'category_id_err' => ''
            ];

            // Validate data
            if(empty($data['name'])) {
                $data['name_err'] = 'Vui lòng nhập tên sản phẩm';
            }
            if(empty($data['description'])) {
                $data['description_err'] = 'Vui lòng nhập mô tả';
            }
            if(empty($data['price'])) {
                $data['price_err'] = 'Vui lòng nhập giá';
            }
            if(empty($data['category_id'])) {
                $data['category_id_err'] = 'Vui lòng chọn danh mục';
            }

            // Make sure no errors
            if(empty($data['name_err']) && empty($data['description_err']) && 
               empty($data['price_err']) && empty($data['category_id_err'])) {
                // Validated
                if($this->productModel->updateProduct($data)) {
                    flash('product_message', 'Cập nhật sản phẩm thành công');
                    redirect('product');
                } else {
                    die('Có lỗi xảy ra');
                }
            } else {
                // Load view with errors
                $this->view('products/edit', $data);
            }
        } else {
            // Get product
            $product = $this->productModel->getProductById($id);
            $categories = $this->categoryModel->getCategories();

            // Check for owner
            if(!$product) {
                redirect('product');
            }

            $data = [
                'title' => 'Sửa sản phẩm',
                'categories' => $categories,
                'id' => $id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category_id' => $product->category_id,
                'image' => $product->image,
                'name_err' => '',
                'description_err' => '',
                'price_err' => '',
                'category_id_err' => ''
            ];

            $this->view('products/edit', $data);
        }
    }

    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get product
            $product = $this->productModel->getProductById($id);

            if(!$product) {
                redirect('product');
            }

            if($this->productModel->deleteProduct($id)) {
                // Delete image if exists
                if(!empty($product->image) && file_exists($product->image)) {
                    unlink($product->image);
                }
                flash('product_message', 'Xóa sản phẩm thành công');
                redirect('product');
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            redirect('product');
        }
    }
} 