<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Edit Profile</h3>
                <p class="text-subtitle text-muted">Ubah informasi pribadi Anda.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <div class="profile-picture-container position-relative"> <?php $profile_picture = $user->profile_picture;
                                                                                        $default_picture = 'default.jpg';
                                                                                        $image_path = base_url('assets/uploads/profile_pictures/' . $profile_picture);
                                                                                        if (empty($profile_picture) || !file_exists('./assets/uploads/profile_pictures/' . $profile_picture)) {
                                                                                            $image_path = base_url('assets/compiled/jpg/' . $default_picture);
                                                                                        } ?> <img src="<?= $image_path ?>" alt="Profile Picture" class="rounded-circle profile-picture" style="width: 150px; height: 150px; object-fit: cover;">
                                <div class="profile-picture-overlay position-absolute top-0 start-0 w-100 h-100 rounded-circle d-flex align-items-center justify-content-center" style="cursor: pointer;"> <span class="text-white text-uppercase fw-bold">Change Profile</span> </div>
                            </div>
                            <div class="mt-3">
                                <h4><?= html_escape($user->first_name . ' ' . $user->last_name) ?></h4>
                                <p class="text-secondary mb-1"><?= html_escape($user->role_name) ?></p>
                            </div>
                        </div>
                        <hr class="my-4">
                        <form action="<?= base_url('admin/profile/update') ?>" method="post" enctype="multipart/form-data" id="profile-picture-form" class="form-group" style="display: none;"> <label for="profile_picture" class="form-label">Change Profile Picture</label> <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                            <div class="form-text text-muted">Ukuran maks: 2MB. Tipe diizinkan: JPG, PNG, GIF.</div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Profil</h4> <?php if ($this->session->flashdata('success')) : ?> <div class="alert alert-success alert-dismissible fade show" role="alert"> <?= $this->session->flashdata('success') ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div> <?php endif; ?> <?php if ($this->session->flashdata('error')) : ?> <div class="alert alert-danger alert-dismissible fade show" role="alert"> <?= $this->session->flashdata('error') ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div> <?php endif; ?> <form action="<?= base_url('admin/profile/update') ?>" method="post" class="form" data-parsley-validate>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory"> <label for="first_name" class="form-label">Nama Depan</label> <input type="text" id="first_name" class="form-control" placeholder="Nama Depan" name="first_name" data-parsley-required="true" value="<?= set_value('first_name', $user->first_name) ?>"> <?= form_error('first_name', '<div class="text-danger">', '</div>') ?> </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory"> <label for="last_name" class="form-label">Nama Belakang</label> <input type="text" id="last_name" class="form-control" placeholder="Nama Belakang" name="last_name" data-parsley-required="true" value="<?= set_value('last_name', $user->last_name) ?>"> <?= form_error('last_name', '<div class="text-danger">', '</div>') ?> </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory"> <label for="email" class="form-label">Email</label> <input type="email" id="email" class="form-control" placeholder="Email" name="email" data-parsley-required="true" value="<?= set_value('email', $user->email) ?>" disabled> </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mandatory"> <label for="phone" class="form-label">Telepon</label> <input type="text" id="phone" class="form-control" placeholder="Telepon" name="phone" data-parsley-required="true" value="<?= set_value('phone', $user->phone) ?>"> <?= form_error('phone', '<div class="text-danger">', '</div>') ?> </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mandatory"> <label for="address" class="form-label">Alamat</label> <textarea name="address" id="address" class="form-control" rows="3" data-parsley-required="true"><?= set_value('address', $user->address) ?></textarea> <?= form_error('address', '<div class="text-danger">', '</div>') ?> </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end"> <button type="submit" class="btn btn-primary me-1 mb-1">Perbarui Profil</button> <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button> </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?= base_url('assets/js/admin/profile/edit.js') ?>"></script>