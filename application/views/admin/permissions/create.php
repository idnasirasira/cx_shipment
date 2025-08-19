<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><?= $title ?></h3>
                <p class="text-subtitle text-muted">Create a new system permission</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/permissions') ?>">Permissions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Permission</li>
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
                    <h4 class="card-title">Create New Permission</h4>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= validation_errors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?= form_open('admin/permissions/create', ['id' => 'createPermissionForm']) ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    value="<?= set_value('name') ?>"
                                    placeholder="Enter permission name (e.g., manage_users)"
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
                                    placeholder="Enter permission description"><?= set_value('description') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6><i class="bi bi-info-circle"></i> Permission Naming Convention</h6>
                                <ul class="mb-0">
                                    <li>Use lowercase letters and underscores</li>
                                    <li>Be descriptive but concise</li>
                                    <li>Examples: <code>manage_users</code>, <code>view_reports</code>, <code>edit_shipments</code></li>
                                </ul>
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
                                    <i class="bi bi-check-circle"></i> Create Permission
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