<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Inbound</h3>
                <p class="text-subtitle text-muted">Manage inbound data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inbound</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> <?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php elseif ($this->session->flashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Inbound List</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="<?= base_url('admin/inbound/create') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add New Inbound
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive datatable-minimal">
                    <table class="table table-striped" id="usersTable">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>AWB Number</th>
                                <th>Courier</th>
                                <th>Status</th>
                                <th>Receiver Name</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inbound as $inbounds): ?>
                                <tr>
                                    <td><?= $inbounds->id ?></td>
                                    <td> <b><?= $inbounds->awb_number ?></b><br> <small><?= $inbounds->package_description ?></small></td>
                                    <td> <b><?= $inbounds->courier_name ?></b> <br> <small><?= $inbounds->courier_code ?></small></td>
                                    <td class="text-center">
                                        <?php if ($inbounds->status == 'pending') : ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php elseif ($inbounds->status == 'problem') : ?>
                                            <span class="badge bg-danger">Problem</span>
                                        <?php elseif ($inbounds->status == 'cancelled') : ?>
                                            <span class="badge bg-danger">Cancelled</span>
                                        <?php elseif ($inbounds->status == 'received') : ?>
                                            <span class="badge bg-success">Received</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $inbounds->receiver_name ?></td>
                                    <td><small>by</small> <b><?= $inbounds->created_by_name ?></b><br> <small>at</small> <b><?= $inbounds->created_at ?></b></td>
                                    <td><small>by</small> <b><?= $inbounds->updated_by_name ?></b><br> <small>at</small> <b><?= $inbounds->updated_at ?></b></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="<?= base_url('admin/inbound/show/' . $inbounds->id) ?>"
                                                class="btn btn-sm btn-outline-info"
                                                title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/inbound/edit/' . $inbounds->id) ?>"
                                                class="btn btn-sm btn-outline-warning"
                                                title="Edit User">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('admin/inbound/delete/' . $inbounds->id) ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Delete User">
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