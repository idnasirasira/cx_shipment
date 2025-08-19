<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Create New User</h3>
                <p class="text-subtitle text-muted">Add a new user to the system</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create User</li>
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

                        <form action="<?= base_url('admin/users/store') ?>" method="POST" class="form form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    <!-- Personal Information -->
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Personal Information</h5>

                                        <div class="form-group row">
                                            <label for="first_name" class="col-sm-3 col-form-label">First Name *</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    id="first_name"
                                                    class="form-control <?= form_error('first_name') ? 'is-invalid' : '' ?>"
                                                    name="first_name"
                                                    placeholder="Enter first name"
                                                    value="<?= set_value('first_name') ?>"
                                                    required>
                                                <?= form_error('first_name', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="last_name" class="col-sm-3 col-form-label">Last Name *</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    id="last_name"
                                                    class="form-control <?= form_error('last_name') ? 'is-invalid' : '' ?>"
                                                    name="last_name"
                                                    placeholder="Enter last name"
                                                    value="<?= set_value('last_name') ?>"
                                                    required>
                                                <?= form_error('last_name', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                                            <div class="col-sm-9">
                                                <input type="tel"
                                                    id="phone"
                                                    class="form-control <?= form_error('phone') ? 'is-invalid' : '' ?>"
                                                    name="phone"
                                                    placeholder="Enter phone number"
                                                    value="<?= set_value('phone') ?>">
                                                <?= form_error('phone', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="address" class="col-sm-3 col-form-label">Address</label>
                                            <div class="col-sm-9">
                                                <textarea id="address"
                                                    class="form-control <?= form_error('address') ? 'is-invalid' : '' ?>"
                                                    name="address"
                                                    placeholder="Enter address"
                                                    rows="3"><?= set_value('address') ?></textarea>
                                                <?= form_error('address', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Information -->
                                    <div class="col-md-6">
                                        <h5 class="mb-3">Account Information</h5>

                                        <div class="form-group row">
                                            <label for="username" class="col-sm-3 col-form-label">Username *</label>
                                            <div class="col-sm-9">
                                                <input type="text"
                                                    id="username"
                                                    class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>"
                                                    name="username"
                                                    placeholder="Enter username"
                                                    value="<?= set_value('username') ?>"
                                                    required>
                                                <?= form_error('username', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-sm-3 col-form-label">Email *</label>
                                            <div class="col-sm-9">
                                                <input type="email"
                                                    id="email"
                                                    class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>"
                                                    name="email"
                                                    placeholder="Enter email address"
                                                    value="<?= set_value('email') ?>"
                                                    required>
                                                <?= form_error('email', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-sm-3 col-form-label">Password *</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="password"
                                                        id="password"
                                                        class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>"
                                                        name="password"
                                                        placeholder="Enter password"
                                                        required>
                                                    <button class="btn btn-outline-secondary"
                                                        type="button"
                                                        id="togglePassword">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                                <?= form_error('password', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password *</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="password"
                                                        id="confirm_password"
                                                        class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>"
                                                        name="confirm_password"
                                                        placeholder="Confirm password"
                                                        required>
                                                    <button class="btn btn-outline-secondary"
                                                        type="button"
                                                        id="toggleConfirmPassword">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                                <?= form_error('confirm_password', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="role_id" class="col-sm-3 col-form-label">Role *</label>
                                            <div class="col-sm-9">
                                                <select id="role_id"
                                                    class="form-select <?= form_error('role_id') ? 'is-invalid' : '' ?>"
                                                    name="role_id"
                                                    required>
                                                    <option value="">Select Role</option>
                                                    <?php foreach ($roles as $role) : ?>
                                                        <option value="<?= $role->id ?>" <?= set_select('role_id', $role->id) ?>>
                                                            <?= ucfirst($role->name) ?> - <?= $role->description ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?= form_error('role_id', '<div class="invalid-feedback">', '</div>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="is_active" class="col-sm-3 col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input"
                                                        type="checkbox"
                                                        id="is_active"
                                                        name="is_active"
                                                        value="1"
                                                        <?= set_checkbox('is_active', '1', true) ?>>
                                                    <label class="form-check-label" for="is_active">
                                                        Active Account
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="<?= base_url('admin/users') ?>" class="btn btn-light-secondary me-1 mb-1">
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