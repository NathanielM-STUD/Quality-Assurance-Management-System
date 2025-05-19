<?= $this->extend('user/templates/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">Notifications</h1>
    
    <?php if (empty($notifications)): ?>
        <div class="alert alert-info">You don't have any notifications.</div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($notifications as $notif): ?>
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?= $notif['title'] ?></h5>
                        <small><?= date('M j, Y g:i a', strtotime($notif['created_at'])) ?></small>
                    </div>
                    <p class="mb-1"><?= $notif['message'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>