<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Developer Settings</h3>
                <p class="text-subtitle text-muted">Welcome to the shipment management system.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Developer Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">

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
                            <a href="<?= base_url('admin/settings/developer/database-reset') ?>" class="btn btn-danger">
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