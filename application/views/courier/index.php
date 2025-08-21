<!-- Bagian ini hanya berisi konten utama, akan dimuat di dalam layout admin Anda -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Courier List</h4>
        <a href="<?php echo site_url('admin/courier/create'); ?>" class="btn btn-primary btn-sm float-end">
            <i class="fas fa-plus"></i> Add New Courier
        </a>
    </div>
    <div class="card-body">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Courier Code</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($couriers)): ?>
                        <?php foreach ($couriers as $courier): ?>
                            <tr>
                                <td><?php echo $courier->id; ?></td>
                                <td><?php echo $courier->name; ?></td>
                                <td><?php echo $courier->code; ?></td>
                                <td><?php echo $courier->created_at ?></td>
                                <td><?php echo $courier->updated_at ?></td>
                                <td>
                                    <?php if ($courier->is_active): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo site_url('admin/courier/edit/' . $courier->id); ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="<?php echo site_url('admin/courier/delete/' . $courier->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kurir ini?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data kurir.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>