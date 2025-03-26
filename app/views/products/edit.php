<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Sửa sản phẩm</h2>
                <a href="<?php echo URLROOT; ?>/product" class="btn btn-light float-right">
                    <i class="fa fa-backward"></i> Quay lại
                </a>
            </div>
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>/product/edit/<?php echo $data['id']; ?>" 
                      method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Tên sản phẩm: <sup>*</sup></label>
                        <input type="text" name="name" 
                               class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $data['name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả:</label>
                        <textarea name="description" 
                                  class="form-control <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>"
                                  rows="4"><?php echo $data['description']; ?></textarea>
                        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="price">Giá: <sup>*</sup></label>
                        <input type="number" name="price" 
                               class="form-control <?php echo (!empty($data['price_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $data['price']; ?>">
                        <span class="invalid-feedback"><?php echo $data['price_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Danh mục: <sup>*</sup></label>
                        <select name="category_id" 
                                class="form-control <?php echo (!empty($data['category_id_err'])) ? 'is-invalid' : ''; ?>">
                            <option value="">Chọn danh mục</option>
                            <?php foreach($data['categories'] as $category) : ?>
                                <option value="<?php echo $category->id; ?>" 
                                    <?php echo ($data['category_id'] == $category->id) ? 'selected' : ''; ?>>
                                    <?php echo $category->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['category_id_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="image">Hình ảnh hiện tại:</label>
                        <?php if($data['image']) : ?>
                            <div>
                                <img src="<?php echo URLROOT . '/' . $data['image']; ?>" 
                                     alt="<?php echo $data['name']; ?>" 
                                     style="max-width: 200px;">
                            </div>
                        <?php else : ?>
                            <p>Chưa có hình ảnh</p>
                        <?php endif; ?>
                        <label for="image">Thay đổi hình ảnh:</label>
                        <input type="file" name="image" class="form-control-file">
                    </div>
                    <input type="submit" class="btn btn-success" value="Cập nhật sản phẩm">
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?> 