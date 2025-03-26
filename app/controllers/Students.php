<?php
class Students extends Controller {
    private $studentModel;
    private $majorModel;

    public function __construct() {
        // Check if user is logged in
        if(!isset($_SESSION['masv'])) {
            redirect('auth/login');
            return;
        }
        
        $this->studentModel = $this->model('StudentModel');
        $this->majorModel = $this->model('MajorModel');
    }

    public function index() {
        $students = $this->studentModel->getStudents();

        $data = [
            'title' => 'Quản lý sinh viên',
            'students' => $students
        ];

        $this->view('students/index', $data);
    }

    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Handle file upload
            $imagePath = '';
            if(isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0) {
                $uploadDir = 'public/uploads/students/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imagePath = $uploadDir . time() . '_' . $_FILES['hinh']['name'];
                move_uploaded_file($_FILES['hinh']['tmp_name'], $imagePath);
            }

            $data = [
                'masv' => trim($_POST['masv']),
                'hoten' => trim($_POST['hoten']),
                'gioitinh' => trim($_POST['gioitinh']),
                'ngaysinh' => trim($_POST['ngaysinh']),
                'hinh' => $imagePath,
                'manganh' => trim($_POST['manganh']),
                'masv_err' => '',
                'hoten_err' => '',
                'ngaysinh_err' => '',
                'manganh_err' => ''
            ];

            // Validate data
            if(empty($data['masv'])) {
                $data['masv_err'] = 'Vui lòng nhập mã sinh viên';
            } elseif($this->studentModel->findStudentByMaSV($data['masv'])) {
                $data['masv_err'] = 'Mã sinh viên đã tồn tại';
            }

            if(empty($data['hoten'])) {
                $data['hoten_err'] = 'Vui lòng nhập họ tên';
            }

            if(empty($data['ngaysinh'])) {
                $data['ngaysinh_err'] = 'Vui lòng nhập ngày sinh';
            }

            if(empty($data['manganh'])) {
                $data['manganh_err'] = 'Vui lòng chọn ngành học';
            }

            // Make sure no errors
            if(empty($data['masv_err']) && empty($data['hoten_err']) && 
               empty($data['ngaysinh_err']) && empty($data['manganh_err'])) {
                // Validated
                if($this->studentModel->addStudent($data)) {
                    flash('student_message', 'Thêm sinh viên thành công');
                    redirect('students');
                } else {
                    die('Có lỗi xảy ra');
                }
            } else {
                // Load view with errors
                $this->view('students/add', $data);
            }
        } else {
            $majors = $this->majorModel->getMajors();
            
            $data = [
                'title' => 'Thêm sinh viên mới',
                'majors' => $majors,
                'masv' => '',
                'hoten' => '',
                'gioitinh' => '',
                'ngaysinh' => '',
                'hinh' => '',
                'manganh' => '',
                'masv_err' => '',
                'hoten_err' => '',
                'ngaysinh_err' => '',
                'manganh_err' => ''
            ];

            $this->view('students/add', $data);
        }
    }

    public function edit($masv) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Handle file upload
            $imagePath = $_POST['current_image'];
            if(isset($_FILES['hinh']) && $_FILES['hinh']['error'] == 0) {
                $uploadDir = 'public/uploads/students/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imagePath = $uploadDir . time() . '_' . $_FILES['hinh']['name'];
                move_uploaded_file($_FILES['hinh']['tmp_name'], $imagePath);

                // Delete old image
                if(!empty($_POST['current_image']) && file_exists($_POST['current_image'])) {
                    unlink($_POST['current_image']);
                }
            }

            $data = [
                'masv' => $masv,
                'hoten' => trim($_POST['hoten']),
                'gioitinh' => trim($_POST['gioitinh']),
                'ngaysinh' => trim($_POST['ngaysinh']),
                'hinh' => $imagePath,
                'manganh' => trim($_POST['manganh']),
                'hoten_err' => '',
                'ngaysinh_err' => '',
                'manganh_err' => ''
            ];

            // Validate data
            if(empty($data['hoten'])) {
                $data['hoten_err'] = 'Vui lòng nhập họ tên';
            }

            if(empty($data['ngaysinh'])) {
                $data['ngaysinh_err'] = 'Vui lòng nhập ngày sinh';
            }

            if(empty($data['manganh'])) {
                $data['manganh_err'] = 'Vui lòng chọn ngành học';
            }

            // Make sure no errors
            if(empty($data['hoten_err']) && empty($data['ngaysinh_err']) && 
               empty($data['manganh_err'])) {
                // Validated
                if($this->studentModel->updateStudent($data)) {
                    flash('student_message', 'Cập nhật sinh viên thành công');
                    redirect('students');
                } else {
                    die('Có lỗi xảy ra');
                }
            } else {
                // Load view with errors
                $this->view('students/edit', $data);
            }
        } else {
            // Get student
            $student = $this->studentModel->getStudentById($masv);
            $majors = $this->majorModel->getMajors();

            if(!$student) {
                redirect('students');
            }

            $data = [
                'title' => 'Sửa thông tin sinh viên',
                'majors' => $majors,
                'masv' => $student->MaSV,
                'hoten' => $student->HoTen,
                'gioitinh' => $student->GioiTinh,
                'ngaysinh' => $student->NgaySinh,
                'hinh' => $student->Hinh,
                'manganh' => $student->MaNganh,
                'hoten_err' => '',
                'ngaysinh_err' => '',
                'manganh_err' => ''
            ];

            $this->view('students/edit', $data);
        }
    }

    public function delete($masv) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get student
            $student = $this->studentModel->getStudentById($masv);

            if(!$student) {
                redirect('students');
            }

            if($this->studentModel->deleteStudent($masv)) {
                // Delete image if exists
                if(!empty($student->Hinh) && file_exists($student->Hinh)) {
                    unlink($student->Hinh);
                }
                flash('student_message', 'Xóa sinh viên thành công');
                redirect('students');
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            redirect('students');
        }
    }

    public function show($masv) {
        // Get student with major info
        $student = $this->studentModel->getStudentWithMajor($masv);

        if(!$student) {
            redirect('students');
        }

        $data = [
            'title' => 'Thông tin sinh viên',
            'student' => $student
        ];

        $this->view('students/show', $data);
    }
} 