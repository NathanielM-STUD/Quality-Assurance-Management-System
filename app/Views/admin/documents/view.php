<?= $this->extend('admin/templates/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">View Submission</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= site_url('admin/documents') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Submission Details</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Title</label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control-plaintext" value="<?= $submission['title'] ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Department</label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control-plaintext" value="<?= $submission['department_name'] ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Category</label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control-plaintext" value="<?= $submission['category_name'] ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Submitted By</label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control-plaintext" value="<?= $submission['submitted_by'] ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Submitted On</label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control-plaintext" value="<?= date('M d, Y H:i', strtotime($submission['submitted_at'])) ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                        <span class="badge 
                            <?= $submission['status'] == 'approved' ? 'bg-success' : '' ?>
                            <?= $submission['status'] == 'pending' ? 'bg-warning text-dark' : '' ?>
                            <?= $submission['status'] == 'reviewed' ? 'bg-info' : '' ?>
                            <?= $submission['status'] == 'rejected' ? 'bg-danger' : '' ?>">
                            <?= ucfirst($submission['status']) ?>
                        </span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <textarea readonly class="form-control-plaintext" rows="3"><?= $submission['description'] ?></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Document</label>
                    <div class="col-sm-9">
                        <a href="<?= site_url("admin/documents/download/{$submission['id']}") ?>" class="btn btn-outline-primary">
                            <i class="bi bi-download"></i> Download Document
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Review Submission</h5>
            </div>
            <div class="card-body">
                <form method="post" action="<?= site_url("admin/documents/update-status/{$submission['id']}") ?>">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Select Status</option>
                            <?php if ($submission['status'] == 'pending'): ?>
                            <option value="reviewed">Mark as Reviewed</option>
                            <?php elseif ($submission['status'] == 'reviewed'): ?>
                            <option value="approved">Approve</option>
                            <option value="rejected">Reject</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5>Requirements</h5>
            </div>
            <div class="card-body">
                <?= $submission['requirements'] ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Remarks History</h5>
        <a href="<?= site_url("admin/documents/history/{$submission['id']}") ?>" class="btn btn-sm btn-outline-primary">View Full History</a>
    </div>
    <div class="card-body">
        <?php if (!empty($submission['remarks'])): ?>
        <div class="mb-3 p-3 bg-light rounded">
            <div class="d-flex justify-content-between mb-2">
                <strong>Current Remarks</strong>
                <small class="text-muted"><?= date('M d, Y H:i', strtotime($submission['updated_at'])) ?></small>
            </div>
            <p><?= $submission['remarks'] ?></p>
        </div>
        <?php else: ?>
        <p>No remarks yet.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>