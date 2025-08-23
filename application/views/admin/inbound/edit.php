<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Inbound</h3>
                <p class="text-subtitle text-muted">Add a new inbound to the system</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/inbound') ?>">Inbound</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Inbound</li>
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

                        <form action="<?= base_url('admin/inbound/' . (isset($inbound) ? 'update/' . $inbound->id : 'store')) ?>" method="POST" class="form form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    <!-- Sender Information -->
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Sender Information</h5>

                                        <div class="form-group row">
                                            <label for="sender_name" class="col-sm-3 col-form-label">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    id="sender_name"
                                                    class="form-control <?= form_error('sender_name') ? 'is-invalid' : '' ?>"
                                                    name="sender_name"
                                                    placeholder="Enter Name"
                                                    value="<?= isset($inbound) ? $inbound->sender_name : set_value('sender_name') ?>"
                                                    required>
                                                <?= form_error('sender_name', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="sender_phone" class="col-sm-3 col-form-label">Phone Number</label>
                                            <div class="col-sm-9">
                                                <input type="tel"
                                                    id="sender_phone"
                                                    class="form-control <?= form_error('sender_phone') ? 'is-invalid' : '' ?>"
                                                    name="sender_phone"
                                                    placeholder="Enter Phone Number"
                                                    value="<?= isset($inbound) ? $inbound->sender_phone : set_value('sender_phone') ?>">
                                                <?= form_error('sender_phone', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="sender_address" class="col-sm-3 col-form-label">Address</label>
                                            <div class="col-sm-9">
                                                <textarea id="sender_address"
                                                    class="form-control <?= form_error('sender_address') ? 'is-invalid' : '' ?>"
                                                    name="sender_address"
                                                    placeholder="Enter Address"
                                                    rows="3"><?= isset($inbound) ? $inbound->sender_address : set_value('sender_address') ?></textarea>
                                                <?= form_error('sender_address', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Receiver Information -->
                                    <div class="col-md-6 mb-3">
                                        <h5 class="mb-3">Receiver Information</h5>

                                        <div class="form-group row">
                                            <label for="receiver_name" class="col-sm-3 col-form-label">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    id="receiver_name"
                                                    class="form-control <?= form_error('receiver_name') ? 'is-invalid' : '' ?>"
                                                    name="receiver_name"
                                                    placeholder="Enter Name"
                                                    value="<?= isset($inbound) ? $inbound->receiver_name : set_value('receiver_name') ?>"
                                                    required>
                                                <?= form_error('receiver_name', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="receiver_phone" class="col-sm-3 col-form-label">Phone Number</label>
                                            <div class="col-sm-9">
                                                <input type="tel"
                                                    id="receiver_phone"
                                                    class="form-control <?= form_error('receiver_phone') ? 'is-invalid' : '' ?>"
                                                    name="receiver_phone"
                                                    placeholder="Enter Phone Number"
                                                    value="<?= isset($inbound) ? $inbound->receiver_phone : set_value('receiver_phone') ?>">
                                                <?= form_error('receiver_phone', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="receiver_address" class="col-sm-3 col-form-label">Address</label>
                                            <div class="col-sm-9">
                                                <textarea id="receiver_address"
                                                    class="form-control <?= form_error('receiver_address') ? 'is-invalid' : '' ?>"
                                                    name="receiver_address"
                                                    placeholder="Enter Address"
                                                    rows="3"><?= isset($inbound) ? $inbound->receiver_address : set_value('receiver_address') ?></textarea>
                                                <?= form_error('receiver_address', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Package Information -->
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Package Information</h5>

                                        <div class="form-group row">
                                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-9">
                                                <textarea id="description"
                                                    class="form-control <?= form_error('description') ? 'is-invalid' : '' ?>"
                                                    name="description"
                                                    placeholder="Enter description"
                                                    rows="3"><?= isset($inbound) ? $inbound->package_description : set_value('description') ?></textarea>
                                                <?= form_error('description', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="weight" class="col-sm-3 col-form-label">Weight(kg)</label>
                                            <div class="col-sm-9">
                                                <input type="tel"
                                                    id="weight"
                                                    class="form-control <?= form_error('weight') ? 'is-invalid' : '' ?>"
                                                    name="weight"
                                                    placeholder="Enter Package Weight"
                                                    value="<?= isset($inbound) ? $inbound->package_weight : set_value('weight') ?>">
                                                <?= form_error('weight', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="notes" class="col-sm-3 col-form-label">Notes</label>
                                            <div class="col-sm-9">
                                                <textarea id="notes"
                                                    class="form-control <?= form_error('notes') ? 'is-invalid' : '' ?>"
                                                    name="notes"
                                                    placeholder="Enter notes"
                                                    rows="3"><?= isset($inbound) ? $inbound->notes : set_value('notes') ?></textarea>
                                                <?= form_error('notes', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Shipment Information -->
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Shipment Information</h5>

                                        <div class="form-group row">
                                            <label for="courier_id" class="col-sm-3 col-form-label">Courier</label>
                                            <div class="col-sm-9">
                                                <select class="form-select" name="courier_id" id="courier_id">
                                                    <?php foreach ($couriers as $courier) : ?>
                                                        <option value="<?= $courier->id ?>" <?= ($courier->id == $inbound->courier_id) ? 'selected' : '' ?>><?= $courier->name ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="status" class="col-sm-3 col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <select class="form-select" name="status" id="status">
                                                    <option value="">Select Status</option>
                                                    <option value="pending" <?= isset($inbound) && $inbound->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                                    <option value="received" <?= isset($inbound) && $inbound->status == 'received' ? 'selected' : '' ?>>Received</option>
                                                    <option value="problem" <?= isset($inbound) && $inbound->status == 'problem' ? 'selected' : '' ?>>Problem</option>
                                                    <option value="cancelled" <?= isset($inbound) && $inbound->status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="<?= base_url('admin/inbound') ?>" class="btn btn-light-secondary me-1 mb-1">
                                            <i class="bi bi-arrow-left"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            <i class="bi bi-check-circle"></i> <?= isset($inbound) ? 'Update Inbound' : 'Create Inbound' ?>
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