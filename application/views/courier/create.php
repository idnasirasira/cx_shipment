<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Create New User</h3>
                <p class="text-subtitle text-muted">Add a new user to the system</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create User</li>
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
                        <h4 class="card-title">User Information</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($validation_errors) && $validation_errors) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Please correct the following errors:
                                <?= $validation_errors ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('courier/store') ?>" method="POST" class="form form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    <!-- Personal Information -->
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Personal Information</h5>

                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label">Name *</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    id="name"
                                                    class="form-control "
                                                    name="name"
                                                    placeholder="Enter name"
                                                    value=""
                                                    required>
                                                <?= form_error('name', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="code" class="col-sm-3 col-form-label">Code</label>
                                            <div class="col-sm-9">
                                                <input type="number"
                                                    id="code"
                                                    class="form-control <?= form_error('code') ? 'is-invalid' : '' ?>"
                                                    name="code"
                                                    placeholder="Enter code number"
                                                    value="<?= set_value('code') ?>">
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
                                                    rows="3"><?= set_value('description') ?></textarea>
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
                                                <i class="bi bi-check-circle"></i> Create User
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