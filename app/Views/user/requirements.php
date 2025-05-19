<?= $this->extend('user/templates/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">Document Requirements</h1>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Document Type</th>
                    <th>Description</th>
                    <th>Requirements</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category['name'] ?></td>
                        <td><?= $category['description'] ?></td>
                        <td><?= $category['requirements'] ?></td>
                        <td>
                            <?php if ($category['deadline_day']): ?>
                                Day <?= $category['deadline_day'] ?> of each month
                            <?php else: ?>
                                No fixed deadline
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('user/download/template/' . $category['id']) ?>" class="btn btn-sm btn-info">
                                Download Template
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>