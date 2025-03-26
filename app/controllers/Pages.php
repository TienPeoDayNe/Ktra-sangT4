<?php
class Pages extends Controller {
    public function __construct() {
        
    }

    public function index() {
        $data = [
            'title' => 'Trang chủ',
            'description' => 'Hệ thống quản lý sinh viên'
        ];

        $this->view('pages/index', $data);
    }

    public function error() {
        $data = [
            'title' => '404 Not Found',
            'message' => 'Không tìm thấy trang bạn yêu cầu'
        ];

        $this->view('pages/error', $data);
    }
} 