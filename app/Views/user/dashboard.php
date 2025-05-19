<?= $this->extend('user/templates/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">User Dashboard</h1>
    
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>
    
    <div class="row">
        <!-- Summary Cards -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Submissions</h5>
                    <h2 class="card-text"><?= $totalSubmissions ?></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <h2 class="card-text"><?= $statusSummary['pending'] ?></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Reviewed</h5>
                    <h2 class="card-text"><?= $statusSummary['reviewed'] ?></h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Approved</h5>
                    <h2 class="card-text"><?= $statusSummary['approved'] ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Upcoming Requirements -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Upcoming Requirements</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($upcomingRequirements)): ?>
                        <p>No upcoming requirements.</p>
                    <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($upcomingRequirements as $req): ?>
                                <li class="list-group-item">
                                    <strong><?= $req['name'] ?></strong><br>
                                    Due on <?= date('F') ?> <?= $req['deadline_day'] ?><br>
                                    <small><?= $req['description'] ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Recent Notifications -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Recent Notifications</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($notifications)): ?>
                        <p>No recent notifications.</p>
                    <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($notifications as $notif): ?>
                                <li class="list-group-item">
                                    <strong><?= $notif['title'] ?></strong><br>
                                    <?= $notif['message'] ?><br>
                                    <small class="text-muted"><?= date('M j, Y g:i a', strtotime($notif['created_at'])) ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <div class="mt-3 text-center">
                        <a href="<?= base_url('user/notifications') ?>" class="btn btn-sm btn-outline-primary">View All Notifications</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Submissions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Recent Submissions</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($recentSubmissions)): ?>
                        <p>No recent submissions.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Date Submitted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentSubmissions as $submission): ?>
                                        <tr>
                                            <td><?= $submission['title'] ?></td>
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
                                            <td>
                                                <a href="<?= base_url('user/submissions/' . $submission['id']) ?>" class="btn btn-sm btn-info">View</a>
                                                <?php if ($submission['status'] == 'rejected'): ?>
                                                    <a href="<?= base_url('user/resubmit/' . $submission['id']) ?>" class="btn btn-sm btn-warning">Resubmit</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                    <div class="mt-3 text-center">
                        <a href="<?= base_url('user/submissions') ?>" class="btn btn-outline-primary">View All Submissions</a>
                        <a href="<?= base_url('user/submit') ?>" class="btn btn-primary">Submit New Document</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>