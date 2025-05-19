<?= $this->extend('admin/templates/template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard Overview</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <i class="bi bi-calendar"></i> This week
        </button>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Today's Submissions</h5>
                        <h2 class="card-text"><?= $todaySubmissions ?></h2>
                    </div>
                    <i class="bi bi-file-earmark-text" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">This Month's Submissions</h5>
                        <h2 class="card-text"><?= $monthSubmissions ?></h2>
                    </div>
                    <i class="bi bi-calendar-month" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Submission Status</h5>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Department Compliance</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Approved</th>
                                <th>Pending</th>
                                <th>Rejected</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($departmentsCompliance as $dept): ?>
                            <tr>
                                <td><?= $dept['name'] ?></td>
                                <td><?= $dept['approved_count'] ?? 0 ?></td>
                                <td><?= $dept['pending_count'] ?? 0 ?></td>
                                <td><?= $dept['rejected_count'] ?? 0 ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Notifications</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach ($notifications as $notification): ?>
                    <a href="#" class="list-group-item list-group-item-action <?= !$notification['is_read'] ? 'list-group-item-primary' : '' ?>">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1"><?= $notification['title'] ?></h6>
                            <small><?= time_ago($notification['created_at']) ?></small>
                        </div>
                        <p class="mb-1"><?= $notification['message'] ?></p>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Recent Activities</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>Document Approved</strong>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                        <div>QMS Manual for IT Department</div>
                    </li>
                    <li class="mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>New Submission</strong>
                            <small class="text-muted">5 hours ago</small>
                        </div>
                        <div>Audit Report for Finance Department</div>
                    </li>
                    <li class="mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>User Added</strong>
                            <small class="text-muted">1 day ago</small>
                        </div>
                        <div>New representative for HR Department</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: [
                <?php foreach ($statusSummary as $status): ?>
                '<?= ucfirst($status['status']) ?>',
                <?php endforeach; ?>
            ],
            datasets: [{
                data: [
                    <?php foreach ($statusSummary as $status): ?>
                    <?= $status['count'] ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [
                    '#ffc107', // Pending - yellow
                    '#17a2b8', // Reviewed - teal
                    '#28a745', // Approved - green
                    '#dc3545'  // Rejected - red
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>