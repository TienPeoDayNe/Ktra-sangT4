<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Danh sách học phần đã đăng ký</h2>
                    <div>
                        <a href="<?php echo URLROOT; ?>/courses" class="btn btn-info">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                        <?php if(!empty($data['courses'])): ?>
                            <form action="<?php echo URLROOT; ?>/courses/confirm" method="POST" class="d-inline">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Lưu đăng ký học phần
                                </button>
                            </form>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAllModal">
                                <i class="fa fa-trash"></i> Xóa tất cả
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <?php flash('course_message'); ?>

                    <!-- Thông tin sinh viên -->
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>MSSV:</strong> <?php echo $data['student']->MaSV; ?>
                            </div>
                            <div class="col-md-4">
                                <strong>Họ tên:</strong> <?php echo $data['student']->HoTen; ?>
                            </div>
                            <div class="col-md-4">
                                <strong>Ngành:</strong> <?php echo $data['student']->TenNganh; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Thống kê -->
                    <div class="alert alert-warning">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Số học phần:</strong> <?php echo $data['stats']->SoHocPhan ?? 0; ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Tổng số tín chỉ:</strong> <?php echo $data['stats']->TongTinChi ?? 0; ?>
                            </div>
                        </div>
                    </div>

                    <?php if(empty($data['courses'])): ?>
                        <div class="alert alert-warning">
                            Bạn chưa đăng ký học phần nào.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Mã học phần</th>
                                        <th>Tên học phần</th>
                                        <th>Số tín chỉ</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data['courses'] as $course): ?>
                                        <tr>
                                            <td><?php echo $course->MaHP; ?></td>
                                            <td><?php echo $course->TenHP; ?></td>
                                            <td><?php echo $course->SoTinChi; ?></td>
                                            <td><?php echo date('d/m/Y H:i:s', strtotime($course->NgayDK)); ?></td>
                                            <td>
                                                <a href="<?php echo URLROOT; ?>/courses/delete/<?php echo $course->MaHP; ?>" 
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Bạn có chắc muốn hủy đăng ký học phần này?');">
                                                    <i class="fa fa-trash"></i> Hủy
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa tất cả -->
<div class="modal fade" id="deleteAllModal" tabindex="-1" role="dialog" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAllModalLabel">Xác nhận xóa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa tất cả học phần đã đăng ký?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <a href="<?php echo URLROOT; ?>/courses/deleteAll" class="btn btn-danger">Xác nhận xóa</a>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 