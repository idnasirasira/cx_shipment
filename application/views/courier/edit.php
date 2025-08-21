<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Courier</h3>
                <p class="text-subtitle text-muted">Update data courier</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('courier') ?>">Courier</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Courier</li>
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


                        <form action="<?= base_url('courier/update/' . $id) ?>" method="POST" class="form form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    <!-- Personal Information -->

                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label">Name </label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                id="name"
                                                class="form-control"
                                                name="name"
                                                placeholder="Enter Name"
                                                value="<?= $courier->name ?>">

                                            <?= form_error('name',  '<p class="text-danger mt-1">', '</p>'); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="code" class="col-sm-3 col-form-label">Code </label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                id="code"
                                                class="form-control"
                                                name="code"
                                                placeholder="Enter Code"
                                                value="<?= $courier->code ?>">
                                            <?= form_error('code',  '<p class="text-danger mt-1">', '</p>'); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="description" class="col-sm-3 col-form-label">Description </label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                id="description"
                                                class="form-control"
                                                name="description"
                                                placeholder="Enter description"
                                                value="<?= $courier->description ?>">

                                            <?= form_error('description',  '<p class="text-danger mt-1">', '</p>'); ?>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="is_active" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9 mt-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    id="is_active"
                                                    name="is_active"
                                                    value="1"
                                                    <?php if ($courier->is_active == 1) :
                                                        echo   set_checkbox('is_active', '1', true); ?>>
                                                <label class="badge bg-success" for="is_active">
                                                    <b>Active</b>
                                                </label>
                                            <?php else :
                                                        echo set_checkbox('is_active', '0', false); ?>
                                                >
                                                <label class="badge bg-danger" for="is_active">
                                                    <b>Inactive</b>
                                                </label>
                                            <?php endif; ?>

                                            </div>
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