<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), 'dashboard') !== false ? 'active' : '' ?>" href="<?= site_url('admin/dashboard') ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), 'documents') !== false ? 'active' : '' ?>" href="<?= site_url('admin/documents') ?>">
                            <i class="bi bi-file-earmark-text"></i> Document Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), 'departments') !== false ? 'active' : '' ?>" href="<?= site_url('admin/departments') ?>">
                            <i class="bi bi-building"></i> Departments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), 'users') !== false ? 'active' : '' ?>" href="<?= site_url('admin/users') ?>">
                            <i class="bi bi-people"></i> User Management
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), 'categories') !== false ? 'active' : '' ?>" href="<?= site_url('admin/categories') ?>">
                            <i class="bi bi-tags"></i> Document Categories
                        </a>
                    </li>
                </ul>
            </div>
        </div>