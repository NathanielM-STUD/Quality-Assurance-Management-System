<?= $this->extend('admin/templates/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Document Categories</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= site_url('admin/categories/new') ?>" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-circle"></i> Add Category
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Deadline Day</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $index => $category): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $category['name'] ?></td>
                <td>
                    <?php if ($category['deadline_day']): ?>
                    <?= $category['deadline_day'] ?><sup><?= $category['deadline_day'] % 10 == 1 ? 'st' : ($category['deadline_day'] % 10 == 2 ? 'nd' : ($category['deadline_day'] % 10 == 3 ? 'rd' : 'th')) ?></sup> of month
                    <?php else: ?>
                    No deadline
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= site_url("admin/categories/edit/{$category['id']}") ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="<?= site_url("admin/categories/{$category['id']}") ?>" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this category?')">
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