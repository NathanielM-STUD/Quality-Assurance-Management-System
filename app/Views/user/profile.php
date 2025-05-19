<?= $this->extend('user/templates/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">My Profile</h1>
    
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    
    <form action="<?= base_url('user/profile/update') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="form-group mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" value="<?= $user['username'] ?>" readonly>
        </div>
        
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" value="<?= $user['email'] ?>" readonly>
        </div>
        
        <div class="form-group mb-3">
            <label for="full_name">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required 
                   value="<?= set_value('full_name', $user['full_name']) ?>">
        </div>
        
        <div class="form-group mb-3">
            <label for="department_id">Department</label>
            <select class="form-control" id="department_id" name="department_id">
                <option value="">-- Select Department --</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept['id'] ?>" <?= set_select('department_id', $dept['id'], $dept['id'] == $user['department_id']) ?>>
                        <?= $dept['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label for="password">New Password (Leave blank to keep current)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        
        <div class="form-group mb-3">
            <label for="password_confirm">Confirm New Password</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm">
        </div>
        
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="<?= base_url('user/dashboard') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>