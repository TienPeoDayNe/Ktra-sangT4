<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Đăng ký tài khoản</h2>
                        <p class="text-muted">Tạo tài khoản mới để quản lý sản phẩm</p>
                    </div>

                    <form action="/webbanhang/auth/register" method="post">
                        <div class="mb-4">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0 <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" 
                                       id="username" name="username" value="<?php echo $data['username']; ?>" 
                                       placeholder="Nhập tên đăng nhập">
                                <div class="invalid-feedback">
                                    <?php echo $data['username_err']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input type="email" class="form-control border-start-0 ps-0 <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                       id="email" name="email" value="<?php echo $data['email']; ?>" 
                                       placeholder="Nhập địa chỉ email">
                                <div class="invalid-feedback">
                                    <?php echo $data['email_err']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user-circle text-primary"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0" 
                                       id="fullname" name="fullname" value="<?php echo $data['fullname']; ?>" 
                                       placeholder="Nhập họ và tên">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 ps-0 <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                                       id="password" name="password" placeholder="Nhập mật khẩu">
                                <div class="invalid-feedback">
                                    <?php echo $data['password_err']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 ps-0 <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" 
                                       id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu">
                                <div class="invalid-feedback">
                                    <?php echo $data['confirm_password_err']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i> Đăng ký
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0">Đã có tài khoản? 
                                <a href="/webbanhang/auth/login" class="text-primary text-decoration-none">Đăng nhập</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?> 