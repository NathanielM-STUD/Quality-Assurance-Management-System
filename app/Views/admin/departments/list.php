<?= $this->extend('admin/templates/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Departments</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= site_url('admin/departments/new') ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-circle"></i> Add Department
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Department Name</th>
                <th>Representatives</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($departments as $index => $department): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $department['name'] ?></td>
                <td><?= $department['representatives'] ?? 'None' ?></td>
                <td>
                    <a href="<?= site_url("admin/departments/edit/{$department['id']}") ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="<?= site_url("admin/departments/{$department['id']}") ?>" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this department?')">
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