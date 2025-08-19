<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Account Security</h3>
                <p class="text-subtitle text-muted">A page where this page can change account security settings</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Security</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('admin/profile/reset_process') ?>" method="POST">
                            <div class="form-group">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="currentPassword" id="currentPassword" placeholder=" ">
                                    <?= form_error('currentPassword', '<small class="text-danger pl-3">', '</small>') ?>
                                    <label for="currentPassword">Current Password</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" id="password" placeholder=" ">
                                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                    <label for="password">New Password</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="passconf" id="passconf" placeholder=" ">
                                    <?= form_error('passconf', '<small class="text-danger pl-3">', '</small>') ?>
                                    <label for="passconf">Confrim Password</label>
                                </div>
                            </div>
                            <div class="form-group my-2 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>