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
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/profile') ?>">Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('admin/profile/edit') ?>" method="post">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Your Username" value="<?= $user->username ?>">
                                <?= form_error('username',  '<p class="text-danger mt-1">', '</p>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Your First Name" value="<?= $user->first_name ?>">
                                <?= form_error('first_name',  '<p class="text-danger mt-1">', '</p>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Your Last Name" value="<?= $user->last_name ?>">
                                <?= form_error('last_name',  '<p class="text-danger mt-1">', '</p>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Your Email" value="<?= $user->email ?>">
                                <?= form_error('email',  '<p class="text-danger mt-1">', '</p>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="number" name="phone" id="phone" class="form-control" placeholder="Your Phone" value="<?= $user->phone ?>">
                                <?= form_error('phone',  '<p class="text-danger mt-1">', '</p>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" id="address" class="form-control" placeholder="Your Address"><?= $user->address ?></textarea>
                                <?= form_error('address',  '<p class="text-danger mt-1">', '</p>'); ?>
                            </div>
                            <div class="form-group mt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>