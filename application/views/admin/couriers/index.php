<div class="page-heading">
    <div class="page-title">
        <div class="">
            <?= $this->session->flashdata('success') ?>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Courier Management</h3>
                <p class="text-subtitle text-muted">Manage system courier and their data</p>
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
                        <h4 class="card-title"><?= $section_title ?></h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a data-bs-toggle="modal" data-bs-target="#inlineForm" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add New Courier
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

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
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Created by</th>
                                <th>Updated</th>
                                <th>Updated by</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($couriers as $courier) : ?>
                                <?php if ($courier->is_deleted == false) : ?>
                                    <tr>
                                        <td><?= $courier->id ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-bold"><?= $courier->name ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $courier->code ?></td>
                                        <td><?= $courier->description ?></td>
                                        <td>
                                            <?php if ($courier->is_active) : ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $courier->created_at ?></td>
                                        <td>
                                            <span class="badge bg-light-info"><?= ucfirst($courier->user_name) ?></span>
                                        </td>
                                        <td><?= $courier->updated_at ?></td>
                                        <td><span class="badge bg-light"><?= ucfirst($courier->user_name) ?></span></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="<?= base_url('admin/users/show/' . $courier->id) ?>"
                                                    class="btn btn-sm btn-outline-info"
                                                    title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/couriers/modal_edit/' . $courier->id) ?>"
                                                    class="btn btn-sm btn-outline-warning btn-edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal"
                                                    data-id="<?= $courier->id ?>"
                                                    data-name="<?= $courier->name ?>"
                                                    data-description="<?= $courier->description ?>"
                                                    data-status="<?= $courier->is_active ?>"
                                                    title="Edit Courier">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href=""
                                                    class="btn btn-sm btn-outline-<?= $user->is_active ? 'secondary' : 'success' ?>"
                                                    onclick="toggleUserStatus(<?= $user->id ?>)"
                                                    title="<?= $user->is_active ? 'Deactivate' : 'Activate' ?> User">
                                                    <i class="bi bi-<?= $user->is_active ? 'pause' : 'play' ?>"></i>
                                                </a>
                                                <a href="<?= base_url('admin/couriers/delete/' . $courier->id) ?>"
                                                    type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteUser(<?= $user->id ?>, '<?= $user->username ?>')"
                                                    title="Delete User">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
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

<!-- Status Toggle form create Modal -->
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Add New Courier</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="<?= base_url('admin/couriers/store') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group form-floating">
                        <input type="text" class="form-control" name="name" id="name" placeholder=" " value="">
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
                        <label for="name">Courier Name</label>
                    </div>
                    <div class="form-group form-floating">
                        <textarea class="form-control" placeholder=" " name="description" id="description" style="height: 100px; resize: none;"></textarea>
                        <label for="description">Description(Opsional)</label>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-text" for="inputGroupSelect01">Status</label>
                            <select class="form-select" id="inputGroupSelect01" name="status">
                                <option selected>Choose...</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1"
                        data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add New Courier</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Status Toggle form edit Modal -->
<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>