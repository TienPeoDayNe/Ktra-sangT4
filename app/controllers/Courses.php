<?php
class Courses extends Controller {
    private $courseModel;
    private $studentModel;

    public function __construct() {
        // Check if user is logged in
        if(!isset($_SESSION['masv'])) {
            redirect('auth/login');
            return;
        }
        
        $this->courseModel = $this->model('CourseModel');
        $this->studentModel = $this->model('StudentModel');
    }

    public function index() {
        $courses = $this->courseModel->getCourses();
        $registeredCourses = $this->courseModel->getRegisteredCourses($_SESSION['masv']);
        $stats = $this->courseModel->getRegistrationStats($_SESSION['masv']);

        // Create an array of registered course IDs for easy checking
        $registeredIds = array_map(function($course) {
            return $course->MaHP;
        }, $registeredCourses);

        $data = [
            'title' => 'Đăng ký học phần',
            'courses' => $courses,
            'registeredIds' => $registeredIds,
            'stats' => $stats
        ];

        $this->view('courses/index', $data);
    }

    public function register($mahp) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check if already registered
            if($this->courseModel->isRegistered($_SESSION['masv'], $mahp)) {
                flash('course_message', 'Bạn đã đăng ký học phần này rồi', 'alert alert-warning');
                redirect('courses');
                return;
            }

            if($this->courseModel->registerCourse($_SESSION['masv'], $mahp)) {
                flash('course_message', 'Đăng ký học phần thành công');
                redirect('courses');
            } else {
                die('Có lỗi xảy ra khi đăng ký học phần');
            }
        } else {
            redirect('courses');
        }
    }

    public function registered() {
        $registeredCourses = $this->courseModel->getRegisteredCourses($_SESSION['masv']);
        $stats = $this->courseModel->getRegistrationStats($_SESSION['masv']);
        
        // Get student information including major
        $student = $this->studentModel->getStudentWithMajor($_SESSION['masv']);

        $data = [
            'title' => 'Học phần đã đăng ký',
            'courses' => $registeredCourses,
            'stats' => $stats,
            'student' => $student
        ];

        $this->view('courses/registered', $data);
    }

    public function delete($mahp) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->courseModel->deleteRegistration($_SESSION['masv'], $mahp)) {
                flash('course_message', 'Đã xóa học phần khỏi danh sách đăng ký');
                redirect('courses/registered');
            } else {
                die('Có lỗi xảy ra khi xóa học phần');
            }
        } else {
            redirect('courses/registered');
        }
    }

    public function deleteAll() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if($this->courseModel->deleteAllRegistrations($_SESSION['masv'])) {
                flash('course_message', 'Đã xóa tất cả học phần đã đăng ký');
                redirect('courses/registered');
            } else {
                die('Có lỗi xảy ra khi xóa học phần');
            }
        } else {
            redirect('courses/registered');
        }
    }

    public function save() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get current registration details
            $registeredCourses = $this->courseModel->getRegisteredCourses($_SESSION['masv']);
            $stats = $this->courseModel->getRegistrationStats($_SESSION['masv']);
            
            if(empty($registeredCourses)) {
                flash('course_message', 'Không có học phần nào để lưu', 'alert alert-warning');
                redirect('courses');
                return;
            }

            // Save registration confirmation
            if($this->courseModel->saveRegistrationConfirmation($_SESSION['masv'])) {
                flash('course_message', 'Đã lưu thông tin đăng ký học phần thành công', 'alert alert-success');
                redirect('courses/registered');
            } else {
                flash('course_message', 'Có lỗi xảy ra khi lưu thông tin đăng ký', 'alert alert-danger');
                redirect('courses');
            }
        } else {
            redirect('courses');
        }
    }
} 