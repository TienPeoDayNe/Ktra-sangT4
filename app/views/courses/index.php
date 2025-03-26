<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Danh sách học phần</h2>
                    <a href="<?php echo URLROOT; ?>/courses/registered" class="btn btn-info">
                        <i class="fa fa-list"></i> Học phần đã đăng ký
                    </a>
                </div>
                <div class="card-body">
                    <?php flash('course_message'); ?>
                    
                    <!-- Thống kê -->
                    <div class="alert alert-info mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Số học phần đã đăng ký:</strong> <?php echo $data['stats']->SoHocPhan ?? 0; ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Tổng số tín chỉ:</strong> <?php echo $data['stats']->TongTinChi ?? 0; ?>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Mã học phần</th>
                                    <th>Tên học phần</th>
                                    <th>Số tín chỉ</th>
                                    <th>Số lượng dự kiến</th>
                                    <th>Đã đăng ký</th>
                                    <th>Còn lại</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['courses'] as $course): ?>
                                    <tr>
                                        <td><?php echo $course->MaHP; ?></td>
                                        <td><?php echo $course->TenHP; ?></td>
                                        <td><?php echo $course->SoTinChi; ?></td>
                                        <td><?php echo $course->SoLuong; ?></td>
                                        <td><?php echo $course->SoLuongDaDangKy; ?></td>
                                        <td><?php echo $course->SoLuong - $course->SoLuongDaDangKy; ?></td>
                                        <td>
                                            <?php if(!isset($_SESSION['masv'])): ?>
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="fa fa-lock"></i> Đăng Ký
                                                </button>
                                            <?php else: ?>
                                                <?php if($course->SoLuongDaDangKy >= $course->SoLuong): ?>
                                                    <button class="btn btn-secondary btn-sm" disabled>
                                                        <i class="fa fa-ban"></i> Đã đủ số lượng
                                                    </button>
                                                <?php else: ?>
                                                    <?php if(in_array($course->MaHP, $data['registered_courses'])): ?>
                                                        <button class="btn btn-success btn-sm" disabled>
                                                            <i class="fa fa-check"></i> Đã Đăng Ký
                                                        </button>
                                                    <?php else: ?>
                                                        <a href="<?php echo URLROOT; ?>/courses/register/<?php echo $course->MaHP; ?>" 
                                                           class="btn btn-primary btn-sm">
                                                            <i class="fa fa-plus"></i> Đăng Ký
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 