<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container mt-4">
    <h2>DANH SÁCH HỌC PHẦN</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Mã Học Phần</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Số lượng dự kiến</th>
                    <th>Đã đăng ký</th>
                    <th>Còn lại</th>
                    <th>Đăng Ký</th>
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
                                <button class="btn btn-secondary" disabled>Đăng Ký</button>
                            <?php else: ?>
                                <?php if($course->SoLuongDaDangKy >= $course->SoLuong): ?>
                                    <button class="btn btn-secondary" disabled>Đã đủ số lượng</button>
                                <?php else: ?>
                                    <?php if(in_array($course->MaHP, $data['registered_courses'])): ?>
                                        <button class="btn btn-success" disabled>Đã Đăng Ký</button>
                                    <?php else: ?>
                                        <a href="<?php echo URLROOT; ?>/courses/register/<?php echo $course->MaHP; ?>" class="btn btn-primary">Đăng Ký</a>
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

<?php require APPROOT . '/views/inc/footer.php'; ?> 