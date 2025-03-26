<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Thêm danh mục mới</h2>
                <a href="<?php echo URLROOT; ?>/category" class="btn btn-light float-right">
                    <i class="fa fa-backward"></i> Quay lại
                </a>
            </div>
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>/category/add" method="post">
                    <div class="form-group mb-3">
                        <label for="name">Tên danh mục: <sup>*</sup></label>
                        <input type="text" name="name" 
                               class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $data['name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Mô tả:</label>
                        <textarea name="description" 
                                  class="form-control <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>"
                                  rows="4"><?php echo $data['description']; ?></textarea>
                        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
