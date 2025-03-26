<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2><?php echo $data['title']; ?></h2>
                <a href="<?php echo URLROOT; ?>/students" class="btn btn-light float-right">
                    <i class="fa fa-backward"></i> Quay lại
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <?php if($data['student']->Hinh) : ?>
                            <img src="<?php echo URLROOT . '/' . $data['student']->Hinh; ?>" 
                                 alt="<?php echo $data['student']->HoTen; ?>" 
                                 class="img-fluid rounded" style="max-width: 300px;">
                        <?php else : ?>
                            <img src="<?php echo URLROOT; ?>/img/no-image.jpg" 
                                 alt="No Image" 
                                 class="img-fluid rounded" style="max-width: 300px;">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <table class="table">
                            <tr>
                                <th style="width: 150px;">Mã sinh viên:</th>
                                <td><?php echo $data['student']->MaSV; ?></td>
                            </tr>
                            <tr>
                                <th>Họ tên:</th>
                                <td><?php echo $data['student']->HoTen; ?></td>
                            </tr>
                            <tr>
                                <th>Giới tính:</th>
                                <td><?php echo $data['student']->GioiTinh; ?></td>
                            </tr>
                            <tr>
                                <th>Ngày sinh:</th>
                                <td><?php echo date('d/m/Y', strtotime($data['student']->NgaySinh)); ?></td>
                            </tr>
                            <tr>
                                <th>Ngành học:</th>
                                <td><?php echo $data['student']->TenNganh; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?> 