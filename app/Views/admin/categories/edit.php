<?= $this->extend('admin/templates/template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Document Category</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/categories') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<form method="post" action="<?= base_url("admin/categories/update/{$category['id']}") ?>">
    <input type="hidden" name="_method" value="PUT">

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $category['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $category['description']) ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="requirements" class="form-label">Requirements</label>
                <textarea class="form-control" id="requirements" name="requirements" rows="5" required><?= old('requirements', $category['requirements']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="deadline_day" class="form-label">Submission Deadline Day</label>
                <select class="form-select" id="deadline_day" name="deadline_day">
                    <option value="">No deadline</option>
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <option value="<?= $i ?>" <?= $category['deadline_day'] == $i ? 'selected' : '' ?>>
                            <?= $i ?><sup><?= $i % 10 == 1 && $i != 11 ? 'st' : ($i % 10 == 2 && $i != 12 ? 'nd' : ($i % 10 == 3 && $i != 13 ? 'rd' : 'th')) ?></sup> of month
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Update Category</button>
</form>

<?= $this->endSection() ?>
