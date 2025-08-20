<div class="container mt-10">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Forgot Password</h3>
                    <p class="text-subtitle text-muted">A page where this page can change account security settings</p>
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
                            <form action="<?= base_url('auth/change_password') ?>" method="post">
                                <div class="form-group my-2">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" value="">
                                    <?= form_error('password',  '<p class="text-danger mt-1">', '</p>'); ?>

                                </div>
                                <div class="form-group my-2">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter confirm password" value="">
                                    <?= form_error('confirm_password',  '<p class="text-danger mt-1">', '</p>'); ?>

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
</div>