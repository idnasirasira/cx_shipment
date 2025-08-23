<div class="page-heading">
    <div class="page-title">
        <div class="">
            <?= $this->session->flashdata('success') ?>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Inbound</h3>
                <p class="text-subtitle text-muted">Manage system inbound and their data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inbound</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title"><?= $section_title ?></h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="<?= base_url('admin/inbound/create') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add New Inbound
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive datatable-minimal">
                    <table class="table table-striped" id="inboundTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Courier</th>
                                <th>AWB Number</th>
                                <th>Status</th>
                                <th>Receiver Name</th>
                                <th>Created</th>
                                <th>Created by</th>
                                <th>Updated</th>
                                <th>Updated by</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inbounds as $inbound) : ?>
                                <tr>
                                    <td><?= $inbound->id ?></td>
                                    <td><?= $inbound->courier_name ?></td>
                                    <td><?= $inbound->awb_number ?></td>
                                    <td>
                                        <?php if ($inbound->status == 'received') : ?>
                                            <span class="badge bg-success">Received</span>
                                        <?php elseif ($inbound->status == 'pending') : ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary"><?= ucfirst($inbound->status) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $inbound->receiver_name ?></td>
                                    <td><?= $inbound->created_at ?></td>
                                    <td><span class="badge bg-light-info"><?= ucfirst($inbound->created_by) ?></span></td>
                                    <td><?= $inbound->updated_at ?></td>
                                    <td><span class="badge bg-light"><?= ucfirst($inbound->updated_by) ?></span></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="<?= base_url('admin/inbound/show/' . $inbound->id) ?>"
                                                class="btn btn-sm btn-outline-info"
                                                title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/inbound/edit/' . $inbound->id) ?>"
                                                class="btn btn-sm btn-outline-warning"
                                                title="Edit inbound">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('admin/inbound/delete/' . $inbound->id) ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Yakin hapus inbound ini?')"
                                                title="Delete Inbound">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Add Inbound Modal -->
<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Add New Inbound</h4>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="<?= base_url('admin/inbound/store') ?>" method="POST">
                <div class="modal-body">
                    <h4 class="mb-3">Inbound Information</h4>
                    <div class="form-group row">
                        <div class="form-group col-md-4">
                            <select class="form-select" name="courier_id" id="courier_id">
                                <option value="">Select Courier</option>
                                <?php foreach ($couriers as $courier) : ?>
                                    <option value="<?= $courier->id ?>"><?= $courier->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select class="form-select" name="status" id="status">
                                <option value="">Select Status</option>
                                <?php foreach ($couriers as $courier) : ?>
                                    <option value="<?= $courier->status ?>"><?= $courier->status ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <h4 class="mb-3">Sender Information</h4>
                    <div class="form-group row g-1 gap-1">
                        <div class="form-floating col-md-6">
                            <input type="text" class="form-control" name="sender_name" id="sender_name" placeholder=" ">
                            <label for="sender_name">Name</label>
                        </div>
                        <div class="form-floating col-md-4">
                            <input type="text" class="form-control" name="sender_phone_number" id="sender_phone_number" placeholder=" ">
                            <label for="sender_phone_number">Phone Number</label>
                        </div>
                    </div>
                    <div class="form-group form-floating col-md-10">
                        <textarea class="form-control" placeholder=" " name="address" id="address" style="height: 100px; resize: none;"></textarea>
                        <label for="address">Address</label>
                    </div>
                    <h4 class="mb-3">Receiver Information</h4>
                    <div class="form-group row g-1 gap-1">
                        <div class="form-floating col-md-6">
                            <input type="text" class="form-control" name="sender_name" id="sender_name" placeholder=" ">
                            <label for="sender_name">Name</label>
                        </div>
                        <div class="form-floating col-md-4">
                            <input type="text" class="form-control" name="sender_phone_number" id="sender_phone_number" placeholder=" ">
                            <label for="sender_phone_number">Phone Number</label>
                        </div>
                    </div>
                    <div class="form-group form-floating col-md-10">
                        <textarea class="form-control" placeholder=" " name="address" id="address" style="height: 100px; resize: none;"></textarea>
                        <label for="address">Address</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1">
                        <span class="d-none d-sm-block">Save Inbound</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal (ajax loaded) -->
<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>