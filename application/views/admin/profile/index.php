<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Account Profile</h3>
                <p class="text-subtitle text-muted">A page where users can change profile information</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column mt-4">
                            <div class="avatar avatar-2xl">
                                <img src="./assets/compiled/jpg/2.jpg" alt="Avatar">
                            </div>

                            <h3 class="mt-3"><?= $user->username ?></h3>
                            <p class="text-small">Junior Software Engineer</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Profile Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-1">

                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="d-flex flex-column mb-3">
                                    <b class="text-muted">Name:</b>
                                    <span><?= $user->first_name . $user->last_name ?></span>
                                </div>
                                <div class="d-flex flex-column mb-3">
                                    <b class="text-muted">Phone:</b>
                                    <span><?= $user->phone ?></span>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="d-flex flex-column mb-3">
                                    <b class="text-muted">Email:</b>
                                    <span><?= $user->email ?></span>
                                </div>
                                <div class="d-flex flex-column mb-3">
                                    <b class="text-muted">Address:</b>
                                    <span><?= $user->address ?></span>
                                </div>
                            </div>

                        </div>

                        <p>
                            <a class="btn btn-primary" href="<?= base_url('admin/profile/edit') ?>" aria-expanded="false" aria-controls="collapseExample">
                                Edit Profile
                            </a>
                            <a class="btn btn-warning" href="<?= base_url('admin/profile/reset_password') ?>" aria-expanded="false" aria-controls="collapseExample">
                                Reset Password
                            </a>
                        </p>
                    </div>
                </div>
            </div>
    </section>
</div>