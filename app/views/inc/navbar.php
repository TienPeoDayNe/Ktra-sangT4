<?php
$current_page = isset($_GET['url']) ? $_GET['url'] : '';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == '' ? 'active' : ''; ?>" 
                       href="<?php echo URLROOT; ?>">Trang chủ</a>
                </li> -->
                <?php if(isset($_SESSION['masv'])) : ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'students' ? 'active' : ''; ?>" 
                       href="<?php echo URLROOT; ?>/students">Quản lý sinh viên</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'courses' ? 'active' : ''; ?>" 
                       href="<?php echo URLROOT; ?>/courses">
                        <i class="fa fa-book"></i> Đăng ký học phần
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if(isset($_SESSION['masv'])) : ?>
                    <li class="nav-item">
                        <span class="nav-link">Xin chào <?php echo $_SESSION['hoten']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>/auth/logout">Đăng xuất</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'auth/login' ? 'active' : ''; ?>" 
                           href="<?php echo URLROOT; ?>/auth/login">Đăng nhập</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav> 