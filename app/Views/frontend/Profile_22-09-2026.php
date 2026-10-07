<!-- Hero Section -->
<div class="ps-hero bg--cover text-white text-center py-5" style="background-image: url('<?= base_url('public/frontend/img/hero/shop.jpg'); ?>'); background-size: cover; background-position: center;">
    <h1 class="display-4">Profile</h1>
</div>

<!-- Profile Form Section -->
<div class="container py-5">
    <div class="ps-checkout">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4 text-center">Profile Information</h2>

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success text-center">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- Profile Form -->
                <form action="<?= base_url('profile/update') ?>" method="post" class="card p-4 shadow-sm mb-5">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="<?= esc($user[0]->name) ?>" required>
                    </div>
                    <?php if (!empty($user) && $user[0]->role == 1) : ?>
                        <div class="mb-3">
                            <label class="form-label">Company Name</label>
                            <input
                                type="text"
                                name="company_name"
                                class="form-control"
                                value="<?= esc($user[0]->company_name); ?>"
                                required
                            >
                        </div>
                    <?php endif; ?>
                    <!--<div class="mb-3">-->
                    <!--    <label class="form-label">Company Name</label>-->
                    <!--    <input type="text" name="company_name" class="form-control" value="< ?= esc($user[0]->company_name) ?>" required>-->
                    <!--</div>-->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($user[0]->email) ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= esc($user[0]->phone) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">WhatsApp No</label>
                        <input type="text" name="whatsapp_no" class="form-control" value="<?= esc($user[0]->whatsapp_no) ?>" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                    </div>
                </form>

                <!-- My Addresses Section --
                <h3 class="mb-3 text-center">My Addresses</h3>
                <div class="row">
                    <?php if (!empty($addresses)): ?>
                        <?php foreach ($addresses as $addr): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card shadow-sm h-100 border-0">
                                    <div class="card-body">
                                        <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary"></i> <?= esc($addr['address']) ?></p>
                                    </div>
                                    <div class="card-footer bg-white border-0 text-end">
                                        <form action="<?= base_url('profile/deleteAddress/' . $addr['id']) ?>" method="post" class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center">No addresses saved yet.</div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Add New Address Button (only if < 5 addresses) -->
                <!--< ?php if (count($addresses) < 5): ?>--
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                            <i class="bi bi-plus-circle"></i> Add New Address
                        </button>
                    </div>-->
                <!--< ?php endif; ?>-->

            </div>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= base_url('profile/addAddress') ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Save Address</button>
        </div>
      </form>
    </div>
  </div>
</div>
