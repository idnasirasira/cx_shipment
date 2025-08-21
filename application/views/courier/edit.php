<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Courier</h3>
                <p class="text-subtitle text-muted">Update courier information</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('courier') ?>">Courier</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Courier</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Courier Information</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($errors) && $errors) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Please correct the following errors:
                                <?= $errors ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('courier/edit/' . $courier->id) ?>" method="POST" class="form form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    <!-- Courier Information -->
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Courier Information</h5>

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label">Name *</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    id="name"
                                                    class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>"
                                                    name="name"
                                                    placeholder="Enter name"
                                                    value="<?= set_value('name', $courier->name) ?>"
                                                    required>
                                                <?= form_error('name', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="code" class="col-sm-3 col-form-label">Code</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    id="code"
                                                    class="form-control <?= form_error('code') ? 'is-invalid' : '' ?>"
                                                    name="code"
                                                    placeholder="Enter code number"
                                                    value="<?= set_value('code', $courier->code) ?>">
                                                <?= form_error('code', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-9">
                                                <textarea id="description"
                                                    class="form-control <?= form_error('description') ? 'is-invalid' : '' ?>"
                                                    name="description"
                                                    placeholder="Enter description"
                                                    rows="3"><?= set_value('description', $courier->description) ?></textarea>
                                                <?= form_error('description', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 d-flex justify-content-end">
                                            <a href="<?= base_url('courier') ?>" class="btn btn-light-secondary me-1 mb-1">
                                                <i class="bi bi-arrow-left"></i> Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                <i class="bi bi-check-circle"></i> Update Courier
                                            </button>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>