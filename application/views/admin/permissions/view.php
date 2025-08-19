<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $title ?></h3>
                <p class="text-subtitle text-muted">View permission details and role assignments</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/permissions') ?>">Permissions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Permission</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <!-- Permission Information -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Permission Information</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Permission ID:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= $permission->id ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-secondary fs-6"><?= htmlspecialchars($permission->name) ?></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Description:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= htmlspecialchars($permission->description) ?: '<em class="text-muted">No description</em>' ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Created:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= date('F d, Y \a\t g:i A', strtotime($permission->created_at)) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Last Updated:</strong>
                        </div>
                        <div class="col-sm-8">
                            <?= date('F d, Y \a\t g:i A', strtotime($permission->updated_at)) ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('admin/permissions') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Permissions
                        </a>
                        <div>
                            <a href="<?= base_url('admin/permissions/edit/' . $permission->id) ?>" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit Permission
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assigned Roles -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Assigned Roles (<?= count($assigned_roles) ?>)</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($assigned_roles)): ?>
                        <div class="row">
                            <?php foreach ($assigned_roles as $role): ?>
                                <div class="col-12 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-shield-check text-primary me-2"></i>
                                        <div>
                                            <strong><?= htmlspecialchars($role->name) ?></strong>
                                            <br>
                                            <small class="text-muted"><?= htmlspecialchars($role->description) ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted">
                            <i class="bi bi-shield-x fs-1"></i>
                            <p class="mt-2">No roles assigned to this permission</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin/permissions/bulk_assign') ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-gear"></i> Manage Role Assignments
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Usage Information -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Usage Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <h6><i class="bi bi-info-circle"></i> How to Use This Permission</h6>
                                <p class="mb-2">To check if a user has this permission in your code:</p>
                                <code>
                                    if ($this->Permission_model->userHasPermission($user_id, '<?= $permission->name ?>')) {<br>
                                    &nbsp;&nbsp;// User has permission<br>
                                    }
                                </code>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-warning">
                                <h6><i class="bi bi-exclamation-triangle"></i> Security Note</h6>
                                <p class="mb-0">Always check permissions on both the frontend and backend. Frontend checks are for user experience, but backend checks are essential for security.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>