<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $title ?></h3>
                <p class="text-subtitle text-muted">Manage user roles and their permissions</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Roles</li>
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
                            <h4 class="card-title">All Roles (<?= $total_roles ?>)</h4>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?= base_url('admin/roles/create') ?>" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Create New Role
                            </a>
                            <a href="<?= base_url('admin/roles/export') ?>" class="btn btn-success">
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
                        <table class="table table-striped" id="rolesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Users</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($roles)): ?>
                                    <?php foreach ($roles as $role): ?>
                                        <tr>
                                            <td><?= $role->id ?></td>
                                            <td>
                                                <span class="badge bg-primary"><?= htmlspecialchars($role->name) ?></span>
                                            </td>
                                            <td><?= htmlspecialchars($role->description) ?></td>
                                            <td>
                                                <?php
                                                $userCount = 0;
                                                foreach ($role_user_counts as $count) {
                                                    if ($count->role_name === $role->name) {
                                                        $userCount = $count->user_count;
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <span class="badge bg-info"><?= $userCount ?> users</span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($role->created_at)) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/roles/view/' . $role->id) ?>"
                                                        class="btn btn-sm btn-outline-primary"
                                                        title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('admin/roles/edit/' . $role->id) ?>"
                                                        class="btn btn-sm btn-outline-warning"
                                                        title="Edit Role">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <?php if ($userCount == 0): ?>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger delete-role"
                                                            data-id="<?= $role->id ?>"
                                                            data-name="<?= htmlspecialchars($role->name) ?>"
                                                            title="Delete Role">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            disabled
                                                            title="Cannot delete - has users">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No roles found</td>
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
<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRoleModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the role "<strong id="roleNameToDelete"></strong>"?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDeleteRole" class="btn btn-danger">Delete Role</a>
            </div>
        </div>
    </div>
</div>