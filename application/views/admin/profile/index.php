<div class="page-heading">
    <div class="page-title">
        <div class="">
            <?= $this->session->flashdata('success') ?>

        </div>

        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Account Profile</h3>
                <p class="text-subtitle text-muted">A page where users can change profile information</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
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
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <div class="avatar avatar-2xl">
                                <img src="./assets/compiled/jpg/2.jpg" alt="Avatar">
                            </div>
                            <h3 class="mt-3"><?= $user->username ?></h3>
                            <p class="text-small">Junior Software Engineer</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('admin/profile/edit_process') ?>" method="POST">
                            <div class="form-group row">
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="firstName" id="firstName" placeholder=" " value="<?= $user->first_name; ?>">
                                        <?= form_error('firstName', '<small class="text-danger pl-3">', '</small>') ?>
                                        <label for="firstName">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="lastName" id="lastName" placeholder=" " value="<?= $user->last_name; ?>">
                                        <?= form_error('lastName', '<small class="text-danger pl-3">', '</small>') ?>
                                        <label for="lastName">last Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="form-floating ">
                                        <input type="text" class="form-control" name="email" id="email" placeholder=" " value="<?= $user->email; ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="tel" name="phoneNum" id="phoneNum" class="form-control" placeholder="Your Last Name" value="<?= $user->phone; ?>">
                                        <?= form_error('phoneNum', '<small class="text-danger pl-3">', '</small>') ?>
                                        <label for="phoneNum">Phone Number</label>
                                    </div>
                                </div>
                                <div class="input-group col-md">
                                    <button onclick="location.href='<?= base_url('admin/profile/reset') ?>'" class="btn btn-outline-secondary" type="button" id="button-addon1">Reset?</button>
                                    <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" value="Password" disabled>
                                </div>
                            </div>
                            <div class="form-group form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" name="address" id="address" style="height: 100px; resize: none;"><?= $user->address; ?></textarea>
                                <?= form_error('address', '<small class="text-danger pl-3">', '</small>') ?>
                                <label for="address">Address</label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>