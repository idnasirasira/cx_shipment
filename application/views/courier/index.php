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
                                <th>Name</th>
                                <th>Code</th>
                                <th>Detail</th>
                                <th>Status</th>
                                <th>Created by</th>
                                <th>Updated by</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courier as $user) : ?>
                                <tr>
                                    <td><?= $user->id ?></td>


                                    <td>
                                        <span class="d-flex align-items-center"><?= $user->name ?></span>
                                    </td>


                                    <td>
                                        <span class="badge bg-light-primary"><?= $user->code ?></span>
                                    </td>


                                    <td>
                                        <span class="badge bg-light-info"><?= ucfirst($user->description) ?></span>
                                    </td>


                                    <td>
                                        <?php if ($user->is_active) : ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>


                                    <td>
                                        <span class="badge bg-light-info"><?= ucfirst($user->created_name) ?></span>
                                    </td>


                                    <td>
                                        <span class="badge bg-light-info"><?= ucfirst($user->updated_by) ?></span>
                                    </td>


                                    <td>
                                        <small><?= date('M d, Y', strtotime($user->created_at)) ?></small>
                                    </td>


                                    <td>
                                        <small><?= date('M d, Y', strtotime($user->created_at)) ?></small>
                                    </td>


                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="<?= base_url('admin/users/show/' . $user->id) ?>"
                                                class="btn btn-sm btn-outline-info"
                                                title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('courier/edit/' . $user->id) ?>"
                                                class="btn btn-sm btn-outline-warning"
                                                title="Edit User">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-<?= $user->is_active ? 'secondary' : 'success' ?>"
                                                onclick="toggleUserStatus(<?= $user->id ?>)"
                                                title="<?= $user->is_active ? 'Deactivate' : 'Activate' ?> User">
                                                <i class="bi bi-<?= $user->is_active ? 'pause' : 'play' ?>"></i>
                                            </button>
                                            <a href="<?= base_url('courier/delete/' . $user->id) ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Edit User">
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