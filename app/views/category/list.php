<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Quản lý danh mục</h2>
                <a href="<?php echo URLROOT; ?>/category/add" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Thêm danh mục mới
                </a>
            </div>
            <div class="card-body">
                <?php flash('category_message'); ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <th>Mô tả</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['categories'] as $category) : ?>
                                <tr>
                                    <td><?php echo $category->id; ?></td>
                                    <td><?php echo $category->name; ?></td>
                                    <td><?php echo $category->description; ?></td>
                                    <td>
                                        <a href="<?php echo URLROOT; ?>/category/edit/<?php echo $category->id; ?>" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form class="d-inline" action="<?php echo URLROOT; ?>/category/delete/<?php echo $category->id; ?>" method="post">
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">
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