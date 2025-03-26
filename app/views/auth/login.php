<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Đăng nhập</h2>
                        <p class="text-muted">Đăng nhập bằng mã sinh viên của bạn</p>
                    </div>

                    <?php flash('register_success'); ?>

                    <form action="<?php echo URLROOT; ?>/auth/login" method="post">
                        <div class="mb-4">
                            <label for="masv" class="form-label">Mã sinh viên</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0 <?php echo (!empty($data['masv_err'])) ? 'is-invalid' : ''; ?>" 
                                       id="masv" name="masv" value="<?php echo $data['masv']; ?>" 
                                       placeholder="Nhập mã sinh viên">
                                <div class="invalid-feedback">
                                    <?php echo $data['masv_err']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0">Chưa có tài khoản? 
                                <a href="/webbanhang/auth/register" class="text-primary text-decoration-none">Đăng ký ngay</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 