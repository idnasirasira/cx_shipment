<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Courier Management</h3>
                <p class="text-subtitle text-muted">Manage system users and their roles</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Courier</li>
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
                        <h4 class="card-title">Courier List</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="<?= base_url('courier/create') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add New Courier
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
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($couriers as $courier) : ?>
                                <tr>
                                    <td><?= $courier->id ?></td>
                                    <td> <b><?= $courier->name ?></b><br> <small>Code : <?= $courier->code ?> </small></td>
                                    <td><?= $courier->description ?></td>
                                    <?php if ($courier->is_active): ?>
                                        <td><span class="badge bg-success">Active</span></td>
                                    <?php else: ?>
                                        <td><span class="badge bg-danger">Inactive</span></td>
                                    <?php endif; ?>
                                    <td><small>by</small> <b><?= $courier->created_by_name ?></b><br> <small>at</small> <b><?= $courier->created_at ?></b></td>
                                    <td><small>by</small> <b><?= $courier->updated_by_name ?></b> <br> <small>at</small> <b><?= $courier->updated_at ?></b></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="<?= base_url('courier/edit/' . $courier->id) ?>"
                                                class="btn btn-sm btn-outline-warning"
                                                title="Edit User">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('courier/delete/' . $courier->id) ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteUser(<?= $courier->id ?>, '<?= $courier->name ?>')"
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