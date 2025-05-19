<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'ISO Management System' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            width: 250px;
            padding-top: 20px;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 10px 15px;
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        .navbar-brand {
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">ISO Management System</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> <?= session()->get('full_name') ?? 'User' ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('user/profile') ?>"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar d-none d-md-block">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('user/dashboard') ? 'active' : '' ?>" href="<?= base_url('user/dashboard') ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('user/submit') ? 'active' : '' ?>" href="<?= base_url('user/submit') ?>">
                    <i class="fas fa-upload"></i> Submit Document
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('user/submissions') ? 'active' : '' ?>" href="<?= base_url('user/submissions') ?>">
                    <i class="fas fa-list"></i> My Submissions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('user/requirements') ? 'active' : '' ?>" href="<?= base_url('user/requirements') ?>">
                    <i class="fas fa-file-alt"></i> Document Requirements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('user/notifications') ? 'active' : '' ?>" href="<?= base_url('user/notifications') ?>">
                    <i class="fas fa-bell"></i> Notifications
                    <?php if (isset($unreadCount) && $unreadCount > 0): ?>
                        <span class="badge bg-danger float-end"><?= $unreadCount ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
    </div>

    <!-- Mobile Sidebar Toggle -->
    <button class="btn btn-dark d-md-none position-fixed bottom-0 start-0 m-3" style="z-index: 1000;" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Mobile Sidebar -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header bg-dark text-white">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= current_url() == base_url('user/dashboard') ? 'active' : '' ?>" href="<?= base_url('user/dashboard') ?>">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() == base_url('user/submit') ? 'active' : '' ?>" href="<?= base_url('user/submit') ?>">
                        <i class="fas fa-upload me-2"></i> Submit Document
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() == base_url('user/submissions') ? 'active' : '' ?>" href="<?= base_url('user/submissions') ?>">
                        <i class="fas fa-list me-2"></i> My Submissions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() == base_url('user/requirements') ? 'active' : '' ?>" href="<?= base_url('user/requirements') ?>">
                        <i class="fas fa-file-alt me-2"></i> Document Requirements
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= current_url() == base_url('user/notifications') ? 'active' : '' ?>" href="<?= base_url('user/notifications') ?>">
                        <i class="fas fa-bell me-2"></i> Notifications
                        <?php if (isset($unreadCount) && $unreadCount > 0): ?>
                            <span class="badge bg-danger float-end"><?= $unreadCount ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>
</html>