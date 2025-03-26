<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="jumbotron text-center">
    <div class="container">
        <h1 class="display-3"><?php echo $data['title']; ?></h1>
        <p class="lead"><?php echo $data['description']; ?></p>
        <?php if(!isset($_SESSION['masv'])) : ?>
            <p><a class="btn btn-primary btn-lg" href="<?php echo URLROOT; ?>/auth/login" role="button">Đăng nhập</a></p>
        <?php endif; ?>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?> 