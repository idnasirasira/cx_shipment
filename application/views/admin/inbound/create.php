<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Create New Inbound</h3>
                    <p class="text-subtitle text-muted">Add a new data inbound</p>
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
                        <div class="card-body">

                            <form action="<?= base_url('admin/inbound/store') ?>" method="POST" class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <!-- Sender Information -->
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Sender Information</h5>

                                            <div class="form-group row">
                                                <label for="sender_name" class="col-sm-3 col-form-label">Sender Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="sender_name" class="form-control " name="sender_name" placeholder="Enter sender name" value="" required="">
                                                    <?= form_error('sender_name', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="sender_phone" class="col-sm-3 col-form-label">Sender Phone</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="sender_phone" class="form-control " name="sender_phone" placeholder="Enter sender phone" value="" required="">
                                                    <?= form_error('sender_phone', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="sender_address" class="col-sm-3 col-form-label">Sender Address</label>
                                                <div class="col-sm-9">
                                                    <textarea id="sender_address" class="form-control " name="sender_address" placeholder="Enter sender address" rows="3"></textarea>
                                                    <?= form_error('sender_address', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Reciever Information -->
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Receiver Information</h5>

                                            <div class="form-group row">
                                                <label for="receiver_name" class="col-sm-3 col-form-label">Receiver Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="receiver_name" class="form-control " name="receiver_name" placeholder="Enter receiver name" value="" required="">
                                                    <?= form_error('receiver_name', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="receiver_phone" class="col-sm-3 col-form-label">Receiver Phone</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="receiver_phone" class="form-control " name="receiver_phone" placeholder="Enter receiver phone" value="" required="">
                                                    <?= form_error('receiver_phone', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="received_by" class="col-sm-3 col-form-label">Received By</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="received_by" class="form-control " name="received_by" placeholder="Enter received by" rows="3"></input>
                                                    <?= form_error('received_by', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="receiver_address" class="col-sm-3 col-form-label">Receiver Address</label>
                                                <div class="col-sm-9">
                                                    <textarea id="receiver_address" class="form-control " name="receiver_address" placeholder="Enter receiver address" rows="3"></textarea>
                                                    <?= form_error('receiver_address', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Package Information -->
                                        <div class="col-md-6">
                                            <h5 class="mb-3">Package Information</h5>

                                            <div class="form-group row">
                                                <label for="courier" class="col-sm-3 col-form-label">Courier Name</label>
                                                <div class="col-sm-9">
                                                    <select id="courier" class="form-select " name="courier" required="">
                                                        <option value="">Select Courier</option>
                                                        <?php foreach ($courier as $couriers): ?>
                                                            <option value="<?= $couriers->id ?>">
                                                                <?= $couriers->name ?> - <?= $couriers->code ?> </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                    <?= form_error('courier', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="package_description" class="col-sm-3 col-form-label">Package Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="package_description" class="form-control " name="package_description" placeholder="Enter package description" value="" required="">
                                                    <?= form_error('package_description', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="package_weight" class="col-sm-3 col-form-label">Package Weight</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="package_weight" class="form-control " name="package_weight" placeholder="Enter package weight" value="" required="">
                                                    <?= form_error('package_weight', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="notes" class="col-sm-3 col-form-label">Notes</label>
                                                <div class="col-sm-9">
                                                    <textarea id="notes" class="form-control " name="notes" placeholder="Enter the notes" rows="3"></textarea>
                                                    <?= form_error('notes', '<p class="text-danger mt-1">', '</p>'); ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                                <div class="col-sm-9">
                                                    <select id="status" class="form-select " name="status">
                                                        <option value="pending">
                                                            Pending </option>
                                                        <option value="received">
                                                            Received </option>
                                                        <option value="problem">
                                                            Problem </option>
                                                        <option value="cancelled">
                                                            Cancelled </option>
                                                    </select>
                                                    <?= form_error('status', '<p class="text-danger mt-1">', '</p>'); ?>
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