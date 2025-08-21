<!-- Bagian ini hanya berisi konten utama, akan dimuat di dalam layout admin Anda -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Edit Courier</h4>
    </div>
    <div class="card-body">
        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

        <?php echo form_open('admin/courier/update/' . $courier->id); ?>
        <div class="mb-3">
            <label for="name" class="form-label">Courier Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo set_value('name', $courier->name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Courier Code</label>
            <input type="text" name="code" id="code" class="form-control" value="<?php echo set_value('code', $courier->code); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control"><?php echo set_value('description', $courier->description); ?></textarea>
        </div>
        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo set_checkbox('is_active', '1', ($courier->is_active == 1)); ?>>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
        <button type="submit" class="btn btn-primary me-2">Update</button>
        <a href="<?php echo site_url('admin/courier'); ?>" class="btn btn-secondary">Batal</a>
        <?php echo form_close(); ?>
    </div>
</div>