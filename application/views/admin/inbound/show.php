<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Inbound Details</h3>
                <p class="text-subtitle text-muted">View Inbound information</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/inbound') ?>">Inbound</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inbound Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <!-- User Profile Card -->
            <div class="col-md-4">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Package Information</h4>
                    </div>
                    <div class="card-body">

                        <h4 class="card-title"><?= $inbound->awb_number ?></h4>
                        <p class="text-muted"><?= $inbound->package_description ?></p>
                        <span><b>Weight: </b><?= $inbound->package_weight ?>Kg</span><br>
                        <span class="text-muted"> <b>Status: </b>
                            <?php if ($inbound->status == 'pending') : ?>
                                <span class="badge bg-warning">Pending</span>
                            <?php elseif ($inbound->status == 'problem') : ?>
                                <span class="badge bg-danger">Problem</span>
                            <?php elseif ($inbound->status == 'cancelled') : ?>
                                <span class="badge bg-danger">Cancelled</span>
                            <?php elseif ($inbound->status == 'received') : ?>
                                <span class="badge bg-success">Received</span>
                            <?php endif; ?>

                        </span><br>
                        <span class="text-muted"> <b>Noted: </b><?= $inbound->notes ?></span><br>
                    </div>

                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('admin/inbound/edit/' . $inbound->id) ?>" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit User
                            </a>
                            <a href="<?= base_url('admin/inbound/edit/' . $inbound->id) ?>" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Delete User
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Sender Information</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <p class="text-muted"><?= $inbound->sender_name ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phone</label>
                                    <p class="text-muted"><?= $inbound->sender_phone ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <p class="text-muted"><?= $inbound->sender_address ?></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Receiver Information</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <p class="text-muted"><?= $inbound->receiver_name ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Phone</label>
                                    <p class="text-muted"><?= $inbound->receiver_phone ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <p class="text-muted"><?= $inbound->receiver_address ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Received By</label>
                                    <?php if ($inbound->received_by) : ?>
                                        <p class="text-muted"><?= $inbound->received_by ?></p>
                                    <?php else : ?>
                                        <p class="text-muted"> N/A </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Information -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Activity Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Created at</label>
                                    <p class="text-muted"><?= date('F d, Y \a\t g:i A', strtotime($inbound->created_at)) ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Updated at</label>
                                    <p class="text-muted"><?= date('F d, Y \a\t g:i A', strtotime($inbound->updated_at)) ?></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Created by</label>
                                    <p class="text-muted"><?= $inbound->created_by_name ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Updated by</label>
                                    <?php if ($inbound->updated_by) : ?>
                                        <p class="text-muted"><?= $inbound->updated_by_name ?></p>
                                    <?php else : ?>
                                        <p class="text-muted">Never Updated</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>