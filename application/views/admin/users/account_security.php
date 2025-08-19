<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Account Security</h3>
                <p class="text-subtitle text-muted">Kelola keamanan akun Anda.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Account Security</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Reset Your Password</h4>
                        <p class="text-subtitle text-muted">Silakan isi formulir di bawah ini untuk mereset kata sandi Anda.</p>

                        <?php if ($this->session->flashdata('success_security')) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('success_security') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('error_security')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('error_security') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/account/reset_password') ?>" method="post" class="form">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mandatory mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input type="password" id="current_password" class="form-control" placeholder="Current Password" name="current_password">
                                        <?= form_error('current_password', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mandatory mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password" id="new_password" class="form-control" placeholder="New Password" name="new_password">
                                        <?= form_error('new_password', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mandatory mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <input type="password" id="confirm_password" class="form-control" placeholder="Confirm Password" name="confirm_password">
                                        <?= form_error('confirm_password', '<div class="text-danger">', '</div>') ?>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Reset Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>