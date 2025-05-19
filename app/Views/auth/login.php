<?= $this->extend('auth/templates/auth_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm my-5">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h1 class="h4 text-gray-900 mb-3">ISO Management System</h1>
                        <h2 class="h5 text-gray-800">Sign in to your account</h2>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('login/attempt') ?>" method="post" class="user">
                        <?= csrf_field() ?>

                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-user" id="username" name="username" 
                                   placeholder="Enter Username" value="<?= set_value('username') ?>" required>
                            <?php if (isset($validation) && $validation->hasError('username')): ?>
                                <div class="invalid-feedback d-block"><?= $validation->getError('username') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-user" id="password" name="password" 
                                   placeholder="Password" required>
                            <?php if (isset($validation) && $validation->hasError('password')): ?>
                                <div class="invalid-feedback d-block"><?= $validation->getError('password') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                <label class="custom-control-label" for="remember">Remember Me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Login
                        </button>
                    </form>

                    <hr>

                    <div class="text-center">
                        <a class="small" href="<?= base_url('forgot-password') ?>">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>