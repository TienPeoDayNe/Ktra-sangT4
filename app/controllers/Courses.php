<?php
class Courses extends Controller {
    private $courseModel;
    private $studentModel;

    public function __construct() {
        $this->courseModel = $this->model('CourseModel');
        $this->studentModel = $this->model('StudentModel');
    }

    public function index() {
        // Get all courses
        $courses = $this->courseModel->getCourses();
        
        // Get registered courses for current student
        $registered_courses = [];
        if(isset($_SESSION['masv'])) {
            $registeredCourses = $this->courseModel->getRegisteredCourses($_SESSION['masv']);
            foreach($registeredCourses as $course) {
                $registered_courses[] = $course->MaHP;
            }
        }

        // Get registration stats for current student
        $stats = null;
        if(isset($_SESSION['masv'])) {
            $stats = $this->courseModel->getRegistrationStats($_SESSION['masv']);
        }

        $data = [
            'courses' => $courses,
            'registered_courses' => $registered_courses,
            'stats' => $stats
        ];

        $this->view('courses/index', $data);
    }

    public function register($mahp = '') {
        if(!isset($_SESSION['masv'])) {
            flash('course_message', 'Bạn cần đăng nhập để đăng ký học phần', 'alert alert-danger');
            redirect('auth/login');
        }

        if(empty($mahp)) {
            flash('course_message', 'Không tìm thấy học phần', 'alert alert-danger');
            redirect('courses');
        }

        // Check if course exists and has available slots
        $course = $this->courseModel->getCourseById($mahp);
        if(!$course) {
            flash('course_message', 'Không tìm thấy học phần', 'alert alert-danger');
            redirect('courses');
        }

        if($course->SoLuongDaDangKy >= $course->SoLuong) {
            flash('course_message', 'Học phần đã đủ số lượng', 'alert alert-danger');
            redirect('courses');
        }

        // Check if already registered
        if($this->courseModel->isRegistered($_SESSION['masv'], $mahp)) {
            flash('course_message', 'Bạn đã đăng ký học phần này rồi', 'alert alert-danger');
            redirect('courses');
        }

        // Register for the course
        if($this->courseModel->registerCourse($_SESSION['masv'], $mahp)) {
            flash('course_message', 'Đăng ký học phần thành công', 'alert alert-success');
        } else {
            flash('course_message', 'Đăng ký học phần thất bại', 'alert alert-danger');
        }

        redirect('courses');
    }

    public function registered() {
        if(!isset($_SESSION['masv'])) {
            flash('course_message', 'Bạn cần đăng nhập để xem học phần đã đăng ký', 'alert alert-danger');
            redirect('auth/login');
        }

        $registeredCourses = $this->courseModel->getRegisteredCourses($_SESSION['masv']);
        $stats = $this->courseModel->getRegistrationStats($_SESSION['masv']);
        $student = $this->studentModel->getStudentWithMajor($_SESSION['masv']);

        $data = [
            'courses' => $registeredCourses,
            'stats' => $stats,
            'student' => $student
        ];

        $this->view('courses/registered', $data);
    }

    public function delete($mahp = '') {
        if(!isset($_SESSION['masv'])) {
            flash('course_message', 'Bạn cần đăng nhập để hủy đăng ký học phần', 'alert alert-danger');
            redirect('auth/login');
        }

        if(empty($mahp)) {
            flash('course_message', 'Không tìm thấy học phần', 'alert alert-danger');
            redirect('courses/registered');
        }

        if($this->courseModel->deleteRegistration($_SESSION['masv'], $mahp)) {
            flash('course_message', 'Hủy đăng ký học phần thành công', 'alert alert-success');
        } else {
            flash('course_message', 'Hủy đăng ký học phần thất bại', 'alert alert-danger');
        }

        redirect('courses/registered');
    }

    public function deleteAll() {
        if(!isset($_SESSION['masv'])) {
            flash('course_message', 'Bạn cần đăng nhập để hủy đăng ký học phần', 'alert alert-danger');
            redirect('auth/login');
        }

        if($this->courseModel->deleteAllRegistrations($_SESSION['masv'])) {
            flash('course_message', 'Hủy tất cả đăng ký học phần thành công', 'alert alert-success');
        } else {
            flash('course_message', 'Hủy tất cả đăng ký học phần thất bại', 'alert alert-danger');
        }

        redirect('courses/registered');
    }

    public function confirm() {
        if(!isset($_SESSION['masv'])) {
            flash('course_message', 'Bạn cần đăng nhập để xác nhận đăng ký học phần', 'alert alert-danger');
            redirect('auth/login');
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('courses/registered');
        }

        // Get temporary registrations
        $tempRegistrations = isset($_SESSION['temp_registrations'][$_SESSION['masv']]) 
            ? $_SESSION['temp_registrations'][$_SESSION['masv']] 
            : [];

        if(empty($tempRegistrations)) {
            flash('course_message', 'Không có học phần nào để lưu', 'alert alert-warning');
            redirect('courses/registered');
        }

        // Save registrations to database
        if($this->courseModel->saveRegistrationConfirmation($_SESSION['masv'])) {
            flash('course_message', 'Xác nhận đăng ký học phần thành công', 'alert alert-success');
        } else {
            flash('course_message', 'Xác nhận đăng ký học phần thất bại', 'alert alert-danger');
        }

        redirect('courses/registered');
    }
} 