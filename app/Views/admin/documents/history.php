<?= $this->extend('admin/templates/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Submission History</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= site_url("admin/documents/view/{$submission['id']}") ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Submission
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Submission: <?= $submission['title'] ?></h5>
    </div>
    <div class="card-body">
        <ul class="timeline">
            <?php foreach ($history as $item): ?>
            <li class="timeline-item">
                <div class="timeline-item-header">
                    <div class="d-flex justify-content-between">
                        <strong><?= $item['user_name'] ?></strong>
                        <small class="text-muted"><?= date('M d, Y H:i', strtotime($item['created_at'])) ?></small>
                    </div>
                    <div>
                        <?php if ($item['action'] == 'status_change'): ?>
                        <span class="badge bg-primary">Status Changed</span>
                        <span class="badge bg-secondary"><?= ucfirst($item['old_status']) ?></span>
                        <i class="bi bi-arrow-right"></i>
                        <span class="badge 
                            <?= $item['new_status'] == 'approved' ? 'bg-success' : '' ?>
                            <?= $item['new_status'] == 'pending' ? 'bg-warning text-dark' : '' ?>
                            <?= $item['new_status'] == 'reviewed' ? 'bg-info' : '' ?>
                            <?= $item['new_status'] == 'rejected' ? 'bg-danger' : '' ?>">
                            <?= ucfirst($item['new_status']) ?>
                        </span>
                        <?php else: ?>
                        <span class="badge bg-secondary"><?= ucfirst($item['action']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="timeline-item-body">
                    <?php if (!empty($item['remarks'])): ?>
                    <p><?= $item['remarks'] ?></p>
                    <?php endif; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<style>
    .timeline {
        list-style: none;
        padding: 0;
    }
    .timeline-item {
        position: relative;
        padding: 0 0 20px 20px;
        border-left: 2px solid #dee2e6;
    }
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    .timeline-item-header {
        margin-bottom: 10px;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -7px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #0d6efd;
    }
</style>
<?= $this->endSection() ?>