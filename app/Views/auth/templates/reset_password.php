<?= $this->extend('auth/templates/auth_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm my-5">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h1 class="h4 text-gray-900 mb-2">Reset Your Password</h1>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('reset-password/' . $token) ?>" method="post" class="user">
                        <?= csrf_field() ?>

                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-user" id="password" name="password" 
                                   placeholder="New Password" required>
                            <?php if (isset($validation) && $validation->hasError('password')): ?>
                                <div class="invalid-feedback d-block"><?= $validation->getError('password') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-user" id="password_confirm" name="password_confirm" 
                                   placeholder="Confirm New Password" required>
                            <?php if (isset($validation) && $validation->hasError('password_confirm')): ?>
                                <div class="invalid-feedback d-block"><?= $validation->getError('password_confirm') ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>