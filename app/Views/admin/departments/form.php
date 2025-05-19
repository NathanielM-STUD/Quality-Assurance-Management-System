<?= $this->extend('admin/templates/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= isset($department) ? 'Edit Department' : 'Add New Department' ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= site_url('admin/departments') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <form method="post" action="<?= isset($department) ? site_url("admin/departments/{$department['id']}") : site_url('admin/departments') ?>">
            <?php if (isset($department)): ?>
            <input type="hidden" name="_method" value="PUT">
            <?php endif; ?>
            
            <div class="mb-3">
                <label for="name" class="form-label">Department Name</label>
                <input type="text" class="form-control" id="name" name="name" 
                    value="<?= isset($department) ? $department['name'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= isset($department) ? $department['description'] : '' ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><?= isset($department) ? 'Update Department' : 'Add Department' ?></button>
        </form>
    </div>
    
    <?php if (isset($department) && isset($representatives)): ?>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Department Representatives</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($representatives)): ?>
                <ul class="list-group">
                    <?php foreach ($representatives as $rep): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $rep['full_name'] ?>
                        <a href="<?= site_url("admin/users/{$rep['id']}/edit") ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>No representatives assigned to this department.</p>
                <?php endif; ?>
                <div class="mt-3">
                    <a href="<?= site_url('admin/users/new') ?>?department_id=<?= $department['id'] ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Add Representative
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>