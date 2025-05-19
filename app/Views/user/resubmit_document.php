<?= $this->extend('user/templates/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">Resubmit Document</h1>
    <p class="text-muted">Original submission: <?= $submission['title'] ?></p>
    
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>
    
    <form action="<?= base_url('user/resubmit/update/' . $submission['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="form-group mb-3">
            <label for="document_category_id">Document Category</label>
            <select class="form-control" id="document_category_id" name="document_category_id" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $submission['document_category_id'] ? 'selected' : '' ?>>
                        <?= $category['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label for="title">Document Title</label>
            <input type="text" class="form-control" id="title" name="title" required 
                   value="<?= set_value('title', $submission['title']) ?>">
        </div>
        
        <div class="form-group mb-3">
            <label for="description">Description (Optional)</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= set_value('description', $submission['description']) ?></textarea>
        </div>
        
        <div class="form-group mb-3">
            <label for="document">New Document File (PDF, DOC, DOCX)</label>
            <input type="file" class="form-control-file" id="document" name="document" required>
            <small class="form-text text-muted">Max file size: 5MB</small>
        </div>
        
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary">Resubmit Document</button>
            <a href="<?= base_url('user/submissions') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>