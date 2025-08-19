<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>My Profile</h3>
                <p class="text-subtitle text-muted">Kelola informasi pribadi Anda.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
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
                            <div class="profile-picture-container position-relative">
                                <?php
                                $profile_picture = $user->profile_picture;
                                $default_picture = 'default.jpg'; // Nama file gambar default Anda
                                $image_path = base_url('assets/uploads/profile_pictures/' . $profile_picture);

                                if (empty($profile_picture) || !file_exists('./assets/uploads/profile_pictures/' . $profile_picture)) {
                                    $image_path = base_url('assets/compiled/jpg/' . $default_picture);
                                }
                                ?>
                                <img src="<?= $image_path ?>" alt="Profile Picture" class="rounded-circle profile-picture" style="width: 150px; height: 150px; object-fit: cover;">
                                <div class="profile-picture-overlay position-absolute top-0 start-0 w-100 h-100 rounded-circle d-flex align-items-center justify-content-center" style="cursor: pointer;">
                                    <span class="text-white text-uppercase fw-bold">Change Profile</span>
                                </div>
                            </div>

                            <div class="mt-3">
                                <h4><?= html_escape($user->first_name . ' ' . $user->last_name) ?></h4>
                                <p class="text-secondary mb-1"><?= html_escape($user->role_name) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Informasi Profil</h4>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="first_name" class="form-label">Nama Depan</label>
                                    <p><?= html_escape($user->first_name) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="last_name" class="form-label">Nama Belakang</label>
                                    <p><?= html_escape($user->last_name) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <p><?= html_escape($user->email) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Telepon</label>
                                    <p><?= html_escape($user->phone) ?></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address" class="form-label">Alamat</label>
                                    <p><?= html_escape($user->address) ?></p>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <a href="<?= base_url('admin/profile/edit') ?>" class="btn btn-primary me-1 mb-1">Edit Profil</a>
                                <button type="button" id="resetPasswordButton" class="btn btn-warning me-1 mb-1">Reset Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButton = document.querySelector('a.btn-primary');
        const resetPasswordButton = document.getElementById('resetPasswordButton');

        if (editButton) {
            // Mengarahkan ke halaman edit profil
            editButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = this.href;
            });
        }

        if (resetPasswordButton) {
            // Mengarahkan ke halaman reset password
            resetPasswordButton.addEventListener('click', function() {
                window.location.href = '<?= base_url("admin/account/security") ?>';
            });
        }
    });
</script>