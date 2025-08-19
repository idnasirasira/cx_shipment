<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $title ?></h3>
                <p class="text-subtitle text-muted">Manage system permissions and their role assignments</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
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
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">All Permissions (<?= $total_permissions ?>)</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?= base_url('admin/permissions/create') ?>" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Create New Permission
                            </a>
                            <a href="<?= base_url('admin/permissions/bulk_assign') ?>" class="btn btn-info">
                                <i class="bi bi-gear"></i> Bulk Assign
                            </a>
                            <a href="<?= base_url('admin/permissions/export') ?>" class="btn btn-success">
                                <i class="bi bi-download"></i> Export CSV
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped" id="permissionsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Assigned Roles</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($permissions)): ?>
                                    <?php foreach ($permissions as $permission): ?>
                                        <tr>
                                            <td><?= $permission->id ?></td>
                                            <td>
                                                <span class="badge bg-secondary"><?= htmlspecialchars($permission->name) ?></span>
                                            </td>
                                            <td><?= htmlspecialchars($permission->description) ?></td>
                                            <td>
                                                <?php if ($permission->assigned_roles): ?>
                                                    <?php
                                                    $roles = explode(',', $permission->assigned_roles);
                                                    foreach ($roles as $role): ?>
                                                        <span class="badge bg-info me-1"><?= htmlspecialchars(trim($role)) ?></span>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No roles assigned</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($permission->created_at)) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/permissions/view/' . $permission->id) ?>"
                                                        class="btn btn-sm btn-outline-primary"
                                                        title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/permissions/edit/' . $permission->id) ?>"
                                                        class="btn btn-sm btn-outline-warning"
                                                        title="Edit Permission">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <?php if (!$permission->assigned_roles): ?>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-permission"
                                                            data-id="<?= $permission->id ?>"
                                                            data-name="<?= htmlspecialchars($permission->name) ?>"
                                                            title="Delete Permission">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            disabled
                                                            title="Cannot delete - assigned to roles">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No permissions found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePermissionModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the permission "<strong id="permissionNameToDelete"></strong>"?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDeletePermission" class="btn btn-danger">Delete Permission</a>
            </div>
        </div>
    </div>
</div>