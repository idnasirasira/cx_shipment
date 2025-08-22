<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>User Management</h3>
                <p class="text-subtitle text-muted">Manage system users and their roles</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title"><?= $title ?></h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="<?= base_url('courier/create') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add New User
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive datatable-minimal">
                    <table class="table table-striped" id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>AWB Number</th>
                                <th>Courier</th>
                                <th>Status</th>
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th>Package</th>
                                <th>Received By</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inbounds as $pkg) : ?>
                                <tr>
                                    <td><?= $pkg->id ?></td>

                                    <td>
                                        <span class="badge bg-light-primary"><?= $pkg->awb_number ?></span>
                                    </td>

                                    <td>
                                        <span><?= $pkg->courier_id ?></span>
                                        <!-- kalau mau join ke table courier, tampilkan $pkg->courier_name -->
                                    </td>

                                    <td>
                                        <span class="badge 
                    <?= $pkg->status == 'pending' ? 'bg-warning' : ($pkg->status == 'received' ? 'bg-success' : ($pkg->status == 'problem' ? 'bg-danger' : 'bg-secondary')) ?>">
                                            <?= ucfirst($pkg->status) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= $pkg->sender_name ?><br>
                                        <small><?= $pkg->sender_phone ?></small><br>
                                        <small><?= $pkg->sender_address ?></small>
                                    </td>

                                    <td>
                                        <?= $pkg->receiver_name ?><br>
                                        <small><?= $pkg->receiver_phone ?></small><br>
                                        <small><?= $pkg->receiver_address ?></small>
                                    </td>

                                    <td>
                                        <?= $pkg->package_description ?><br>
                                        <small><?= $pkg->package_weight ?> kg</small>
                                    </td>

                                    <td>
                                        <?= $pkg->received_by ?><br>
                                        <small><?= $pkg->received_at ?></small>
                                    </td>

                                    <td><?= $pkg->created_by ?></td>
                                    <td><?= $pkg->updated_by ?></td>

                                    <td><small><?= date('M d, Y', strtotime($pkg->created_at)) ?></small></td>
                                    <td><small><?= date('M d, Y', strtotime($pkg->updated_at)) ?></small></td>

                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="#"
                                                class="btn btn-sm btn-outline-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/inbound/edit/' . $pkg->id) ?>"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('admin/inbound/delete/' . $pkg->id) ?>"
                                                class="btn btn-sm btn-outline-danger" title="Delete"
                                                onclick="return confirm('Yakin ingin menghapus inbound shipment ini?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete user <strong id="deleteUserName"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger btn-confirm">Delete User</a>
            </div>
        </div>
    </div>
</div>

<!-- Status Toggle Confirmation Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Confirm Status Change</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="statusModalMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmStatusBtn" class="btn btn-primary btn-confirm">Confirm</a>
            </div>
        </div>
    </div>
</div>