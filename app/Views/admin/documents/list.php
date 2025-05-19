<?= $this->extend('admin/templates/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Document Submissions</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>Filters</h5>
    </div>
    <div class="card-body">
        <form method="get" action="<?= site_url('admin/documents') ?>">
            <div class="row">
                <div class="col-md-3">
                    <label for="department_id" class="form-label">Department</label>
                    <select class="form-select" id="department_id" name="department_id">
                        <option value="">All Departments</option>
                        <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['id'] ?>" <?= $filters['department_id'] == $dept['id'] ? 'selected' : '' ?>>
                            <?= $dept['name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $filters['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                            <?= $cat['name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        <option value="pending" <?= $filters['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="reviewed" <?= $filters['status'] == 'reviewed' ? 'selected' : '' ?>>Reviewed</option>
                        <option value="approved" <?= $filters['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="rejected" <?= $filters['status'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="start_date" class="form-label">From</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $filters['start_date'] ?>">
                </div>
                <div class="col-md-2">
                    <label for="end_date" class="form-label">To</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $filters['end_date'] ?>">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary me-2">Apply Filters</button>
                    <a href="<?= site_url('admin/documents') ?>" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Department</th>
                <th>Category</th>
                <th>Submitted By</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($submissions as $submission): ?>
            <tr>
                <td><?= $submission['id'] ?></td>
                <td><?= $submission['title'] ?></td>
                <td><?= $submission['department_name'] ?></td>
                <td><?= $submission['category_name'] ?></td>
                <td><?= $submission['submitted_by'] ?></td>
                <td><?= date('M d, Y', strtotime($submission['submitted_at'])) ?></td>
                <td>
                    <span class="badge 
                        <?= $submission['status'] == 'approved' ? 'bg-success' : '' ?>
                        <?= $submission['status'] == 'pending' ? 'bg-warning text-dark' : '' ?>
                        <?= $submission['status'] == 'reviewed' ? 'bg-info' : '' ?>
                        <?= $submission['status'] == 'rejected' ? 'bg-danger' : '' ?>">
                        <?= ucfirst($submission['status']) ?>
                    </span>
                </td>
                <td>
                    <a href="<?= site_url("admin/documents/view/{$submission['id']}") ?>" class="btn btn-sm btn-outline-primary" title="View">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="<?= site_url("admin/documents/download/{$submission['id']}") ?>" class="btn btn-sm btn-outline-success" title="Download">
                        <i class="bi bi-download"></i>
                    </a>
                    <a href="<?= site_url("admin/documents/history/{$submission['id']}") ?>" class="btn btn-sm btn-outline-secondary" title="History">
                        <i class="bi bi-clock-history"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>