<?php
class Auth extends Controller {
    private $studentModel;
    
    public function __construct() {
        $this->studentModel = $this->model('StudentModel');
    }
    
    public function index() {
        // Redirect to login page
        $this->login();
    }
    
    public function login() {
        // Check if logged in
        if(isset($_SESSION['masv'])) {
            redirect('students/index');
            return;
        }
        
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'masv' => trim($_POST['masv']),
                'masv_err' => ''
            ];
            
            // Validate masv
            if(empty($data['masv'])) {
                $data['masv_err'] = 'Vui lòng nhập mã sinh viên';
            } elseif(!$this->studentModel->findStudentByMaSV($data['masv'])) {
                $data['masv_err'] = 'Mã sinh viên không tồn tại';
            }
            
            // Make sure errors are empty
            if(empty($data['masv_err'])) {
                // Get Student
                $student = $this->studentModel->getStudentById($data['masv']);
                
                if($student) {
                    // Create Session
                    $this->createUserSession($student);
                } else {
                    $data['masv_err'] = 'Mã sinh viên không tồn tại';
                    $this->view('auth/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('auth/login', $data);
            }
        } else {
            // Init data
            $data = [
                'masv' => '',
                'masv_err' => ''
            ];
            
            // Load view
            $this->view('auth/login', $data);
        }
    }
    
    public function register() {
        // Check if logged in
        if(isset($_SESSION['user_id'])) {
            redirect('pages/index');
        }
        
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Init data
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'fullname' => trim($_POST['fullname']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Vui lòng nhập tên đăng nhập';
            } elseif($this->userModel->findUserByUsername($data['username'])) {
                $data['username_err'] = 'Tên đăng nhập đã tồn tại';
            }
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Vui lòng nhập email';
            } elseif($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email đã tồn tại';
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Vui lòng nhập mật khẩu';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }
            
            // Validate confirm password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Vui lòng xác nhận mật khẩu';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Mật khẩu không khớp';
                }
            }
            
            // Make sure errors are empty
            if(empty($data['username_err']) && empty($data['email_err']) && 
               empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Validated
                
                // Register user
                if($this->userModel->register($data)) {
                    flash('register_success', 'Bạn đã đăng ký thành công và có thể đăng nhập');
                    redirect('auth/login');
                } else {
                    die('Đã xảy ra lỗi');
                }
            } else {
                // Load view with errors
                $this->view('auth/register', $data);
            }
        } else {
            // Init data
            $data = [
                'username' => '',
                'email' => '',
                'fullname' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Load view
            $this->view('auth/register', $data);
        }
    }
    
    public function createUserSession($student) {
        $_SESSION['masv'] = $student->MaSV;
        $_SESSION['hoten'] = $student->HoTen;
        redirect('students/index');
    }
    
    public function logout() {
        unset($_SESSION['masv']);
        unset($_SESSION['hoten']);
        session_destroy();
        redirect('auth/login');
    }
} 