<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $title ?></h3>
                <p class="text-subtitle text-muted">Edit role details and permissions</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/roles') ?>">Roles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Role: <?= htmlspecialchars($role->name) ?></h4>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= validation_errors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open('admin/roles/edit/' . $role->id, ['id' => 'editRoleForm']) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    value="<?= set_value('name', $role->name) ?>"
                                    placeholder="Enter role name"
                                    required>
                                <div class="invalid-feedback" id="nameFeedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control"
                                    id="description"
                                    name="description"
                                    rows="3"
                                    placeholder="Enter role description"><?= set_value('description', $role->description) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Permissions</h5>
                            <p class="text-muted">Select the permissions that this role should have:</p>

                            <?php if (!empty($permissions)): ?>
                                <div class="row">
                                    <?php foreach ($permissions as $permission): ?>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="<?= $permission->id ?>"
                                                    id="permission_<?= $permission->id ?>"
                                                    <?= in_array($permission->id, $role_permissions) ? 'checked' : '' ?>
                                                    <?= set_checkbox('permissions[]', $permission->id, in_array($permission->id, $role_permissions)) ?>>
                                                <label class="form-check-label" for="permission_<?= $permission->id ?>">
                                                    <strong><?= htmlspecialchars($permission->name) ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?= htmlspecialchars($permission->description) ?></small>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    No permissions found. Please create permissions first.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/roles') ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to Roles
                                </a>
                                <div>
                                    <a href="<?= base_url('admin/roles/view/' . $role->id) ?>" class="btn btn-info">
                                        <i class="bi bi-eye"></i> View Details
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Update Role
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>