<?php
class CourseModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
        if(!isset($_SESSION['temp_registrations'])) {
            $_SESSION['temp_registrations'] = [];
        }
    }

    public function getCourses() {
        $this->db->query('SELECT hp.*, 
                         (SELECT COUNT(*) FROM ChiTietDangKy ctdk 
                          JOIN DangKy dk ON ctdk.MaDK = dk.MaDK 
                          WHERE ctdk.MaHP = hp.MaHP) as SoLuongDaDangKy 
                         FROM HocPhan hp');
        return $this->db->resultSet();
    }

    public function getCourseById($mahp) {
        $this->db->query('SELECT hp.*, 
                         (SELECT COUNT(*) FROM ChiTietDangKy ctdk 
                          JOIN DangKy dk ON ctdk.MaDK = dk.MaDK 
                          WHERE ctdk.MaHP = hp.MaHP) as SoLuongDaDangKy 
                         FROM HocPhan hp 
                         WHERE hp.MaHP = :mahp');
        $this->db->bind(':mahp', $mahp);
        return $this->db->single();
    }

    public function registerCourse($masv, $mahp) {
        // Get course details
        $course = $this->getCourseById($mahp);
        if(!$course) {
            return false;
        }

        // Check if course is full
        if($course->SoLuongDaDangKy >= $course->SoLuong) {
            return false;
        }

        // Add to temporary registration session
        if(!isset($_SESSION['temp_registrations'][$masv])) {
            $_SESSION['temp_registrations'][$masv] = [];
        }
        
        $_SESSION['temp_registrations'][$masv][$mahp] = [
            'MaHP' => $mahp,
            'TenHP' => $course->TenHP,
            'SoTinChi' => $course->SoTinChi,
            'NgayDK' => date('Y-m-d H:i:s')
        ];

        return true;
    }

    public function isRegistered($masv, $mahp) {
        // Check temporary registrations first
        if(isset($_SESSION['temp_registrations'][$masv][$mahp])) {
            return true;
        }

        // If not in temporary, check database
        $this->db->query('SELECT dk.MaDK 
                         FROM DangKy dk 
                         JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK 
                         WHERE dk.MaSV = :masv AND ctdk.MaHP = :mahp');
        
        $this->db->bind(':masv', $masv);
        $this->db->bind(':mahp', $mahp);

        return $this->db->single() ? true : false;
    }

    public function getRegisteredCourses($masv) {
        $registeredCourses = [];

        // Get temporary registrations
        if(isset($_SESSION['temp_registrations'][$masv])) {
            foreach($_SESSION['temp_registrations'][$masv] as $course) {
                $registeredCourses[] = (object)$course;
            }
        }

        // Get permanent registrations from database
        $this->db->query('SELECT hp.*, dk.NgayDK 
                         FROM HocPhan hp
                         JOIN ChiTietDangKy ctdk ON hp.MaHP = ctdk.MaHP
                         JOIN DangKy dk ON ctdk.MaDK = dk.MaDK
                         WHERE dk.MaSV = :masv');
        
        $this->db->bind(':masv', $masv);
        $dbCourses = $this->db->resultSet();

        // Merge both results
        return array_merge($registeredCourses, $dbCourses);
    }

    public function deleteRegistration($masv, $mahp) {
        // Check if in temporary registrations
        if(isset($_SESSION['temp_registrations'][$masv][$mahp])) {
            unset($_SESSION['temp_registrations'][$masv][$mahp]);
            if(empty($_SESSION['temp_registrations'][$masv])) {
                unset($_SESSION['temp_registrations'][$masv]);
            }
            return true;
        }

        // If not in temporary, delete from database
        $this->db->beginTransaction();
        
        try {
            // Get the MaDK first
            $this->db->query('SELECT dk.MaDK 
                             FROM DangKy dk 
                             WHERE dk.MaSV = :masv');
            $this->db->bind(':masv', $masv);
            $result = $this->db->single();
            
            if(!$result) {
                return false;
            }

            $madk = $result->MaDK;

            // Delete from ChiTietDangKy
            $this->db->query('DELETE FROM ChiTietDangKy WHERE MaDK = :madk AND MaHP = :mahp');
            $this->db->bind(':madk', $madk);
            $this->db->bind(':mahp', $mahp);
            $this->db->execute();

            // Check if this was the last course in this registration
            $this->db->query('SELECT COUNT(*) as count FROM ChiTietDangKy WHERE MaDK = :madk');
            $this->db->bind(':madk', $madk);
            $count = $this->db->single()->count;

            // If no more courses, delete the registration
            if($count == 0) {
                $this->db->query('DELETE FROM DangKy WHERE MaDK = :madk');
                $this->db->bind(':madk', $madk);
                $this->db->execute();

                // Check if there are any registrations left
                $this->db->query('SELECT COUNT(*) as count FROM DangKy');
                $totalCount = $this->db->single()->count;

                // If no registrations left, reset auto_increment
                if($totalCount == 0) {
                    $this->db->query('ALTER TABLE DangKy AUTO_INCREMENT = 1');
                    $this->db->execute();
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function deleteAllRegistrations($masv) {
        // Clear temporary registrations
        if(isset($_SESSION['temp_registrations'][$masv])) {
            unset($_SESSION['temp_registrations'][$masv]);
        }

        // Get the MaDK first before starting transaction
        $this->db->query('SELECT MaDK FROM DangKy WHERE MaSV = :masv');
        $this->db->bind(':masv', $masv);
        $result = $this->db->single();

        // If no registration found, return true as there's nothing to delete
        if(!$result) {
            return true;
        }

        // Start transaction only if we have something to delete
        $this->db->beginTransaction();
        
        try {
            $madk = $result->MaDK;

            // Delete from ChiTietDangKy
            $this->db->query('DELETE FROM ChiTietDangKy WHERE MaDK = :madk');
            $this->db->bind(':madk', $madk);
            $this->db->execute();

            // Delete from DangKy
            $this->db->query('DELETE FROM DangKy WHERE MaDK = :madk');
            $this->db->bind(':madk', $madk);
            $this->db->execute();

            // Check if there are any registrations left
            $this->db->query('SELECT COUNT(*) as count FROM DangKy');
            $totalCount = $this->db->single()->count;

            // If no registrations left, reset auto_increment
            if($totalCount == 0) {
                $this->db->query('ALTER TABLE DangKy AUTO_INCREMENT = 1');
                $this->db->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getRegistrationStats($masv) {
        $soHocPhan = 0;
        $tongTinChi = 0;

        // Calculate stats from temporary registrations
        if(isset($_SESSION['temp_registrations'][$masv])) {
            foreach($_SESSION['temp_registrations'][$masv] as $course) {
                $soHocPhan++;
                $tongTinChi += $course['SoTinChi'];
            }
        }

        // Get stats from database
        $this->db->query('SELECT COUNT(ctdk.MaHP) as SoHocPhan, SUM(hp.SoTinChi) as TongTinChi
                         FROM DangKy dk
                         JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK
                         JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP
                         WHERE dk.MaSV = :masv');
        $this->db->bind(':masv', $masv);
        $dbStats = $this->db->single();

        // Combine stats
        return (object)[
            'SoHocPhan' => $soHocPhan + ($dbStats ? $dbStats->SoHocPhan : 0),
            'TongTinChi' => $tongTinChi + ($dbStats ? $dbStats->TongTinChi : 0)
        ];
    }

    public function saveRegistrationConfirmation($masv) {
        // If no temporary registrations, nothing to save
        if(!isset($_SESSION['temp_registrations'][$masv]) || empty($_SESSION['temp_registrations'][$masv])) {
            return true;
        }

        $this->db->beginTransaction();
        
        try {
            // Create new registration
            $this->db->query('INSERT INTO DangKy (MaSV, NgayDK) VALUES (:masv, NOW())');
            $this->db->bind(':masv', $masv);
            $this->db->execute();
            $madk = $this->db->lastInsertId();

            // Add all temporary courses to registration
            foreach($_SESSION['temp_registrations'][$masv] as $mahp => $course) {
                $this->db->query('INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (:madk, :mahp)');
                $this->db->bind(':madk', $madk);
                $this->db->bind(':mahp', $mahp);
                $this->db->execute();
            }

            // Clear temporary registrations
            unset($_SESSION['temp_registrations'][$masv]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function updateCourseCapacity($mahp, $soLuong) {
        $this->db->query('UPDATE HocPhan SET SoLuong = :soLuong WHERE MaHP = :mahp');
        $this->db->bind(':soLuong', $soLuong);
        $this->db->bind(':mahp', $mahp);
        return $this->db->execute();
    }

    public function getRemainingCapacity($mahp) {
        $course = $this->getCourseById($mahp);
        if(!$course) {
            return 0;
        }
        return $course->SoLuong - $course->SoLuongDaDangKy;
    }
}