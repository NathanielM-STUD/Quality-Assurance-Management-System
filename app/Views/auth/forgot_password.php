<?= $this->extend('auth/templates/auth_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm my-5">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                        <p class="text-muted">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('forgot-password/send') ?>" method="post" class="user">
                        <?= csrf_field() ?>

                        <div class="form-group mb-3">
                            <input type="email" class="form-control form-control-user" id="email" name="email" 
                                   placeholder="Enter Email Address" value="<?= set_value('email') ?>" required>
                            <?php if (isset($validation) && $validation->hasError('email')): ?>
                                <div class="invalid-feedback d-block"><?= $validation->getError('email') ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Reset Password
                        </button>
                    </form>

                    <hr>

                    <div class="text-center">
                        <a class="small" href="<?= base_url('login') ?>">Already have an account? Login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>