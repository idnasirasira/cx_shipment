<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $title ?></h3>
                <p class="text-subtitle text-muted">View role details and assigned users</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/roles') ?>">Roles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Role</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <!-- Role Information -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Role Information</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Role ID:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= $role->id ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-primary fs-6"><?= htmlspecialchars($role->name) ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Description:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= htmlspecialchars($role->description) ?: '<em class="text-muted">No description</em>' ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Created:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= date('F d, Y \a\t g:i A', strtotime($role->created_at)) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Last Updated:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= date('F d, Y \a\t g:i A', strtotime($role->updated_at)) ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('admin/roles') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Roles
                        </a>
                        <div>
                            <a href="<?= base_url('admin/roles/edit/' . $role->id) ?>" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit Role
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Assigned Permissions (<?= count($permissions) ?>)</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($permissions)): ?>
                        <div class="row">
                            <?php foreach ($permissions as $permission): ?>
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <div>
                                            <strong><?= htmlspecialchars($permission->name) ?></strong>
                                            <br>
                                            <small class="text-muted"><?= htmlspecialchars($permission->description) ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted">
                            <i class="bi bi-exclamation-triangle fs-1"></i>
                            <p class="mt-2">No permissions assigned to this role</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin/roles/edit/' . $role->id) ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-gear"></i> Manage Permissions
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Users with this Role -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Users with this Role (<?= count($users) ?>)</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($users)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Last Login</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= $user->id ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <div class="avatar-initial rounded-circle bg-primary">
                                                            <?= strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) ?>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <strong><?= htmlspecialchars($user->first_name . ' ' . $user->last_name) ?></strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($user->username) ?></td>
                                            <td><?= htmlspecialchars($user->email) ?></td>
                                            <td>
                                                <?php if ($user->is_active): ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($user->last_login): ?>
                                                    <?= date('M d, Y g:i A', strtotime($user->last_login)) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Never</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('admin/users/view/' . $user->id) ?>"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="View User">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= base_url('admin/users/edit/' . $user->id) ?>"
                                                    class="btn btn-sm btn-outline-warning"
                                                    title="Edit User">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-people fs-1"></i>
                            <p class="mt-2">No users assigned to this role</p>
                            <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Create User
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>