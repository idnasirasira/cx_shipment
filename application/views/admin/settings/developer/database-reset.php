<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Database Reset</h3>
                <p class="text-subtitle text-muted">Reset database to initial state using SQL migration files</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/settings/developer') ?>">Developer Settings</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Database Reset</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">⚠️ Database Reset Warning</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">⚠️ This action will:</h6>
                        <ul class="mb-0">
                            <li>Drop all existing tables</li>
                            <li>Recreate all tables from scratch</li>
                            <li>Insert default data</li>
                            <li><strong>All existing data will be permanently lost!</strong></li>
                        </ul>
                    </div>

                    <?php if ($last_reset): ?>
                        <div class="alert alert-info">
                            <strong>Last Reset:</strong> <?= $last_reset ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">SQL Migration Files</h4>
                </div>
                <div class="card-body">
                    <?php if (empty($sql_files)): ?>
                        <div class="alert alert-warning">
                            No SQL files found in the database directory.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Filename</th>
                                        <th>Size</th>
                                        <th>Modified</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sql_files as $index => $file): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <code><?= $file['filename'] ?></code>
                                            </td>
                                            <td><?= number_format($file['size']) ?> bytes</td>
                                            <td><?= $file['modified'] ?></td>
                                            <td>
                                                <span class="badge bg-success">Ready</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Reset Database</h4>
                </div>
                <div class="card-body">
                    <form id="resetForm">
                        <div class="form-group">
                            <label for="confirmation" class="form-label">Confirmation Code</label>
                            <input type="text" class="form-control" id="confirmation" name="confirmation"
                                placeholder="Type 'RESET_DATABASE' to confirm" required>
                            <div class="form-text">
                                To confirm this action, please type <code>RESET_DATABASE</code> in the field above.
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-danger" id="resetBtn" disabled>
                                <i class="bi bi-trash"></i> Reset Database
                            </button>
                            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Modal -->
    <div class="modal fade" id="resultsModal" tabindex="-1" aria-labelledby="resultsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultsModalLabel">Reset Results</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="resultsContent">
                    <!-- Results will be populated here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>