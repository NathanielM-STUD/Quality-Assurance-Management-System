<?= $this->extend('admin/templates/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Users</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= site_url('admin/users/new') ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-circle"></i> Add User
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $index => $user): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $user['full_name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td>
                    <span class="badge <?= $user['role'] == 'admin' ? 'bg-primary' : 'bg-secondary' ?>">
                        <?= ucfirst($user['role']) ?>
                    </span>
                </td>
                <td><?= $user['department_name'] ?? 'N/A' ?></td>
                <td>
                    <a href="<?= site_url("admin/users/{$user['id']}/edit") ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="<?= site_url("admin/users/reset-password/{$user['id']}") ?>" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Reset Password" onclick="return confirm('Reset password for this user?')">
                            <i class="bi bi-key"></i>
                        </button>
                    </form>
                    <form action="<?= site_url("admin/users/{$user['id']}") ?>" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>