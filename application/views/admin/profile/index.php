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

                            <h3 class="mt-3">John Doe</h3>
                            <p class="text-small">Junior Software Engineer</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url("admin/profile/update") ?>" method="post">
                            <div class="form-group row">
                                <div class=" col-md-6">
                                    <label for="name" class="form-label">First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Your First Name" value="<?= $user->first_name ?>">
                                </div>
                                <div class=" col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Your Last Name" value="<?= $user->last_name ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class=" col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="Your Phone Number" value="<?= $user->phone ?>">
                                </div>
                                <div class=" col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Your Email" value="<?= $user->email ?>">
                                </div>
                                <div class="col-12 mt-3 ">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St" value="<?= $user->address ?>">
                                </div>
                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Change Password</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url("admin/profile/change_password") ?>" method="post">
                        <div class=" form-group my-2">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="current_password"
                                class="form-control" placeholder="Enter your current password"
                                value="">
                        </div>
                        <div class="form-group my-2">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Enter new password" value="">
                        </div>
                        <div class="form-group my-2">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="form-control" placeholder="Enter confirm password" value="">
                        </div>

                        <div class="form-group my-2 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>