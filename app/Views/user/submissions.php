<?= $this->extend('user/templates/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">My Submissions</h1>
    
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    
    <div class="mb-3">
        <a href="<?= base_url('user/submit') ?>" class="btn btn-primary">Submit New Document</a>
    </div>
    
    <?php if (empty($submissions)): ?>
        <div class="alert alert-info">You haven't submitted any documents yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date Submitted</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission): ?>
                        <tr>
                            <td><?= $submission['title'] ?></td>
                            <td><?= $submission['category_name'] ?></td>
                            <td>
                                <?php 
                                $badgeClass = 'bg-secondary';
                                if ($submission['status'] == 'approved') $badgeClass = 'bg-success';
                                elseif ($submission['status'] == 'rejected') $badgeClass = 'bg-danger';
                                elseif ($submission['status'] == 'reviewed') $badgeClass = 'bg-warning';
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= ucfirst($submission['status']) ?></span>
                            </td>
                            <td><?= date('M j, Y g:i a', strtotime($submission['submitted_at'])) ?></td>
                            <td><?= $submission['remarks'] ?? 'None' ?></td>
                            <td>
                                <a href="<?= base_url('user/download/' . $submission['id']) ?>" class="btn btn-sm btn-info" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                <?php if ($submission['status'] == 'rejected'): ?>
                                    <a href="<?= base_url('user/resubmit/' . $submission['id']) ?>" class="btn btn-sm btn-warning" title="Resubmit">
                                        <i class="fas fa-upload"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>