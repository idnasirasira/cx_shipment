<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>User Details</h3>
                <p class="text-subtitle text-muted">View user information</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Details</li>
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
                    <div class="card-body text-center">
                        <div class="avatar avatar-xl mb-3">
                            <?php if ($user->profile_picture) : ?>
                                <img src="<?= base_url('uploads/profiles/' . $user->profile_picture) ?>" alt="Profile Picture">
                            <?php else : ?>
                                <div class="avatar-initial rounded-circle bg-primary">
                                    <?= strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h4 class="card-title"><?= $user->first_name . ' ' . $user->last_name ?></h4>
                        <p class="text-muted"><?= ucfirst($user->role_name) ?></p>

                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <?php if ($user->is_active) : ?>
                                <span class="badge bg-success">Active</span>
                            <?php else : ?>
                                <span class="badge bg-danger">Inactive</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('admin/users/edit/' . $user->id) ?>" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit User
                            </a>
                            <button type="button"
                                class="btn btn-<?= $user->is_active ? 'secondary' : 'success' ?>"
                                onclick="toggleUserStatus(<?= $user->id ?>)">
                                <i class="bi bi-<?= $user->is_active ? 'pause' : 'play' ?>"></i>
                                <?= $user->is_active ? 'Deactivate' : 'Activate' ?> User
                            </button>
                            <button type="button"
                                class="btn btn-danger"
                                onclick="deleteUser(<?= $user->id ?>, '<?= $user->username ?>')">
                                <i class="bi bi-trash"></i> Delete User
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Personal Information</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Full Name</label>
                                    <p class="text-muted"><?= $user->first_name . ' ' . $user->last_name ?></p>
                                </div>

                                <?php if ($user->phone) : ?>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Phone</label>
                                        <p class="text-muted"><?= $user->phone ?></p>
                                    </div>
                                <?php endif; ?>

                                <?php if ($user->address) : ?>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Address</label>
                                        <p class="text-muted"><?= nl2br($user->address) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Account Information</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Username</label>
                                    <p class="text-muted"><?= $user->username ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <p class="text-muted"><?= $user->email ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Role</label>
                                    <p class="text-muted">
                                        <span class="badge bg-light-info"><?= ucfirst($user->role_name) ?></span>
                                        <?php if ($role && $role->description) : ?>
                                            <br><small class="text-muted"><?= $role->description ?></small>
                                        <?php endif; ?>
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Account Status</label>
                                    <p class="text-muted">
                                        <?php if ($user->is_active) : ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </p>
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
                                    <label class="form-label fw-bold">Account Created</label>
                                    <p class="text-muted"><?= date('F d, Y \a\t g:i A', strtotime($user->created_at)) ?></p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Last Updated</label>
                                    <p class="text-muted"><?= date('F d, Y \a\t g:i A', strtotime($user->updated_at)) ?></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Last Login</label>
                                    <?php if ($user->last_login) : ?>
                                        <p class="text-muted"><?= date('F d, Y \a\t g:i A', strtotime($user->last_login)) ?></p>
                                    <?php else : ?>
                                        <p class="text-muted">Never logged in</p>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">User ID</label>
                                    <p class="text-muted">#<?= $user->id ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete User</a>
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
                <a href="#" id="confirmStatusBtn" class="btn btn-primary">Confirm</a>
            </div>
        </div>
    </div>
</div>