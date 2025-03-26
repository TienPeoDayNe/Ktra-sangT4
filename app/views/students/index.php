<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Quản lý sinh viên</h2>
                <a href="<?php echo URLROOT; ?>/students/add" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Thêm sinh viên mới
                </a>
            </div>
            <div class="card-body">
                <?php flash('student_message'); ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã SV</th>
                                <th>Hình</th>
                                <th>Họ tên</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Ngành học</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['students'] as $student) : ?>
                                <tr>
                                    <td><?php echo $student->MaSV; ?></td>
                                    <td>
                                        <?php if($student->Hinh) : ?>
                                            <img src="<?php echo URLROOT . '/' . $student->Hinh; ?>" 
                                                 alt="<?php echo $student->HoTen; ?>" 
                                                 style="max-width: 50px;">
                                        <?php else : ?>
                                            <img src="<?php echo URLROOT; ?>/img/no-image.jpg" 
                                                 alt="No Image" 
                                                 style="max-width: 50px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $student->HoTen; ?></td>
                                    <td><?php echo $student->GioiTinh; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($student->NgaySinh)); ?></td>
                                    <td><?php echo $student->TenNganh; ?></td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/students/show/<?php echo $student->MaSV; ?>" 
                                           class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="<?php echo URLROOT; ?>/students/edit/<?php echo $student->MaSV; ?>" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form class="d-inline" action="<?php echo URLROOT; ?>/students/delete/<?php echo $student->MaSV; ?>" method="post">
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
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
<?php require APPROOT . '/views/inc/footer.php'; ?> 