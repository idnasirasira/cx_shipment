<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $title ?></h3>
                <p class="text-subtitle text-muted">Bulk assign permissions to roles</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/permissions') ?>">Permissions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bulk Assign</li>
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
                    <h4 class="card-title">Bulk Assign Permissions</h4>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= validation_errors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open('admin/permissions/bulk_assign', ['id' => 'bulkAssignForm']) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role_id" class="form-label">Select Role <span class="text-danger">*</span></label>
                                <select class="form-select" id="role_id" name="role_id" required>
                                    <option value="">Choose a role...</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role->id ?>" <?= set_select('role_id', $role->id) ?>>
                                            <?= htmlspecialchars($role->name) ?> - <?= htmlspecialchars($role->description) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Quick Actions</label>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="selectAll">
                                        <i class="bi bi-check-all"></i> Select All
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="deselectAll">
                                        <i class="bi bi-x-circle"></i> Deselect All
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Select Permissions</h5>
                            <p class="text-muted">Choose the permissions you want to assign to the selected role:</p>

                            <?php if (!empty($permissions)): ?>
                                <div class="row">
                                    <?php foreach ($permissions as $permission): ?>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input permission-checkbox"
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="<?= $permission->id ?>"
                                                    id="permission_<?= $permission->id ?>"
                                                    <?= set_checkbox('permissions[]', $permission->id) ?>>
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
                            <div class="alert alert-info">
                                <h6><i class="bi bi-info-circle"></i> Important Note</h6>
                                <p class="mb-0">This will replace all existing permissions for the selected role. Any permissions not selected will be removed from the role.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/permissions') ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to Permissions
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Assign Permissions
                                </button>
                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>