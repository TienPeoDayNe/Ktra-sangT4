<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Thêm sinh viên mới</h2>
                <a href="<?php echo URLROOT; ?>/students" class="btn btn-light float-right">
                    <i class="fa fa-backward"></i> Quay lại
                </a>
            </div>
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>/students/add" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="masv">Mã sinh viên: <sup>*</sup></label>
                        <input type="text" name="masv" 
                               class="form-control <?php echo (!empty($data['masv_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $data['masv']; ?>">
                        <span class="invalid-feedback"><?php echo $data['masv_err']; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="hoten">Họ tên: <sup>*</sup></label>
                        <input type="text" name="hoten" 
                               class="form-control <?php echo (!empty($data['hoten_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $data['hoten']; ?>">
                        <span class="invalid-feedback"><?php echo $data['hoten_err']; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="gioitinh">Giới tính:</label>
                        <select name="gioitinh" class="form-control">
                            <option value="Nam" <?php echo ($data['gioitinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo ($data['gioitinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="ngaysinh">Ngày sinh: <sup>*</sup></label>
                        <input type="date" name="ngaysinh" 
                               class="form-control <?php echo (!empty($data['ngaysinh_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $data['ngaysinh']; ?>">
                        <span class="invalid-feedback"><?php echo $data['ngaysinh_err']; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="hinh">Hình:</label>
                        <input type="file" name="hinh" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="manganh">Ngành học: <sup>*</sup></label>
                        <select name="manganh" 
                                class="form-control <?php echo (!empty($data['manganh_err'])) ? 'is-invalid' : ''; ?>">
                            <option value="">Chọn ngành học</option>
                            <?php foreach($data['majors'] as $major) : ?>
                                <option value="<?php echo $major->MaNganh; ?>" 
                                        <?php echo ($data['manganh'] == $major->MaNganh) ? 'selected' : ''; ?>>
                                    <?php echo $major->TenNganh; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['manganh_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Thêm sinh viên</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?> 