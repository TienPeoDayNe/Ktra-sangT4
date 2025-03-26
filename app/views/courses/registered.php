<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Học phần đã đăng ký</h2>
                <div>
                    <?php if(!empty($data['courses'])) : ?>
                        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#confirmModal">
                            <i class="fa fa-save"></i> Lưu đăng ký
                        </button>
                        <form class="d-inline" action="<?php echo URLROOT; ?>/courses/deleteAll" method="post" 
                              onsubmit="return confirm('Bạn có chắc muốn xóa tất cả học phần đã đăng ký?');">
                            <button type="submit" class="btn btn-danger me-2">
                                <i class="fa fa-trash"></i> Xóa tất cả đăng ký
                            </button>
                        </form>
                    <?php endif; ?>
                    <a href="<?php echo URLROOT; ?>/courses" class="btn btn-light">
                        <i class="fa fa-backward"></i> Quay lại
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php flash('course_message'); ?>
                
                <!-- Thống kê -->
                <div class="alert alert-info mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Số học phần:</strong> <?php echo $data['stats']->SoHocPhan ?? 0; ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Tổng số tín chỉ:</strong> <?php echo $data['stats']->TongTinChi ?? 0; ?>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã học phần</th>
                                <th>Tên học phần</th>
                                <th>Số tín chỉ</th>
                                <th>Ngày đăng ký</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($data['courses'])) : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Bạn chưa đăng ký học phần nào</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach($data['courses'] as $course) : ?>
                                    <tr>
                                        <td><?php echo $course->MaHP; ?></td>
                                        <td><?php echo $course->TenHP; ?></td>
                                        <td><?php echo $course->SoTinChi; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($course->NgayDK)); ?></td>
                                        <td>
                                            <form class="d-inline" action="<?php echo URLROOT; ?>/courses/delete/<?php echo $course->MaHP; ?>" method="post"
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa học phần này?');">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-times"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận đăng ký -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Thông tin đăng ký</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo URLROOT; ?>/courses/save" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã số sinh viên:</label>
                        <input type="text" class="form-control" value="<?php echo $data['student']->MaSV; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Họ tên sinh viên:</label>
                        <input type="text" class="form-control" value="<?php echo $data['student']->HoTen; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngành học:</label>
                        <input type="text" class="form-control" value="<?php echo $data['student']->TenNganh; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày đăng ký:</label>
                        <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i:s'); ?>" readonly>
                    </div>
                    <div class="alert alert-info">
                        <strong>Số học phần đăng ký:</strong> <?php echo $data['stats']->SoHocPhan ?? 0; ?><br>
                        <strong>Tổng số tín chỉ:</strong> <?php echo $data['stats']->TongTinChi ?? 0; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 