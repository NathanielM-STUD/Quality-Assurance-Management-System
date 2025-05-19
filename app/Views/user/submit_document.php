<?= $this->extend('user/templates/layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">Submit Document</h1>
    
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>
    
    <form action="<?= base_url('user/submit/save') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="form-group mb-3">
            <label for="document_category_id">Document Category</label>
            <select class="form-control" id="document_category_id" name="document_category_id" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= set_select('document_category_id', $category['id']) ?>>
                        <?= $category['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group mb-3">
            <label for="title">Document Title</label>
            <input type="text" class="form-control" id="title" name="title" required 
                   value="<?= set_value('title') ?>">
        </div>
        
        <div class="form-group mb-3">
            <label for="description">Description (Optional)</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= set_value('description') ?></textarea>
        </div>
        
        <div class="form-group mb-3">
            <label for="document">Document File (PDF, DOC, DOCX)</label>
            <input type="file" class="form-control-file" id="document" name="document" required>
            <small class="form-text text-muted">Max file size: 5MB</small>
        </div>
        
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary">Submit Document</button>
            <a href="<?= base_url('user/dashboard') ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>