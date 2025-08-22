<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Create New Inbound</h3>
                <p class="text-subtitle text-muted">Add a new inbound shipment to the system</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/inbound') ?>">Inbound</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Inbound</li>
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
                        <h4 class="card-title">Inbound Information</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($validation_errors) && $validation_errors) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> Please correct the following errors:
                                <?= $validation_errors ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/inbound/store') ?>" method="POST" class="form form-horizontal">
                            <div class="form-body">
                                <div class="row">

                                    <!-- Shipment Info -->
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Shipment Information</h5>

                                        <div class="form-group row">
                                            <label for="courier_id" class="col-sm-3 col-form-label">Courier *</label>
                                            <div class="col-sm-9">
                                                <select id="courier_id"
                                                    class="form-select <?= form_error('courier_id') ? 'is-invalid' : '' ?>"
                                                    name="courier_id" required>
                                                    <option value="">Select Courier</option>
                                                    <?php foreach ($couriers as $courier) : ?>
                                                        <option value="<?= $courier->id ?>" <?= set_select('courier_id', $courier->id) ?>>
                                                            <?= $courier->name ?> (<?= $courier->code ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?= form_error('courier_id', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="status" class="col-sm-3 col-form-label">Status *</label>
                                            <div class="col-sm-9">
                                                <select id="status"
                                                    class="form-select <?= form_error('status') ? 'is-invalid' : '' ?>"
                                                    name="status" required>
                                                    <option value="">Select Status</option>
                                                    <option value="pending" <?= set_select('status', 'pending') ?>>Pending</option>
                                                    <option value="received" <?= set_select('status', 'received') ?>>Received</option>
                                                    <option value="problem" <?= set_select('status', 'problem') ?>>Problem</option>
                                                    <option value="cancelled" <?= set_select('status', 'cancelled') ?>>Cancelled</option>
                                                </select>
                                                <?= form_error('status', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sender & Receiver -->
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Sender Information</h5>

                                        <div class="form-group row">
                                            <label for="sender_name" class="col-sm-3 col-form-label">Name *</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="sender_name"
                                                    class="form-control <?= form_error('sender_name') ? 'is-invalid' : '' ?>"
                                                    name="sender_name" placeholder="Enter sender name"
                                                    value="<?= set_value('sender_name') ?>" required>
                                                <?= form_error('sender_name', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="sender_phone" class="col-sm-3 col-form-label">Phone</label>
                                            <div class="col-sm-9">
                                                <input type="tel" id="sender_phone"
                                                    class="form-control <?= form_error('sender_phone') ? 'is-invalid' : '' ?>"
                                                    name="sender_phone" placeholder="Enter sender phone"
                                                    value="<?= set_value('sender_phone') ?>">
                                                <?= form_error('sender_phone', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="sender_address" class="col-sm-3 col-form-label">Address</label>
                                            <div class="col-sm-9">
                                                <textarea id="sender_address"
                                                    class="form-control <?= form_error('sender_address') ? 'is-invalid' : '' ?>"
                                                    name="sender_address" placeholder="Enter sender address"
                                                    rows="2"><?= set_value('sender_address') ?></textarea>
                                                <?= form_error('sender_address', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <h5 class="mb-3 mt-4">Receiver Information</h5>

                                        <div class="form-group row">
                                            <label for="receiver_name" class="col-sm-3 col-form-label">Name *</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="receiver_name"
                                                    class="form-control <?= form_error('receiver_name') ? 'is-invalid' : '' ?>"
                                                    name="receiver_name" placeholder="Enter receiver name"
                                                    value="<?= set_value('receiver_name') ?>" required>
                                                <?= form_error('receiver_name', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="receiver_phone" class="col-sm-3 col-form-label">Phone</label>
                                            <div class="col-sm-9">
                                                <input type="tel" id="receiver_phone"
                                                    class="form-control <?= form_error('receiver_phone') ? 'is-invalid' : '' ?>"
                                                    name="receiver_phone" placeholder="Enter receiver phone"
                                                    value="<?= set_value('receiver_phone') ?>">
                                                <?= form_error('receiver_phone', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="receiver_address" class="col-sm-3 col-form-label">Address</label>
                                            <div class="col-sm-9">
                                                <textarea id="receiver_address"
                                                    class="form-control <?= form_error('receiver_address') ? 'is-invalid' : '' ?>"
                                                    name="receiver_address" placeholder="Enter receiver address"
                                                    rows="2"><?= set_value('receiver_address') ?></textarea>
                                                <?= form_error('receiver_address', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Package Info -->
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5 class="mb-3">Package Information</h5>

                                        <div class="form-group row">
                                            <label for="package_description" class="col-sm-2 col-form-label">Description</label>
                                            <div class="col-sm-10">
                                                <textarea id="package_description"
                                                    class="form-control <?= form_error('package_description') ? 'is-invalid' : '' ?>"
                                                    name="package_description"
                                                    placeholder="Enter package description"
                                                    rows="2"><?= set_value('package_description') ?></textarea>
                                                <?= form_error('package_description', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="package_weight" class="col-sm-2 col-form-label">Weight (kg)</label>
                                            <div class="col-sm-10">
                                                <input type="number" step="0.01" id="package_weight"
                                                    class="form-control <?= form_error('package_weight') ? 'is-invalid' : '' ?>"
                                                    name="package_weight" placeholder="Enter package weight"
                                                    value="<?= set_value('package_weight') ?>">
                                                <?= form_error('package_weight', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="notes" class="col-sm-2 col-form-label">Notes</label>
                                            <div class="col-sm-10">
                                                <textarea id="notes"
                                                    class="form-control <?= form_error('notes') ? 'is-invalid' : '' ?>"
                                                    name="notes"
                                                    placeholder="Additional notes"
                                                    rows="2"><?= set_value('notes') ?></textarea>
                                                <?= form_error('notes', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="row mt-4">
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="<?= base_url('admin/inbound') ?>" class="btn btn-light-secondary me-1 mb-1">
                                            <i class="bi bi-arrow-left"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            <i class="bi bi-check-circle"></i> Create Inbound
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