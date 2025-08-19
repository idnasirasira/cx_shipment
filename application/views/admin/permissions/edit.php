<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $title ?></h3>
                <p class="text-subtitle text-muted">Edit permission details</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/permissions') ?>">Permissions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Permission</li>
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
                    <h4 class="card-title">Edit Permission: <?= htmlspecialchars($permission->name) ?></h4>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= validation_errors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open('admin/permissions/edit/' . $permission->id, ['id' => 'editPermissionForm']) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    value="<?= set_value('name', $permission->name) ?>"
                                    placeholder="Enter permission name"
                                    required>
                                <div class="form-text">Use lowercase with underscores (e.g., manage_users, view_reports)</div>
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
                                    placeholder="Enter permission description"><?= set_value('description', $permission->description) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <h6><i class="bi bi-exclamation-triangle"></i> Important Note</h6>
                                <p class="mb-0">Changing the permission name may affect existing role assignments. Make sure to update any role permissions if necessary.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('admin/permissions') ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to Permissions
                                </a>
                                <div>
                                    <a href="<?= base_url('admin/permissions/view/' . $permission->id) ?>" class="btn btn-info">
                                        <i class="bi bi-eye"></i> View Details
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Update Permission
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