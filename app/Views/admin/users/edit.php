<?= $this->extend('admin/templates/template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit User</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= site_url('admin/users') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<?php if (isset($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $error): ?>
        <p><?= esc($error) ?></p>
    <?php endforeach ?>
</div>
<?php endif; ?>

<form method="post" action="<?= base_url("admin/users/update/{$user['id']}") ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name', $user['full_name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="representative" <?= old('role', $user['role']) == 'representative' ? 'selected' : '' ?>>Department Representative</option>
                </select>
            </div>
            <div class="mb-3" id="department-field" style="<?= $user['role'] == 'representative' ? '' : 'display: none;' ?>">
                <label for="department_id" class="form-label">Department</label>
                <select class="form-select" id="department_id" name="department_id">
                    <option value="">Select Department</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['id'] ?>" <?= old('department_id', $user['department_id']) == $dept['id'] ? 'selected' : '' ?>>
                            <?= esc($dept['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="text-muted">Leave blank to keep current password</small>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Update User</button>
</form>

<script>
    document.getElementById('role').addEventListener('change', function() {
        const departmentField = document.getElementById('department-field');
        if (this.value === 'representative') {
            departmentField.style.display = 'block';
            document.getElementById('department_id').setAttribute('required', '');
        } else {
            departmentField.style.display = 'none';
            document.getElementById('department_id').removeAttribute('required');
        }
    });
</script>

<?= $this->endSection() ?>
