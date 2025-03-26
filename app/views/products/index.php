<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2>Quản lý sản phẩm</h2>
                <a href="<?php echo URLROOT; ?>/product/add" class="btn btn-primary float-right">
                    <i class="fa fa-plus"></i> Thêm sản phẩm mới
                </a>
            </div>
            <div class="card-body">
                <?php flash('product_message'); ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Danh mục</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['products'] as $product) : ?>
                                <tr>
                                    <td><?php echo $product->id; ?></td>
                                    <td>
                                        <?php if($product->image) : ?>
                                            <img src="<?php echo URLROOT . '/' . $product->image; ?>" 
                                                 alt="<?php echo $product->name; ?>" 
                                                 style="max-width: 50px;">
                                        <?php else : ?>
                                            <img src="<?php echo URLROOT; ?>/img/no-image.jpg" 
                                                 alt="No Image" 
                                                 style="max-width: 50px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $product->name; ?></td>
                                    <td><?php echo number_format($product->price, 0, ',', '.'); ?> đ</td>
                                    <td><?php echo $product->category_name; ?></td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/product/edit/<?php echo $product->id; ?>" 
                                           class="btn btn-sm btn-info">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="<?php echo URLROOT; ?>/product/delete/<?php echo $product->id; ?>" 
                                              method="post" style="display: inline;">
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
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