<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Admin Dashboard</h3>
                <p class="text-subtitle text-muted">Welcome to the shipment management system.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Home</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl bg-primary me-3">
                                <i class="bi bi-people-fill text-white fs-1"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">Users</h4>
                                <p class="text-muted mb-0">Manage system users</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl bg-success me-3">
                                <i class="bi bi-truck text-white fs-1"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">Shipments</h4>
                                <p class="text-muted mb-0">Track deliveries</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl bg-warning me-3">
                                <i class="bi bi-graph-up text-white fs-1"></i>
                            </div>
                            <div>
                                <h4 class="mb-0">Reports</h4>
                                <p class="text-muted mb-0">View analytics</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (ENVIRONMENT === 'development'): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Developer Tools</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading">⚠️ Development Environment</h6>
                                <p class="mb-0">These tools are only available in development mode.</p>
                            </div>
                            <a href="<?= base_url('database') ?>" class="btn btn-danger">
                                <i class="bi bi-database"></i> Database Reset
                            </a>
                            <p class="text-muted mt-2">
                                Reset the database to its initial state using SQL migration files.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>